<?php


class ProvaController extends Controller
{

	public function iniciar()
	{		
	}

	public function finalizar()
	{		
	}

	public function calcularNota()
	{		
	}

	public function apresentarNota()
	{		
	}

	public function salvarProva()
	{
		if(empty($_POST['id'])) unset($_POST['id']);
		$valid = new Validator($_POST);
		$valid->field_filledIn($_POST);
		if ($valid->valid) {
			if(isset($_POST['id'])) $prov['id'] = $_POST['id'];

			$prov['titulo'] = $_POST['titulo'];
			$prov['disciplina'] = $_POST['disciplina'];
			$prov['data_prova'] = $_POST['data_prova'];
			$prov['horario_inicio'] = $_POST['inicio'];
			$prov['horario_fim'] = $_POST['fim'];
			$prov['professor_id'] = $_SESSION['user_id'];
			$prov['qtd_questoes'] = $_POST['quantidade']; 
			$prov['status'] = 0;
			
			$prova = new Prova($prov);
			$prova->save();
			$data['prova'] = $prova;

			if(isset($_POST['id'])) {
				$data['questoes'] = Questao::selecionar("prova_id='".$prova->getId()."'");
			}

			$this->render('professor/cadastroProva', $data,array('title'=>'Prova Eletronica','msg'=>array(
                'success',
                'Prova cadastrada com sucesso.',
                'Agora você já pode adicionar Questões!'
                )));;

		} else {
			$this->render('professor/cadastroProva',array(),array('title'=>'Prova Eletronica','msg'=>$valid->getErrors()));
			$this->redirectTo('professor/cadastroProva');
		}
	}

	public function cadastrarQuestaoAjax()
	{
		$resposta = false;
			
			for($i = 0; $i < sizeof($_POST); $i++) {
				if(isset($_POST["resposta_alternativa$i"]))  
					if($_POST["resposta_alternativa$i"]){
						$resposta = true;						
						break;				
					}			
			}
			if ($resposta == 1 ) {
				
				if($_POST['questao_id'] == ""){ unset($_POST['questao_id']);}else{$prov['id'] = $_POST['questao_id'];}
				$quest['enunciado']		= $_POST['enunciado'];
				$quest['valor'] 		= $_POST['valor'];
				$quest['prova_id'] 		= $_POST['prova_id'];
				$quest['status'] 		= true;
				$questao = new Questao($quest);
				if($questao->save()){

					if(empty($_POST['alternativa_id'])) unset($_POST['alternativa_id']);		
					if(isset($_POST['alternativa_id'])) $prov['id'] = $_POST['alternativa_id'];
					$alter['questao_id'] = $questao->getId();
					for($i = 0; $i < sizeof($_POST); $i++) {													
							if(isset($_POST["resposta_alternativa$i"])) {
								$alter['alternativa_certa'] = 1;
							} else {
								$alter['alternativa_certa'] = 0;
							}	
							if (isset($_POST["alternativa$i"])) {
								$alter['enunciado_alter'] = $_POST["alternativa$i"];
								$alternativa = 	new Alternativa($alter);
								$alternativa->save();
							}									
					}			
					$quest['id'] = $questao->getId();												
					echo json_encode($quest);
				} else {
					//ERRO AO SALVAR A QUESTÃO;
					$erro['erro'] = 1;
					echo json_encode($erro);
				}
			} else {
				// DEFINA UMA RESPOSTA CERTA
				$erro['erro'] = 0;
				echo json_encode($erro);
			}
	}

	public function excluirQuestao()
	{
		$questao = Questao::selecionarUm($_POST['id']);
		$alternativas = Alternativa::selecionar("questao_id='".$questao->getId()."'");

		foreach ($alternativas as $alternativa) {
			$alternativa->deletar();
		}
		if($questao->deletar()) {
			//VALOR ENVIAR PARA O AJAX
			echo "1";
		} else {
			//VALOR ENVIAR PARA O AJAX
			echo "0";
		}			
	}

	public function anularQuestao()
	{
		$questao = Questao::selecionarUm($_POST['id']);
		if ($questao->getStatus() == 1) {
			$questao->setStatus(0);
			$questao->save();
			echo "1";
		} else {
			$questao->setStatus(1);
			$questao->save();
			echo "2";
		}		
	}

	public function editarQuestao()
	{
		$questao = Questao::selecionarUm($_POST['id']);
		$data['questao'] = $questao; 
		$alternativas = Alternativa::selecionar("questao_id='".$questao->getId()."'");
		$data['alternativas'] = $alternativas;
		Template::exibir('prova/modalQuestao', $data);
	}

	public function elaborarQuestao()
	{		
	}

	public function VerificarResposta()
	{		
	}
}