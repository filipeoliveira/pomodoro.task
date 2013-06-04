<?php
 
class ListController extends BaseController {

   public function getCreate() {
        return View::make('listas/add_list');

    }
     
     
   public function postCreate() {
        //criando regras de validação
        $regras = array('titulo' => 'required');

        //executando validação
        $validacao = Validator::make(Input::all(), $regras);

        //se a validação deu errado
        if ($validacao->fails()) {
            return Redirect::to('list/create')->withErrors($validacao);
        }
        //se a validação deu certo
        else {
            $list = new Lista;
            $list->titulo = Input::get('titulo');
            $list->user_id = Auth::user()->id;
            $list->save();

            return View::make('listas/add_list')->with('sucesso', TRUE);
        }
    }


    public function listar() {
        return View::make('listas/list_lists')->with('lists', User::find(Auth::user()->id)->listas);
    }
    
    
    public function listarTasks($lista_id = 0) {
        if ($lista_id == 0)
        return $this->listar();
    
        return View::make('listas/lista')->with('lista', User::find(Auth::user()->id)->listas()->where('id', '=', $lista_id)->first());
    }
}