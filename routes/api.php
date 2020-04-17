<?php
use Illuminate\Support\Facades\Route;

Route::group(['namespace'=>'Api\V1'],function (){

    //公共组
    Route::group(['prefix'=>'/v1'],function (){

        Route::get('/index','IndexController@index');


    });

});