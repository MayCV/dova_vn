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
Route::get('/login','Backend\LoginController@getLogin');
Route::post('/login', 'Backend\LoginController@postLogin');
// Route::get('/nhan-su', function () {
//     return view('admin/nhansu/ns_chamcong');
// });
Route::group(['prefix' => 'staff'], function () {
    Route::get('home', "Backend\StaffController@home" );
    Route::get('timecard', "Backend\StaffController@getTimeCard");
    Route::post('timecard', "Backend\StaffController@postTimeCard");
    Route::get('timecard/info/january', "Backend\StaffController@getJanuary");
    

});
Route::group(['prefix' => 'admin/{satff_id}','middleware'=>'login'], function () {
    Route::get('/', 'Backend\HomeController@admin'); 
   
});
Route::get('editnote/{id}', ['uses'=> 'Backend\StaffController@getEditnote']);
Route::put('/editNote/edit/{id}', "Backend\StaffController@postEditnote");
Route::get('admin', "Backend\LoginController@login");
// -------------------------phần vinh

Route::get('/', function () {
    return view('welcome');
});
// ---login

// User
Route::get('/','Frontend\HomeController@index')->name('home');
Route::get('/listUser', 'Backend\UserController@list')
    ->name('User.Index');
Route::post('/updateUser/{User_id}', 'Backend\UserController@update');
Route::get('/editUser/{User_id}', 'Backend\UserController@edit')->name('user.edit')
        ->name('User.Edit');
Route::post('/saveUser', 'Backend\UserController@save');
Route::get('/addUser', 'Backend\UserController@add')
    ->name('User.Add');
Route::get('/deleteUser/{User_id}', 'Backend\UserController@delete');

//Project Route
Route::group(["prefix" => "project"], function() {
    Route::get('/projectHome', 'Backend\ProjectController@index')->name('home_project');
    Route::get('/listProject', 'Backend\ProjectController@getList')->name('list_project');
    Route::get('/createProject', 'Backend\ProjectController@create')->name('create_project');
    Route::post('/createProject', 'Backend\ProjectController@store')->name('store_project');
    Route::get('/editProject', 'Backend\ProjectController@edit')->name('edit_project');
    Route::post('/updateProject/{id}', 'Backend\ProjectController@update')->name('update_project');
    Route::get('/ongoingProject', 'Backend\ProjectController@ongoingList')->name('ongoing_project');
    Route::get('/completeProject', 'Backend\ProjectController@completeList')->name('complete_project');
    Route::get('/unexecutedProject', 'Backend\ProjectController@unexecutedList')->name('unexecuted_project');
    Route::get('/searchDate', 'Backend\ProjectController@searchDate')->name('search_date');
    Route::get('/search', 'Backend\ProjectController@search')->name('search');
    Route::get('/projectDetails/{id}', 'Backend\ProjectController@detail')->name('project_detail');
});
