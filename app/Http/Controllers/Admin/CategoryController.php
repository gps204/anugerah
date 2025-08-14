<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\CategoryTranslation;
use App\Models\Language;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.categories.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $activeLanguages = Language::active()->get();
        $categories = Category::whereNull('parent_category_id')->with('translations')->get();
        return view('admin.categories.create', compact('activeLanguages', 'categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {   
        $defaultLocale = config('app.locale');
        $request->validate([
            'parent_category_id' => 'nullable|exists:categories,id',
            'status' => 'required|boolean',
            'translations' => 'required|array',
            "translations.{$defaultLocale}.name" => 'required|string|max:255',
            'translations.*.name' => 'nullable|string|max:255',
            'translations.*.description' => 'nullable|string',
            'translations.*.image_url' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
        ]);

        DB::beginTransaction();
        try {
            $defaultName = $request->input("translations.{$defaultLocale}.name");
            $slug = $this->generateUniqueSlug($defaultName);

            $category = Category::create([
                'slug' => $slug,
                'parent_category_id' => $request->parent_category_id,
                'status' => $request->status,
            ]);
            
            foreach ($request->translations as $lang => $data) {
                if (!empty($data['name'])) {
                    $imagePath = null;
                    if ($request->hasFile("translations.{$lang}.image_url")) {
                        $imagePath = $request->file("translations.{$lang}.image_url")->store('categories', 'public');
                    }

                    CategoryTranslation::create([
                        'category_id' => $category->id,
                        'language_code' => $lang,
                        'name' => $data['name'],
                        'description' => $data['description'] ?? null,
                        'image_url' => $imagePath,
                    ]);
                }
            }

            DB::commit();
            return redirect()->route('admin.categories.index')->with('success', __('cms.categories.created'));

        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Failed to create category: '.$e->getMessage() . ' in ' . $e->getFile() . ' on line ' . $e->getLine());
            return redirect()->back()->with('error', __('cms.categories.error_create'))->withInput();
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $category = Category::with('translations')->findOrFail($id);
        $activeLanguages = Language::active()->get();
        $categories = Category::whereNull('parent_category_id')->where('id', '!=', $id)->with('translations')->get();
        return view('admin.categories.edit', compact('category', 'activeLanguages', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $category = Category::findOrFail($id);
        $defaultLocale = config('app.locale');
        $request->validate([
            'parent_category_id' => 'nullable|exists:categories,id',
            'status' => 'required|boolean',
            'translations' => 'required|array',
            "translations.{$defaultLocale}.name" => 'required|string|max:255',
        ]);

        DB::beginTransaction();
        try {
            $defaultName = $request->input("translations.{$defaultLocale}.name");
            $slug = $this->generateUniqueSlug($defaultName, $category->id);

            $category->update([
                'slug' => $slug,
                'parent_category_id' => $request->parent_category_id,
                'status' => $request->status,
            ]);

            foreach ($request->translations as $lang => $data) {
                if (!empty($data['name'])) {
                    $translation = $category->translations()->firstOrNew(['language_code' => $lang]);
                    $imagePath = $translation->image_url;

                    if ($request->hasFile("translations.{$lang}.image_url")) {
                        if ($imagePath) {
                            Storage::disk('public')->delete($imagePath);
                        }
                        $imagePath = $request->file("translations.{$lang}.image_url")->store('categories', 'public');
                    }

                    $translation->name = $data['name'];
                    $translation->description = $data['description'] ?? null;
                    $translation->image_url = $imagePath;
                    $translation->save();
                } else {
                    $category->translations()->where('language_code', $lang)->delete();
                }
            }

            DB::commit();
            return redirect()->route('admin.categories.index')->with('success', __('cms.categories.updated'));

        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Failed to update category: '.$e->getMessage() . ' in ' . $e->getFile() . ' on line ' . $e->getLine());
            return redirect()->back()->with('error', __('cms.categories.error_update'))->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        DB::beginTransaction();
        try {
            // Hapus gambar yang terkait dengan semua terjemahan kategori ini
            foreach ($category->translations as $translation) {
                if ($translation->image_url) {
                    Storage::disk('public')->delete($translation->image_url);
                }
            }

            // Menghapus kategori akan menghapus terjemahan secara otomatis jika relasi diatur dengan onDelete('cascade')
            $category->delete();

            DB::commit();

            // Respon untuk panggilan AJAX dari DataTables
            return response()->json(['success' => true, 'message' => __('cms.categories.deleted')]);

        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Failed to delete category: '.$e->getMessage() . ' in ' . $e->getFile() . ' on line ' . $e->getLine());
            return response()->json(['success' => false, 'message' => __('cms.categories.error_delete')], 500);
        }
    }

    /**
     * Get data for DataTables.
     */
    public function getCategories(Request $request)
    {
        if ($request->ajax()) {
            try {
                $data = Category::withoutGlobalScopes()->with('translations')->latest()->get();

                return DataTables::of($data)
                    ->addIndexColumn()
                    ->addColumn('name', function($row) {
                        $locale = app()->getLocale();
                        $fallbackLocale = config('app.fallback_locale', 'en');

                        // 1. Coba cari terjemahan untuk locale saat ini.
                        $translation = $row->translations->firstWhere('language_code', $locale);
                        if ($translation && !empty($translation->name)) {
                            return $translation->name;
                        }

                        // 2. Jika tidak ada, coba cari untuk fallback locale.
                        $fallbackTranslation = $row->translations->firstWhere('language_code', $fallbackLocale);
                        if ($fallbackTranslation && !empty($fallbackTranslation->name)) {
                            return $fallbackTranslation->name;
                        }

                        // 3. Jika masih tidak ada, ambil terjemahan pertama yang tersedia.
                        $anyTranslation = $row->translations->first();
                        if ($anyTranslation && !empty($anyTranslation->name)) {
                            return $anyTranslation->name;
                        }

                        return 'N/A'; // Fallback jika tidak ada terjemahan sama sekali.
                    })
                    ->addColumn('status', function($row){
                        $checked = $row->status ? 'checked' : '';
                        return '<label class="switch"><input type="checkbox" class="status-toggle" data-id="'.$row->id.'" '.$checked.'><span class="slider round"></span></label>';
                    })
                    ->addColumn('action', function($row){
                        $editUrl = route('admin.categories.edit', $row->id);
                        $deleteUrl = route('admin.categories.destroy', $row->id);
                        $btn = '<a href="'.$editUrl.'" class="btn btn-primary btn-sm">'.__('cms.categories.edit').'</a> ';
                        $btn .= '<button class="btn btn-danger btn-sm delete-btn" data-url="'.$deleteUrl.'">'.__('cms.categories.delete').'</button>';
                        return $btn;
                    })
                    ->rawColumns(['status', 'action'])
                    ->make(true);
            } catch (\Throwable $e) {
                Log::error('DataTables Error: ' . $e->getMessage() . ' in ' . $e->getFile() . ' on line ' . $e->getLine());
                return response()->json(['error' => 'Server Error: Could not retrieve data. Check logs for details.'], 500);
            }
        }
    }

    /**
     * Update category status.
     */
    public function updateCategoryStatus(Request $request)
    {
        try {
            // Gunakan withoutGlobalScopes() untuk memastikan kategori bisa ditemukan meskipun statusnya tidak aktif
            $category = Category::withoutGlobalScopes()->findOrFail($request->id);
            $category->status = $request->status;
            $category->save();

            return response()->json(['success' => true, 'message' => __('cms.categories.status_updated')]);
        } catch (\Throwable $e) {
            Log::error('Failed to update category status: '.$e->getMessage() . ' in ' . $e->getFile() . ' on line ' . $e->getLine());
            return response()->json(['success' => false, 'message' => __('cms.categories.error_status_update')], 500);
        }
    }

    /**
     * Generate a unique slug for the category.
     *
     * @param string $name
     * @param int|null $exceptId
     * @return string
     */
    private function generateUniqueSlug(string $name, int $exceptId = null): string
    {
        $slug = Str::slug($name);
        $originalSlug = $slug;
        $counter = 1;

        while (Category::where('slug', $slug)->when($exceptId, function ($query) use ($exceptId) {
            return $query->where('id', '!=', $exceptId);
        })->exists()) {
            $slug = $originalSlug . '-' . $counter++;
        }

        return $slug;
    }
}
