<?php
abstract class Model {

    protected $campos_alterados = array();

    abstract public function getTabela();
    abstract public function getCampos();
    abstract public function getCamposObrigatorios();

    public function __construct(array $data = null) {
        if (!is_null($data)) {
            $this->setData($data);
        }
    }

    public function getCampo($campo) {
        $campos = $this->getCampos();
        return isset($campos[$campo]) ? $campos[$campo] : null;
    }

    public function setData($data) {
        $atrObrigatorios = $this->getCamposObrigatorios();
        foreach ($atrObrigatorios as $key) {
            if (!array_key_exists($key, $data)) {
                throw new Exception("Atributo $key é obrigatório");
            }
        }
        foreach ($data as $key => $value) {
            $method = 'set' . ucfirst($key);
            $this->$method($value);
        }
    }

    public function getChavePrimaria() {
        $metodo = 'get' . ucfirst(static::$chave_primaria);
        return $this->$metodo();
    }

    public function setChavePrimaria($id) {
        $metodo = 'set' . ucfirst(static::$chave_primaria);
        $this->$metodo($id);
    }

    protected function _set($campo, $valor) {
        $this->$campo = $valor;
        if (!is_null($this->getChavePrimaria())
            && !in_array($campo, $this->campos_alterados)
            && $campo != static::$chave_primaria) {
            $this->campos_alterados[] = $campo;
        }
    }

    public function __call($metodo, $argumentos) {
        $prefixo = substr($metodo, 0, 3);
        $campo = strtolower(substr($metodo, 3));

        if ($prefixo == 'set') {
            $this->_set($campo, $argumentos[0]);
        } elseif ($prefixo == 'get'){
           return $this->$campo;
        } else {
            throw new Exception('M�todo n�o existe!');
        }
    }

    public function save() {
        if (isset($this->id)) {
            $this->update();
        } else {
            $this->insert();
        }
        return true;
    }

    protected function update() {
        $pdo = Banco::instanciar();
        $campos = array_values($this->campos_alterados);
        $camposUpdate = array();
        foreach ($campos as $campo) {
            $camposUpdate[] = "$campo = ?";
        }
        $camposUpdate = implode(',', $camposUpdate);
        $updateSQL = "UPDATE {$this->getTabela()} "
                   . "SET $camposUpdate WHERE " . static::$chave_primaria .  " = ? ";

        $dados = array();
        foreach ($campos as $campo) {
            $metodo = 'get' . ucfirst($campo);
            $dados[] = $this->$metodo();
        }

        $dados[] = $this->getChavePrimaria();
        $statement = $pdo->prepare($updateSQL);

        $statement->execute($dados);

    }

    protected function insert() {
        $pdo = Banco::instanciar();
        $campos = implode(',', array_keys($this->getCampos()));
        $values = implode(',', array_fill(0, count($this->getCampos()), '?'));
        $insertSQL = "INSERT INTO {$this->getTabela()} "
                   . "( {$campos} ) VALUES ( $values )";

        $dados = array();
        foreach (array_keys($this->getCampos()) as $campo) {
            $metodo = 'get' . ucfirst($campo);
            $dados[] = $this->$metodo();
        }

        $statement = $pdo->prepare($insertSQL);
        $statement->execute($dados);
        $this->setChavePrimaria($pdo->lastInsertId());
    }

    public static function selecionarUm($id) {
        $pdo = Banco::instanciar();
        $selectSQL = "SELECT * FROM " . static::$tabela
                  . " WHERE " . static::$chave_primaria .  " = ? ";
        $statement = $pdo->prepare($selectSQL);
        $dados = array($id);
        $statement->execute($dados);
        $data = $statement->fetch();

        if ($data){
            $classe = static::$classe;
            return new $classe($data);
        } else {
            return NULL;
        }

    }

    public function deletar() {
        if (is_null($this->getChavePrimaria())) {
            throw new Exception('Impossível excluir objeto não persistido!');
        }
        $pdo = Banco::instanciar();
        $deleteSQL = "DELETE FROM {$this->getTabela()} "
                  . "WHERE " . static::$chave_primaria . " = ? ";

        $statement = $pdo->prepare($deleteSQL);
        $dados = array($this->getChavePrimaria());
        if ($statement->execute($dados)) {
            $this->setChavePrimaria(null);
            return true;
        } else {
            return false;
        }
    }

    public static function selecionar(
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
        $selectSQL = "SELECT * FROM " . static::$tabela
                     . (!is_null($condicao) ? " WHERE $condicao" : '')
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