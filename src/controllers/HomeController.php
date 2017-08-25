<?php

class HomeController extends Controller
{

	function __construct()
	{
		if(!isset($_SESSION['login'])) {
            self::render("index",[],[]);
             exit();
        } elseif (!$_SESSION['login']) {
            self::render("index",[],[]);   
             exit();       
        }

	}

    public function index()
    {       
        $this->render("index",[],[]);
    }

    public function cadastroProva()
    {
        $this->render("home/cadastroProva",[],[]);
    }

    public function provas()
    {
        $this->render("home/provas",[],[]);
    }
}
