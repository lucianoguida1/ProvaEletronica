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
				'data_prova'	=> array('rotulo' => 'data_prova'),
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

	public function allProvas()
	{
		$provas = Prova::selecionar("status <= 1");
		$html = "";
		$cont = 1;
		foreach ($provas as $key => $value) {
			$html .= "
				<tr id='j_". $value->getId()."'>
					<th scope='row'> ".$value->getTitulo()." </th>
					<td>".$value->getDisciplina()."</td>
					<td>".$value->getData_prova()."</td>
					<td>".$value->getQtd_questoes()."</td>
					<td>
						<a id='".$value->getId()."' href='acao=cadastroProva&modulo=professor&id=".$value->getId()." ' class='badge badge-primary j_editar'>Editar</a>
						<a id=' ".$value->getId()."' href='acao=anularProva&modulo=professor&id=".$value->getId()."' class='badge badge-secondary j_anular'>Anular</a>
						<a id=' ".$value->getId()."' href='acao=excluirProva&modulo=professor&id=".$value->getId()."' class='badge badge-danger j_excluir'>Excluir</a></td>
					</tr>";
					$cont++;
			}
		return $html;
	}
}