<?php



// Route::get('/', function () {
//     return view('contenido');
// });


Route::get('/main', function () {
    return view('contenido');
})->name('main');



// Login
Route::get('login', 'Auth\AuthController@getLogin');
Route::post('login', ['as' =>'login', 'uses' => 'Auth\AuthController@postLogin']);
Route::get('logout', ['as' => 'logout', 'uses' => 'Auth\AuthController@getLogout']);
 
// Registration routes...
Route::get('register', 'Auth\AuthController@getRegister');
Route::post('register', ['as' => 'auth/register', 'uses' => 'Auth\AuthController@postRegister']);
Route::get('/', 'HomeController@index');
Route::get('home', 'HomeController@index');

// Categorias
Route::get('categoria','CategoriaController@index');
Route::get('categoria/cbo','CategoriaController@cboCategoria');
Route::post('categoria','CategoriaController@store');
Route::put('categoria','CategoriaController@edit');
Route::put('categoria/estado','CategoriaController@update');

// Producto
Route::get('producto','ProductoController@index');
Route::post('producto','ProductoController@store');
Route::post('producto/editar','ProductoController@edit');
Route::get('producto/buscarProductoIngreso','ProductoController@buscarProductoIngreso');
Route::get('producto/buscarProductoVenta','ProductoController@buscarProductoVenta');
Route::put('producto/estado','ProductoController@update');
Route::get('producto/listarPdf','ProductoController@listarPdf')->name('productos_pdf');


// Proveedor
Route::get('proveedor','ProveedorController@index');
Route::post('proveedor','ProveedorController@store');
Route::put('proveedor','ProveedorController@edit');
Route::get('proveedor/listarCbo','ProveedorController@listarCbo');



// Cliente
Route::get('cliente','ClienteController@index');
Route::post('cliente','ClienteController@store');
Route::put('cliente','ClienteController@edit');
Route::put('cliente/estado','ClienteController@update');
Route::get('cliente/listarCbo','ClienteController@listarCbo');
Route::get('cliente/consultarnombre','ClienteController@consultaApiSunat');


//Venta
Route::get('venta','VentaController@index');
Route::post('venta','VentaController@store');
Route::get('venta/numero','VentaController@numeroComprobante');
Route::get('venta/obtenerCabecera','VentaController@obtenerCabecera');
Route::get('venta/obtenerDetalles','VentaController@obtenerDetalles');
Route::put('venta/anular','VentaController@anularVenta');
Route::get('venta/ventaid','VentaController@idVenta');
Route::get('venta/listarPdfVenta','VentaController@listarPdfVenta');
Route::get('venta/ticket/{id}','VentaController@ticket');



//Ingreso
Route::get('ingreso','IngresoController@index');
Route::get('ingreso/numero','IngresoController@numeroComprobante');
Route::get('ingreso/obtenerCabecera','IngresoController@obtenerCabecera');
Route::get('ingreso/obtenerDetalles','IngresoController@obtenerDetalles');
Route::put('ingreso/anular','IngresoController@anularIngreso');
Route::post('ingreso','IngresoController@store');


//Reporte
Route::get('reporte/rangoFechaVenta','ReporteController@rangoFechaVenta');
Route::get('reporte/rangoFechaIngreso','ReporteController@rangoFechaIngreso');
Route::get('reporte/donaProducto','ReporteController@donaProductos');
Route::get('reporte/boxes','ReporteController@smallBoxes');
Route::get('reporte/sinStockProducto','ReporteController@listarProductosSinStock');


//Empresa
Route::get('empresa','EmpresaController@index');
Route::post('empresa/registrar','EmpresaController@store');
Route::post('empresa/editar','EmpresaController@edit');