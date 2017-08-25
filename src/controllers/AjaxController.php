<?php

require_once '.../config/autoload.php';
require_once '.../config/config.php';
class AjaxController {
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
            }

        }
}

