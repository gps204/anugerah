<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;

class BlogController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.blogs.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.blogs.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'status' => 'required|in:published,draft',
        ]);

        DB::beginTransaction();
        try {
            $imagePath = null;
            if ($request->hasFile('image')) {
                $imagePath = $request->file('image')->store('blogs', 'public');
            }

            Blog::create([
                'title' => $request->title,
                'slug' => Str::slug($request->title),
                'content' => $request->content,
                'image' => $imagePath,
                'status' => $request->status,
                'user_id' => auth()->id(), // Asumsikan ada relasi dengan user
            ]);

            DB::commit();

            return redirect()->route('admin.blogs.index')->with('success', __('cms.blogs.success_create'));
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Failed to create blog post: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Gagal membuat postingan blog.')->withInput();
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Blog $blog)
    {
        return view('admin.blogs.edit', compact('blog'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Blog $blog)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
            'status' => 'required|in:published,draft',
        ]);

        DB::beginTransaction();
        try {
            $imagePath = $blog->image;
            if ($request->hasFile('image')) {
                // Hapus gambar lama jika ada
                if ($imagePath) {
                    Storage::disk('public')->delete($imagePath);
                }
                $imagePath = $request->file('image')->store('blogs', 'public');
            }

            $blog->update([
                'title' => $request->title,
                'slug' => Str::slug($request->title),
                'content' => $request->content,
                'image' => $imagePath,
                'status' => $request->status,
            ]);

            DB::commit();

            return redirect()->route('admin.blogs.index')->with('success', __('cms.blogs.success_update'));
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Failed to update blog post: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Gagal memperbarui postingan blog.')->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Blog $blog)
    {
        DB::beginTransaction();
        try {
            if ($blog->image) {
                Storage::disk('public')->delete($blog->image);
            }
            $blog->delete();
            DB::commit();
            return response()->json(['success' => true, 'message' => __('cms.blogs.success_delete')]);
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Failed to delete blog post: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => __('cms.blogs.error')], 500);
        }
    }

    /**
     * Get data for DataTables.
     */
    public function getData(Request $request)
    {
        if ($request->ajax()) {
            $data = Blog::with('user')->latest()->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('title', function ($row) {
                    return Str::limit($row->title, 50);
                })
                ->addColumn('author', function ($row) {
                    return optional($row->user)->name ?? 'N/A';
                })
                ->addColumn('status', function ($row) {
                    $checked = $row->status == 'published' ? 'checked' : '';
                    // Menggunakan class 'status-switch' yang sesuai dengan JS di index.blade.php
                    return '<label class="switch"><input type="checkbox" class="status-switch" data-id="' . $row->id . '" ' . $checked . '><span class="slider round"></span></label>';
                })
                ->addColumn('action', function ($row) {
                    $editUrl = route('admin.blogs.edit', $row->id);
                    $deleteUrl = route('admin.blogs.destroy', $row->id);
                    $btn = '<a href="' . $editUrl . '" class="btn btn-primary btn-sm">Edit</a> ';
                    $btn .= '<button class="btn btn-danger btn-sm delete-btn" data-url="' . $deleteUrl . '">Delete</button>';
                    return $btn;
                })
                ->rawColumns(['status', 'action'])
                ->make(true);
        }
    }

    /**
     * Update blog status.
     */
    public function updateStatus(Request $request)
    {
        try {
            $blog = Blog::findOrFail($request->id);
            $blog->status = $request->status == 'true' ? 'published' : 'draft';
            $blog->save();

            return response()->json(['success' => true, 'message' => __('cms.blogs.status_updated')]);
        } catch (\Exception $e) {
            Log::error('Failed to update blog status: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => __('cms.blogs.error')], 500);
        }
    }
}