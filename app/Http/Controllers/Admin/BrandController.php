<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Language;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;

class BrandController extends Controller
{
    public function index()
    {
        return view('admin.brands.index');
    }

    public function getData(Request $request)
    {
        if ($request->ajax()) {
            try {
                $query = Brand::with('translation');

                return DataTables::of($query)
                    ->addIndexColumn()
                    ->addColumn('logo', function ($row) {
                        $url = $row->logo_url ? Storage::url($row->logo_url) : asset('img/no-image.png');
                        return '<img src="' . $url . '" border="0" width="40" class="img-rounded" align="center" />';
                    })
                    ->addColumn('name', function ($row) {
                        return $row->translation->name ?? $row->slug;
                    })
                    ->addColumn('status', function ($row) {
                        $checked = $row->status ? 'checked' : '';
                        return '<div class="form-check form-switch">
                                    <input class="form-check-input status-toggle" type="checkbox" role="switch" data-id="' . $row->id . '" ' . $checked . '>
                                </div>';
                    })
                    ->addColumn('action', function ($row) {
                        $editUrl = route('admin.brands.edit', $row->id);
                        $deleteUrl = route('admin.brands.destroy', $row->id);
                        $btn = '<a href="' . $editUrl . '" class="btn btn-primary btn-sm me-1"><i class="fas fa-edit"></i></a>';
                        $btn .= '<button class="btn btn-danger btn-sm delete-btn" data-url="' . $deleteUrl . '"><i class="fas fa-trash"></i></button>';
                        return $btn;
                    })
                    ->rawColumns(['logo', 'status', 'action'])
                    ->orderColumn('name', function ($query, $order) {
                        $query->leftJoin('brand_translations', 'brands.id', '=', 'brand_translations.brand_id')
                              ->where(fn($q) => $q->where('brand_translations.locale', app()->getLocale())->orWhereNull('brand_translations.locale'))
                              ->orderBy('brand_translations.name', $order)
                              ->select('brands.*');
                    })
                    ->make(true);
            } catch (\Exception $e) {
                Log::error('DataTables Error for Brands: ' . $e->getMessage());
                return response()->json(['error' => 'Server Error: ' . $e->getMessage()], 500);
            }
        }
    }

    public function create()
    {
        $activeLanguages = Language::where('active', 1)->get();
        return view('admin.brands.create', compact('activeLanguages'));
    }

    public function store(Request $request)
    {
        $defaultLang = config('app.locale');
        $validated = $request->validate([
            'translations.' . $defaultLang . '.name' => 'required|string|max:255',
            'translations.*.name' => 'nullable|string|max:255',
            'translations.*.description' => 'nullable|string',
            'logo_url' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'status' => 'required|boolean',
        ]);

        DB::beginTransaction();
        try {
            $logoPath = null;
            if ($request->hasFile('logo_url')) {
                $logoPath = $request->file('logo_url')->store('brands', 'public');
            }

            $slug = Str::slug($request->input("translations.{$defaultLang}.name"));
            $originalSlug = $slug;
            $count = 1;
            while (Brand::where('slug', $slug)->exists()) {
                $slug = $originalSlug . '-' . $count++;
            }

            $brand = Brand::create([
                'slug' => $slug,
                'logo_url' => $logoPath,
                'status' => $request->status,
            ]);

            foreach ($request->translations as $langCode => $data) {
                if (!empty($data['name'])) {
                    $brand->translations()->create([
                        'language_code' => $langCode,
                        'name' => $data['name'],
                        'description' => $data['description'] ?? null,
                    ]);
                }
            }

            DB::commit();
            return redirect()->route('admin.brands.index')->with('success', __('cms.brands.created'));
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error creating brand: ' . $e->getMessage());
            return redirect()->back()->with('error', __('cms.brands.error_create'))->withInput();
        }
    }

    public function edit(Brand $brand)
    {
        $brand->load('translations');
        $activeLanguages = Language::where('active', 1)->get();
        return view('admin.brands.edit', compact('brand', 'activeLanguages'));
    }

    public function update(Request $request, Brand $brand)
    {
        $defaultLang = config('app.locale');
        $validated = $request->validate([
            'translations.' . $defaultLang . '.name' => 'required|string|max:255',
            'translations.*.name' => 'nullable|string|max:255',
            'translations.*.description' => 'nullable|string',
            'logo_url' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'status' => 'required|boolean',
        ]);

        DB::beginTransaction();
        try {
            $logoPath = $brand->logo_url;
            if ($request->hasFile('logo_url')) {
                if ($logoPath) {
                    Storage::disk('public')->delete($logoPath);
                }
                $logoPath = $request->file('logo_url')->store('brands', 'public');
            }

            $brand->update([
                'logo_url' => $logoPath,
                'status' => $request->status,
            ]);

            foreach ($request->translations as $langCode => $data) {
                if (!empty($data['name'])) {
                    $brand->translations()->updateOrCreate(
                        ['language_code' => $langCode],
                        [
                            'name' => $data['name'],
                            'description' => $data['description'] ?? null,
                        ]
                    );
                } else {
                    $brand->translations()->where('language_code', $langCode)->delete();
                }
            }

            DB::commit();
            return redirect()->route('admin.brands.index')->with('success', __('cms.brands.updated'));
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error("Error updating brand with ID {$brand->id}: " . $e->getMessage());
            return redirect()->back()->with('error', __('cms.brands.error_update'))->withInput();
        }
    }

    public function destroy(Brand $brand)
    {
        try {
            if ($brand->logo_url) {
                Storage::disk('public')->delete($brand->logo_url);
            }
            $brand->delete(); // Relasi (translations) akan terhapus otomatis oleh database (cascade)
            return response()->json(['success' => true, 'message' => __('cms.brands.deleted')]);
        } catch (\Exception $e) {
            Log::error("Error deleting brand with ID {$brand->id}: " . $e->getMessage());
            return response()->json(['success' => false, 'message' => __('cms.brands.error_delete')], 500);
        }
    }

    public function updateStatus(Request $request)
    {
        try {
            $brand = Brand::findOrFail($request->id);
            $brand->status = $request->status;
            $brand->save();
            return response()->json(['success' => true, 'message' => __('cms.brands.status_updated')]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Error updating status.'], 500);
        }
    }
}