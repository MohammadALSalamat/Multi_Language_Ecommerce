<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\VendorController;
use App\Http\Controllers\LanguagesController;
use App\Http\Controllers\SubCategoryController;
use App\Http\Controllers\MainCategoryController;





/*
|--------------------------------------------------------------------------
| Web Routes For admins side
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

define('PaginationCount', 10);
Route::group(['middleware' => ['admin']], function () {

    Route::get('/Dashboard', [AdminController::class, 'Show_Dashboard'])->name('Show_Dashboard');
    ############### Languages Routs ################
    Route::group(['prefix' => 'Languges'], function () {
        Route::get('/', [LanguagesController::class, 'IndexLanguage'])->name('show_Languages');
        Route::get('/Create', [LanguagesController::class, 'CreateLanguage'])->name('Create_Languages');
        Route::post('/Store', [LanguagesController::class, 'StoreLanguage'])->name('Store_Languages');
        Route::match(['post', 'get'], '/edit/{id}', [LanguagesController::class, 'EditLanguage'])->name('Edit_Languages');
        Route::match(['post', 'get'], '/update/{id}', [LanguagesController::class, 'UpdateLanguage'])->name('Update_Languages');
        Route::match(['post', 'get'], '/delete/{id}', [LanguagesController::class, 'DeleteLanguage'])->name('Delete_Languages');
    });

    ############### Languages Routs ################
    ############### main Category Routs ################
    Route::group(['prefix' => 'MainCategory'], function () {
        Route::get('/', [MainCategoryController::class, 'IndexMainCategory'])->name('show_MainCategory');
        Route::get('/Create', [MainCategoryController::class, 'CreateMainCategory'])->name('Create_MainCategory');
        Route::post('/Store', [MainCategoryController::class, 'StoreMainCategory'])->name('Store_MainCategory');
        Route::match(['post', 'get'], '/edit/{id}', [MainCategoryController::class, 'EditMainCategory'])->name('Edit_MainCategory');
        Route::match(['post', 'get'], '/update/{id}', [MainCategoryController::class, 'UpdateMainCategory'])->name('Update_MainCategory');
        Route::match(['post', 'get'], '/update_otherLanguages/{id}', [MainCategoryController::class, 'updateotherLanguages'])->name('Update_MainCategory_OtherLanguages');
        Route::match(['post', 'get'], '/Activate/{id}', [MainCategoryController::class, 'Directe_Activate'])->name('Activate_MainCategory');
        Route::match(['post', 'get'], '/delete/{id}', [MainCategoryController::class, 'DeleteMainCategory'])->name('Delete_MainCategory');
    });

    ############### main category Routs ################


    ############### Sub Category Routs ################
    Route::group(['prefix' => 'SubCategory'], function () {
        Route::get('/', [SubCategoryController::class, 'IndexSubCategory'])->name('show_SubCategory');
        Route::get('/Create', [SubCategoryController::class, 'CreateSubCategory'])->name('Create_SubCategory');
        Route::post('/Store', [SubCategoryController::class, 'StoreSubCategory'])->name('Store_SubCategory');
        Route::match(['post', 'get'], '/edit/{id}', [SubCategoryController::class, 'EditSubCategory'])->name('Edit_SubCategory');
        Route::match(['post', 'get'], '/update/{id}', [SubCategoryController::class, 'UpdateSubCategory'])->name('Update_SubCategory');
        Route::match(['post', 'get'], '/update_otherLanguages/{id}', [SubCategoryController::class, 'updateotherLanguages'])->name('Update_SubCategory_OtherLanguages');
        Route::match(['post', 'get'], '/Activate/{id}', [SubCategoryController::class, 'Directe_Activate'])->name('Activate_SubCategory');
        Route::match(['post', 'get'], '/delete/{id}', [SubCategoryController::class, 'DeleteSubCategory'])->name('Delete_SubCategory');
    });

    ############### Sub category Routs ################


    ############### Vendors Routs ################
    Route::group(['prefix' => 'Vendors'], function () {
        Route::get('/', [VendorController::class, 'IndexVendors'])->name('show_Vendors');
        Route::get('/Create', [VendorController::class, 'CreateVendors'])->name('Create_Vendors');
        Route::post('/Store', [VendorController::class, 'StoreVendors'])->name('Store_Vendors');
        Route::match(['post', 'get'], '/edit/{id}', [VendorController::class, 'EditVendors'])->name('Edit_Vendors');
        Route::match(['post', 'get'], '/update/{id}', [VendorController::class, 'UpdateVendors'])->name('Update_Vendors');
        Route::match(['post', 'get'], '/Activate/{id}', [VendorController::class, 'Directe_Activate'])->name('Activate');
        Route::match(['post', 'get'], '/delete/{id}', [VendorController::class, 'DeleteVendors'])->name('Delete_Vendors');
    });

    ############### Vendors Routs ################
});

Route::get('/login', [AdminController::class, 'Login'])->name('admin_login');
Route::post('/EnterDashboard', [AdminController::class, "Enter_Dashboard"])->name('Enter_Dashboard');
