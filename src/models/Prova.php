<?php


class Prova extends Model 
{
	static $tabela = 'provas';
	static $classe = 'Prova';
	static $chave_primaria = 'id';

	protected $id,		
			  $titulo,
			  $disciplina,	
			  $data_prova,
			  $horario_inicio,
			  $horario_fim,
			  $professor_id,
			  $qtd_questoes;

	public function getTabela()
	{
		return static::$tabela;
	}		  

	public function getCampos()
	{
		return array(
				'id'			=> array('rotulo' => 'id'),	
				'titulo'		=> array('rotulo' => 'titulo'),	
				'disciplina'    => array('rotulo' => 'disciplina'),	
				'data_prova'			=> array('rotulo' => 'data_prova'),
				'horario_inicio' => array('rotulo' => 'horario_inicio'),
				'horario_fim'	=> array('rotulo' => 'horario_fim'),
				'professor_id'	=> array('rotulo' => 'professor_id'),	
				'qtd_questoes'   => array('rotulo' => 'qtd_questoes')			
			);
	}

	public function getCamposObrigatorios()
	{
		return array('titulo', 'disciplina', 'data_prova', 'horario_inicio', 'horario_fim', 'professor_id', 'qtd_questoes');
		
	}
}