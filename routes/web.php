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
    Route::put('/update-profile/{id}', 'UserController@updateProfile')->name('update-profile');
    Route::get('/change-password', 'UserController@changePassword');
    Route::patch('/update-password/{id}', 'UserController@updatePassword')->name('update-password');

    Route::get('/pengajuan-surat', 'LetterController@index')->name('pengajuan-surat');
    Route::get('/salary/download/{id}', 'SalaryController@download')->name('salary.download');
    Route::get('/incapable/download/{id}', 'IncapableController@download')->name('incapable.download');

    Route::get('/detail-kk/{kk}', 'UserController@detailKK')->name('detail-kk');
    Route::get('/detail-nik/{nik}', 'UserController@detailNIK')->name('detail-nik');

    Route::group(['roles' => 'Super Admin'], function () {

        Route::put('/users/restore-all', 'UserController@restoreAll')->name('users.restoreAll');
        Route::delete('/users/softdelete/{id}', 'UserController@softdelete')->name('users.delete');
        Route::patch('/users/restore/{id}', 'UserController@restore')->name('users.restore');
        Route::resource('/users', 'UserController')->except(['show']);
        Route::get('/users/trash', 'UserController@trash')->name('users.trash');

        Route::resource('/role', 'RoleController')->except(['create', 'show']);
        Route::post('/getRole/{id}', 'RoleController@getRole');
        Route::post('/change-access', 'RoleController@changeAccess');

        Route::resource('/menu', 'MenuController')->except(['create', 'show', 'edit']);
        Route::post('/getMenu', 'MenuController@getMenu');

        Route::resource('/submenu', 'SubmenuController')->except(['create', 'show', 'edit']);;
        Route::post('/getSubmenu', 'SubmenuController@getSubmenu');

    });

    Route::group(['roles' => 'Kepala Desa'], function () {
        
        Route::get('/dashboard', 'HomeController@index')->name('home');

        //Salary
        Route::patch('/salary/{id}/verify2', 'SalaryController@verify2')->name('salary.verify2');
        Route::get('/salary/unprocessed2', 'SalaryController@unprocessed2')->name('salary.unprocessed2');
        Route::get('/salary/{id}/unprocessed2', 'SalaryController@editUnprocessed2')->name('salary.edit-unprocessed2');
        Route::get('/salary/verified2', 'SalaryController@verified2')->name('salary.verified2');
        Route::get('/salary/declined2', 'SalaryController@declined2')->name('salary.declined2');
        Route::get('/salary/{id}/declined2', 'SalaryController@editDeclined2')->name('salary.edit-declined2');

        //Incapable
        Route::patch('/incapable/{id}/verify2', 'IncapableController@verify2')->name('incapable.verify2');
        Route::get('/incapable/unprocessed2', 'IncapableController@unprocessed2')->name('incapable.unprocessed2');
        Route::get('/incapable/{id}/unprocessed2', 'IncapableController@editUnprocessed2')->name('incapable.edit-unprocessed2');
        Route::get('/incapable/verified2', 'IncapableController@verified2')->name('incapable.verified2');
        Route::get('/incapable/declined2', 'IncapableController@declined2')->name('incapable.declined2');
        Route::get('/incapable/{id}/declined2', 'IncapableController@editDeclined2')->name('incapable.edit-declined2');

        Route::get('/jenis-kelamin', 'PopulationGraphController@gender')->name('jenis-kelamin');
        Route::get('/usia', 'PopulationGraphController@age')->name('usia');
        Route::get('/agama', 'PopulationGraphController@religion')->name('agama');
        Route::get('/status-pernikahan', 'PopulationGraphController@marital')->name('status-pernikahan');
        
    });

    Route::group(['roles' => 'Administrasi'], function () {
        //Salary
        Route::put('/salary/{id}/verify1', 'SalaryController@verify1')->name('salary.verify1');
        Route::get('/salary/unprocessed1', 'SalaryController@unprocessed1')->name('salary.unprocessed1');
        Route::get('/salary/{id}/unprocessed1', 'SalaryController@editUnprocessed1')->name('salary.edit-unprocessed1');
        Route::get('/salary/verified1', 'SalaryController@verified1')->name('salary.verified1');
        Route::get('/salary/{id}/verified1', 'SalaryController@editVerified1')->name('salary.edit-verified1');
        Route::get('/salary/declined1', 'SalaryController@declined1')->name('salary.declined1');
        
        //Incapable
        Route::put('/incapable/{id}/verify1', 'IncapableController@verify1')->name('incapable.verify1');
        Route::get('/incapable/unprocessed1', 'IncapableController@unprocessed1')->name('incapable.unprocessed1');
        Route::get('/incapable/{id}/unprocessed1', 'IncapableController@editUnprocessed1')->name('incapable.edit-unprocessed1');
        Route::get('/incapable/verified1', 'IncapableController@verified1')->name('incapable.verified1');
        Route::get('/incapable/{id}/verified1', 'IncapableController@editVerified1')->name('incapable.edit-verified1');
        Route::get('/incapable/declined1', 'IncapableController@declined1')->name('incapable.declined1');
    });

    Route::group(['roles' => 'Penduduk'], function () {
        Route::resource('/salary', 'SalaryController')->except(['create', 'edit', 'show']);
        Route::resource('/incapable', 'IncapableController')->except(['create', 'edit', 'show']);
    });
});
