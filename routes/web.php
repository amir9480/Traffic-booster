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

//ثبت نام
Route::match(['get','post'],'signup','UserManagmentController@signup');

// ورود
Route::match(['get','post'],'signin','UserManagmentController@signin');

// تغییر رمز فراموش شده
Route::match(['get','post'],'passreset','UserManagmentController@passwordReset');

// فرم ارسال لینک ریست پسورد
Route::match(['get','post'],'passremember','UserManagmentController@passRemeber');

// مشاهده تمام سایت ها
Route::get('websites','WebsitesController@showWebsites');
// مشاهده تمام وبسایت های کاربر جهت بروز رسانی
Route::get('websites/mywebsites','WebsitesController@showMyWebsites');

// افزودن سایت جدید
Route::match(['get','post'],'websites/addwebsite','WebsitesController@addWebsite');

// اصلاح سایت وجود کاربر
Route::match(['get','post'],'websites/editwebsite','WebsitesController@editWebsite');

//AJAX درخواست مشاهده ی سایت
Route::get('websites/api/requestvisit','WebsiteViewsController@requestVisit');

// AJAX  درخواست فرم اعتبار سنجی
Route::get('websites/api/requestpoint','WebsiteViewsController@requestPoint');

// Ajax اعتبار سنجی و ثبت امتیاز
Route::get('websites/api/submitpoint','WebsiteViewsController@submitPoint');

// Ajax تصویر اعتبار سنجی
Route::get('websites/api/current_image.png','WebsiteViewsController@getCurrectImage');



// جهت انجام کانفیگ های لازم . چنانچه به پایان رسید حتما این قسمت کامنت شود
//Route::get('doconfig/awjawidawoawdinawodnawnoanovawnognwaroira',function()
//{
//    Artisan::call('migrate');
//    echo 'Done!';
//});
