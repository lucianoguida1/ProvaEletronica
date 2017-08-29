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
		  $qtd_questoes,
		  $status;

	public function getTabela()
	{
		return static::$tabela;
	}

	public function getCampos()
	{
		return array(
				'id'			=> array('rotulo' => 'id'),
				'titulo'			=> array('rotulo' => 'titulo'),
				'disciplina'   		 => array('rotulo' => 'disciplina'),
				'data_prova'		=> array('rotulo' => 'data_prova'),
				'horario_inicio'		 => array('rotulo' => 'horario_inicio'),
				'horario_fim'		=> array('rotulo' => 'horario_fim'),
				'professor_id'		=> array('rotulo' => 'professor_id'),
				'qtd_questoes' 		 => array('rotulo' => 'qtd_questoes'),
				'status' => array('rotulo' => 'status')
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

	public function allProvasAluno()
	{
		$provas = Prova::selecionar("status <= 1");
		$html = "";
		$cont = 1;
		$status = ['0' => 'Inativa', '1' => 'Ativa'];
		foreach ($provas as $key => $value) {
			$html .= "
				<tr id='j_". $value->getId()."'>
					<th scope='row'> ".$value->getTitulo()." </th>
					<td>".$value->getDisciplina()."</td>
					<td>".date('d/m/y',strtotime($value->getData_prova()))."</td>
					<td>".date('H:i',strtotime($value->getHorario_inicio()))." as ".date('H:i',strtotime($value->getHorario_fim()))."</td>
					<td>".$status[$value->getStatus()]."</td>
					<td>";
					if($value->getStatus() == 1 && $this->validarDataHora(['inicio' => $value->getHorario_inicio(),'fim' => $value->getHorario_fim(),'data' => $value->getData_prova()]))
					{ 
						$html .= "<a class='btn btn-light' href='acao=responderProva&modulo=aluno&id=".$value->getId()."' role='button'> Responder</a>"; 
					}
					else
					{ 
						$html .= "<button class='btn btn-light' disabled> Indisponivel</button>";
					}	
					$html .= "<td/></tr>";
					$cont++;
			}
		return $html;
	}

	public function validarDataHora(array $array)
	{
		$data_start = $array['data']." ".$array['inicio'];
		$data_fim = $array['data']." ".$array['fim'];
		$data_hora_atual = DateTime::createFromFormat('Y-m-d H:i:s', date('Y-m-d H:i:s'));
		$date_time_start = DateTime::createFromFormat('Y-m-d H:i:s', $data_start);
		$date_time_end = DateTime::createFromFormat('Y-m-d H:i:s',$data_fim);
		if($data_hora_atual >= $date_time_start && $data_hora_atual <= $date_time_end)
			return true;
		return false;
	}
}