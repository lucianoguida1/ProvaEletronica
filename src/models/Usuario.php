<?php


class Usuario extends Model 
{
	static $tabela = 'usuarios';
	static $classe = 'Usuario';
	static $chave_primaria = 'id';

	protected $id,
			  $login,
			  $senha,
			  $tipo,
			  $status;

    public function getTabela()
    {
    	return static::$tabela;
    }

    public function getCampos()
    {
    	return array(
    			'id'		=> array('rotulo' => 'id'),
    			'login'		=> array('rotulo' => 'login'),
    			'senha'		=> array('rotulo' => 'senha'),
    			'tipo'		=> array('rotulo' => 'tipo'),
    			'status'	=> array('rotulo' => 'status')	
    		);
    }

    public function getCamposObrigatorios(){
    	return array('login', 'senha', 'tipo', 'status');
    }

    public static function logar($dados)
    {
        $callBack_logar = [];
        $callBack_logar['alert'] = [];
        $callBack_logar['status'] = false;
        $callBack_logar['user'] = [];
        if(!empty($dados['email'])){
            if(!empty($dados['senha'])){
                $login = Usuario::selecionar("login='".$dados['email']."'");
                if(isset($login[0]) && null != ($login[0]) || !empty($login[0]))
                {
                    $password = md5($dados['senha']);
                    if($login[0]->getSenha() == $password)
                    {
                        if($login[0]->getStatus() == 1)
                        {
                                    $callBack_logar['status'] = true;
                                    $callBack_logar['user'] = ['tipo' => $login[0]->getTipo(), "id_user"=>$login[0]->getId(),"user_name" => $dados['email']];
                        }
                        else
                        {
                            $callBack_logar['alert'][2] = '<strong>Usuário</strong> bloqueado, aguardando aprovação do cadastro!';

                        }
                    }
                    else
                    {
                        $callBack_logar['alert'][2] = "<strong>Senha</strong> digitada incorreta!";
                    }
                }
                else
                {
                    $callBack_logar['alert'][2] = 'Este <strong>Usuário</strong> não existe!';

                }
            }
            else
            {
                $callBack_logar['alert'][2] = "O campo <strong>senha</strong> está vazio.";
            }
        }
        else
        {
            $callBack_logar['alert'][2] = "O campo <strong>e-mail</strong> está vazio.";
        }
        $callBack_logar['alert'][0] = 'danger';
        $callBack_logar['alert'][1] = 'Verifique os erros de validacao!';
        return $callBack_logar;
    }
}