<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\auth\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\admin\AdminController;
use App\Http\Controllers\employer\EmployerController;
use App\Http\Controllers\employer_listing\EmployerListingController;


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

Route::controller(AuthController::class)->group(function () {
    Route::get('/', 'login_view')->name('login');
    Route::post('/', 'login');
    Route::get('register', 'register_view')->name('register');
    Route::post('register', 'register');

    Route::post('logout', 'logout')->name('logout');

});

Route::controller(DashboardController::class)->group(function () {
    Route::get('dashboard', 'index')->name('dashboard');
});

Route::controller(EmployerController::class)->group(function () {
    Route::get('employerdashboard', 'index')->name('employerdashboard');
    Route::get('profile', 'profile')->name('employerprofile');
});

Route::controller(AdminController::class)->group(function () {
    Route::get('show', 'index')->name('adminprofile');
    Route::patch('details', 'update')->name('admindetails');
    Route::patch('password', 'password')->name('adminpassword');
    Route::patch('picture', 'picture')->name('adminpicture');
    Route::get('employers', 'employers')->name('employers');
    Route::get('showemployers/{id}', 'showemployers')->name('showemployers');
    Route::get('editemp/{id}', 'edit')->name('edit');
    Route::patch('updateemployer/{id}', 'updateemployer')->name('updateemployer');
    Route::patch('updatepicture/{id}', 'updatepicture')->name('updateemployerpicture');
    Route::patch('updatepassword/{id}', 'updateemployerpassword')->name('updateemployerpassword');
    Route::delete('deleteemployer/{id}', 'deleteemployer')->name('deleteemployer');
    Route::get('createemployer', 'createemployer')->name('create.employer');
    Route::post('createemployer', 'addemployer');
    Route::get('listings', 'listings')->name('listings');
    Route::get('{id}/showlistings', 'showlistings')->name('showlistings');

    Route::get('editlistings/{listing}', 'editlistings')->name('editlistings');
    Route::patch('editlistings/{listing}', 'updateListings');
    Route::patch('updatedec_addr/{listing}', 'updatedec_addr')->name('updatedec_addr');
    Route::delete('deletelisting/{listing}', 'destroy')->name('deletelisting');
    Route::get('createlisting', 'createlistings')->name('createlistings');
    Route::post('createlisting', 'addlistings');

});

Route::controller(EmployerListingController::class)->group(function(){
    Route::get('showlist', 'index')->name('showlisting');
    Route::get('create','create')->name('createlisting');
    Route::post('create','store');
    Route::get('{listing}/showemployerlistings','show')->name('show');
    Route::get('{listing}/edit','edit')->name('editlisting');
    Route::post('{listing}/edit','update');
    Route::get('{listing}/add_desc','add_desc')->name('editadddesc');
    Route::post('{listing}/add_desc','add_desc');

    Route::patch('employerpassword', 'password')->name('password');
    Route::patch('employerpicture', 'picture')->name('picture');
    Route::delete('{listing}/edit','destroy')->name('destroy');
});
