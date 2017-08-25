<?php

class Administrador extends Usuario
{
	static $tabela = 'administradores';
	static $classe = 'Administrador';
	static $chave_primaria = 'id';

	protected $id,
			  $usuario_id;

	public function getTabela()
	{
		return static::$tabela;
	}		  

	public function getCampos()
	{
		return array(
				'id'		=> array('rotulo' => 'id'),
				'usuario_id'=> array('rotulo' => 'usuario_id')
			);
	}

	public function getCamposObrigatorios()
	{
		return array('usuario_id');
	}
}