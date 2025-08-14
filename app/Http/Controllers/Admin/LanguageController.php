<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Language;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use Yajra\DataTables\Facades\DataTables;

class LanguageController extends Controller
{
    public function index()
    {
        return view('admin.languages.index');
    }

    public function getData(Request $request)
    {
        if ($request->ajax()) {
            // Gunakan withoutGlobalScopes() untuk memastikan semua bahasa (aktif/tidak aktif) ditampilkan
            $data = Language::withoutGlobalScopes()->latest()->get();

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('status', function ($row) {
                    $checked = $row->status ? 'checked' : '';
                    return '<label class="switch"><input type="checkbox" class="status-toggle" data-id="'.$row->id.'" '.$checked.'><span class="slider round"></span></label>';
                })
                ->addColumn('action', function ($row) {
                    $editUrl = route('admin.languages.edit', $row->id);
                    $deleteUrl = route('admin.languages.destroy', $row->id);
                    $btn = '<a href="'.$editUrl.'" class="btn btn-primary btn-sm">'.__('cms.languages.edit').'</a> ';
                    $btn .= '<button class="btn btn-danger btn-sm delete-btn" data-url="'.$deleteUrl.'">'.__('cms.languages.delete').'</button>';
                    return $btn;
                })
                ->rawColumns(['status', 'action'])
                ->make(true);
        }
    }

    public function create()
    {
        return view('admin.languages.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|size:2|unique:languages,code',
            'status' => 'required|boolean',
        ]);

        Language::create($request->all());

        return redirect()->route('admin.languages.index')->with('success', __('cms.languages.success_create'));
    }

    public function edit(Language $language)
    {
        return view('admin.languages.edit', compact('language'));
    }

    public function update(Request $request, Language $language)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'code' => ['required', 'string', 'size:2', Rule::unique('languages')->ignore($language->id)],
            'status' => 'required|boolean',
        ]);

        $language->update($request->all());

        return redirect()->route('admin.languages.index')->with('success', __('cms.languages.success_update'));
    }

    public function destroy(Language $language)
    {
        // Prevent deleting the default language
        if ($language->code === config('app.locale')) {
            return response()->json(['success' => false, 'message' => __('cms.languages.error_delete_default')], 403);
        }

        try {
            $language->delete();
            return response()->json(['success' => true, 'message' => __('cms.languages.success_delete')]);
        } catch (\Exception $e) {
            Log::error('Failed to delete language: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => __('cms.languages.error_delete')], 500);
        }
    }

    public function updateStatus(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:languages,id',
            'status' => 'required|boolean',
        ]);

        $language = Language::find($request->id);

        // Prevent deactivating the default language
        if ($language->code === config('app.locale') && $request->status == 0) {
            return response()->json(['success' => false, 'message' => __('cms.languages.error_deactivate_default')], 403);
        }

        try {
            $language->status = $request->status;
            $language->save();
            return response()->json(['success' => true, 'message' => __('cms.languages.status_updated')]);
        } catch (\Exception $e) {
            Log::error('Failed to update language status: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Error updating status!'], 500);
        }
    }

    public function changeLanguage(Request $request)
    {
        $lang = $request->input('lang');

        if (! in_array($lang, ['en', 'es', 'de', 'ar', 'fa', 'it', 'nl', 'pl', 'pt', 'tr', 'zh', 'fr', 'ru', 'ja', 'ko', 'th', 'vi', 'hi', 'id'])) {
            return response()->json(['error' => 'Unsupported language'], 400);
        }

        session(['locale' => $lang]);
        app()->setLocale($lang);

        return redirect()->back()->with('success', 'Language changed successfully');
    }
}
