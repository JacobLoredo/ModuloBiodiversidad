<?php

use Illuminate\Support\Facades\Route;

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
    return redirect('/Biodiversidad');
});

Route::group(['prefix' => 'Biodiversidad'], function () {
    Route::get('/usuario', 'HomeController@verificar')->name('UXV');
    Route::view('/', 'index')->name('Bio');
    Route::view('/LoginInstitucional', 'Institucional.vista')->name('LInstitucional');
    Auth::routes();
    Auth::routes(['verify' => true]);
    Route::get('/usuario', 'HomeController@verificar')->name('UXV');
    Route::get('/Ejemplares', 'NombreEjemplarController@indexPublic')->name('EjemplaresP');
    Route::get('/FichaTecnica/{id}', 'FichaTecnicaController@show')->name('FichaTecnicaPublica');

    Route::post('/LoginInstitucional', 'HomeController@loginInstitucional')->name('LInstitucionalP');
    Route::get('/HojaCampo/Verificadas', 'PlantaController@showVerificadas')->name('showVerificados');

    Route::get('/Mapa', 'PlantaController@allPlantas')->name('Mapa');
    Route::get('FichasTecnicas','FichaTecnicaController@index')->name('FichasT');
    Route::post('FichasTecnicas','FichaTecnicaController@store')->name('FichasT');
    Route::group(['prefix' => 'Sistema', 'middleware' => 'auth'], function () {
        Route::get('/', 'HomeController@index')->name('dashbord');
        Route::get('/Ejemplares', 'NombreEjemplarController@index')->name('Ejemplares');
        Route::get('/FichaTecnica/{id}', 'NombreEjemplarController@show')->name('PlantasEjemplares');
        Route::group(['middleware' => 'TRol:administrador'], function () {
            Route::post('/CambiaRoles', 'HomeController@editRol')->name('CambiaRol');
            Route::get('/home', 'HomeController@index')->name('home');
            Route::get('/UsuariosAdmin', 'HomeController@getUsers')->name('UserAdmin');
            Route::post('/EliminarUser', 'HomeController@deleteUser')->name('EliminarUser');
            Route::get('/MisHojasCampo', 'HomeController@getHCByUser')->name('UserHC');

            //Route::get('/MisHojasCampo/{id}', 'PlantaController@show')->name('UserHCEdit');
           // Route::get('/HojasCampo', 'PlantaController@showAllPlantas')->name('ShowHC');
            /*
            Route::get('/HojaCampo', 'PlantaController@index')->name('HojaCampo');
            Route::post('/GuardaHC', 'PlantaController@store')->name('GHC');
            */
            Route::get('/Planta/{id}', 'PlantaController@show')->name('ShowPlanta');
           // Route::post('MisHojasCampo/{id}/verificar', 'PlantaController@deleteUser')->name('VerificarHC');
        });

        Route::group(['middleware' => 'TRol:Gestor|administrador'], function () {
            Route::get('/HojaCampo', 'PlantaController@index')->name('HojaCampo');
            Route::post('/GuardaHC', 'PlantaController@store')->name('GHC');
            Route::get('/MisHojasCampo', 'HomeController@getHCByUser')->name('UserHC');
            Route::get('MisHojasCampo/{id}', 'PlantaController@show')->name('UserHCEdit');
           
        });
        

        Route::group(['middleware' => 'TRol:administrador|Coordinador|Gestor'], function () {
            Route::post('/MisHojasCampo/verificar', 'PlantaController@verificar')->name('VerificarHC');
            Route::post('/MisHojasCampo/rechazar', 'PlantaController@rechazar')->name('RechazarHC');
            Route::get('/HojasCampo', 'PlantaController@showAllPlantas')->name('ShowHC');
            Route::get('MisHojasCampo/{id}', 'PlantaController@show')->name('UserHCEdit');
        });
    });
});
