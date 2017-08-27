<?php


class ProvaController extends Controller
{

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

			if(isset($_POST['id'])) {
				$msg = 'Prova atualizada com sucesso.';
			} else {
				$msg = 'Prova cadastrada com sucesso.';
			}


			$this->render('professor/cadastroProva', $data,array('title'=>'Prova Eletronica','msg'=>array(
                'success',
                $msg,
                'Agora você já pode adicionar Questões!'
                )));;

		} else {
			$this->render('professor/cadastroProva',array(),array('title'=>'Prova Eletronica','msg'=>$valid->getErrors()));
			$this->redirectTo('professor/cadastroProva');
		}
	}

	public function cadastrarQuestaoAjax()
	{

		$existeResposta = false;
		$data = array();
		foreach ($_POST as $key => $value) {
			if(substr($key, 0, 5) === 'certa') {
				$existeResposta = true;
				break;
			}

		}


		if ($existeResposta == 1 ) {
			if(empty($_POST['questao_id'])){
				$prov['id'] = $_POST['questao_id'];
			}
			$quest['enunciado']		= $_POST['enunciado'];
			$quest['valor'] 		= $_POST['valor'];
			$quest['prova_id'] 		= $_POST['prova_id'];
			$quest['ordem']			= $_POST['ordem'];
			$quest['status'] 		= true;
			$questao = new Questao($quest);
			if($questao->save()){

				$alter['questao_id'] = $questao->getId();

				foreach($_POST as $key => $value) {
					if(substr($key, 0, 11) == 'alternativa') {
						$id = substr($key, 16);
						$dataId = empty($_POST["id_alternativa".$id]);
						if($dataId != 1){
							$alter['id'] = $_POST["id_alternativa".$id];
						}
						if(isset($_POST["certa_alternativa".$id])){
							$alter["alternativa_certa"] = 1;
						}
						$alter['enunciado_alter'] = $_POST[$key];

						$alternativa = new Alternativa($alter);
						$alternativa->save();

					}
					unset($alter['id']);
					$alter["alternativa_certa"] = 0;
				}

					$html = "
					<tr id='j_".$questao->getId()."'>
						<th scope='row'>".$questao->getOrdem().".</th>
						<td>".$questao->getEnunciado()."</td>
						<td>
							<a id='".$questao->getId()."' href='acao=editarQuestao&modulo=prova&id=".$questao->getId()."' class='badge badge-primary j_editar'>Editar</a>
							<a id='".$questao->getId()."' href='acao=anularQuestao&modulo=prova&id=".$questao->getId()."' class='badge badge-secondary j_anular'>Anular</a>
							<a id='".$questao->getId()."' href='acao=excluirQuestao&modulo=prova&id=".$questao->getId()."' class='badge badge-danger j_excluir'>Excluir</a>
							<i  class='fa fa-check' aria-hidden='true'></i>
						</td>
					</tr>";


				echo $html;
			} else {
					//ERRO AO SALVAR A QUESTÃO;
				echo '1';
			}
		} else {
				// DEFINA UMA RESPOSTA CERTA
			echo '0';
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

	public function excluirAlternativa()
	{

		$alternativa =  Alternativa::selecionarUm($_POST['id']);

		if($alternativa->deletar()) {
			echo "1";
		} else{
			echo "0";
		}
	}

}