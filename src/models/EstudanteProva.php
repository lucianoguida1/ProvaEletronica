<?php
class EstudanteProva extends Prova 
{
	static $tabela = 'estudante_has_provas';
	static $classe = 'EstudanteProva';
	static $chave_primaria = 'id';

	protected $id,
			  $estudante_id,
			  $prova_id;

	public function getTabela()
	{
		return static::$tabela;
	}		  

	public function getCampos()
	{
		return array(
				'id'            => array('rotulo' => 'id'),
				'estudante_id'	=> array('rotulo' => 'estudante_id'),
				'prova_id'		=> array('rotulo' => 'prova_id')
				
			);
	}

	public function getCamposObrigatorios()
	{
		return array();
	}

	public function allProvasRespondidasAluno($id_aluno)
	{
		$id_estudante = Estudante::selecionar('usuario_id = '.$id_aluno)[0]->getId();
		$resultado = EstudanteProva::selecionar("estudante_id='".$id_estudante."'");
		$html = "";
		$status = ['0' => 'Inativa', '1' => 'Ativa'];
		foreach ($resultado as $key => $provas) {
			$value = Prova::selecionarUm($provas->getProva_id());
			if($value->getStatus() <= 1){
				$html .= "
					<tr id='j_". $value->getId()."'>
						<th scope='row'> ".$value->getTitulo()." </th>
						<td>".$value->getDisciplina()."</td>
						<td>".date('d/m/y',strtotime($value->getData_prova()))."</td>
						<td>".date('H:i',strtotime($value->getHorario_inicio()))." as ".date('H:i',strtotime($value->getHorario_fim()))."</td>
						<td>".$status[$value->getStatus()]."</td>
						<td>";
						if($value->getStatus() == 1 && $this->validarDataHora($value->getHorario_inicio(),$this->getHorario_fim(),$this->getData_prova()))
						{ 
							$html .= "<a class='btn btn-light' href='acao=responderProva&modulo=aluno&id=".$value->getId()."' role='button'> Responder</a>"; 
						}
						else
						{ 
							$html .= "<button class='btn btn-light' disabled> Indisponivel</button>";
						}	
						$html .= "<td/></tr>";
				}
			}
		return $html;
	}
}