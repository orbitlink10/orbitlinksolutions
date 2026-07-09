<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::get('images', function (Request $request) {
    return get_uploaded_image($request->path);
})->name('images');

Route::get('/', ['as' => 'blog', 'uses'=>'App\Http\Controllers\WelcomeController@index']);
Route::get('/jobs', ['as' => 'all_jobs', 'uses'=>'App\Http\Controllers\WelcomeController@allPosts']);
Route::get('/articles', ['as' => 'all_articles', 'uses'=>'App\Http\Controllers\WelcomeController@allArticles']);
Route::get('/contact', ['as' => 'contact', 'uses'=>'App\Http\Controllers\WelcomeController@contact']);
Route::get('/category/{slug}', ['as' => 'view_category', 'uses'=>'App\Http\Controllers\WelcomeController@show']);
Route::get('job/{slug}', ['as' => 'blog_single', 'uses'=>'App\Http\Controllers\WelcomeController@blogSingle']);
Route::get('article/view/{id}', ['as' => 'view_article', 'uses'=>'App\Http\Controllers\WelcomeController@viewArticle']);
Route::get('/{slug}', ['as' => 'view_page', 'uses'=>'App\Http\Controllers\WelcomeController@viewPage']);
Route::post('save-message', ['as' => 'save_message', 'uses'=>'App\Http\Controllers\WelcomeController@saveMessage']);
Route::get('/page/sitemap.xml', [App\Http\Controllers\WelcomeController::class, 'sitemap'])->name('sitemap');



Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::post('/save_tag', [App\Http\Controllers\HomeController::class, 'saveTag'])->name('save-tag');
Route::post('/save_post', [App\Http\Controllers\HomeController::class, 'savePost'])->name('save-post');
Route::post('/save_posts', [App\Http\Controllers\HomeController::class, 'savePosts'])->name('save-posts');


Route::get('job', ['as' => 'blogs', 'uses'=>'App\Http\Controllers\WelcomeController@index']);
Route::get('tag/{slug}', ['as' => 'tag_select', 'uses'=>'App\Http\Controllers\WelcomeController@tagSelect']);

Route::get('/categories', [App\Http\Controllers\HomeController::class, 'category'])->name('categories');
Route::post('/save-category', [App\Http\Controllers\HomeController::class, 'saveCategory'])->name('save_category');
Route::post('/update-categorys/{id}', [App\Http\Controllers\HomeController::class, 'updateCategory'])->name('update_categorys');


Route::get('/products', [App\Http\Controllers\HomeController::class, 'product'])->name('products');
Route::get('/edit-post/{id}', [App\Http\Controllers\HomeController::class, 'editPost'])->name('edit_post');
Route::get('/edit-page/{id}', [App\Http\Controllers\HomeController::class, 'editPage'])->name('edit_page');
Route::post('/update-category/{id}', [App\Http\Controllers\HomeController::class, 'updatePost'])->name('update_category');

//pages

Route::get('/pages', [App\Http\Controllers\HomeController::class, 'pages'])->name('pages');
Route::post('/save-page', [App\Http\Controllers\HomeController::class, 'savePage'])->name('save-page');
Route::post('/update-page/{id}', [App\Http\Controllers\HomeController::class, 'updatePage'])->name('update-page');

Route::get('/enquiries', [App\Http\Controllers\HomeController::class, 'enquiries'])->name('enquiries');

Route::post('save-settings', ['as'=>'save_settings', 'uses' => 'DashboardController@updateOptions']);


Route::get('/seo/{slug}', ['as' => 'page_single', 'uses'=>'App\Http\Controllers\WelcomeController@sitemaps']);

