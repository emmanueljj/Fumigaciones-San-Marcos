<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Controlador;

//ingresar a paginas

Route::get('/', [Controlador::class, 'index']);
Route::get('/productos', [Controlador::class, 'productos']);
Route::get('/tecnicos', [Controlador::class, 'tecnicos']);

// paginas agregar 3
Route::get('/ag_Empresas', [Controlador::class, 'ag_empresa']);
Route::get('/ag_Tecnicos', [Controlador::class, 'ag_tecnicos']);
Route::get('/ag_Productos', [Controlador::class, 'ag_productos']);
Route::get('/ag_Meses/{id_empresa}', [Controlador::class, 'ag_meses']);


// hacer registros 3
Route::post('/addEmpresa', [Controlador::class, 'addEmpresa']);
Route::post('/addTecnicos', [Controlador::class, 'addTecnicos']);
Route::post('/addProductos', [Controlador::class, 'addProductos']);
Route::post('/addMes/{id_empresa}', [Controlador::class, 'addMes']);

//editar registros vistas
Route::get('/edTecnicos/{id_tec}', [Controlador::class, 'edTecnicos']);

//update registros
Route::post('/upTec', [Controlador::class, 'updateTec']);

// ver meses
Route::get('/meses/{id_empresa}', [Controlador::class, 'verMeses']);


