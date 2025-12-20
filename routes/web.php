<?php

use App\Http\Controllers\actividadesController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\controlador;
use App\Http\Controllers\empresasController;
use App\Http\Controllers\mesesController;
use App\Http\Controllers\tecnicosController;
use App\Http\Controllers\productosController;
use App\Http\Controllers\serviciosController;

//Estos usan controlador prinicpal ya que solo obtienen reistros y los muestran en la vista
//____________________________________________________________

Route::get('/', [empresasController::class, 'index']);
Route::get('/productos', [productosController::class, 'productos']);
Route::get('/tecnicos', [tecnicosController::class, 'tecnicos']);
Route::get('/meses/{id_empresa}', [mesesController::class, 'verMeses']);
Route::get('/servicios/{id_mes}', [serviciosController::class, 'verServicios']);
Route::get('/actividades/{id_servicio}', [actividadesController::class, 'verActividades']);


// paginas agregar 3
Route::get('/ag_Empresas', [empresasController::class, 'ag_empresa']);
Route::get('/ag_Tecnicos', [tecnicosController::class, 'ag_tecnicos']);
Route::get('/ag_Productos', [productosController::class, 'ag_productos']);
Route::get('/ag_Meses/{id_empresa}', [mesesController::class, 'ag_meses']);
Route::get('/ag_Servicios/{id_mes}', [serviciosController::class, 'ag_servicios']);
Route::get('/actividades/crear/{id_servicio}', [actividadesController::class, 'create'])->name('actividades.create');

//  CREAR registros en db
//___________________________________________________________________
// hacer registros 3
Route::post('/addEmpresa', [empresasController::class, 'addEmpresa']);
Route::post('/addTecnicos', [tecnicosController::class, 'addTecnicos']);
Route::post('/addProductos', [productosController::class, 'addProductos']);
Route::post('/addMes/{id_empresa}', [mesesController::class, 'addMes']);
Route::post('/addServicio/{id_mes}', [serviciosController::class, 'addServicio']);
Route::post('/actividades/guardar', [actividadesController::class, 'store'])->name('actividades.store');


//  EDITAR (VISTAS)
//___________________________________________________________________
Route::get('/edTecnico/{id_tec}', [tecnicosController::class, 'edTecnico']);
Route::get('/edProducto/{id_prod}', [productosController::class, 'edProducto']);
Route::get('/edEmpresa/{id_empresa}', [empresasController::class, 'edEmpresa']);
Route::get('/edMes/{id_mes}', [mesesController::class, 'edMes']);
Route::get('/edServicio/{id_servicio}', [serviciosController::class, 'edServicio'])->name('servicio.editar');
Route::get('/actividades/editar/{id}', [actividadesController::class, 'edit'])->name('actividades.edit'); // {id} es el id de la actividad

//  ACTUALIAR registros en db
Route::put('/upTecnico/{id_tec}', [tecnicosController::class, 'updateTecnico']);
Route::put('/upProducto/{id_tec}', [productosController::class, 'updateProducto']);
Route::put('/upEmpresa/{id_empresa}', [empresasController::class, 'updateEmpresa']);
Route::put('/upMes/{id_mes}', [mesesController::class, 'updateMes']);
Route::put('/actividades/actualizar/{id}', [actividadesController::class, 'update'])->name('actividades.update');

//  BORRAR  en db
//___________________________________________________________________

Route::delete('/delTec/{tec_del}', [tecnicosController::class, 'delTecnicos']);
Route::delete('/delProd/{prod_del}', [productosController::class, 'delProductos']);
Route::delete('/delEmp/{id_empresa}', [empresasController::class, 'delEmpresa']);
Route::delete('/delMes/{id_mes}', [mesesController::class, 'delMes']);
Route::delete('/delSer/{id_servicio}', [serviciosController::class, 'delServicio']);
Route::delete('/actividades/borrar/{id}', [actividadesController::class, 'destroy'])->name('actividades.destroy');