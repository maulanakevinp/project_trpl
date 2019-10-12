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
    Route::get('/my-profile', 'UserController@show');
    Route::get('/edit-profile', 'UserController@editProfile')->name('edit-profile');
    Route::patch('/update-profile/{id}', 'UserController@updateProfile')->name('update-profile');
    Route::get('/change-password', 'UserController@changePassword');
    Route::patch('/update-password/{id}', 'UserController@updatePassword')->name('update-password');

    Route::get('/pengajuan-surat', 'LetterController@index');
    Route::get('/salary/download/{id}', 'SalaryController@download')->name('salary.download');

    Route::group(['roles' => 'Super Admin'], function () {
        Route::get('/dashboard', 'HomeController@index')->name('home');
        Route::resource('/users', 'UserController')->except(['show']);
        Route::get('/users/softdelete/{id}', 'UserController@softdelete')->name('softdelete');
        Route::get('/users/trash', 'UserController@trash')->name('users.trash');
        Route::get('/users/restore/{id}', 'UserController@restore')->name('users.restore');
        Route::get('/users/restore', 'UserController@restoreAll')->name('users.restoreAll');

        Route::resource('/role', 'RoleController')->except(['create', 'show']);
        Route::post('/getRole/{id}', 'RoleController@getRole');
        Route::post('/change-access', 'RoleController@changeAccess');

        Route::resource('/menu', 'MenuController')->except(['create', 'show', 'edit']);
        Route::post('/getMenu', 'MenuController@getMenu');

        Route::resource('/submenu', 'SubmenuController')->except(['create', 'show', 'edit']);;
        Route::post('/getSubmenu', 'SubmenuController@getSubmenu');

        Route::get('/gender-chart', 'PopulationGraphController@gender')->name('gender-chart');
        Route::get('/age-chart', 'PopulationGraphController@age')->name('age-chart');
        Route::get('/education-chart', 'PopulationGraphController@education')->name('education-chart');
        Route::get('/religion-chart', 'PopulationGraphController@religion')->name('religion-chart');
        Route::get('/job-chart', 'PopulationGraphController@job')->name('job-chart');
        Route::get('/marital-chart', 'PopulationGraphController@marital')->name('marital-chart');
    });

    Route::group(['roles' => 'Kepala Desa'], function () {
        Route::patch('/salary/{id}', 'SalaryController@verify2')->name('salary.verify2');
        Route::get('/salary/unprocessed2', 'SalaryController@unprocessed2')->name('salary.unprocessed2');
        Route::get('/salary/verified2', 'SalaryController@verified2')->name('salary.verified2');
        Route::get('/salary/declined2', 'SalaryController@declined2')->name('salary.declined2');
    });

    Route::group(['roles' => 'Administrasi'], function () {
        Route::put('/salary/{id}', 'SalaryController@verify1')->name('salary.verify1');
        Route::get('/salary/unprocessed1', 'SalaryController@unprocessed1')->name('salary.unprocessed1');
        Route::get('/salary/verified1', 'SalaryController@verified1')->name('salary.verified1');
        Route::get('/salary/declined1', 'SalaryController@declined1')->name('salary.declined1');
    });

    Route::group(['roles' => 'Penduduk'], function () {
        Route::resource('/salary', 'SalaryController')->except(['create', 'edit', 'show']);
    });
});
