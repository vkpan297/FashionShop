<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

//search
Route::get('search', [App\Http\Controllers\HomeController::class, 'getSearch'])->name('search');

//contact
Route::get('/lien-he', [App\Http\Controllers\ContactController::class, 'lien_he'])->name('lien_he');

//checkout
Route::get('/checkout', [App\Http\Controllers\CheckoutController::class, 'checkout'])->name('checkout');
Route::get('/payment', [App\Http\Controllers\CheckoutController::class, 'payment'])->name('payment');
Route::post('/save-check', [App\Http\Controllers\CheckoutController::class, 'save_checkout'])->name('save-checkout');
Route::post('/checkout/select-delivery-home', [App\Http\Controllers\CheckoutController::class, 'select_delivery_home'])->name('select_delivery_home');
Route::post('/checkout/calculate-fee', [App\Http\Controllers\CheckoutController::class, 'calculate_fee'])->name('calculate_fee');
Route::post('/order-place', [App\Http\Controllers\CheckoutController::class, 'orderPlace'])->name('orderPlace');

//cart
Route::get('/category/{slug}/{id}', [App\Http\Controllers\CategoryController::class, 'index'])->name('category.product');
Route::get('/cart/{id}', [App\Http\Controllers\CartController::class, 'index'])->name('cart');
Route::get('/show-cart', [App\Http\Controllers\CartController::class, 'showCart'])->name('showCart');
Route::get('/update-cart', [App\Http\Controllers\CartController::class, 'updateCart'])->name('updateCart');
Route::get('/delete-cart', [App\Http\Controllers\CartController::class, 'deleteCart'])->name('deleteCart');

//Login facebook
Route::get('/login-facebook',[App\Http\Controllers\Auth\LoginController::class,'login_facebook'])->name('login_facebook');
Route::get('/login/callback',[App\Http\Controllers\Auth\LoginController::class,'callback_facebook'])->name('callback_facebook');

//Login  google
Route::get('/login-google',[App\Http\Controllers\Auth\LoginController::class,'login_google'])->name('login_google');
Route::get('/google/callback',[App\Http\Controllers\Auth\LoginController::class,'callback_google'])->name('callback_google');


//detail product
Route::get('/detail/{id}', [App\Http\Controllers\ProductController::class, 'detail'])->name('detail');
Route::post('/save-views', [App\Http\Controllers\ProductController::class, 'save_views'])->name('save_views');
Route::get('/tag/{product_tag}', [App\Http\Controllers\ProductController::class, 'product_tag'])->name('product_tag');
Route::post('/send-comment', [App\Http\Controllers\ProductController::class, 'send_comment'])->name('send_comment');
Route::post('/load-comment', [App\Http\Controllers\ProductController::class, 'load_comment'])->name('load_comment');

Route::get('login', [App\Http\Controllers\Auth\LoginController::class,'getLogin'])->name('login');
Route::post('login', [App\Http\Controllers\Auth\LoginController::class,'postLogin'])->name('login');

Route::get('logout', [App\Http\Controllers\Auth\LogoutController::class,'getLogout'])->name('logout');

// Đăng ký thành viên
Route::get('register', [App\Http\Controllers\Auth\RegisterController::class,'getRegister']);
Route::post('register', [App\Http\Controllers\Auth\RegisterController::class,'postRegister']);


//Admin

Route::get('/admin', [App\Http\Controllers\AdminController::class, 'index']);
Route::post('/filter-by-date', [App\Http\Controllers\AdminController::class, 'filter_by_date']);
Route::post('/dashboard-filter', [App\Http\Controllers\AdminController::class, 'dashboard_filter']);
Route::post('/days-order', [App\Http\Controllers\AdminController::class, 'days_order']);


Route::prefix('admin')->group(function () {

    //contact
    Route::get('/infomation', [App\Http\Controllers\ContactController::class, 'infomation'])->name('infomation');
    Route::post('/save-info/{id}', [App\Http\Controllers\ContactController::class, 'update'])->name('contact.update');
    //category
    Route::prefix('categories')->group(function () {
        Route::get('/', [App\Http\Controllers\AdminCategoryController::class,'index'])->name('categories.index');
        Route::get('/create', [App\Http\Controllers\AdminCategoryController::class,'create'])->name('categories.create');
        Route::post('/store', [App\Http\Controllers\AdminCategoryController::class,'store'])->name('categories.store');
        Route::get('/edit/{id}', [App\Http\Controllers\AdminCategoryController::class,'edit'])->name('categories.edit');
        Route::post('/update/{id}', [App\Http\Controllers\AdminCategoryController::class,'update'])->name('categories.update');
        Route::get('/delete/{id}', [App\Http\Controllers\AdminCategoryController::class,'delete'])->name('categories.delete');
    });

    //menu
    Route::prefix('menus')->group(function () {
        Route::get('/', [App\Http\Controllers\AdminMenuController::class,'index'])->name('menus.index');
        Route::get('/create', [App\Http\Controllers\AdminMenuController::class,'create'])->name('menus.create');
        Route::post('/store', [App\Http\Controllers\AdminMenuController::class,'store'])->name('menus.store');
        Route::get('/edit/{id}', [App\Http\Controllers\AdminMenuController::class,'edit'])->name('menus.edit');
        Route::post('/update/{id}', [App\Http\Controllers\AdminMenuController::class,'update'])->name('menus.update');
        Route::get('/delete/{id}', [App\Http\Controllers\AdminMenuController::class,'delete'])->name('menus.delete');
    });

    //order
    Route::prefix('order')->group(function () {
        Route::get('/', [App\Http\Controllers\AdminOrderController::class,'index'])->name('order.index');
        Route::get('/order-detail/{id}', [App\Http\Controllers\AdminOrderController::class,'OrderDetail'])->name('order.detail');
        Route::post('/update-order-quantity', [App\Http\Controllers\AdminOrderController::class,'update_order_quantity'])->name('update_order_quantity');
        Route::post('/update-quantity', [App\Http\Controllers\AdminOrderController::class,'update_quantity'])->name('update_quantity');
    });

    //task
    Route::prefix('sendMail')->group(function () {
        Route::get('/', [App\Http\Controllers\TaskController::class, 'index'])->name('task.index');
        Route::post('/task', [App\Http\Controllers\TaskController::class, 'store'])->name('store.task');
        Route::get('/task/{id}', [App\Http\Controllers\TaskController::class, 'delete'])->name('delete.task');
    });

    //product
    Route::prefix('product')->group(function () {
        Route::get('/', [App\Http\Controllers\AdminProductController::class,'index'])->name('product.index');
        Route::get('/create', [App\Http\Controllers\AdminProductController::class,'create'])->name('product.create');
        Route::post('/store', [App\Http\Controllers\AdminProductController::class,'store'])->name('product.store');
        Route::get('/edit/{id}', [App\Http\Controllers\AdminProductController::class,'edit'])->name('product.edit');
        Route::post('/update/{id}', [App\Http\Controllers\AdminProductController::class,'update'])->name('product.update');
        Route::get('/delete/{id}', [App\Http\Controllers\AdminProductController::class,'delete'])->name('product.delete');
    });

    //slider
    Route::prefix('slider')->group(function () {
        Route::get('/', [App\Http\Controllers\AdminSliderController::class,'index'])->name('slider.index');
        Route::get('/create', [App\Http\Controllers\AdminSliderController::class,'create'])->name('slider.create');
        Route::post('/store', [App\Http\Controllers\AdminSliderController::class,'store'])->name('slider.store');
        Route::get('/edit/{id}', [App\Http\Controllers\AdminSliderController::class,'edit'])->name('slider.edit');
        Route::post('/update/{id}', [App\Http\Controllers\AdminSliderController::class,'update'])->name('slider.update');
        Route::get('/delete/{id}', [App\Http\Controllers\AdminSliderController::class,'delete'])->name('slider.delete');
    });

    //comment
    Route::prefix('comment')->group(function () {
        Route::post('/reply-comment', [App\Http\Controllers\AdminCommentController::class,'reply_comment'])->name('reply_comment');
        Route::get('/', [App\Http\Controllers\AdminCommentController::class,'index'])->name('comment.index');
    });
    //setting
    Route::prefix('setting')->group(function () {
        Route::get('/', [App\Http\Controllers\AdminSettingController::class,'index'])->name('setting.index');
        Route::get('/create', [App\Http\Controllers\AdminSettingController::class,'create'])->name('setting.create');
        Route::post('/store', [App\Http\Controllers\AdminSettingController::class,'store'])->name('setting.store');
        Route::get('/edit/{id}', [App\Http\Controllers\AdminSettingController::class,'edit'])->name('setting.edit');
        Route::post('/update/{id}', [App\Http\Controllers\AdminSettingController::class,'update'])->name('setting.update');
        Route::get('/delete/{id}', [App\Http\Controllers\AdminSettingController::class,'delete'])->name('setting.delete');
    });

    //user
    Route::prefix('user')->group(function () {
        Route::get('/', [App\Http\Controllers\UserAdminController::class,'index'])->name('user.index');
        Route::get('/create', [App\Http\Controllers\UserAdminController::class,'create'])->name('user.create');
        Route::post('/store', [App\Http\Controllers\UserAdminController::class,'store'])->name('user.store');
        Route::get('/edit/{id}', [App\Http\Controllers\UserAdminController::class,'edit'])->name('user.edit');
        Route::post('/update/{id}', [App\Http\Controllers\UserAdminController::class,'update'])->name('user.update');
        Route::get('/delete/{id}', [App\Http\Controllers\UserAdminController::class,'delete'])->name('user.delete');
    });

    //role
    Route::prefix('role')->group(function () {
        Route::get('/', [App\Http\Controllers\RoleAdminController::class,'index'])->name('role.index');
        Route::get('/create', [App\Http\Controllers\RoleAdminController::class,'create'])->name('role.create');
        Route::post('/store', [App\Http\Controllers\RoleAdminController::class,'store'])->name('role.store');
        Route::get('/edit/{id}', [App\Http\Controllers\RoleAdminController::class,'edit'])->name('role.edit');
        Route::post('/update/{id}', [App\Http\Controllers\RoleAdminController::class,'update'])->name('role.update');
        Route::get('/delete/{id}', [App\Http\Controllers\RoleAdminController::class,'delete'])->name('role.delete');
    });

    //feeship
    Route::prefix('feeship')->group(function () {
        Route::get('/', [App\Http\Controllers\Delivery::class,'index'])->name('feeship.index');
        Route::post('/select-delivery', [App\Http\Controllers\Delivery::class,'select_delivery'])->name('select_delivery');
        Route::post('/select-feeship', [App\Http\Controllers\Delivery::class,'select_feeship'])->name('select_feeship');
        Route::post('/insert-delivery', [App\Http\Controllers\Delivery::class,'insert_delivery'])->name('insert_delivery');
        Route::post('/update-delivery', [App\Http\Controllers\Delivery::class,'update_delivery'])->name('update_delivery');

    });

    //permission
    Route::prefix('permission')->group(function () {
        Route::get('/', [App\Http\Controllers\PermissionAdminController::class,'index'])->name('permission.index');
        Route::get('/create', [App\Http\Controllers\PermissionAdminController::class,'create'])->name('permission.create');
        Route::post('/store', [App\Http\Controllers\PermissionAdminController::class,'store'])->name('permission.store');
        Route::get('/edit/{id}', [App\Http\Controllers\PermissionAdminController::class,'edit'])->name('permission.edit');
        Route::post('/update/{id}', [App\Http\Controllers\PermissionAdminController::class,'update'])->name('permission.update');
        Route::get('/delete/{id}', [App\Http\Controllers\PermissionAdminController::class,'delete'])->name('permission.delete');
    });

});
//Route::get('/delivery', [App\Http\Controllers\Delivery::class,'index'])->name('feeship.index');
//Route::post('/select-delivery', [App\Http\Controllers\Delivery::class,'select_delivery'])->name('select_delivery');
