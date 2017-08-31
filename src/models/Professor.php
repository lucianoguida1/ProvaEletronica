<?php


class Professor extends Usuario
{
	static $tabela = 'professores';
	static $classe = 'Professor';
	static $chave_primaria = 'id';

	protected $id,
			  $nome_prof,
			  $matricula_prof,
			  $cpf_prof,
			  $email_prof,
			  $sexo_prof,
			  $usuario_id;

	public function getTabela()
	{
		return static::$tabela;
	}
	public function getCampos()
	{
		return array(
				'id'			=> array('rotulo' => 'id'),
				'nome_prof'		=> array('rotulo' => 'nome_prof'),
				'matricula_prof'=> array('rotulo' => 'matricula_prof'),
				'cpf_prof'		=> array('rotulo' => 'cpf_prof'),
				'email_prof'	=> array('rotulo' => 'email_prof'),
				'sexo_prof'		=> array('rotulo' => 'sexo_prof'),
				'usuario_id'	=> array('rotulo' => 'usuario_id')
			);
	}	

	public function getCamposObrigatorios()
	{
		return array('nome_prof', 'matricula_prof', 'cpf_prof', 'email_prof', 'sexo_prof', 'usuario_id');
	}	  
}