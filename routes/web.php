<?php

use App\Http\Controllers\ContactController;
use App\Http\Controllers\Admin\AttributeController;
use App\Http\Controllers\Admin\BannerController;
use App\Http\Controllers\Admin\BlogController as AdminBlogController;
use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Store\BlogController as StoreBlogController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Store\ProductReviewController as StoreProductReviewController;
use App\Http\Controllers\Admin\CustomerController;
use App\Http\Controllers\Admin\LanguageController;
use App\Http\Controllers\Admin\MenuController;
use App\Http\Controllers\ProductPageController;
use App\Http\Controllers\Admin\MenuItemController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\PageController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\ProductReviewController;
use App\Http\Controllers\Admin\VendorController;
use App\Http\Controllers\SiteSettingsController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// ==========================
// Rute Halaman Frontend
// ==========================
// Rute-rute frontend utama (seperti /, /cart, /checkout) sudah didefinisikan di routes/store.php
// Rute-rute di bawah ini adalah placeholder dan bisa dinonaktifkan dengan comment untuk menghindari konflik.
// Route::get('/', function () { return view('themes.xylo.home'); });
// Route::get('/cart', function () { return view('themes.xylo.cart'); });
// Route::get('/checkout', function () { return view('themes.xylo.checkout'); });
// Route::get('/product-detail', function () { return view('themes.xylo.product-detail'); });
// Route::get('/search', function () { return view('themes.xylo.search-results'); });

// Rute untuk halaman statis yang dibuat dari MenuSeeder
// Anda perlu membuat file view yang sesuai di resources/views/themes/xylo/
Route::get('/home', function () {
    return redirect()->route('xylo.home');
});

Route::view('/about', 'themes.xylo.about')->name('about');
Route::view('/services', 'themes.xylo.services')->name('services');
Route::get('/blog', [StoreBlogController::class, 'index'])->name('blog.index');
Route::get('/blog/{slug}', [StoreBlogController::class, 'show'])->name('blog.show');
Route::get('/contact', [ContactController::class, 'show'])->name('contact');
Route::post('/contact', [ContactController::class, 'send'])->name('contact.send');
// Rute-rute ini sekarang dikelola di dalam file routes/store.php untuk menjaga konsistensi.
// Route::get('/produk', [ProductPageController::class, 'index'])->name('shop.index');
// Route::get('/product/{slug}', [ProductPageController::class, 'show'])->name('product.show');

// ==========================
// Rute Login (Admin Login)
// ==========================
// Redirect dari /admin ke /admin/dashboard
Route::get('/admin', function () {
    return redirect()->route('admin.dashboard');
});

Route::get('/login', function () {
    return view('admin.auth.login');
});

Auth::routes();

// ==========================
// Rute Admin (Dashboard, CRUD, dsb.)
// ==========================
Route::prefix('admin')->name('admin.')->middleware('auth')->group(function () {

    Route::get('/dashboard', [App\Http\Controllers\HomeController::class, 'index'])->name('dashboard');
    Route::get('categories/data', [CategoryController::class, 'getCategories'])->name('categories.data');
    Route::post('categories/update-status', [CategoryController::class, 'updateCategoryStatus'])->name('categories.updateStatus');
    Route::resource('categories', CategoryController::class);

    Route::resource('products', ProductController::class);
    Route::post('products/data', [ProductController::class, 'getProducts'])->name('products.data');
    Route::post('products/update-status', [ProductController::class, 'updateStatus'])->name('products.updateStatus');

    Route::get('brands/data', [BrandController::class, 'getData'])->name('brands.data');
    Route::post('brands/update-status', [BrandController::class, 'updateStatus'])->name('brands.updateStatus');
    Route::resource('brands', BrandController::class);

    // Language Management
    Route::resource('languages', LanguageController::class)->except(['show']);
    Route::get('languages/data', [LanguageController::class, 'getData'])->name('languages.data');
    Route::post('languages/update-status', [LanguageController::class, 'updateStatus'])->name('languages.updateStatus');

    Route::post('/change-language', [LanguageController::class, 'changeLanguage'])->name('change.language');

    Route::resource('menus', MenuController::class);
    Route::post('menus/data', [MenuController::class, 'getData'])->name('menus.data');
    Route::resource('menus.items', MenuItemController::class)->shallow();
    Route::get('menus-items', [MenuItemController::class, 'index'])->name('menus.item.index');
    Route::post('menus-items/getdata', [MenuItemController::class, 'getData'])->name('menus.item.getData');

    // Route::resource('banners', BannerController::class);
    // Route::post('banners/data', [BannerController::class, 'getData'])->name('banners.data');
    // Route::put('/banners/toggle-status/{id}', [BannerController::class, 'toggleStatus'])->name('banners.toggleStatus');
    // Route::post('/banners/update-status', [BannerController::class, 'updateStatus'])->name('banners.updateStatus');

    Route::resource('product_variants', ProductVariantController::class);
    Route::post('/product_variants/data', [ProductVariantController::class, 'getData'])->name('product_variants.data');

    Route::resource('customers', CustomerController::class);
    Route::get('customers/data', [CustomerController::class, 'getCustomerData'])->name('customers.data');

    // Route::resource('attributes', AttributeController::class);
    // Route::post('attributes/{attribute}/values', [AttributeController::class, 'storeValue'])->name('attributes.values.store');
    // Route::delete('values/{value}', [AttributeController::class, 'destroyValue'])->name('values.destroy');
    // Route::post('attributes/data', [AttributeController::class, 'getAttributesData'])->name('attributes.data');
    // Route::post('values/{value}/translations', [AttributeController::class, 'storeTranslation'])->name('values.translations.store');
    // Route::delete('translations/{translation}', [AttributeController::class, 'destroyTranslation'])->name('translations.destroy');

    Route::get('vendors', [VendorController::class, 'index'])->name('vendors.index');
    Route::get('vendors/data', [VendorController::class, 'getVendorData'])->name('vendors.data');
    Route::delete('vendors/{id}', [VendorController::class, 'destroy'])->name('vendors.destroy');

    Route::resource('pages', PageController::class);
    Route::post('pages/update-status', [PageController::class, 'updatePageStatus'])->name('pages.updateStatus');
    Route::post('pages/data', [PageController::class, 'data'])->name('pages.data');

    Route::get('blogs/data', [AdminBlogController::class, 'getData'])->name('blogs.data');
    Route::post('blogs/update-status', [AdminBlogController::class, 'updateStatus'])->name('blogs.updateStatus');
    Route::resource('blogs', AdminBlogController::class);

});

// ==========================
// Rute untuk Pengaturan Situs
// ==========================
Route::get('site-settings', [SiteSettingsController::class, 'index'])->name('site-settings.index');
Route::get('site-settings/edit', [SiteSettingsController::class, 'edit'])->name('admin.site-settings.edit');
Route::put('site-settings/update', [SiteSettingsController::class, 'update'])->name('admin.site-settings.update');
