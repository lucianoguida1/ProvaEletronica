<?php

class IndexController extends Controller
{
    
    public function index(){       
        $this->render('index',array(),array('title'=>'Prova Eletronica'));
    }
    
    public function cadastro(){
        $this->render('usuario/cadastro',array(),array('title'=>'Prova Eletronica'));
    }
    public function cadastrar(){
        $valid = new Validator($_POST);
        $valid->field_email('email');
        $valid->field_cadastropessoa('cpf');
        $valid->field_filledIn($_POST);
        if($valid->valid){
            $usuario['login'] = $_POST['email'];
            $usuario['senha'] = md5($_POST['senha']);
            $usuario['tipo']  = $_POST['tipo'];
            $usuario['status']= 0;
            if($_POST['tipo'] == 'professor'){
                $user = New Usuario($usuario);
                $user->save();
                $prof = New Professor(array(
                    'nome_prof'     => $_POST['nome'],
                    'matricula_prof'=> $_POST['matricula'],
                    'cpf_prof'      => $_POST['cpf'],
                    'email_prof'    => $_POST['email'],
                    'sexo_prof'     => $_POST['sexo'],
                    'usuario_id'    => $user->getId()
                ));
                $prof->save();
            }elseif($_POST['tipo'] == 'estudante'){
                $user = New Usuario($usuario);
                $user->save();
                $estd = New Estudante(array(
                    'nome_estudante'     => $_POST['nome'],
                    'matricula_estudante'=> $_POST['matricula'],
                    'cpf_estudante'      => $_POST['cpf'],
                    'email_estudante'    => $_POST['email'],
                    'sexo_estudante'     => $_POST['sexo'],
                    'usuario_id'    => $user->getId()
                ));
                $estd->save();
            }
            $this->render('usuario/cadastro',array(),array('title'=>'Prova Eletronica','msg'=>array(
                'success',
                'Cadastro realizado com sucesso.',
                'Seu cadastro esta aguardando aprovação, em brece você pode utilizar o sistema!'
                )));
        }else{
            $this->render('usuario/cadastro',array(),array('title'=>'Prova Eletronica','msg'=>$valid->getErrors()));
        }
    }
}
