<?php

class AlunoController extends Controller
{

	function __construct()
	{
		if(isset($_SESSION['login']) && $_SESSION['tipo'] != 'estudante' || !isset($_SESSION['login'])) {
            $this->redirectCheck();
        }

	}

    public function index()
    {       
        $hora_atual = date("H:i:s");
        $data_atual = date("Y-m-d");
        $provas = Prova::selecionar("status <= 1 AND data_prova >= '".$data_atual."'");
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

                    if($value->getStatus() == 1 && Prova::validarDataHora(['inicio' => $value->getHorario_inicio(),'fim' => $value->getHorario_fim(),'data' => $value->getData_prova()]))
                    {
                        $html .= "<a class='btn btn-light' href='?acao=responderProva&modulo=aluno&id=".$value->getId()."' role='button'> Responder</a>";
                    }
                    else
                    {
                        $html .= "<button class='btn btn-light' disabled> Indisponivel</button>";
                    }
                    $html .= "<td/></tr>";
        }
        $this->render("aluno/index",['provas' => $html],[]);

        
}

    public function perfil()
    {
        $usuario = Usuario::selecionarUm($_SESSION['user_id']);
        $estudante = Estudante::selecionar("usuario_id = '".$_SESSION['user_id']."'");

        if(isset($_GET['id']) && !empty($_GET['id']))
        {
            $valid = new Validator($_POST);
            $valid->field_email('email');
            $valid->field_cadastropessoa('cpf');
            $valid->field_filledIn($_POST);
            if($valid->valid)
            {
                $usuario->setLogin($_POST['email']);
                if(!empty($_POST['senha']))
                    $usuario->setSenha(md5($_POST['senha']));
                $usuario->save();
                $estudante[0]->setNome_estudante($_POST['nome']);
                $estudante[0]->setMatricula_estudante($_POST['matricula']);
                $estudante[0]->setCpf_estudante($_POST['cpf']);
                $estudante[0]->setEmail_estudante($_POST['email']);
                $estudante[0]->setSexo_estudante($_POST['sexo']);
                $estudante[0]->save();
                $this->render('aluno/perfil',array(),array('title'=>'Prova Eletronica','msg'=>array(
                    'success',
                    'Cadastro realizado com sucesso.',
                    'Seu cadastro esta aguardando aprovação, em brece você pode utilizar o sistema!'
                    )));
            }else{
                $this->render('aluno/perfil',array(),array('title'=>'Prova Eletronica','msg'=>$valid->getErrors()));
            }
        }
        else
        {
        $this->render("aluno/perfil",['estudante' => $estudante, 'usuario' => $usuario],[]);
        }
    }

    public function minhasProvas()
    {
        $provas = new EstudanteProva();
        $html_provas = $provas->allProvasRespondidasAluno($_SESSION['user_id']);
        /*if($html_provas)
        {
            
        }
        else
        {
            $this->render("aluno/minhasprovas",[],['msg'=> ['info','Falha na busca de dados!', 'Contate o administrador do sistema.']]);
            exit();
        }*/
        $this->render("aluno/minhasprovas",['provas' => $html_provas],[]);
    }

    public function responderProva()
    {
        $id_prova = $_GET['id'];
        $usuario = Usuario::selecionarUm($_SESSION['user_id']);
        $dados = [
                'estudante_id' => $usuario->getEstudante()->getId(),
                'prova_id' => $id_prova,
             ];
        $sessions = new Session($dados);
        $sessions->init();
        $html = "";
        $prova = Prova::selecionarUm($id_prova);
        $questoes = Questao::selecionar("prova_id = '".$id_prova."'");
        $html .= "
        <h1>".$prova->getTitulo()."</h1>";
        foreach ($questoes as $key => $value) {

            $html .= "<div id='questao$key' ".($key != 0 ? "style='display:none;'" : "").">
            <p>
                ".($key+1) ." - ".$value->getEnunciado()."
            </p>";
            $alternativas = Alternativa::selecionar("questao_id = '".$value->getId()."'");
            foreach ($alternativas as $indice => $alter) {
                $html .= "
                <div class='form-check'>
                            <label class='form-check-label'>
                                <input class='form-check-input' type='radio' name='".$value->getId()."' id='exampleRadios1' value='".$alter->getId()."'>
                                ".$alter->getEnunciado_alter()."
                            </label>
                        </div>
                ";
            }
            $html .= "<div class='container'><div class='row'>
                    ";
            $html .= ($key > 0 && $key <= count($questoes) ? "<div class='col align-self-start'><div  onclick='anterior()' class='btn btn-info'>Anterior</div></div>" : "");
            $html .= ($key+1 == count($questoes) ? "<a class='btn btn-success' href='javascript: finalizarprova()'>Envie</a>" : "");
            $html .= ($key+1 != count($questoes) ? "<div class='col align-self-end'><div onclick='proximo()' class='btn btn-info'>Proxima</div></div>" : "");
            $html .= "</div></div></div>";

        }


        
        $this->render("aluno/responder_prova",['questoes' => $html],[],false);
    }
    
    public function finalizarprova()
    {
        var_dump($_POST);
    }
}
