<?php 


class AdministradorController extends Controller
{
	public function index(){
		$us = New Usuario();
		$data['usuarios'] = $us->selecionar('status = 0');
		$this->render('admin/index',$data);
	}
}