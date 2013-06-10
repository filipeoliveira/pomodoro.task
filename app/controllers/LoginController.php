<?php
 
class LoginController extends BaseController {

   public function __construct(){

   		$this->beforeFilter('csrf', 

   			function(){
   			if(Auth::guest()) 
   			return Redirect::to('login');
   		});

   }


   public function getLogin() {
        return View::make('login');

    }

   public function postLogin(){
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
			return 'logado com sucesso';
		}
		else {
			return Redirect::to('login')->withErrors('Usuário ou Senha Inválido');
		}

		
   } 
}