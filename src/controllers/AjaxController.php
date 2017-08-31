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
		/*
    
        TAVA COM FOME QNDO FEZ ISSO ???????
        QUE VIAGEM BY GUIDA!!!

        $modulo = isset($_POST['modulo']) ? $_POST['modulo'] : 'home';
        $acao = isset($_POST['acao']) ? $_POST['acao'] : 'index';
        $classe = ucfirst($modulo) . 'Controller';

        try {
            if (!class_exists($classe)){
                throw new Exception('Controller inexistente!');
            }

            $classeInstancia = new $classe;
            if (!method_exists($classeInstancia, $acao)){
                throw new Exception("Não existe acao $acao no controller $classe!");
            }

            $classeInstancia->$acao();

        } catch (Exception $exc) {
            echo $exc->getMessage();
            echo $exc->getTraceAsString();
            exit;
        }*/

}

