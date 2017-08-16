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

// مشاهده پروفایل کاربر
Route::get('user/{user_name}','WebsitesController@showUserProfile');

// مشاهده تمام سایت ها
Route::get('websites','WebsitesController@showWebsites');
// مشاهده تمام وبسایت های کاربر جهت بروز رسانی
Route::get('websites/mywebsites','WebsitesController@showMyWebsites');
// وبسایت های پسندیده
Route::get('websites/likedwebsites','WebsitesController@showLiked');

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

// انجام لایک و پس گرفتن آن
Route::get('websites/api/togglelike','LikesController@toggleLike');

// تهیه نظرات کاربران در مورد یک وبسایت
Route::get('websites/api/comments/{website_id}','WebsiteViewsController@getComments')
        ->where(['website_id'=>'[0-9]+']);

// اضافه کردن یه نظر جدید
Route::post('website/api/comments/add','WebsiteViewsController@addComment');

// حزف یه نظر
Route::post('website/api/comments/delete','WebsiteViewsController@deleteComment');

// صفحه اصلی پنل ادمین
Route::get('admin','WebAdmin@home');

// پنل ادمین لیست کاربران
Route::get('admin/users','WebAdmin@users');

// اصلاح کاربر
Route::match(['get','post'],'admin/users/edit/{userid}','WebAdmin@showUserEdit');

// حزف کاربر
Route::match(['get','post'],'admin/users/remove/{userid}','WebAdmin@showUserRemove');

// پنل ادمین لیست وبسایت ها
Route::get('admin/websites/','WebAdmin@websites');

// اصلاح وبسایت
Route::match(['get','post'],'admin/websites/edit/{websiteid}','WebAdmin@showWebEdit');

// حزف وبسایت
Route::match(['get','post'],'admin/websites/remove/{websiteid}','WebAdmin@showWebRemove');

// حزف تمام وبسایت های کاربر
Route::match(['get','post'],'admin/websites/removeall/{websiteid}','WebAdmin@showWebAllRemove');

// صفحه ساخت هش
Route::match(['get','post'],'admin/hashcreator','WebAdmin@showHashCreator');


// پنل ادمین لیست نظرات
Route::get('/admin/comments','WebAdmin@showComments');

// اصلاح کامنت
Route::match(['get','post'],'admin/comments/edit/{commentid}','WebAdmin@showCommentEdit');

// حزف کامنت
Route::match(['get','post'],'admin/comments/remove/{commentid}','WebAdmin@showCommentRemove');

// حزف تمام کامنت های کاربر
Route::match(['get','post'],'admin/comments/removeall/{commentid}','WebAdmin@showCommentAllRemove');

// جهت انجام کانفیگ های لازم .
Route::get('doconfig/awjawidawoawdinawodnawnoanovawnognwaroira',function()
{
    Artisan::call('migrate');
    echo 'Done!';
});
