<?php

class UserController extends BaseController {

   public function form() {
      return View::make('cadastro/form');
   }
   
   
   public function cadastro() {

      //A regra unique verifica se existe na tabela.
      //No caso, não podemos ter emails repetidos.
      //A regra same verifica se dois campos do formulário
      //são iguais.
      //No caso, queremos ter certeza que a senha e a 
      //confirmação da senha são iguais.
    
      $regras = ['email' => 'required|email|unique:users,email',
                 'senha' => 'required',
                 'confirmacao' => 'required|same:senha'];
      
      $validacao = Validator::make(Input::all(), $regras);
      
      if ($validacao->fails())
         return Redirect::to('cadastro')->withErrors($validacao);
      
      //cadastrando um novo usuário
      $usuario = new User;
      $usuario->email = Input::get('email');
      $usuario->password = Hash::make( Input::get('senha') );
      $usuario->save();
      
      return View::make('cadastro/sucesso');
   }
}