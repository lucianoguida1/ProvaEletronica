<?php


class Estudante extends Usuario
{
	static $tabela = 'estudantes';
	static $classe = 'Estudante';
	static $chave_primaria = 'id';

	protected $id,
			  $nome_estudante,
			  $matricula_estudante,
			  $cpf_estudante,
			  $email_estudante,
			  $sexo_estudante,
			  $usuario_id;

	public function getTabela()
	{
		return static::$tabela;
	}		  

	public function getCampos()
	{
		return array(
				'id'					=> array('rotulo' => 'id'),
				'nome_estudante'		=> array('rotulo' => 'nome_estudante'),
				'matricula_estudante'	=> array('rotulo' => 'matricula_estudante'),
				'cpf_estudante'			=> array('rotulo' => 'cpf_estudante'),
				'email_estudante'		=> array('rotulo' => 'email_estudante'),
				'sexo_estudante'		=> array('rotulo' => 'sexo_estudante'),
				'usuario_id'			=> array('rotulo' => 'usuario_id')				
			);
	}

	public function getCamposObrigatorios()
	{
		return array('nome_estudante', 'matricula_estudante', 'cpf_estudante', 'email_estudante', 'sexo_estudante', 'usuario_id');
	}

	public static function getEstProva(
            $condicao = null,
            $ordem = null,
            $limite = null,
            $deslocamento = null) {

            if(!is_null($limite)) {
                if (!is_null($deslocamento)) {
                    $limite = "$deslocamento , $limite";
                }
            }
            $pdo = Banco::instanciar();
            $selectSQL = "SELECT 
                estudantes.nome_estudante,
                estudantes.matricula_estudante,
                estudantes.cpf_estudante,
                estudantes.email_estudante,
                estudantes.sexo_estudante,
                estudantes.usuario_id,
                sum(questoes.valor) as nota  
                FROM " . static::$tabela
                ." INNER JOIN prova_eletronica.resultados ON resultados.estudante_id=estudantes.id
                   INNER JOIN prova_eletronica.questoes ON questoes.id = resultados.questoes_id "
                . (!is_null($condicao) ? " WHERE $condicao" : '') . " and resultados.resposta!=questoes.resposta "
                . "  group by estudantes.nome_estudante, estudantes.matricula_estudante, estudantes.cpf_estudante, estudantes.email_estudante, estudantes.sexo_estudante, estudantes.usuario_id "
                . (!is_null($ordem) ? " ORDER BY $ordem" : '')
                . (!is_null($limite) ? " LIMIT $limite" : '');

            $statement = $pdo->prepare($selectSQL);
            $statement->execute();
            $results = $statement->fetchAll();
            $objects = array();
            $classe = static::$classe;

            foreach ($results as $row) {
                $objects[] = new $classe($row);
            }

            return $objects;
    }
}