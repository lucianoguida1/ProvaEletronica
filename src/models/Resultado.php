<?php


class Resultado extends Model 
{
	static $tabela = 'resultados';
	static $classe = 'Resultado';
	static $chave_primaria = 'id';

	protected $id,
			  $resposta,
			  $estudante_id,
			  $prova_id,
			  $questoes_id;

	public function getTabela()
	{
		return static::$tabela;
	}		  

	public function getCampos()
	{
		return array(
				'id'            => array('rotulo' => 'id'),
				'resposta'  	=> array('rotulo' => 'resposta'),
				'estudante_id'	=> array('rotulo' => 'estudante_id'),
				'prova_id'		=> array('rotulo' => 'prova_id'),
				'questoes_id'	=> array('rotulo' => 'questoes_id')
			);
	}

	public function getCamposObrigatorios()
	{
		return array('resposta', 'estudante_id', 'prova_id', 'questoes_id');
	}
}