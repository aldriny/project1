<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\CustomerController;
use App\Http\Controllers\Auth\UserController;

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

Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified'
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});


/////////////////////////////////////////////////////////////////////////////////////////////////////////
//-- Admins Routes --//

Route::post('/admin/check',[LoginController::class,'process_admin_login'])->name('admin.login2');
Route::post('/admin/save',[LoginController::class,'process_admin_signup'])->name('admin.register2');
Route::get('/admin/logout',[LoginController::class,'admin_logout'])->name('admin.logout');

Route::group(['middleware'=>['AuthCheck']],function(){
    Route::get('/admin/login',[LoginController::class,'show_login_form'])->name('admin.login1');
    Route::get('/admin/register',[LoginController::class,'show_signup_form'])->name('admin.register1');
    Route::get('/admin/dashboard',[LoginController::class,'admin_dashboard'])->name('admin.dashboard');
    Route::get('/admin/add-place',[LoginController::class,'show_add_place'])->name('admin.add.place');
    Route::post('/admin/view-places', [LoginController::class, 'add_place'])->name('admin.add.places');
    Route::get('/admin/view-places',[LoginController::class,'view_places'])->name('admin.view.places');;
    Route::get('/admin/show-place/{id}', [LoginController::class, 'show_place'])->name('admin.show.place');
    Route::post('/admin/edit-place/{id}', [LoginController::class, 'edit_place'])->name('admin.edit.place');
    Route::get('/admin/delete-place/{id}', [LoginController::class, 'delete_place'])->name('admin.delete.place');
    
    Route::get('/admin/partner-requests', [LoginController::class, 'partner_req'])->name('admin.partner.req');
    Route::get('/admin/partner-reports', [LoginController::class, 'partner_rep'])->name('admin.partner.rep');


});
/////////////////////////////////////////////////////////////////////////////////////////////////////////
//-- Customers Routes --//


Route::post('/customer/check/',[CustomerController::class,'process_admin_login'])->name('customer.login2');
Route::get('/customer/logout',[CustomerController::class,'admin_logout'])->name('customer.logout');

Route::group(['middleware'=>['AuthCheck2']],function(){
    Route::get('/customer/login',[CustomerController::class,'show_login_form'])->name('customer.login1');
    Route::get('/customer/dashboard/',[CustomerController::class,'admin_dashboard'])->name('customer.dashboard');

    Route::get('/customer/view-place/',[CustomerController::class,'view_place'])->name('customer.view.place');

    Route::get('/customer/edit-place/',[CustomerController::class,'edit_place'])->name('customer.edit');

    Route::post('/customer/view-place/',[CustomerController::class,'edit_myplace'])->name('customer.edit.myplace');

    Route::get('/customer/change-password/',[CustomerController::class,'show_change_password'])->name('show.change.password');
    Route::post('/customer/change-password/',[CustomerController::class,'change_password'])->name('change.password');


});
/////////////////////////////////////////////////////////////////////////////////////////////////////////
//-- Users Routes --//

Route::post('/user/check/',[UserController::class,'process_user_login'])->name('user.login2');
Route::post('/user/save',[UserController::class,'process_user_signup'])->name('user.register2');
Route::get('/user/logout',[UserController::class,'user_logout'])->name('user.logout');

Route::group(['middleware'=>['AuthCheck3']],function(){
    Route::get('/user/login',[UserController::class,'show_login_form'])->name('user.login1');
    Route::get('/user/register',[UserController::class,'show_signup_form'])->name('user.register1');
    Route::get('/user/dashboard/',[UserController::class,'user_dashboard'])->name('user.dashboard');

    Route::post('/user/dashboard/',[UserController::class,'become_partner'])->name('become.partner');


    Route::get('/user/view-place/{id}/{distance}',[UserController::class,'show_user_place'])->name('user.show.place');


    Route::get('/user/search/',[UserController::class,'show_search_places'])->name('user.search');

    Route::get('/user/malls/',[UserController::class,'show_malls'])->name('user.show.malls');
    Route::get('/user/restaurants/',[UserController::class,'show_rest'])->name('user.show.rest');
    Route::get('/user/hospitals/',[UserController::class,'show_hosp'])->name('user.show.hosp');
    Route::get('/user/stores/',[UserController::class,'show_stores'])->name('user.show.stores');
    Route::get('/user/cafes/',[UserController::class,'show_cafes'])->name('user.show.cafes');
    Route::get('/user/companies/',[UserController::class,'show_comp'])->name('user.show.comp');


});
