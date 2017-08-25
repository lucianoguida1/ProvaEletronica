<?php

class ProfessorController extends Controller 
{
	function __construct()
	{
		if(isset($_SESSION['login']) && $_SESSION['tipo'] != 'professor') {
            $this->redirectCheck();
        }
	}
	public function index()
	{
		$this->render("professor/index",[],["title" => "Bem-vindo"]);
	}

	public function verPerfilProf()
	{
	}

	public function cadastroProva()
    {
        $this->render("professor/cadastroProva",[],[]);
    }

	public function editarProva()
	{
	}

	public function excluirProva()
	{
		$questao = Prova::selecionarUm($_POST['id']);
		$questao->setStatus(2);
		$questao->save();
		echo "1";
	}

	public function provas()
	{
		$provas = new Prova;
		$this->render("professor/provas",['provas' => $provas->allProvas()],[]);
	}	

	public function buscarProva()
	{		
	}
}