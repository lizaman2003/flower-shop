<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MainController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BinController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\OrderController;

Route::get('/', [MainController::class, 'index'])->name('index');
Route::get('/category/{id}', [MainController::class, 'index'])->name('category');
Route::get('/item/{id}', [MainController::class, 'item'])->name('item');
Route::get('/we', [MainController::class, 'we'])->name('we');
Route::get('/contact', [MainController::class, 'contact'])->name('contact');
Route::get('/sorting', [MainController::class, 'sorting'])->name('sorting');


//РОУТЫ ДЛЯ ГОСТЕЙ КОТОРЫЕ НЕ АВТОРИЗОВАЛИСЬ
Route::middleware(['guest'])->group(function () {
    Route::post('/register', [UserController::class, 'register'])->name('register');
    Route::post('/auth', [UserController::class, 'auth'])->name('auth');
});

// РОУТЫ ДЛЯ АВТОРИЗОВАННЫХ
Route::middleware(['auth'])->group(function () {
    Route::get('/logout', [UserController::class, 'logout'])->name('logout');
    Route::get('/bin', [BinController::class, 'bin'])->name('bin');
    Route::get('/bin/changeCount', [BinController::class, 'changeCount'])->name('changeCount');
    Route::get('/addBin', [BinController::class, 'addBin'])->name('addBin');
    Route::post('/order', [OrderController::class, 'addOrder'])->name('addOrder');
    Route::get('/myorder', [OrderController::class, 'order'])->name('order');
    Route::post('/myorder/delete/{id}', [OrderController::class, 'deleteOrder'])->name('deleteOrder');
    Route::post('/bin/remove-item', [BinController::class, 'removeItem'])->name('bin.removeItem');
    
});

//РОУТЫ ДЛЯ АДМИНА
Route::middleware(['admin'])->group(function () {
    Route::get('/admin', [AdminController::class, 'admin'])->name('admin');
    Route::get('/admin/deletecategory/{id}', [AdminController::class, 'deleteCategory'])->name('deleteCategory');
    Route::post('/admin/createcategory', [AdminController::class, 'createCategory'])->name('createCategory');
    Route::get('/admin/deleteitem/{id}', [AdminController::class, 'deleteItem'])->name('deleteItem');
    Route::get('/filter', [AdminController::class, 'filter'])->name('filter');
    Route::post('/admin/selectstatus', [AdminController::class, 'selectStatus1'])->name('selectStatus1');
    Route::post('/admin/selectstatus2', [AdminController::class, 'selectStatus2'])->name('selectStatus2');
    Route::post('/admin/createItem', [AdminController::class, 'createItem'])->name('createItem');
    Route::get('/admin/editItemPage/{id}', [AdminController::class, 'editItemPage'])->name('editItemPage');
    Route::post('/admin/editItem', [AdminController::class, 'editItem'])->name('editItem');
});
