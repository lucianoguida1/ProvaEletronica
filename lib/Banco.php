<?php

class Banco {
//    static $instancia;
    static $pdo;


    private function __construct() {
        
    }
    /**
     * 
     * @return PDO
     */
    
    static function instanciar(){
        if(!isset(self::$pdo)){
            self::$pdo = new PDO(
                    'mysql:host=localhost;dbname=prova_eletronica',
                    'root',
                    '');
            self::$pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
            self::$pdo->setAttribute( PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
            
        }
        return self::$pdo;
    }
}


