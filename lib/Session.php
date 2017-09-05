<?php
/**
* 
*/
class Session
{

	public $id_estudante;
	public $id_prova;
	public $status_log;
	
	function __construct($dados)
	{
		$this->id_estudante = $dados['estudante_id'];
		$this->id_prova = $dados['prova_id'];
	}

	public function init()
	{
		if($this->check_existe())
        {
            if($this->status_log)
            {
                $this->startOrContinue();
            }
            else
            {
                self::closeOrStop();
            }
        }
        else
        {

            $dados = ['status_responder_prova' => "1",'estudante_id' => $this->id_estudante,'prova_id' => $this->id_prova];
            $provaEstudante = new EstudanteProva($dados);
            $provaEstudante->save();
        }
	}

	private function check_existe()
	{
		$result = null;
		$result = EstudanteProva::selecionar("estudante_id = '".$this->id_estudante."' AND prova_id = '".$this->id_prova."'")[0];
		if(is_null($result) || empty($result))
			return false;
		$this->status_log = $result->getStatus_responder_prova();
		return true;
	}

	private function startOrContinue()
	{
		$prova = Prova::selecionarUm($this->id_prova);
		if(Prova::validarDataHora([
			'inicio' => $prova->getHorario_inicio(),
			'fim' => $prova->getHorario_fim(),
			'data' => $prova->getData_prova()
		])){
			$_SESSION['prova_em_progresso'] = ['estudante' => $this->id_estudante,'prova' => $this->id_prova];
		}
		else
		{
			$this->closeOrStop();
		}
	}

	private static function closeOrStop()
	{
		unset($_SESSION['prova_em_progresso']);
	}

	public static function checkTempo($id_prova,$id_estudante)
	{
		if(isset($_SESSION['prova_em_progresso']))
		{
			if($_SESSION['prova_em_progresso']['estudante'] = $id_estudante && $_SESSION['prova_em_progresso']['prova'] = $id_prova)
			{
				$prova = Prova::selecionarUm($id_prova);
				$hora_atual = strtotime(date("H:i:s"));
				$hora_prova = strtotime($prova->getHorario_fim());

				return ($hora_prova - $hora_atual);
			}
		}
	}
}