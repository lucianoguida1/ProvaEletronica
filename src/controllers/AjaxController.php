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
            $prof = $us->getProfessor(); //// PAREI AQUI VEA
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

