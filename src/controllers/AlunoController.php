<?php

class AlunoController extends Controller
{

	function __construct()
	{
		if(isset($_SESSION['login']) && $_SESSION['tipo'] != 'estudante') {
            $this->redirectCheck();
        }

	}

    public function index()
    {       
        $this->render("index",[],[]);
    }

    

    public function provas()
    {
        $this->render("home/provas",[],[]);
    }
}
