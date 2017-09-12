<?php


class Resultado extends Model 
{
	static $tabela = 'resultados';
	static $classe = 'Resultado';
	static $chave_primaria = 'id';

	protected $id,
			  $resposta,
			  $estudante_id,
			  $prova_id,
			  $questoes_id;

	public function getTabela()
	{
		return static::$tabela;
	}		  

	public function getCampos()
	{
		return array(
				'id'            => array('rotulo' => 'id'),
				'resposta'  	=> array('rotulo' => 'resposta'),
				'estudante_id'	=> array('rotulo' => 'estudante_id'),
				'prova_id'		=> array('rotulo' => 'prova_id'),
				'questoes_id'	=> array('rotulo' => 'questoes_id')
			);
	}

	public function getCamposObrigatorios()
	{
		return array();
	}


    public static function getEstZero(
        $condicao = null,
        $qtdQuestoes = null) {


        $pdo = Banco::instanciar();
        $selectSQL = "SELECT 
                estudantes.nome_estudante as nome_estudante,
                estudantes.matricula_estudante as matricula_estudante,
                (0) as nota,
                count(prova_eletronica.resultados.resposta) as erros
                FROM " . static::$tabela
            ." inner join prova_eletronica.questoes on questoes.id=resultados.questoes_id "
            ." inner join prova_eletronica.estudantes on estudantes.id=resultados.estudante_id "
            . (!is_null($condicao) ? " WHERE $condicao" : '') . " and resultados.resposta!=questoes.resposta "
            . "  group by nome_estudante, matricula_estudante "
            . (!is_null($qtdQuestoes) ? " HAVING erros = $qtdQuestoes" : '');

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