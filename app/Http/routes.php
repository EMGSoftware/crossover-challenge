<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', 'HomeController@index');
//Route::get('public', 'ReportController@index');

Route::group(['middleware' => 'auth'], function()
{
    Route::get('reports/{report_id}/download_pdf', ['uses' =>'ReportController@download_pdf'])->name('reports.download_pdf');
    Route::get('reports/{report_id}/send_pdf', ['uses' =>'ReportController@send_pdf'])->name('reports.send_pdf');
    Route::resource("reports","ReportController");
    Route::resource("patients","PatientController");
    Route::resource("tests_definitions","TestController");
    Route::resource("operators","OperatorController");
    
});

Route::get('users/login', 'Auth\AuthController@getLogin');
Route::post('users/login', 'Auth\AuthController@postLogin');
Route::get('users/logout', 'Auth\AuthController@getLogout');
Route::auth();
