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


    Route::post('/register_invitation', 'CustomAuthController@register_invitation')->name('register_invitation');
    Route::get('/loginPage','CustomAuthController@loginPage')->name('loginPage');
    Route::get('/registerPage','CustomAuthController@registerPage')->name('registerPage');
    Route::get('/create_event/{name}/{location}/{date}','EventController@create_event')->name('create_event');

    Route::post('/phoneLogin','CustomAuthController@phoneLogin')->name('phoneLogin');
    Route::get('/removeRedirectToHome','CustomAuthController@removeRedirectToHome')->name('removeRedirectToHome');

    Route::get('/quiz_join/{id}','HomeController@quiz_join')->name('quiz_join');
    Route::get('/polling_question/{id?}','HomeController@polling_question')->name('polling_question');
    Route::get('/polling_response/{id}','HomeController@polling_response')->name('polling_response');
    Route::get('/polling_response/{question_id?}/{answer_id?}','HomeController@select_polling_response')->name('select_polling_response');
    Route::get('/set_winner/{response_id?}/{invitation_id?}','HomeController@set_winner')->name('set_winner');
    Route::get('/quiz_report/{polling_id?}','HomeController@quiz_report')->name('quiz_report');
    Route::get('/quiz_result/{polling_id?}','HomeController@quiz_result')->name('quiz_result');
    Route::get('/quiz_result_data/{polling_id}','HomeController@quiz_result_data')->name('quiz_result_data');

    Route::post('/join_quiz/{id}', 'HomeController@join_quiz')->name('join_quiz');
    Route::get('/downloadBarcode', 'HomeController@downloadBarcode')->name('downloadBarcode');
    Route::get('/sendEmailBarcode', 'HomeController@sendEmailBarcode')->name('sendEmailBarcode');

    Route::get('/logout','CustomAuthController@logout')->name('logout');
    Route::get('/', 'HomeController@index')->name('home');

    Auth::routes();
    
    Route::middleware(['auth'])->group(function () {

    	Route::get('/polling_response/{polling_id}/{invitation_id}/reset','PollingController@polling_response_reset')->name('polling_response.reset');
        Route::get('/quiz_response/{id}','HomeController@quiz_response')->name('quiz_response');
    	Route::get('/quiz_response/{question_id?}/{answer_id?}','HomeController@select_quiz_response')->name('select_quiz_response');
        Route::get('/invitation/register/face', 'InvitationController@register_face')->name('invitation.register_face');
        Route::get('/invitation/check_in/face', 'InvitationController@check_in_face')->name('invitation.check_in_face');
        Route::post('/invitation/check_id', 'InvitationController@check_id')->name('invitation.check_id');
        Route::post('/invitation/register/face', 'InvitationController@process_register_face')->name('invitation.process_register_face');

    });

    Route::middleware(['auth','admin'])->prefix('admin')->group(function () {
        Route::get('/product/chart/{id}','HomeController@product_chart')->name('product.chart');
        Route::get('/product/report','HomeController@product_report')->name('product.report');
        Route::get('/product/report/excel','HomeController@product_export_excel')->name('product.export_excel');
        Route::get('/presence/report','InvitationController@report')->name('presence.report');
        Route::get('/presence/export/excel', 'InvitationController@export_excel')->name('invitation.export_excel');
        Route::get('/quiz/export/excel/{polling_id}', 'HomeController@quiz_export_excel')->name('quiz.export_excel');
        Route::get('/invitation/{id}/clear','InvitationController@clear')->name('invitation.clear');
        Route::get('/invitation/reset','InvitationController@reset')->name('invitation.reset');
        Route::get('/polling/report','PollingController@report')->name('polling.report');
        Route::get('/','HomeController@admin')->name('admin');
        Route::get('/invitation/import', 'InvitationController@import')->name('invitation.import');
        Route::post('/invitation/import', 'InvitationController@process_import')->name('invitation.process_import');
        Route::resource('event_detail','EventDetailController');
        Route::resource('invitation','InvitationController');
        Route::resource('polling','PollingController');
        Route::get('/polling/{polling_id?}/{question_id?}','PollingController@detail')->name('polling.detail');
        Route::resource('polling_answer','PollingAnswerController');
        Route::resource('polling_question','PollingQuestionController');
        Route::get('/screen','HomeController@screen')->name('screen');
    });

    // Route::prefix('products')->group(function () {
    // 	Route::get('/{type}/{code}',function($type, $code)
    // 	{
    // 		return view('products')->with(['type'=>$type,'code'=>$code]);
    // 	});
    // });
    Route::get('/response_product/{code?}/{response?}','HomeController@response_product')->name('response_product');