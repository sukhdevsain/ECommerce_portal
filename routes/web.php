<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\SubcategoryController;
use App\Http\Controllers\ProductdetailController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VendorController;
use App\Http\Controllers\Vendor\VendorOrderController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\admin\AdminCategoryController;
use App\Http\Controllers\admin\AdminBannerController;
use App\Http\Controllers\vendor\ProductController;
use App\Http\Middleware\VendorMiddleware;
use App\Http\Controllers\PaymentController;

Route::get('/', function () {
    return view('welcome');
});

Route::post('/check-phone',[UserController::class,'checkPhone'])->name('check.phone');
Route::post('/authentication-verify-otp',[UserController::class,'authenticationVerifyOtp'])->name('authentication.verify.otp');

Route::post('/submit-phone-billing',[UserController::class,'submitPhoneAndBilling'])->name('submit.phone.billing');
Route::post('/verify-otp',[UserController::class,'verifyOtp'])->name('verify.otp');
Route::post('/place-order', [CheckoutController::class, 'placeOrder'])->name('place.order')->middleware('auth');
Route::post('/checkout',[CheckoutController::class,'checkout'])->name('checkout');

// ✅ Stripe - single clean route pointing to PaymentController
Route::post('/stripe/create-intent', [PaymentController::class, 'createPaymentIntent'])->name('stripe.intent')->middleware('auth');
Route::get('/payment-success', [CheckoutController::class, 'paymentSuccess'])->middleware('auth');

Route::get('/',[HomeController::class,'index']);

Route::get('Category/{category}',[CategoryController::class,'detail'])->name('category');

Route::get('Sub-Category/{category}/{sub_category}',[SubcategoryController::class,'detail'])->name('category.subcategory');

Route::get('Sub-Category/{category}/{sub_category}/{product_detail}',[ProductdetailController::class,'detail'])->name('product_detail');

Route::get('/cart-list/{slug}',[CartController::class,'list']);

Route::get('/checkout/{slug}',[CheckoutController::class,'checkout']);

Route::get('register',[UserController::class,'register']);
Route::get('register1',[UserController::class,'register1']);
Route::get('login',[UserController::class,'login']);
Route::get('login1',[UserController::class,'login1']);

// User Dashboard Routes
Route::get('user/',[UserController::class,'index']);
Route::get('user/order-history/',[UserController::class,'history']);
Route::get('user/detail/{slug}',[UserController::class,'detail']);
Route::get('user/detail/{order_id}', [UserController::class, 'detail'])->name('user.detail');
Route::post('user/settings/update',[UserController::class,'updateSettings'])->name('user.settings.update');
Route::get('user/settings/',[UserController::class,'settings']);

// Vendor Dashboard Routes
Route::get('vendor/signup',[VendorController::class,'signup']);
Route::post('vendor/signup',[VendorController::class,'register']);
Route::get('vendor/login',[VendorController::class,'login']);
Route::post('vendor/login',[VendorController::class,'login_create']);
Route::get('vendor/logout',[VendorController::class,'logout']);
Route::get('vendor/forget',[VendorController::class,'forget']);
Route::get('vendor/',[VendorController::class,'index'])->middleware(VendorMiddleware::class);
Route::get('/vendor/login', [VendorController::class, 'login'])->name('vendor.login');

Route::get('vendor/add-product',[ProductController::class,'addproduct']);
Route::post('vendor/add-product',[ProductController::class,'createproduct']);
Route::get('vendor/view-product',[ProductController::class,'viewproduct']);
Route::get('vendor/edit-product/{p_id}',[ProductController::class,'editproduct']);
Route::put('vendor/edit-product/{p_id}',[ProductController::class,'updateproduct']);
Route::delete('vendor/delete-product/{p_id}',[ProductController::class,'deleteproduct']);

Route::get('vendor/orders',[VendorOrderController::class,'index']);
Route::get('vendor/order-processing/{order_id}', [VendorOrderController::class, 'updateStatus'])->name('order.processing');
Route::get('vendor/order-ontheway/{order_id}', [VendorOrderController::class, 'updateStatus'])->name('order.ontheway');
Route::get('vendor/order-delivered/{order_id}', [VendorOrderController::class, 'updateStatus'])->name('order.delivered');
Route::get('vendor/order-detail/{id}',[VendorController::class,'orderdetail']);
Route::get('vendor/users',[VendorController::class,'users']);
Route::get('vendor/profile',[VendorController::class,'profile']);
Route::put('vendor/profile',[VendorController::class,'updateprofile']);

Route::prefix('vendor')->middleware('vendor.middleware')->group(function(){
    Route::get('orders', [VendorOrderController::class, 'index'])->name('vendor.orders');
});

// Admin Dashboard Routes
Route::get('admin/login',[AdminController::class,'login']);
Route::get('admin/',[AdminController::class,'index']);
Route::get('admin/order-detail/{id}',[AdminController::class,'orderdetail'])->name('admin.order.detail');

Route::get('admin/add-category',[AdminCategoryController::class,'addcategory']);
Route::post('admin/add-category',[AdminCategoryController::class,'createcategory']);
Route::get('admin/view-category',[AdminCategoryController::class,'viewcategory']);
Route::get('admin/edit-category/{c_id}',[AdminCategoryController::class,'editcategory']);
Route::put('admin/edit-category/{c_id}',[AdminCategoryController::class,'updatecategory']);
Route::delete('admin/view-category/{c_id}',[AdminCategoryController::class,'deletecategory']);

Route::get('admin/users',[AdminController::class,'users']);
Route::get('admin/vendors',[AdminController::class,'vendors']);
Route::get('admin/vendors/{id}/verified',[VendorController::class,'verified'])->name('vendor.verified');
Route::get('admin/vendors/{id}/unverified',[VendorController::class,'unverified'])->name('vendor.unverified');
Route::get('admin/orders',[AdminController::class,'orders']);

Route::get('admin/add-banner',[AdminBannerController::class,'addbanner']);
Route::post('admin/add-banner',[AdminBannerController::class,'createbanner']);
Route::get('admin/view-banner',[AdminBannerController::class,'viewbanner']);
Route::delete('admin/delete-banner/{b_id}',[AdminBannerController::class,'deletebanner']);