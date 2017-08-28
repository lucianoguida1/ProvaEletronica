<?php


class Questao extends Model
{
	static $tabela = 'questoes';
	static $classe = 'Questao';
	static $chave_primaria = 'id';

	protected $id,
		  $enunciado,
		  $valor,
		  $status,
		  $ordem,
		  $prova_id;

	public function getTabela()
	{
		return static::$tabela;
	}

	public function getCampos()
	{
		return array(
				'id'			=> array('rotulo' => 'id'),
				'enunciado'		=> array('rotulo' => 'enunciado'),
				'valor'			=> array('rotulo' => 'valor'),
				'status'			=> array('rotulo' => 'status'),
				'ordem'			=> array('rotulo' => 'ordem'),
				'prova_id'		=> array('rotulo' => 'prova_id')
			);
	}

	public function getCamposObrigatorios()
	{
		return array('enunciado', 'valor', 'status', 'prova_id', 'ordem');
	}
}