<?php

class Controller {   

    public static function inicializar() {
            $modulo = isset($_GET['modulo']) ? $_GET['modulo'] : 'index';
            $acao = isset($_GET['acao']) ? $_GET['acao'] : 'index';
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
    
        

    public function redirectTo($endereco)
    {
        $separado = explode("/",$endereco);
        header("Location: ?acao=$separado[1]&modulo=$separado[0]");
    }

    public function render($arquivo = 'erro404',$data = array(),$adicionais=array()){
        /**
            $arquivo: RECEBE A VIEW A SER EXIBIDA
            $data: RECEBE OS DADOS A SEREM MOTRADO NA VIEW
            $adicionais: RECEBE OS ADICIONAIS A SEREM EXIBIDO NO HEADER
        **/
        if(!isset($adicionais['title']))
            $adicionais['title'] = "Prova Eletronica";
        Template::exibir('_header',$adicionais);
        Template::exibir($arquivo, $data);
        Template::exibir('_Footer');
    }

    public function redirectCheck()
    {
        if($_SESSION['login']){
            switch ($_SESSION['tipo']) {
                case 'professor':
                        $this->redirectTo("professor/index");
                        break;
                    case 'estudante':
                        $this->redirectTo("aluno/index");
                        break;
                    case 'admin':
                        $this->redirectTo("administrador/index");
                        break;
                    default:
                        $this->redirectTo("usuario/login");
                        break;
            }
        }
        else
        {
            $this->redirectTo("usuario/login");
        }
    }
}

