<?php

class Template {

    public static function exibir($template,array $data = null){
        if (!is_null($data)){
            extract($data);
        }
        if( isset($_SESSION['login']) && isset($_SESSION['tipo']) ){
            extract(self::menus($_SESSION['tipo']));
        }else{
            extract(self::menus('index'));
        }
        $dir = dirname(__FILE__)
            .DIRECTORY_SEPARATOR . '..'
            .DIRECTORY_SEPARATOR . 'src'
            .DIRECTORY_SEPARATOR . 'views'
            .DIRECTORY_SEPARATOR;

            $dirs = array(
            'home',
            'usuario'            
        );

        $verdade = false;
        foreach ($dirs as $d) {
            $file = dirname(__FILE__)
                . DIRECTORY_SEPARATOR . '..'
                . DIRECTORY_SEPARATOR . 'src'
                . DIRECTORY_SEPARATOR . 'views'
                . DIRECTORY_SEPARATOR . $d
                . DIRECTORY_SEPARATOR . $template . '.tpl.php';
            if (file_exists($file)) {
                require_once $file;
                $verdade = true;
            }
        }
        
        if(!$verdade) {
            require_once $dir . $template . '.tpl.php';
        }
    }


    public static function menus($tipo){
            /*
    **  PARA ADICIONAR ITEM AO MENUS, A KEY( REPRESENTA O NOME EXIBIDO) E O VALOR ( CLASSE(controller) / METODO );
            */
            switch ($tipo) {
                case 'index':
                    $menu['menu']=array(
                        "Login"=>"index/login",
                        "Cadastro"=>"index/cadastro"
                    );
                    break;
                case 'professor':
                    $menu['menu']=array(
                        "Cadastrar Prova" => "home/cadastroProva",
                        "Provas"          => "home/provas",
                        "Sair" => "index/logout"
                    );
                    break;
                case 'estudante':
                    $menu['menu']= [

                    ];
                    break;
                case 'admin':
                    $menu['menu'] = [
                    ];
                    break;
            }
            return $menu;
        }
}


