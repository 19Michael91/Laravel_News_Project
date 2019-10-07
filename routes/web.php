<?php

use App\User;

Auth::routes();

Route::get('/', 'NewsController@index')->name('news.index');

Route::get('category/{category_id}', 'NewsController@getNewsByCategory')->name('news.category');
Route::get('single/{news_id}', 'NewsController@getSingleNews' )->name('news.single');
Route::get('add_favorite/{news_id}', 'NewsController@addNewsToFavorite' )->name('news.add_favorite');
Route::get('remove_favorite/{news_id}', 'NewsController@removeNewsFromFavorite' )->name('news.remove_favorite');
Route::get('favorites', 'NewsController@getFavoritesNews' )->name('news.favourite');
Route::get('subscribe', 'NewsController@subscribe')->name('news.subscribe');
Route::get('unsubscribe', 'NewsController@unsubscribe')->name('news.unsubscribe');
Route::post('search', 'NewsController@searchNews')->name('news.search');


Route::prefix('admin')->middleware(['auth'])->group(function () {
    Route::get('/', 'AdminController@getAllNews')->name('admin.index');
    Route::get('/create', 'AdminController@createNews')->name('admin.create');
    Route::get('/delete/{news_id}', 'AdminController@destroyNews')->name('admin.destroy');
    Route::post('/store', 'AdminController@storeNews')->name('admin.store');
});
