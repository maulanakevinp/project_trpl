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
    Route::get('/salaries/download/{salary}', 'SalariesController@show')->name('salaries.download');
    Route::get('/incapables/download/{incapable}', 'IncapablesController@show')->name('incapables.download');
    Route::get('/domiciles/download/{domicile}', 'DomicilesController@show')->name('domiciles.download');
    Route::get('/enterprises/download/{enterprise}', 'EnterprisesController@show')->name('enterprises.download');
    Route::get('/disappearances/download/{disappearance}', 'DisappearancesController@show')->name('disappearances.download');
    Route::get('/births/download/{birth}', 'BirthsController@show')->name('births.download');

    // Ajax
    Route::post('/getDetailUser', 'UserController@getDetailUser')->name('ajax.get.detail.user');
    Route::post('/getEditDomiciles','DomicilesController@getEditDomiciles')->name('ajax.get.edit.domiciles');
    Route::post('/getEditSalaries','SalariesController@getEditSalaries')->name('ajax.get.edit.salaries');
    Route::post('/getEditIncapables','IncapablesController@getEditIncapables')->name('ajax.get.edit.incapables');
    Route::post('/getEditEnterprises','EnterprisesController@getEditEnterprises')->name('ajax.get.edit.enterprises');
    Route::post('/getEditDisappearances','DisappearancesController@getEditDisappearances')->name('ajax.get.edit.disappearances');
    Route::post('/getEditBirths','BirthsController@getEditBirths')->name('ajax.get.edit.births');

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

        Route::resource('/submenu', 'SubmenuController')->except(['create', 'show', 'edit']);
        Route::get('/getSubmenu', 'SubmenuController@getSubmenu')->name('ajax.get.submenu');
        Route::post('/getSubmenu/edit', 'SubmenuController@getEditSubmenu')->name('ajax.get.edit.submenu');

    });

    // Kepala Desa
    Route::group(['roles' => 'Kepala Desa'], function () {
        
        Route::get('/dashboard', 'HomeController@index')->name('home');
        Route::get('/getUsers', 'UserController@getUsers')->name('ajax.get.users');

        // Grafik
        Route::get('/jenis-kelamin', 'PopulationGraphController@gender')->name('jenis-kelamin');
        Route::get('/usia', 'PopulationGraphController@age')->name('usia');
        Route::get('/agama', 'PopulationGraphController@religion')->name('agama');
        Route::get('/status-pernikahan', 'PopulationGraphController@marital')->name('status-pernikahan');

        // Domiciles
        Route::get('/domiciles/kepala-dinas', 'DomicilesController@index')->name('domiciles.index2');
        Route::put('/domiciles/{domicile}/verify2', 'DomicilesController@verify2')->name('domiciles.verify2');
        Route::get('/domiciles/{domicile}/unprocessed2', 'DomicilesController@editUnprocessed2')->name('domiciles.edit-unprocessed2');
        Route::get('/domiciles/{domicile}/verified2', 'DomicilesController@editVerified2')->name('domiciles.edit-verified2');        
        Route::get('/getUnprocessed2Domiciles', 'DomicilesController@getUnprocessed2')->name('ajax.get.unprocessed2.domiciles');
        Route::get('/getVerified2Domiciles', 'DomicilesController@getVerified2')->name('ajax.get.verified2.domiciles');
        Route::get('/getDeclined2Domiciles', 'DomicilesController@getDeclined2')->name('ajax.get.declined2.domiciles');
        
        // Salaries
        Route::get('/salaries/kepala-dinas', 'SalariesController@index')->name('salaries.index2');
        Route::put('/salaries/{salary}/verify2', 'SalariesController@verify2')->name('salaries.verify2');
        Route::get('/salaries/{salary}/unprocessed2', 'SalariesController@editUnprocessed2')->name('salaries.edit-unprocessed2');
        Route::get('/salaries/{salary}/verified2', 'SalariesController@editVerified2')->name('salaries.edit-verified2');        
        Route::get('/getUnprocessed2Salaries', 'SalariesController@getUnprocessed2')->name('ajax.get.unprocessed2.salaries');
        Route::get('/getVerified2Salaries', 'SalariesController@getVerified2')->name('ajax.get.verified2.salaries');
        Route::get('/getDeclined2Salaries', 'SalariesController@getDeclined2')->name('ajax.get.declined2.salaries');
        
        // Incapables
        Route::get('/incapables/kepala-dinas', 'IncapablesController@index')->name('incapables.index2');
        Route::put('/incapables/{incapable}/verify2', 'IncapablesController@verify2')->name('incapables.verify2');
        Route::get('/incapables/{incapable}/unprocessed2', 'IncapablesController@editUnprocessed2')->name('incapables.edit-unprocessed2');
        Route::get('/incapables/{incapable}/verified2', 'IncapablesController@editVerified2')->name('incapables.edit-verified2');        
        Route::get('/getUnprocessed2Incapables', 'IncapablesController@getUnprocessed2')->name('ajax.get.unprocessed2.incapables');
        Route::get('/getVerified2Incapables', 'IncapablesController@getVerified2')->name('ajax.get.verified2.incapables');
        Route::get('/getDeclined2Incapables', 'IncapablesController@getDeclined2')->name('ajax.get.declined2.incapables');
        
        // Enterprises
        Route::get('/enterprises/kepala-dinas', 'EnterprisesController@index')->name('enterprises.index2');
        Route::put('/enterprises/{enterprise}/verify2', 'EnterprisesController@verify2')->name('enterprises.verify2');
        Route::get('/enterprises/{enterprise}/unprocessed2', 'EnterprisesController@editUnprocessed2')->name('enterprises.edit-unprocessed2');
        Route::get('/enterprises/{enterprise}/verified2', 'EnterprisesController@editVerified2')->name('enterprises.edit-verified2');        
        Route::get('/getUnprocessed2Enterprises', 'EnterprisesController@getUnprocessed2')->name('ajax.get.unprocessed2.enterprises');
        Route::get('/getVerified2Enterprises', 'EnterprisesController@getVerified2')->name('ajax.get.verified2.enterprises');
        Route::get('/getDeclined2Enterprises', 'EnterprisesController@getDeclined2')->name('ajax.get.declined2.enterprises');
        
        // Disappearances
        Route::get('/disappearances/kepala-dinas', 'DisappearancesController@index')->name('disappearances.index2');
        Route::put('/disappearances/{disappearance}/verify2', 'DisappearancesController@verify2')->name('disappearances.verify2');
        Route::get('/disappearances/{disappearance}/unprocessed2', 'DisappearancesController@editUnprocessed2')->name('disappearances.edit-unprocessed2');
        Route::get('/disappearances/{disappearance}/verified2', 'DisappearancesController@editVerified2')->name('disappearances.edit-verified2');        
        Route::get('/getUnprocessed2Disappearances', 'DisappearancesController@getUnprocessed2')->name('ajax.get.unprocessed2.disappearances');
        Route::get('/getVerified2Disappearances', 'DisappearancesController@getVerified2')->name('ajax.get.verified2.disappearances');
        Route::get('/getDeclined2Disappearances', 'DisappearancesController@getDeclined2')->name('ajax.get.declined2.disappearances');
        
        // Births
        Route::get('/births/kepala-dinas', 'BirthsController@index')->name('births.index2');
        Route::put('/births/{birth}/verify2', 'BirthsController@verify2')->name('births.verify2');
        Route::get('/births/{birth}/unprocessed2', 'BirthsController@editUnprocessed2')->name('births.edit-unprocessed2');
        Route::get('/births/{birth}/verified2', 'BirthsController@editVerified2')->name('births.edit-verified2');        
        Route::get('/getUnprocessed2Births', 'BirthsController@getUnprocessed2')->name('ajax.get.unprocessed2.births');
        Route::get('/getVerified2Births', 'BirthsController@getVerified2')->name('ajax.get.verified2.births');
        Route::get('/getDeclined2Births', 'BirthsController@getDeclined2')->name('ajax.get.declined2.births');
    });

    // Administrasi
    Route::group(['roles' => 'Administrasi'], function () {

        // Domiciles
        Route::get('/domiciles/admin', 'DomicilesController@index')->name('domiciles.index1');
        Route::put('/domiciles/{domicile}/verify1', 'DomicilesController@verify1')->name('domiciles.verify1');
        Route::get('/domiciles/{domicile}/unprocessed1', 'DomicilesController@editUnprocessed1')->name('domiciles.edit-unprocessed1');
        Route::get('/domiciles/{domicile}/verified1', 'DomicilesController@editVerified1')->name('domiciles.edit-verified1');        
        Route::get('/getUnprocessed1Domiciles', 'DomicilesController@getUnprocessed1')->name('ajax.get.unprocessed1.domiciles');
        Route::get('/getVerified1Domiciles', 'DomicilesController@getVerified1')->name('ajax.get.verified1.domiciles');
        Route::get('/getDeclined1Domiciles', 'DomicilesController@getDeclined1')->name('ajax.get.declined1.domiciles');
        
        // Salaries
        Route::get('/salaries/admin', 'SalariesController@index')->name('salaries.index1');
        Route::put('/salaries/{salary}/verify1', 'SalariesController@verify1')->name('salaries.verify1');
        Route::get('/salaries/{salary}/unprocessed1', 'SalariesController@editUnprocessed1')->name('salaries.edit-unprocessed1');
        Route::get('/salaries/{salary}/verified1', 'SalariesController@editVerified1')->name('salaries.edit-verified1');        
        Route::get('/getUnprocessed1Domiciles', 'SalariesController@getUnprocessed1')->name('ajax.get.unprocessed1.salaries');
        Route::get('/getVerified1Domiciles', 'SalariesController@getVerified1')->name('ajax.get.verified1.salaries');
        Route::get('/getDeclined1Domiciles', 'SalariesController@getDeclined1')->name('ajax.get.declined1.salaries');
        
        // Incapables
        Route::get('/incapables/admin', 'IncapablesController@index')->name('incapables.index1');
        Route::put('/incapables/{incapable}/verify1', 'IncapablesController@verify1')->name('incapables.verify1');
        Route::get('/incapables/{incapable}/unprocessed1', 'IncapablesController@editUnprocessed1')->name('incapables.edit-unprocessed1');
        Route::get('/incapables/{incapable}/verified1', 'IncapablesController@editVerified1')->name('incapables.edit-verified1');        
        Route::get('/getUnprocessed1Incapables', 'IncapablesController@getUnprocessed1')->name('ajax.get.unprocessed1.incapables');
        Route::get('/getVerified1Incapables', 'IncapablesController@getVerified1')->name('ajax.get.verified1.incapables');
        Route::get('/getDeclined1Incapables', 'IncapablesController@getDeclined1')->name('ajax.get.declined1.incapables');
        
        // Enterprises
        Route::get('/enterprises/admin', 'EnterprisesController@index')->name('enterprises.index1');
        Route::put('/enterprises/{enterprise}/verify1', 'EnterprisesController@verify1')->name('enterprises.verify1');
        Route::get('/enterprises/{enterprise}/unprocessed1', 'EnterprisesController@editUnprocessed1')->name('enterprises.edit-unprocessed1');
        Route::get('/enterprises/{enterprise}/verified1', 'EnterprisesController@editVerified1')->name('enterprises.edit-verified1');        
        Route::get('/getUnprocessed1Enterprises', 'EnterprisesController@getUnprocessed1')->name('ajax.get.unprocessed1.enterprises');
        Route::get('/getVerified1Enterprises', 'EnterprisesController@getVerified1')->name('ajax.get.verified1.enterprises');
        Route::get('/getDeclined1Enterprises', 'EnterprisesController@getDeclined1')->name('ajax.get.declined1.enterprises');
        
        // Disappearances
        Route::get('/disappearances/admin', 'DisappearancesController@index')->name('disappearances.index1');
        Route::put('/disappearances/{disappearance}/verify1', 'DisappearancesController@verify1')->name('disappearances.verify1');
        Route::get('/disappearances/{disappearance}/unprocessed1', 'DisappearancesController@editUnprocessed1')->name('disappearances.edit-unprocessed1');
        Route::get('/disappearances/{disappearance}/verified1', 'DisappearancesController@editVerified1')->name('disappearances.edit-verified1');        
        Route::get('/getUnprocessed1Disappearances', 'DisappearancesController@getUnprocessed1')->name('ajax.get.unprocessed1.disappearances');
        Route::get('/getVerified1Disappearances', 'DisappearancesController@getVerified1')->name('ajax.get.verified1.disappearances');
        Route::get('/getDeclined1Disappearances', 'DisappearancesController@getDeclined1')->name('ajax.get.declined1.disappearances');
        
        // Births
        Route::get('/births/admin', 'BirthsController@index')->name('births.index1');
        Route::put('/births/{birth}/verify1', 'BirthsController@verify1')->name('births.verify1');
        Route::get('/births/{birth}/unprocessed1', 'BirthsController@editUnprocessed1')->name('births.edit-unprocessed1');
        Route::get('/births/{birth}/verified1', 'BirthsController@editVerified1')->name('births.edit-verified1');        
        Route::get('/getUnprocessed1Births', 'BirthsController@getUnprocessed1')->name('ajax.get.unprocessed1.births');
        Route::get('/getVerified1Births', 'BirthsController@getVerified1')->name('ajax.get.verified1.births');
        Route::get('/getDeclined1Births', 'BirthsController@getDeclined1')->name('ajax.get.declined1.births');
        
    });

    // Penduduk
    Route::group(['roles' => 'Penduduk'], function () {
        // Domiciles
        Route::get('/getDomiciles','DomicilesController@getDomiciles')->name('ajax.get.domiciles');
        Route::resource('/domiciles', 'DomicilesController')->except(['edit']);
        
        // Salaries
        Route::get('/getSalaries','SalariesController@getSalaries')->name('ajax.get.salaries');
        Route::resource('/salaries', 'SalariesController')->except(['edit']);

        // Incapables
        Route::get('/getIncapables','IncapablesController@getIncapables')->name('ajax.get.incapables');
        Route::resource('/incapables', 'IncapablesController')->except(['edit']);

        // Enterprises
        Route::get('/getEnterprises','EnterprisesController@getEnterprises')->name('ajax.get.enterprises');
        Route::resource('/enterprises', 'EnterprisesController')->except(['edit']);

        // Disappearances
        Route::get('/getDisappearances','DisappearancesController@getDisappearances')->name('ajax.get.disappearances');
        Route::resource('/disappearances', 'DisappearancesController')->except(['edit']);

        // Births
        Route::get('/getBirths','BirthsController@getBirths')->name('ajax.get.births');
        Route::resource('/births', 'BirthsController')->except(['edit']);
    });
});
