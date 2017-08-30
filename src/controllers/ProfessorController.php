<?php

class ProfessorController extends Controller
{
	function __construct()
	{
		if(isset($_SESSION['login']) && $_SESSION['tipo'] != 'professor') {
            		$this->redirectCheck();
       	 }
	}
	public function index()
	{
		$data['provasPublicadas'] = Prova::selecionar("status= 1");
		$data['provasAPublicar'] = Prova::selecionar("status=0");
		$this->render("professor/index", $data,["title" => "Bem-vindo"]);
	}

	public function verPerfilProf()
	{
	}

	public function cadastroProva()
    {
        $this->render("professor/cadastroProva",[],[]);
    }

	public function editarProva()
	{
	}

	public function excluirProva()
	{
		$questao = Prova::selecionarUm($_POST['id']);
		$questao->setStatus(2);
		$questao->save();
		echo "1";
	}

	public function provas()
	{
		$provas = new Prova;
		$this->render("professor/provas",['provas' => $provas->allProvas()],[]);
	}

	public function buscarProva()
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
			if(!empty($_POST['questao_id'])){
				$quest['id'] = $_POST['questao_id'];
			}
			$quest['enunciado']	= $_POST['enunciado'];
			$quest['valor'] 		= $_POST['valor'];
			$quest['prova_id'] 	= $_POST['prova_id'];
			$quest['ordem']		= $_POST['ordem'];
			$quest['status'] 		= true;
			$questao = new Questao($quest);
			if($questao->save()){

				foreach($_POST as $key => $value) {
					if(substr($key, 0, 11) == 'alternativa') {
						$id = substr($key, 16);

						if(!empty($_POST["id_alternativa".$id])){
							$alter['id'] = $_POST["id_alternativa".$id];

						}
						if(isset($_POST["certa_alternativa".$id])){
							$alter["alternativa_certa"] = 1;

						} else {
							$alter["alternativa_certa"] = 0;
						}
						$alter['enunciado_alter'] = $_POST[$key];
						$alter['questao_id'] = $questao->getId();
						$alternativa = new Alternativa($alter);
						$alternativa->save();
						unset($alter);
					}
				}
					if(empty($_POST['questao_id'])) {

					$html = "
						<tr id='j_".$questao->getId()."'>
							<th scope='row'>".$questao->getOrdem().".</th>
							<td>".$questao->getEnunciado()."</td>
							<td>
								<a id='".$questao->getId()."' href='acao=editarQuestao&modulo=professor&id=".$questao->getId()."' class='badge badge-primary j_editar'>Editar</a>
								<a id='".$questao->getId()."' href='acao=anularQuestao&modulo=professor&id=".$questao->getId()."' class='badge badge-secondary j_anular'>Anular</a>
								<a id='".$questao->getId()."' href='acao=excluirQuestao&modulo=professor&id=".$questao->getId()."' class='badge badge-danger j_excluir'>Excluir</a>
								<i  class='fa fa-check' aria-hidden='true'></i>
							</td>
						</tr>";
					} else {

					$html = "

							<th scope='row'>".$questao->getOrdem().".</th>
							<td>".$questao->getEnunciado()."</td>
							<td>
								<a id='".$questao->getId()."' href='acao=editarQuestao&modulo=professor&id=".$questao->getId()."' class='badge badge-primary j_editar'>Editar</a>
								<a id='".$questao->getId()."' href='acao=anularQuestao&modulo=professor&id=".$questao->getId()."' class='badge badge-secondary j_anular'>Anular</a>
								<a id='".$questao->getId()."' href='acao=excluirQuestao&modulo=professor&id=".$questao->getId()."' class='badge badge-danger j_excluir'>Excluir</a>
								<span class='j_carregando'><i  class='fa fa-spinner fa-spin' aria-hidden='true'></i></span>
							</td>";
					}

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
		Template::exibir('professor/modalQuestao', $data);
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