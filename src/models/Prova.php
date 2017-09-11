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
				'status' => array('rotulo' => 'status')
			);
	}

	public function getCamposObrigatorios()
	{
		return array('titulo', 'disciplina', 'data_prova', 'horario_inicio', 'horario_fim', 'professor_id');

	}

	public function getProfessor(){
		$return = new Professor();
        return $return->selecionar("id = ".$this->getId())[0];
	}
	public function allProvas()
	{


	}

	public function allProvasAluno()
	{
		$provas = Prova::selecionar("status <= 1");
		$html = "";
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
						$html .= "<a class='btn btn-light' href='?acao=responderProva&modulo=aluno&id=".$value->getId()."' role='button'> Responder</a>";
					}
					else
					{
						$html .= "<button class='btn btn-light' disabled> Indisponivel</button>";
					}
					$html .= "<td/></tr>";
			}
		return $html;
	}

	public static function validarDataHora(array $array)
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

	public static function getProvas(
		$condicao = null,
		$ordem = null,
		$limite = null,
		$deslocamento = null) {

		if(!is_null($limite)) {
			if (!is_null($deslocamento)) {
				$limite = "$deslocamento , $limite";
			}
		}

		$pdo = Banco::instanciar();
		$selectSQL = "SELECT
		provas.id,
		provas.titulo,
		provas.disciplina,
		provas.data_prova,
		provas.horario_inicio,
		provas.horario_fim,
		provas.professor_id,		
		provas.status,
		COUNT(questoes.id) as qtd_questoes,
		sum(questoes.valor) as valor,
		COUNT(DISTINCT estudante_has_provas.estudante_id) as qtdEst
		FROM " . static::$tabela
		." LEFT JOIN questoes ON questoes.prova_id = provas.id LEFT JOIN estudante_has_provas ON estudante_has_provas.prova_id=provas.id"
		. (!is_null($condicao) ? " WHERE $condicao" : '')
		. "  group by provas.id, provas.titulo, provas.disciplina, provas.data_prova, provas.horario_inicio,
		provas.horario_fim, provas.professor_id, provas.status"
		. (!is_null($ordem) ? " ORDER BY $ordem" : '')
		. (!is_null($limite) ? " LIMIT $limite" : '');

		$statement = $pdo->prepare($selectSQL);
		$statement->execute();
		$results = $statement->fetchAll();
		$objects = array();
		$classe = static::$classe;

		foreach ($results as $row) {
			$objects[] = new $classe($row);
		}

        return $objects;
    }

    public static function getArrayProvas(
        $condicao = null,
        $ordem = null,
        $limite = null,
        $deslocamento = null) {

        if(!is_null($limite)) {
            if (!is_null($deslocamento)) {
                $limite = "$deslocamento , $limite";
            }
        }

        $pdo = Banco::instanciar();
        $selectSQL = "SELECT
		provas.id,
		provas.titulo,
		provas.disciplina,
		provas.data_prova,
		provas.horario_inicio,
		provas.horario_fim,
		provas.professor_id,		
		provas.status,
		COUNT(questoes.id) as qtd_questoes,
		format(sum(questoes.valor),2,'de_DE') as valor,
		COUNT(DISTINCT estudante_has_provas.estudante_id) as qtdEst
		FROM " . static::$tabela
            ." LEFT JOIN questoes ON questoes.prova_id = provas.id LEFT JOIN estudante_has_provas ON estudante_has_provas.prova_id=provas.id"
            . (!is_null($condicao) ? " WHERE $condicao" : '')
            . "  group by provas.id, provas.titulo, provas.disciplina, provas.data_prova, provas.horario_inicio,
		provas.horario_fim, provas.professor_id, provas.status"
            . (!is_null($ordem) ? " ORDER BY $ordem" : '')
            . (!is_null($limite) ? " LIMIT $limite" : '');

        $statement = $pdo->prepare($selectSQL);
        $statement->execute();
        $results = $statement->fetchAll();

        return $results;
    }

}