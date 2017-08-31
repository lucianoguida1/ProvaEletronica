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

}

