<?php

use App\Http\Controllers\Customer\CustomerController;
use App\Http\Controllers\User\UserController;
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
    return view('welcome');
});

Route::get('login/customers', [CustomerController::class, 'showCustomerLoginForm'])->name('login.customers');

Route::get('register/customers', [App\Http\Controllers\Auth\RegisterController::class, 'showCustomerRegistrationForm'])->name('register.customers');

Route::get('login/service-providers', [App\Http\Controllers\Auth\LoginController::class, 'showServiceProviderLoginForm'])->name('login.service-providers');

Route::post('register/service-providers', [App\Http\Controllers\Auth\RegisterController::class, 'createServiceProvider']);

Route::get('csrf-token', function () {
    return response()->json(csrf_token());
});

//LOGIN/REGISTRO DE CLIENTES
Route::post('register/customers', [CustomerController::class, 'storeOrUpdate']);

Route::post('login/customers', [CustomerController::class, 'login']);

Route::get('check-email', [CustomerController::class, 'checkEmail']);

//LOGIN/REGISTRO DE AUTONOMOS
Route::post('register/users', [UserController::class, 'storeOrUpdate']);

Route::post('login/users', [UserController::class, 'login']);

Route::get('check-email-user', [UserController::class, 'checkEmail']);

//COMPLETAR CADASTRO
Route::post('autonomo', [\App\Http\Controllers\Autonomo\AutonomoController::class, 'store']);

Route::get('get-autonomo', [\App\Http\Controllers\Autonomo\AutonomoController::class, 'getAutonomo']);

Route::get('get-autonomo-perfil', [\App\Http\Controllers\Autonomo\AutonomoController::class, 'getAutonomoPerfil']);

//AGENDAMENTO
Route::post('agendamentos', [\App\Http\Controllers\Customer\AgendamentoController::class, 'store']);
Route::post('avaliacao', [\App\Http\Controllers\Customer\AgendamentoController::class, 'avaliar']);
Route::post('deletar-agendamento/{id}', [\App\Http\Controllers\Customer\AgendamentoController::class, 'deletarServico']);
Route::post('aceitar/{id}', [\App\Http\Controllers\Customer\AgendamentoController::class, 'aceitarServico']);
Route::post('concluir/{id}', [\App\Http\Controllers\Customer\AgendamentoController::class, 'concluirServico']);
Route::get('get-notificacao', [\App\Http\Controllers\Customer\AgendamentoController::class, 'getNotificacao']);
Route::get('get-meus-servicos', [\App\Http\Controllers\Customer\AgendamentoController::class, 'getMeuServico']);

Route::get('get-meus-pedidos', [\App\Http\Controllers\Customer\AgendamentoController::class, 'getMeuPedido']);

Route::group(['middleware' => ['web']], function () {
    // Suas rotas de cliente aqui
});
