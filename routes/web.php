<?php

use Illuminate\Support\Facades\Route;


Route::post('/books','App\Http\Controllers\BookController@store');
Route::patch('/books/{book}','App\Http\Controllers\BookController@update');
Route::delete('/books/{book}','App\Http\Controllers\BookController@destroy');

Route::post('/author','App\Http\Controllers\AuthorController@store');
