<?php

namespace App\Http\Controllers\Admin;

use App\Models\Brand;
use App\Models\Category;
use App\Http\Controllers\Controller;
use App\Models\Language;
use App\Models\Shop;
use App\Models\Vendor;
use App\Models\Product;
// use App\Models\Attribute;
// use App\Models\AttributeValue;
// use App\Models\ProductAttributeValue;
use App\Services\Admin\CategoryService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;

class ProductController extends Controller
{
    public function index()
    {
        return view('admin.products.index');
    }

    public function getProducts(Request $request)
    {
        if ($request->ajax()) {
            try { // Mengambil data sebagai collection (->get()) untuk memastikan semua relasi dimuat sebelum ke DataTables
                \Log::info('getProducts method called');

                $data = Product::with(['translation', 'category.translation', 'brand.translation'])->latest()->get();

                return DataTables::of($data)
                    ->addIndexColumn()
                    ->addColumn('name', function ($row) {
                        return optional($row->translation)->name ?? $row->slug ?? 'N/A';
                    })
                    ->addColumn('category', function ($row) {
                        return optional(optional($row->category)->translation)->name ?? 'N/A';
                    })
                    ->addColumn('brand', function ($row) {
                        return optional(optional($row->brand)->translation)->name ?? 'N/A';
                    })
                    ->addColumn('status', function ($row) {
                        $checked = $row->status ? 'checked' : '';
                        return '<label class="switch"><input type="checkbox" class="status-toggle" data-id="'.$row->id.'" '.$checked.'><span class="slider round"></span></label>';
                    })
                    ->addColumn('action', function ($row) {


                        $editUrl = route('admin.products.edit', $row->id);
                        $deleteUrl = route('admin.products.destroy', $row->id);
                        $btn = '<a href="'.$editUrl.'" class="btn btn-primary btn-sm">Edit</a> ';
                        $btn .= '<button class="btn btn-danger btn-sm delete-btn" data-url="'.$deleteUrl.'">Delete</button>';
                        return $btn;
                    })
                    ->rawColumns(['status', 'action'])
                    ->make(true);
            } catch (\Exception $e) {
                Log::error('DataTables Error for Products: ' . $e->getMessage());
                return response()->json(['error' => 'Server Error: ' . $e->getMessage()], 500);
            }
        }
    }



    public function create()
    {

        $languages = Language::where('active', 1)->get();

        $categories = Category::with('translations')->get();
        $brands = Brand::with('translations')->get();

        return view('admin.products.create', compact('languages', 'categories', 'brands'));
    }

    public function store(Request $request)
    {
        $defaultLang = config('app.locale');

        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'brand_id' => 'nullable|exists:brands,id',
            'status' => 'required|boolean',
            'translations.'.$defaultLang.'.name' => 'required|string|max:255',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        DB::transaction(function () use ($request, $defaultLang) {

            $defaultName = $request->translations[$defaultLang]['name'] ?? 'product';
            $slug = $this->generateUniqueSlug($defaultName);

            $product = Product::create([
                'slug' => $slug,
                'category_id' => $request->category_id,
                'brand_id' => $request->brand_id,
                'status' => $request->status,
                'product_type' => 'simple',
            ]);

            foreach ($request->translations as $lang => $data) {
                if (!empty($data['name'])) {
                    $product->translations()->create([
                        'language_code' => $lang,
                        'name' => $data['name'],
                        'description' => $data['description'] ?? null,
                        'short_description' => $data['short_description'] ?? null,
                        'tags' => $data['tags'] ?? null,
                    ]);
                }
            }

            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $image) {
                    $path = $image->store('products', 'public');

                    $product->images()->create([
                        'name' => $image->getClientOriginalName(),
                        'image_url' => $path,
                        'type' => 'thumb',
                    ]);
                }
            }

        });

        return redirect()->route('admin.products.index')->with('success', __('cms.products.success_create'));
    }

    public function generateUniqueSlug($name)
    {
        $slug = Str::slug($name);
        $originalSlug = $slug;
        $count = 1;

        while (Product::where('slug', $slug)->exists()) {
            $slug = $originalSlug.'-'.$count;
            $count++;
        }

        return $slug;
    }

    public function edit($id)
    {
        $product = Product::with([
            'translations', 'images',
            // 'variants.translations',
            // 'variants.attributeValues',
        ])->findOrFail($id);

        $languages = Language::where('active', 1)->get();
        $categories = Category::with('translation')->get();
        $brands = Brand::with('translation')->get();

        return view('admin.products.edit', compact(
            'product', 'languages', 'categories', 'brands'
        ));

    }

    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);
        $defaultLang = config('app.locale');

        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'brand_id' => 'nullable|exists:brands,id',
            'status' => 'required|boolean',
            'translations.'.$defaultLang.'.name' => 'required|string|max:255',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        DB::transaction(function () use ($request, $product, $defaultLang) {

            foreach ($request->translations as $lang => $data) {
                if (!empty($data['name'])) {
                    $product->translations()->updateOrCreate(
                        ['language_code' => $lang],
                        [
                            'name' => $data['name'],
                            'description' => $data['description'] ?? null,
                            'short_description' => $data['short_description'] ?? null,
                            'tags' => $data['tags'] ?? null,
                        ]
                    );
                } else {
                    // Jika nama kosong, hapus terjemahan yang ada untuk bahasa tersebut
                    $product->translations()->where('language_code', $lang)->delete();
                }
            }

            $product->update([
                'category_id' => $request->category_id,
                'brand_id' => $request->brand_id,
                'status' => $request->status,
            ]);

            if ($request->has('remove_images')) {
                foreach ($request->remove_images as $imageId) {
                    $image = $product->images()->find($imageId);
                    if ($image) {
                        Storage::disk('public')->delete($image->image_url);
                        $image->delete();
                    }
                }
            }

            if ($request->hasFile('images')) {
                foreach ($request->file('images') as $image) {
                    $path = $image->store('products', 'public');
                    $product->images()->create([
                        'name' => $image->getClientOriginalName(),
                        'image_url' => $path,
                        'type' => 'thumb',
                    ]);
                }
            }

        });

        return redirect()->route('admin.products.index')->with('success', __('cms.products.success_update'));
    }

    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $product = Product::with(['images', 'variants'])->findOrFail($id);

            // Delete images from storage
            foreach ($product->images as $image) {
                Storage::disk('public')->delete($image->image_url);
            }

            // Delete product and its related data (cascade should handle translations, variants, etc.)
            $product->delete();

            DB::commit();

            return response()->json(['success' => true, 'message' => __('cms.products.success_delete')]);
        } catch (\Exception $e) {
            \Log::error("Error deleting product with ID {$id}: ".$e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'An error occurred while deleting the product.',
            ]);
        }
    }

    public function updateStatus(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:products,id',
            'status' => 'required|boolean',
        ]);

        $product = Product::find($request->id);
        $product->status = $request->status;
        $product->save();

        if ($product) {
            return response()->json([
                'success' => true,
                'message' => __('cms.products.status_updated'),
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Product status could not be updated.',
            ]);
        }

    }
}
