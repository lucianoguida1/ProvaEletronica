<?php


class Alternativa extends Model
{
	static $tabela = 'alternativas';
	static $classe = 'Alternativa';
	static $chave_primaria = 'id';

	protected $id,
			  $enunciado_alter,
			  $alternativa_certa,
			  $questao_id;

	public function getTabela()
	{
		return static::$tabela;
	}

	public function getCampos()
	{
		return array(
			'id'				=> array('rotulo' => 'id'),
			'enunciado_alter'	=> array('rotulo' => 'enunciado_alter'),
			'alternativa_certa' => array('rotulo' => 'alternativa_certa'),
			'questao_id'		=> array('rotulo' => 'questao_id')
			);
	}

	public  function getCamposObrigatorios()
	{
		return array('enunciado_alter', 'alternativa_certa', 'questao_id');
	}
}