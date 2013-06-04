<?php
/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::get('/', function()
{
	return View::make('hello');
});




/*
|**************************************************************************
|     FILTROS
|**************************************************************************
*/

Route::filter('auth', function(){

	$erros = array('precisaDeAutenticacao' => 'Para acessar esta página é necessário autenticação',
				   'paginaAcessada'        => URL::current());
			    				


    if (Auth::guest()){ return Redirect::to('login')->withErrors($erros);	    				 
    }

});
//Route::get('list', array('before' => 'auth', 'do' => 'ListController@listar') );



/*
|--------------------------------------------------------------------------
| Rota Padrão
|--------------------------------------------------------------------------
|
| Essa é a rota padrão do laravel4. Ela tem como objeto:
| -Pegar qualquer requisição a url localhost/laravel4/public/ e criar um array definindo que 'como HOME' faça a fuñção tal.
|
*/

Route::any('/', array("as" => "home",
              function() { return View::make('home'); }
        )
);



/*
|--------------------------------------------------------------------------
| Rota Teste para ola/usuario(opcional)
|--------------------------------------------------------------------------
|
| A rota pega qualquer interação com a URL do navegador ( GET ou POST ). 
| Ela pega a url public/ola/ e recebe um parametro usuario OPCIONAL devido ao .
| Retorna a action ola do controller Home.
|
*/

Route::any('ola/{usuario?}', 'HomeController@ola');



/*
|--------------------------------------------------------------------------
| Rotas para Cadastro
|--------------------------------------------------------------------------
*/
/*    cadastro de novos usuários    */
Route::group(["before"=>'guest'], function() {
	Route::get('cadastro', 'UserController@form');
	Route::post('cadastro','UserController@cadastro');
});




/*
|--------------------------------------------------------------------------
| Rotas para Login e Logout
|--------------------------------------------------------------------------
*/

Route::get('login', function(){
	 return View::make('login')->with('paginaAcessada', 0);	
});


Route::post('login',array('as' => 'login', function(){

	$regras = array("email" => "required|email",
					"senha" => "required");
	$validacao = Validator::make(Input::all(), $regras);

	if ($validacao->fails()){
	return Redirect::to('login')->withErrors($validacao);
	}

	//setando os dados do usuario colhidos para um Array
	$dadosDoUsuario = array(
				'email'    => Input::get('email'),
				'password' => Input::get('senha')
				
		);


	//tenta logar o usuário
	if (Auth::attempt($dadosDoUsuario) ) {

		return Redirect::to(Input::get('paginaAcessada'));
		//Redirect::to(Input::get('paginaAcessada'));
	}
	else {
		return Redirect::to('login')->withErrors('Usuário ou Senha Inválido');
	}	
}));



Route::get('logout', function(){ Auth::logout();
	return Redirect::to('login');
});




/*
|--------------------------------------------------------------------------
| GRUPO DE ROTAS QUE DEVEM RODAR APENAS SE AUTORIZADOS PELO AUTH;
|--------------------------------------------------------------------------
*/

Route::group(array('before' => 'auth'), function(){






	/*
	|--------------------------------------------------------------------------
	| Adicionando Rotas para as tasks
	|--------------------------------------------------------------------------
	*/

	Route::get('task/add/{lista_id}', 'TaskController@getAdd');
	Route::post('task/add/{lista_id}', 'TaskController@postAdd');


	//////USADO COMO TESTE///////
	//Route::get('task/add', array("as" => "addTask", "uses" => 'TaskController@getAdd'));
	//Route::post('task/add', 'TaskController@postAdd');

	//Route::get('task/add', array("as" => "addTask", "uses" => 'TaskController@getAdd'));
	//Route::post('task/add', array("as" => "addTask", "uses" => 'TaskController@postAdd'));


	/*
	|--------------------------------------------------------------------------
	| Rota para CRIAR Listas
	|--------------------------------------------------------------------------
	*/

	Route::get('list/create', 'ListController@getCreate');
	Route::post('list/create', 'ListController@postCreate');



	/*
	|--------------------------------------------------------------------------
	| Rotas para LISTAR as tasks
	|--------------------------------------------------------------------------
	*/

	Route::any('task', 'TaskController@listar');
	Route::any('tasks', 'TaskController@listar');



	/*
	|--------------------------------------------------------------------------
	| Rota para PEGAR as listas
	|--------------------------------------------------------------------------
	*/
	
	Route::get('list', 'ListController@listar');
	Route::get('list/{lista_id?}', 'ListController@listarTasks');



	/*
	|--------------------------------------------------------------------------
	| Rota do AJAX para CHECKAR tasks
	|--------------------------------------------------------------------------
	*/

	Route::post('task/check', 'TaskController@check');



	//

});	