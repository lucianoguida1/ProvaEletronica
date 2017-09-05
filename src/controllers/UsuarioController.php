<?php

class UsuarioController extends Controller
{
	public function login()
	{
        
        if(isset($_SESSION['login']) && $_SESSION['login'] == true) $this->redirectCheck();

        if(isset($_REQUEST['email']) && !is_null($_REQUEST['email'])){
	        $callback = Usuario::logar($_REQUEST);    
	        if($callback['status'] == true)
	        {
	            $_SESSION['user_id'] = $callback['user']['id_user'];
	            $_SESSION['tipo'] = $callback['user']['tipo'];
	            $_SESSION['user_email'] = $callback['user']['tipo'];
	            $_SESSION['login'] = $callback['status'];
	            switch ($callback['user']['tipo']) {
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
	            		$this->redirectTo("index/index");
	            		break;
	            }
	            
	        }
	        else
	        {
	            $this->render("login",[],['msg'=>$callback['alert'], 'title' => "Prova Eletronica"]);
	        }
	    }
	    else
	    {
	    	$this->render('login',array(),array('title'=>'Prova Eletronica'));
	    }
    }

    public function logout()
    {
        $_SESSION['login'] == true;
        session_destroy();
        $this->redirectTo("index/index");
    }
}