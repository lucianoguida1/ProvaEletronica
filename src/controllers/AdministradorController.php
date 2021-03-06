<?php 


class AdministradorController extends Controller
{

	function __construct()
	{
		if(isset($_SESSION['login']) && $_SESSION['tipo'] != 'admin' || !isset($_SESSION['login'])) {
            $this->redirectCheck();
        }

	}

	public function index(){
		$us = New Usuario();
		$data['usuarios'] = $us->selecionar('status = 0');
		$this->render('admin/index',$data);
	}
	public function professores(){
		$us = New Usuario();
		$data['usuarios'] = $us->selecionar('status != 0 and tipo="professor"');
		$this->render('admin/professores',$data);
	}
	public function estudantes(){
		$us = New Usuario();
		$data['usuarios'] = $us->selecionar('status != 0 and tipo="estudante"');
		$this->render('admin/estudantes',$data);
	}
	public function provas(){
		$us = New Prova();
		$data['provas'] = $us->selecionar();
		$this->render('admin/provas',$data);
	}
	public function solicitacao(){
		$us = New Usuario();
		$data['usuarios'] = $us->selecionar('status = 2');
		$this->render('admin/solicitacao',$data);
	}
}