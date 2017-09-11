<?php
class EstudanteProva extends Model
{
	static $tabela = 'estudante_has_provas';
	static $classe = 'EstudanteProva';
	static $chave_primaria = 'id';

	protected $id,
		    $estudante_id,
		    $prova_id,
		    $status_responder_prova;

	public function getTabela()
	{
		return static::$tabela;
	}

	public function getCampos()
	{
		return array(
			'id'            => array('rotulo' => 'id'),
			'estudante_id'	=> array('rotulo' => 'estudante_id'),
			'prova_id'		=> array('rotulo' => 'prova_id'),
			'status_responder_prova' => array('rotulo' => 'status_responder_prova')
			);
	}

	public function getCamposObrigatorios()
	{
		return array();
	}
}