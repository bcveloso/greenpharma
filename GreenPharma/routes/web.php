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
    return view('login');
});
Route::get('/user/admin/cadastro', function () {
    return view('user.user');
});

Route::resource('importar', 'Xlsx\XlsxController');
Route::get('/admin','AuthController@dashboard')->name('admin');
Route::get('/importacao','AuthController@import')->name('importacao');
Route::get('/relatorio','AuthController@report')->name('relatorio');
Route::get('/login','AuthController@showLoginForm')->name('login');
Route::get('/logout','AuthController@logout')->name('logout');
Route::post('/login/do','AuthController@login')->name('login.do');
Route::post('/relatorio/list','ProductController@list')->name('relatorio.list');
Route::post('/user/admin/cadastro/do', 'userLogin@newUser')->name('user.admin.cadastro.do');

Route::get('session', 'sessionController@session');