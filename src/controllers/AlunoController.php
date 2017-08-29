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
        $provas = new Prova;
        $this->render("aluno/index",['provas' => $provas->allProvasAluno()],[]);
    }

    public function perfil()
    {
        $this->render("aluno/perfil",['estudante' => Estudante::selecionar("usuario_id = '".$_SESSION['user_id']."'"), 'usuario' => Usuario::selecionarUm($_SESSION['user_id'])],[]);
    }

    public function minhasProvas()
    {
        $provas = new EstudanteProva();
        $this->render("aluno/minhasprovas",['provas' =>$provas->allProvasRespondidasAluno($_SESSION['user_id'])],[]);
    }

    public function responderProva()
    {
        $id_prova = $_GET['id'];
    }

    
}
