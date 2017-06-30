<?php

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
    return view('home');
})->middleware('nonusersonly');

Route::get('logout',function(){
    return redirect('/')->withCookie(Cookie::forget('userid'))->withCookie(Cookie::forget('usersession'));
})->middleware('usersonly');


Route::match(['get','post'],'signup','UserManagmentController@signup');

Route::match(['get','post'],'signin','UserManagmentController@signin');

Route::get('websites','WebsitesController@showWebsites');
Route::get('websites/mywebsites','WebsitesController@showMyWebsites');

Route::match(['get','post'],'websites/addwebsite','WebsitesController@addWebsite');
Route::match(['get','post'],'websites/editwebsite','WebsitesController@editWebsite');

Route::get('websites/api/requestvisit','WebsiteViewsController@requestVisit');
Route::get('websites/api/requestpoint','WebsiteViewsController@requestPoint');
Route::get('websites/api/submitpoint','WebsiteViewsController@submitPoint');

Route::get('websites/api/current_image.png','WebsiteViewsController@getCurrectImage');

Route::get('doconfig/awjawidawoawdinawodnawnoanovawnognwaroira',function()
{
    Artisan::call('migrate');
    echo 'Done!';
});