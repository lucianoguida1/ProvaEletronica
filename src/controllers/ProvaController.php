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
		
		$valid = new validator($_POST);
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
			
			$prova = new Prova($prov);
			$prova->save();
			$data['prova'] = $prova;

			if(isset($_POST['id'])) {
				$data['questoes'] = Questao::selecionar("prova_id='".$prova->getId()."'");
			}

			$this->render('home/cadastroProva', $data,array('title'=>'Prova Eletronica','msg'=>array(
                'success',
                'Prova cadastrada com sucesso.',
                'Agora você já pode adicionar Questões!'
                )));;

		} else {
			$this->render('home/cadastroProva',array(),array('title'=>'Prova Eletronica','msg'=>$valid->getErrors()));
			$this->redirectTo('home/cadastroProva');
		}
	}
}