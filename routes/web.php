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

use Illuminate\Support\Facades\Auth;
//use Illuminate\Support\Facades\Admin;



Route::get('/', function () {
    return redirect()->to("/login");
});


//-------------------------------
// Áreas
//-------------------------------

	Route::group(
    [
        "middleware" => [
            "admin"
        ]
    ],
    function () {

        # API
        Route::prefix("api")
            ->group(function () {
				//////////////////usuarios//////////////////////////////
				//Route::get("areass", "usuariosController@mostrar2");
				//MOSTRAR
				Route::get("usuarios", "usuariosController@mostrar");
				//BUSCAR
				Route::get("usuarios/buscar/{busqueda}", "usuariosController@buscar");
				//Eliminar
				Route::delete("usuario/{id}", "UsuariosController@eliminar");
				Route::post("usuarios/eliminar", "UsuariosController@eliminarMuchas");
            
			    //MOSTRAR
				Route::get("mapas", "MapasController@mostrar");
                
				//BUSCAR
				Route::get("mapas/buscar/{busqueda}", "MapasController@buscar");
				
            });


        # VISTAS
		
		///FORMULARIO PARA REGISTRAR REQUERIMIENTOS - DESDE EL MAPA
		Route::view("requerimientos/agregar", "requerimientos/agregar_requerimiento_mapa")->name("formularioGuardarRequerimientoMapa");
		Route::get("requerimientos/agregar/{id}", "RequerimientosController@agregar_requerimientoMapa")->name("formulario_guardar_requerimiento_mapa");
		Route::put("requerimientos/", "RequerimientosController@guardarCambios_req_mapa")->name("guardarCambiosReqMapa");
		
		
		///MOSTRAR UBICACIONES
		Route::view("ubicaciones/","mapas/mostrar")->name("mapas");
		
		///EDITAR UBICACIONES
		Route::get("ubicaciones/editar/{id}", "MapasController@editar")->name("formularioEditarUbicaciones");
		Route::put("ubicacion/", "MapasController@guardarCambios")->name("guardarCambiosMapa");
		
			///AGREGAR UBICACIONES
		Route::view("ubicaciones/agregar", "mapas/agregar_ubicacion")->name("formularioGuardarEquipo");
		Route::post("ubicaciones/agregar", "MapasController@agregar")->name("guardarEquipo");
		
        //buscador
		Route::view("buscador/","buscador/mostrar")->name("buscador");

		///MOSTRAR usuarios
		Route::view("usuarios/","usuarios/mostrar")->name("usuarios");		

		///EDITAR
		Route::get("usuarios/editar/{id}", "usuariosController@editar")->name("formularioEditarUsuario");
		Route::put("usuario/", "usuariosController@guardarCambios")->name("guardarCambiosDeUsuario");
		
		///GUARDAR
		 Route::view("usuarios/agregar", "usuarios/agregar_usuario")->name("formularioUsuario");
		Route::post("usuarios/agregar", "usuariosController@agregar")->name("guardarUsuario");
        # Logout
        Route::get("logout", function () {
            Auth::logout();
            # Intentar redireccionar a una protegida, que a su vez redirecciona al login :)
            return redirect()->route("usuarios");
        })->name("logout");
    });



	Route::get('/test', function () {
    phpinfo();
});

	//Route::get('/pdf','PDFController@PDF')->name('descargarPDF');

Auth::routes(["register" => false]);

Route::get('/', 'HomeController@index')->name('home');
