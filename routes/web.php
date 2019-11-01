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

    Route::post('/getDetailUser', 'UserController@getDetailUser')->name('ajax.get.detail.user');

    // Super admin
    Route::group(['roles' => 'Super Admin'], function () {

        Route::put('/users/restore-all', 'UserController@restoreAll')->name('users.restoreAll');
        Route::delete('/users/softdelete/{id}', 'UserController@softdelete')->name('users.delete');
        Route::patch('/users/restore/{id}', 'UserController@restore')->name('users.restore');
        Route::resource('/users', 'UserController')->except(['show']);
        Route::get('/users/trash', 'UserController@trash')->name('users.trash');
        Route::get('/getUser', 'UserController@getUser')->name('ajax.get.user');
        Route::get('/getUserDeleted', 'UserController@getUserDeleted')->name('ajax.get.user.deleted');

        Route::resource('/role', 'RoleController')->except(['create', 'show']);
        Route::post('/getRole/{id}', 'RoleController@getRole');
        Route::post('/change-access', 'RoleController@changeAccess');

        Route::resource('/menu', 'MenuController')->except(['create', 'show', 'edit']);
        Route::post('/getMenu', 'MenuController@getMenu');

        Route::resource('/submenu', 'SubmenuController')->except(['create', 'show', 'edit']);;
        Route::get('/getSubmenu', 'SubmenuController@getSubmenu')->name('ajax.get.submenu');
        Route::post('/getSubmenu/edit', 'SubmenuController@getEditSubmenu')->name('ajax.get.edit.submenu');

    });

    // Kepala Desa
    Route::group(['roles' => 'Kepala Desa'], function () {
        
        Route::get('/dashboard', 'HomeController@index')->name('home');
        Route::get('/getUsers', 'UserController@getUsers')->name('ajax.get.users');

        //Salary
        Route::patch('/salary/{id}/verify2', 'SalaryController@verify2')->name('salary.verify2');
        Route::get('/salary/unprocessed2', 'SalaryController@unprocessed2')->name('salary.unprocessed2');
        Route::get('/salary/{id}/unprocessed2', 'SalaryController@editUnprocessed2')->name('salary.edit-unprocessed2');
        Route::get('/salary/verified2', 'SalaryController@verified2')->name('salary.verified2');
        Route::get('/salary/declined2', 'SalaryController@declined2')->name('salary.declined2');
        Route::get('/salary/{id}/declined2', 'SalaryController@editDeclined2')->name('salary.edit-declined2');
        Route::get('/getUnprocessed2Salary', 'SalaryController@getUnprocessed2')->name('ajax.get.unprocessed2.salary');
        Route::get('/getVerified2Salary', 'SalaryController@getVerified2')->name('ajax.get.verified2.salary');
        Route::get('/getDeclined2Salary', 'SalaryController@getDeclined2')->name('ajax.get.declined2.salary');

        //Incapable
        Route::patch('/incapable/{id}/verify2', 'IncapableController@verify2')->name('incapable.verify2');
        Route::get('/incapable/unprocessed2', 'IncapableController@unprocessed2')->name('incapable.unprocessed2');
        Route::get('/incapable/{id}/unprocessed2', 'IncapableController@editUnprocessed2')->name('incapable.edit-unprocessed2');
        Route::get('/incapable/verified2', 'IncapableController@verified2')->name('incapable.verified2');
        Route::get('/incapable/declined2', 'IncapableController@declined2')->name('incapable.declined2');
        Route::get('/incapable/{id}/declined2', 'IncapableController@editDeclined2')->name('incapable.edit-declined2');
        Route::get('/getUnprocessed2Incapable', 'IncapableController@getUnprocessed2')->name('ajax.get.unprocessed2.incapable');
        Route::get('/getVerified2Incapable', 'IncapableController@getVerified2')->name('ajax.get.verified2.incapable');
        Route::get('/getDeclined2Incapable', 'IncapableController@getDeclined2')->name('ajax.get.declined2.incapable');

        Route::get('/jenis-kelamin', 'PopulationGraphController@gender')->name('jenis-kelamin');
        Route::get('/usia', 'PopulationGraphController@age')->name('usia');
        Route::get('/agama', 'PopulationGraphController@religion')->name('agama');
        Route::get('/status-pernikahan', 'PopulationGraphController@marital')->name('status-pernikahan');
        
    });

    // Administrasi
    Route::group(['roles' => 'Administrasi'], function () {
        //Salary
        Route::put('/salary/{id}/verify1', 'SalaryController@verify1')->name('salary.verify1');
        Route::get('/salary/unprocessed1', 'SalaryController@unprocessed1')->name('salary.unprocessed1');
        Route::get('/salary/{id}/unprocessed1', 'SalaryController@editUnprocessed1')->name('salary.edit-unprocessed1');
        Route::get('/salary/verified1', 'SalaryController@verified1')->name('salary.verified1');
        Route::get('/salary/{id}/verified1', 'SalaryController@editVerified1')->name('salary.edit-verified1');
        Route::get('/salary/declined1', 'SalaryController@declined1')->name('salary.declined1');
        Route::get('/getUnprocessed1Salary', 'SalaryController@getUnprocessed1')->name('ajax.get.unprocessed1.salary');
        Route::get('/getVerified1Salary', 'SalaryController@getVerified1')->name('ajax.get.verified1.salary');
        Route::get('/getDeclined1Salary', 'SalaryController@getDeclined1')->name('ajax.get.declined1.salary');
        
        //Incapable
        Route::put('/incapable/{id}/verify1', 'IncapableController@verify1')->name('incapable.verify1');
        Route::get('/incapable/unprocessed1', 'IncapableController@unprocessed1')->name('incapable.unprocessed1');
        Route::get('/incapable/{id}/unprocessed1', 'IncapableController@editUnprocessed1')->name('incapable.edit-unprocessed1');
        Route::get('/incapable/verified1', 'IncapableController@verified1')->name('incapable.verified1');
        Route::get('/incapable/{id}/verified1', 'IncapableController@editVerified1')->name('incapable.edit-verified1');
        Route::get('/incapable/declined1', 'IncapableController@declined1')->name('incapable.declined1');
        Route::get('/getUnprocessed1Incapable', 'IncapableController@getUnprocessed1')->name('ajax.get.unprocessed1.incapable');
        Route::get('/getVerified1Incapable', 'IncapableController@getVerified1')->name('ajax.get.verified1.incapable');
        Route::get('/getDeclined1Incapable', 'IncapableController@getDeclined1')->name('ajax.get.declined1.incapable');
        
    });

    // Penduduk
    Route::group(['roles' => 'Penduduk'], function () {
        //salary
        Route::get('/getSalary','SalaryController@getSalary')->name('ajax.get.salary');
        Route::post('/getEditSalary','SalaryController@getEditSalary')->name('ajax.get.edit.salary');
        Route::resource('/salary', 'SalaryController')->except(['create', 'edit', 'show']);

        //incapable
        Route::get('/getIncapable','IncapableController@getIncapable')->name('ajax.get.incapable');
        Route::post('/getEditIncapable','IncapableController@getEditIncapable')->name('ajax.get.edit.incapable');
        Route::resource('/incapable', 'IncapableController')->except(['create', 'edit', 'show']);
    });
});
