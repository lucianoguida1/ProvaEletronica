<?php

function autoloadLib($classe)
{
        $file = dirname(__FILE__) 
                . DIRECTORY_SEPARATOR . '..'
                . DIRECTORY_SEPARATOR . 'lib'
                . DIRECTORY_SEPARATOR . $classe . '.php';
        if (file_exists($file)){
            require_once $file;
        }
  
}
spl_autoload_register('autoloadLib');

function autoloadSrc($classe)
{
    $dirs = array(
        'controllers',
        'models',
     );
        
    foreach($dirs as $dir) {
        $file = dirname(__FILE__) 
                . DIRECTORY_SEPARATOR . '..'
                . DIRECTORY_SEPARATOR . 'src'
                . DIRECTORY_SEPARATOR . $dir
                . DIRECTORY_SEPARATOR . $classe . '.php';
        if (file_exists($file)){
            require_once $file;
        }
    }
}
spl_autoload_register('autoloadSrc');