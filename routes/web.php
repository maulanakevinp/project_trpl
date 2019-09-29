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

Auth::routes(['verify' => true]);

Route::get('/', function () {
    return redirect()->route('login');
});

Route::group(['middleware' => ['web', 'auth', 'roles', 'verified']], function () {
    Route::get('/my-profile', 'UserController@show')->name('my-profile');
    Route::get('/edit-profile', 'UserController@editProfile')->name('edit-profile');
    Route::patch('/update-profile/{id}', 'UserController@updateProfile')->name('update-profile');
    Route::get('/change-password', 'UserController@changePassword')->name('change-password');
    Route::patch('/update-password/{id}', 'UserController@updatePassword')->name('update-password');

    Route::group(['roles' => 'Admin'], function () {
        Route::get('/dashboard', 'HomeController@index')->name('home');
        Route::resource('/users', 'UserController')->except(['show']);

        Route::resource('/role', 'RoleController')->except(['create', 'show']);
        Route::post('/getRole/{id}', 'RoleController@getRole');
        Route::post('/change-access', 'RoleController@changeAccess');

        Route::resource('/menu', 'MenuController')->except(['create', 'show', 'edit']);
        Route::post('/getMenu', 'MenuController@getMenu');

        Route::resource('/submenu', 'SubmenuController')->except(['create', 'show', 'edit']);;
        Route::post('/getSubmenu', 'SubmenuController@getSubmenu');

        Route::resource('/letters', 'LetterController')->except(['show', 'create', 'store']);

        Route::get('/gender-chart', 'PopulationGraphController@gender')->name('gender-chart');
        Route::get('/age-chart', 'PopulationGraphController@age')->name('age-chart');
        Route::get('/education-chart', 'PopulationGraphController@education')->name('education-chart');
        Route::get('/religion-chart', 'PopulationGraphController@religion')->name('religion-chart');
        Route::get('/job-chart', 'PopulationGraphController@job')->name('job-chart');
        Route::get('/marital-chart', 'PopulationGraphController@marital')->name('marital-chart');
    });

    Route::group(['roles' => 'Member'], function () {
        Route::get('/letters/show', 'LetterController@show')->name('letters.show');
        Route::get('/letters/create', 'LetterController@show')->name('letters.create');
        Route::post('/letters', 'LetterController@show')->name('letters.store');
    });
});
