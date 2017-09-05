<?php

class AlunoController extends Controller
{

	function __construct()
	{
		if(isset($_SESSION['login']) && $_SESSION['tipo'] != 'estudante') {
            $this->redirectCheck();
        }

	}

    public function index()
    {       
        $provas = new Prova;
        $this->render("aluno/index",['provas' => $provas->allProvasAluno()],[]);
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
        $this->render("aluno/responder_prova",[],[],false);
    }

    
}
