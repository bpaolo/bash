<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () use ($router) {
    return '<h1 style="text-align: center; margin: 20% 0;">Kevin<br><img style="width: 150px; margin: 0 auto;" src="https://s-media-cache-ak0.pinimg.com/originals/ee/87/f7/ee87f713215684485f47393d2abab711.png" /></h1>';
});
// API BASE
$router->group(['prefix' => '/v1/'], function () use ($router){
    // API Auth Basic
    $router->group(['prefix' => 'auth'], function () use ($router){
        // API LOGIN
        $router->post('login', ['as'=>'login',		'uses'=>'AuthController@login']);
        // API Auth JWT
        $router->group(['middleware' => 'auth:api'], function () use ($router){
            $router->post('refresh', ['as'=>'refresh', 'uses'=>'AuthController@refresh']);
            $router->post('logout', ['as'=>'logout', 'uses'=>'AuthController@logout']);
            $router->post('me', ['as'=>'me', 'uses'=>'AuthController@me']);
        });
    });
    //Auth:api
    $router->group(['middleware' => 'auth:api'], function () use ($router){
        //Seminovos
        $router->group(['prefix' => 'seminovos'], function () use ($router){
	        $router->post('sync/criar-pedido', ['as'=>'CriarPedidoAtivo', 'uses'=>'SeminovosController@CriarPedidoAtivo']);
	        $router->post('sync/atualiza-status-veiculo', ['as'=>'AtualizaStatusVeiculo', 'uses'=>'SeminovosController@AtualizaStatusVeiculoEntregue']);
            $router->post('sync/atualiza-status-financeiro', ['as'=>'AtualizaStatusFinanceiro', 'uses'=>'SeminovosController@AtualizaStatusFinanceiro']);
	    });
        //Rent a Car
        $router->group(['prefix' => 'rac'], function () use ($router){
            $router->post('async/abertura-contrato', ['as'=>'AberturaDeContrato', 'uses'=>'RacController@AberturaDeContrato']);
            $router->post('async/cancelamento-contrato', ['as'=>'CancelamentoDeContrato', 'uses'=>'RacController@CancelamentoDeContrato']);
            $router->post('async/encerramento-contrato', ['as'=>'EncerramentoDeContrato', 'uses'=>'RacController@EncerramentoDeContrato']);
	    });
        //Ativos
        $router->group(['prefix' => 'ativos'], function () use ($router){
            $router->post('sync/movimentacao', ['as'=>'Movimentacao',      'uses'=>'AtivosController@Movimentacao']);
            $router->get('sync/movimentacao', ['as'=>'Movimentacao',      'uses'=>'AtivosController@Movimentacao']);
            $router->get('sync/cancelamento', ['as'=>'Cancelamento',      'uses'=>'AtivosController@Cancelamento']);
        });
        //Rent a Car
        $router->group(['prefix' => 'sic'], function () use ($router){
            $router->get('sync/busca-cliente', ['as'=>'BuscaCliente', 'uses'=>'SicController@BuscaCliente']);
            $router->get('sync/busca-fornecedor', ['as'=>'BuscaFornecedor', 'uses'=>'SicController@BuscaFornecedor']);
        });
    });
});