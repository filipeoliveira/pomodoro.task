<?php

class HomeController extends BaseController {

	/*
	|--------------------------------------------------------------------------
	| Default Home Controller
	|--------------------------------------------------------------------------
	|
	| You may wish to use controllers instead of, or in addition to, Closure
	| based routes. That's great! Here is an example controller method to
	| get you started. To route to this controller, just add the route:
	|
	|	Route::get('/', 'HomeController@showWelcome');
	|
	*/

	public function ola($usuario = null){
			$k = ucwords($usuario);
			return View::make('ola')->with('usuario', $k);
	}


	public function showWelcome()
	{
		return View::make('hello');
	}


		public function testJson($lista_id){

		$lista = User::find(Auth::user()->id)->listas()->where('id', '=', $lista_id)->first();
		$tasks = Task::where('list_id', '=' , 7);
	    
       	var_dump ( $tasks );	
	
    }
}