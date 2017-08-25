<?php


class Estudante extends Usuario
{
	static $tabela = 'estudantes';
	static $classe = 'Estudante';
	static $chave_primaria = 'id';

	protected $id,
			  $nome_estudante,
			  $matricula_estudante,
			  $cpf_estudante,
			  $email_estudante,
			  $sexo_estudante,
			  $usuario_id;

	public function getTabela()
	{
		return static::$tabela;
	}		  

	public function getCampos()
	{
		return array(
				'id'					=> array('rotulo' => 'id'),
				'nome_estudante'		=> array('rotulo' => 'nome_estudante'),
				'matricula_estudante'	=> array('rotulo' => 'matricula_estudante'),
				'cpf_estudante'			=> array('rotulo' => 'cpf_estudante'),
				'email_estudante'		=> array('rotulo' => 'email_estudante'),
				'sexo_estudante'		=> array('rotulo' => 'sexo_estudante'),
				'usuario_id'			=> array('rotulo' => 'usuario_id')				
			);
	}

	public function getCamposObrigatorios()
	{
		return array('nome_estudante', 'matricula_estudante', 'cpf_estudante', 'email_estudante', 'sexo_estudante', 'usuario_id');
	}
}