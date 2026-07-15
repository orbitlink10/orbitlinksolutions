<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\IndexingController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SubCategoryController;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\TestimonialController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\MenuController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MediaController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\RentalController;
use App\Http\Controllers\DesignController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\WeldingProductController;


use App\Http\Controllers\SliderController;

use App\Http\Controllers\InvoiceController;


use App\Http\Controllers\InvoiceItemController;

use App\Http\Controllers\CareerController;
use App\Http\Controllers\ProductSizeController;



use App\Http\Controllers\Admin\WeldingProductController as AdminWeldingProductController;

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


Route::get('google-feed.xml', [App\Http\Controllers\GoogleFeedController::class, 'index']);


Route::get('images', function (Request $request) {
    return get_uploaded_image($request->path);
})->name('images');


Route::get('/how-to-order', function () {
   return view('theme.'.get_option('theme').'.how');
});

Route::get('/reviews', [WelcomeController::class, 'reviews'])->name('reviews');


Route::get('/starlink-kenya-price', function () {
    return view('theme.'.get_option('theme').'.pricing');
});




Route::post('/careers/apply', [CareerController::class, 'apply'])
     ->name('careers.apply');


Route::get('/designs/design/{id}', [DesignController::class, 'design'])->name('designs.design');

Route::get('/design', [DesignController::class, 'designPublic'])->name('design');

Route::get('/all-categories', [WelcomeController::class, 'allcategories'])->name('allcategories');

Route::post('/product/preview', [ProductController::class, 'preview']);



Route::get('/notify-thank-you', function () {
    return view('notify.thank-you');
})->name('notify.thank-you');





Route::prefix('welding-products')->group(function () {
    // Show all welding products
    Route::get('/', [WeldingProductController::class, 'index'])->name('welding-products.index');

    // Show welding products filtered by category slug
    Route::get('/category/{slug}', [WeldingProductController::class, 'category'])->name('welding-products.category');

});

Route::get('/welding-products/{product}', [WeldingProductController::class, 'show'])->name('welding-products.show');

Route::post('/categories/upload-image', [CategoryController::class, 'uploadImage'])->name('categories.upload-image');
Route::resource('categories', CategoryController::class);


Route::resource('menus', MenuController::class);

Route::resource('sliders', SliderController::class);

Route::resource('medias', MediaController::class);


Route::post('/notify', [NotificationController::class, 'store'])->name('notify.store');

Route::prefix('notifications')->name('notifications.')->group(function () {
    Route::get('/', [NotificationController::class, 'index'])->name('index');
    Route::get('create', [NotificationController::class, 'create'])->name('create');
    Route::post('store', [NotificationController::class, 'store'])->name('store');
    Route::get('edit/{notification}', [NotificationController::class, 'edit'])->name('edit');
    Route::put('update/{notification}', [NotificationController::class, 'update'])->name('update');
    Route::delete('destroy/{notification}', [NotificationController::class, 'destroy'])->name('destroy');
    Route::get('thank-you', [NotificationController::class, 'thankYou'])->name('thank-you');
});

Route::get('/starlink-rental', function () {
    return view('theme.starlink-rental');
});

// Dedicated Onsite Welding Services landing page (Gamun theme)
Route::get('/welding-services', function () {
    $theme = get_option('theme');
    $view = 'theme.' . $theme . '.welding_services';
    if (view()->exists($view)) {
        return view($view);
    }
    // fallback to gamun theme view if active theme differs
    return view('theme.gamun.welding_services');
})->name('welding.services');

Route::get('/rental', [RentalController::class, 'index'])->name('rental.index');
Route::post('/rental', [RentalController::class, 'store'])->name('rental.store');
Route::get('/rental/thank-you', function () {
    return view('rentals.thank-you');
})->name('rental.thank-you');


Route::get('bconfirm-payment/{id}', 'App\Http\Controllers\WelcomeController@bconfirmPayment')->name('bconfirmPayment');
Route::get('bmpesa', 'App\Http\Controllers\WelcomeController@bmpesa')->name('bmpesa');
Route::get('success-deposit/{id}', ['as' => 'success_deposit', 'uses' => 'App\Http\Controllers\WelcomeController@successDeposit']);
Route::get('success-deposit-invoice/{id}', ['as' => 'success_deposit_invoice', 'uses' => 'App\Http\Controllers\WelcomeController@successDepositInvoice']);
// Account Routes
Route::middleware(['auth'])->group(function () {

    Route::get('/account/dashboard', [AccountController::class, 'dashboard'])->name('account.dashboard');
    Route::get('/account/orders', [AccountController::class, 'orders'])->name('account.orders');
    Route::get('/account/payments', [AccountController::class, 'payments'])->name('account.payments');
    Route::get('/account/details', [AccountController::class, 'details'])->name('account.details');
    Route::post('/account/details/update', [AccountController::class, 'updateDetails'])->name('account.updateDetails');
    Route::get('/account/addresses', [AccountController::class, 'addresses'])->name('account.addresses');
    Route::get('/account/logout', [AccountController::class, 'logout'])->name('account.logout');
    
});


Route::post('login-post-users', ['as' => 'login_post_users', 'uses' => 'App\Http\Controllers\WelcomeController@loginPostUsers']);
Route::post('register/user', [WelcomeController::class, 'storeUser'])->name('users.store_user');
Route::get('/faq', [WelcomeController::class, 'faq'])->name('faq');
Route::get('/terms', [WelcomeController::class, 'terms'])->name('terms');
Route::get('/about', [WelcomeController::class, 'about'])->name('about_us');
Route::get('/services', [WelcomeController::class, 'services'])->name('services');
Route::get('/shop', [WelcomeController::class, 'products'])->name('product');
Route::get('/product/{slug}', [WelcomeController::class, 'product_details'])->name('product_details');

Route::get('/product/preview/{slug}', [WelcomeController::class, 'product_details_preview'])->name('product_details_preview');


use App\Http\Controllers\WishlistController;

Route::middleware(['auth'])->group(function () {
    // Display the user's wishlist
    Route::get('/wishlist', [WishlistController::class, 'index'])->name('wishlist.index');

    // Add an item to the wishlist
    Route::get('/wishlist/{id}', [WishlistController::class, 'store'])->name('wishlist.store');

    // Remove an item from the wishlist
    Route::delete('/wishlist/{id}', [WishlistController::class, 'destroy'])->name('wishlist.destroy');
});



// Invoice Routes
Route::resource('invoices', InvoiceController::class);
Route::get('invoices/{invoice}/items', [InvoiceItemController::class, 'create'])->name('invoice.items.create');
Route::post('invoices/{invoice}/items', [InvoiceItemController::class, 'store'])->name('invoice.items.store');
Route::delete('invoices/{invoice}/items/{item}', [InvoiceItemController::class, 'destroy'])->name('invoice.items.destroy');
Route::get('invoices/open/{slug}', [InvoiceController::class, 'open'])->name('invoices.open');
Route::get('/invoices/{id}/download', [InvoiceController::class, 'download'])->name('invoices.download');


Route::get('/service/{slug}', [WelcomeController::class, 'serviceSingle'])->name('service_single');

Route::get('/contacts', [WelcomeController::class, 'contacts'])->name('contacts');
Route::get('/blogs', [WelcomeController::class, 'blogs'])->name('blogs');

Route::post('/cart/add', [CartController::class, 'addToCart'])->name('cart.add');
Route::get('/cart', [CartController::class, 'viewCart'])->name('cart.view');
Route::post('/cart/remove', [CartController::class, 'removeFromCart'])->name('cart.remove');
Route::get('/checkout', [CartController::class, 'checkout'])->name('cart.checkout');
Route::post('/cart/update', [CartController::class, 'updateCart'])->name('cart.update');
Route::post('/checkout/order', [WelcomeController::class, 'storeOrder'])->name('store_order');

Route::get('/pay-now/{total}', [WelcomeController::class, 'payNow'])->name('pay_now');
Route::get('/pay-now-invoice/{total}', [WelcomeController::class, 'payNowInvoice'])->name('pay_now_invoice');

Route::get('/register-url', [WelcomeController::class, 'registerUrl']);

//my routes
Route::get('/generate-access-token', [HomeController::class, 'generateAccessToken']);

Route::withoutMiddleware([
    \App\Http\Middleware\VerifyCsrfToken::class    
])->group(function(){
    Route::post('/confirmation-url', [WelcomeController::class, 'confirmation']);
    Route::post('/stkpush/callback', [WelcomeController::class, 'MpesaRes']);
    Route::post('/validation-url', [WelcomeController::class, 'validation']);
    Route::post('/mpesa/stkpush', [WelcomeController::class, 'initiateStkPush'])->name('mpesa.stkpush');
});


Route::get('/', ['as' => 'blog_home', 'uses'=>'App\Http\Controllers\WelcomeController@index']);
Route::get('/category/{slug}', ['as' => 'view_product_category', 'uses'=>'App\Http\Controllers\WelcomeController@showProductCategory']);
Route::get('/post/category/{slug}', ['as' => 'view_category', 'uses'=>'App\Http\Controllers\WelcomeController@show']);
Route::get('posts/{slug}', ['as' => 'blog_single', 'uses'=>'App\Http\Controllers\WelcomeController@blogSingle']);
Route::get('p/{slug}', ['as' => 'view_page', 'uses'=>'App\Http\Controllers\WelcomeController@viewPage']);
Route::post('save-message', ['as' => 'save_message', 'uses'=>'App\Http\Controllers\WelcomeController@saveMessage']);
Route::get('/sitemap.xml', [App\Http\Controllers\WelcomeController::class, 'sitemap'])->name('sitemap');
Route::get('/sitemap-products.xml', [App\Http\Controllers\WelcomeController::class, 'productSitemap'])->name('product_sitemap');
Route::get('/sitemap-categories.xml', [App\Http\Controllers\WelcomeController::class, 'categoriesSitemap'])->name('categories_sitemap');
Route::get('/robots.txt', function () {
    $content = implode("\n", [
        'User-agent: *',
        'Allow: /',
        '',
        'Sitemap: ' . url('/sitemap.xml'),
        '',
    ]);

    return response($content, 200)->header('Content-Type', 'text/plain; charset=UTF-8');
})->name('robots');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::post('/save_tag', [App\Http\Controllers\HomeController::class, 'saveTag'])->name('save-tag');
Route::post('/save_post', [App\Http\Controllers\HomeController::class, 'savePost'])->name('save-post');
Route::post('/save_posts', [App\Http\Controllers\HomeController::class, 'savePosts'])->name('save-posts');


// Route::get('blog', ['as' => 'blog', 'uses'=>'App\Http\Controllers\WelcomeController@index']);
Route::get('tag/{slug}', ['as' => 'tag_select', 'uses'=>'App\Http\Controllers\WelcomeController@tagSelect']);





Route::post('/update-location/{id}', [App\Http\Controllers\HomeController::class, 'updateLocation'])->name('update_location');
Route::delete('/category/delete/{id}',[HomeController::class, 'deleteCategory'])->name('delete_category');


Route::get('/orders', [OrderController::class, 'index'])->name('orders.index');
Route::get('/users', [OrderController::class, 'users'])->name('orders.users');

Route::get('/orders/{id}', [OrderController::class, 'show'])->name('orders.show');



Route::resource('testimonials', TestimonialController::class);

// Route to show the form for adding sizes to a specific product
Route::get('/products/{product}/sizes/create', [ProductSizeController::class, 'create'])
    ->name('products.sizes.create');
Route::post('/products/{product}/sizes', [ProductSizeController::class, 'store'])
    ->name('products.sizes.store');

Route::resource('service', ServiceController::class);


// Route::get('/products', [App\Http\Controllers\HomeController::class, 'product'])->name('products');
Route::get('admin/create-job', [App\Http\Controllers\HomeController::class, 'createJob'])->name('create_job');
Route::get('/edit-post/{id}', [App\Http\Controllers\HomeController::class, 'editPost'])->name('edit_post');

Route::post('/update-category/{id}', [App\Http\Controllers\HomeController::class, 'updatePost'])->name('update_category');

Route::resource('sub_categories',SubCategoryController::class);
Route::resource('products',ProductController::class);
Route::post('/product-media-save', [App\Http\Controllers\ProductController::class, 'mediaSave'])->name('products.media');
Route::get('/product/create', [App\Http\Controllers\ProductController::class, 'create'])->name('product.create');

Route::get('/get-subcategories/{categoryId}', [ProductController::class, 'getSubcategories'])->name('subcategories.fetch');
Route::resource('designs', DesignController::class);
//pages
Route::resource('pages', PageController::class);
Route::post('/page-media-save', [App\Http\Controllers\PageController::class, 'mediaSave'])->name('pages.media');
Route::get('/edit-page/{id}', [App\Http\Controllers\HomeController::class, 'editPage'])->name('edit_page');
Route::get('/pages', [App\Http\Controllers\HomeController::class, 'pages'])->name('pages');
Route::get('/new-post', [App\Http\Controllers\HomeController::class, 'newPost'])->name('new_post');
Route::delete('/pages/delete/{id}', [App\Http\Controllers\HomeController::class, 'destroy'])->name('delete-page');
Route::post('/pages/bulk', [App\Http\Controllers\HomeController::class, 'bulkPages'])
    ->name('pages.bulk');
Route::get('/location', [App\Http\Controllers\HomeController::class, 'location'])->name('location');
Route::post('/save-page', [App\Http\Controllers\HomeController::class, 'savePage'])->name('save-page');
Route::post('/save-location', [App\Http\Controllers\HomeController::class, 'saveLocation'])->name('save-location');
Route::post('/update-page/{id}', [App\Http\Controllers\HomeController::class, 'updatePage'])->name('update-page');

Route::get('/enquiries', [App\Http\Controllers\HomeController::class, 'enquiries'])->name('enquiries');

Route::get('/{assetPath}', function (string $assetPath) {
    $allowedRoots = [
        'assets' => base_path('assets'),
        'blog' => base_path('blog'),
        'css' => base_path('css'),
        'dark' => base_path('dark'),
        'gamun' => base_path('gamun'),
        'lucare' => base_path('lucare'),
    ];

    $rootName = strtok($assetPath, '/');

    if (!isset($allowedRoots[$rootName])) {
        abort(404);
    }

    $relativePath = ltrim(substr($assetPath, strlen($rootName)), '/');
    $root = realpath($allowedRoots[$rootName]);

    if (!$root) {
        abort(404);
    }

    $file = realpath($root . DIRECTORY_SEPARATOR . str_replace(['/', '\\'], DIRECTORY_SEPARATOR, $relativePath));

    if (!$file || !is_file($file) || strpos($file, $root . DIRECTORY_SEPARATOR) !== 0) {
        abort(404);
    }

    $mimeTypes = [
        'css' => 'text/css; charset=UTF-8',
        'js' => 'application/javascript; charset=UTF-8',
        'mjs' => 'application/javascript; charset=UTF-8',
        'json' => 'application/json; charset=UTF-8',
        'map' => 'application/json; charset=UTF-8',
        'svg' => 'image/svg+xml',
        'png' => 'image/png',
        'jpg' => 'image/jpeg',
        'jpeg' => 'image/jpeg',
        'gif' => 'image/gif',
        'webp' => 'image/webp',
        'ico' => 'image/x-icon',
        'woff' => 'font/woff',
        'woff2' => 'font/woff2',
        'ttf' => 'font/ttf',
        'eot' => 'application/vnd.ms-fontobject',
        'otf' => 'font/otf',
        'mp4' => 'video/mp4',
        'webm' => 'video/webm',
        'pdf' => 'application/pdf',
        'zip' => 'application/zip',
    ];

    $extension = strtolower(pathinfo($file, PATHINFO_EXTENSION));

    return response()->file($file, [
        'Content-Type' => $mimeTypes[$extension] ?? 'application/octet-stream',
    ]);
})->where('assetPath', '(?:assets|blog|css|dark|gamun|lucare)/.*\.(?:css|js|mjs|png|jpe?g|gif|webp|svg|ico|json|map|woff2?|ttf|eot|otf|mp4|webm|pdf|zip)');

Route::get('/{slug}', ['as' => 'page_single', 'uses'=>'App\Http\Controllers\WelcomeController@sitemaps']);

Route::get('/admin/analytics', [App\Http\Controllers\HomeController::class, 'analytics'])->name('admin.analytics');
Route::get('/admin/keyword-research', [App\Http\Controllers\HomeController::class, 'keywordResearch'])->name('admin.keyword-research');
Route::get('/admin/site-audit', [App\Http\Controllers\HomeController::class, 'siteAudit'])->name('admin.site-audit');
Route::get('/admin/users/', [App\Http\Controllers\HomeController::class, 'Allusers'])->name('admin.users');
Route::post('/admin/store/users', [App\Http\Controllers\HomeController::class, 'saveUser'])->name('admin.save_user');
Route::post('/admin/update/users/{id}', [App\Http\Controllers\HomeController::class, 'updateUser'])->name('admin.update_user');
Route::get('/login_as/{id}', [App\Http\Controllers\HomeController::class, 'loginAs'])->name('login_as');

Route::get('admin/settings', [App\Http\Controllers\HomeController::class, 'settings'])->name('admin.settings');
Route::get('admin/pages-content', [App\Http\Controllers\HomeController::class, 'pages_content'])->name('admin.pages_content');

Route::post('save-settings', [App\Http\Controllers\HomeController::class, 'updateOptions'])->name('save_settings');
// Route::get('settings', ['as' => 'settings', 'uses' => 'HomeController@settings']);





Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    // Admin CRUD routes for categories
    Route::resource('categories', AdminCategoryController::class)->except(['show']);
    
    // Admin CRUD routes for welding products
    Route::resource('welding-products', AdminWeldingProductController::class);
    
});
