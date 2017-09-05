<?php


class AjaxController extends controller{
    public function adminAceita(){
        if(isset($_REQUEST['id'])){
            $us = new Usuario();
            $us = $us->selecionarUm((int)$_REQUEST['id']);
            if(!empty($us)){
                $us->setStatus(1);
                if($us->save()){
                    echo true;
                }else{
                    echo false;
                }
            }
        }
    }
    public function adminAltera(){
        if(isset($_REQUEST['id'])){
            $us = new Usuario();
            $us = $us->selecionarUm((int)$_REQUEST['id']);
            $prof = $us->getProfessor();
            $prof->setNome_prof($_REQUEST['nome']);
            $prof->setMatricula_prof($_REQUEST['matricula']);
            $prof->setEmail_prof($_REQUEST['email']);
            if($prof->save()){
                echo ("<div class='alert alert-success' role='alert'>
                        Usuário alterado com sucesso!
                    </div>");
            }
        }
    }
    public function adminRecusa(){
        if(isset($_REQUEST['id'])){
            $us = new Usuario();
            $us = $us->selecionarUm((int)$_REQUEST['id']);
            if(!empty($us)){
                $us->setStatus(2);
                if($us->save()){
                    echo true;
                }else{
                    echo false;
                }
            }
        }
    }
    public function alunoResponderProvaCheckTempo()
    {
        if(isset($_REQUEST['id_prova']) && isset($_REQUEST['id_estudante']))
        {
            $callback = Session::checkTempo($_REQUEST['id_prova'],$_REQUEST['id_estudante']);
            echo $callback;
        }

    }

}

