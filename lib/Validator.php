<?php
	
	/**
	* @name: Validator
	* @description: Módulo responsável por realizar processo de validação inteligente
	* @author: Bruno C. Santos
	* @version: 1.0
	*/

	/**
	 * Include do módulo auxiliar
	 */
	include("extends/CPFCNPJ.php");

	class Validator extends CPFCNPJ {

		/**
		 * Atributos
		 * @var null
		 */
		public $valid = false;
		public $validCheckPoint = array();
		public $duplicate = false;
		public $errors = array();
		public $request = array();
		
		/**
		 * Mensagens de erro
		 * TAGS PERMITIDAS:
		 * - %%campo%% = Atribui o nome do campo inválido
		 * @var array
		 */
		public $errors_msg=array(
			100=>'O campo <strong>%%campo%%</strong> é obrigatório e não foi preenchido.',
			101=>'O campo <strong>%%campo%%</strong> não é um cpf/cnpj válido.',
			102=>'O campo <strong>%%campo%%</strong> não é um username válido.',
			103=>'O campo <strong>%%campo%%</strong> não é um valor númerico.',
			104=>'A condição para o campo <strong>%%campo%%</strong> não foi atendida.',
			105=>'O campo <strong>%%campo%%</strong> não é um e-mail válido.'
		);

		/**
		 * Método construtor
		 * @param array $requestArray Array com os dados a serem validados
		 */
		public function __construct(array $requestArray){
			$this->request = $requestArray;
			try{
				if(empty($this->request))
					throw new Exception('<h2>Oops, o REQUEST est&aacute; vazio!</h2>');
			}catch(Exception $e){
				echo '<h3>Validator - Erro #1: </h3>', $e->getMessage();
				die();
			}	
		}
		
		/**
		 * Método responsável por validar se os campos determinados estão preenchidos
		 * @param  array/string  $field Campo(s) a ser(em) validado(s)
		 * @return boolean     			Status da validação
		 */
		public function field_filledIn($field = null){
			if($field == null)
				$field=$this->request;
			if(is_array($field)){
				$i=0;
				foreach ($field as $key => $value){
					if(!array_key_exists($key, $this->request) || empty($this->request[$key])){
						$this->setError($key, 100);
						$i++;
					}
				}
				return (($i == 0) ? $this->resetValid(true) : $this->resetValid(false));
			}else{
				if(!array_key_exists($field, $this->request) || empty($this->request[$field])){
					$this->setError($field, 100);
					return $this->resetValid(false);
				}
				return $this->resetValid(true);
			}
		}

		/**
		 * Método responsável por realizar a validação final do campo de Cadastro de Pessoa Física ou Jurídica
		 * @param  string  $field  Campo a ser validado
		 * @return boolean     	   Status da validação
		 */
		public function field_cadastropessoa($field){
			$value = preg_replace('/[^0-9]/', '', $this->request[$field]);
			$value = (string)$value;
			if($this->verifica_cpf_cnpj($value) === 'CPF'){
				if($this->valida_cpf($value))
					return $this->resetValid(true);
			}elseif($this->verifica_cpf_cnpj($value) === 'CNPJ'){
				if($this->valida_cnpj($value))
					return $this->resetValid(true);
			}
			$this->setError($field, 101);
			return $this->resetValid(false);
		}

		/**
		 * Método responsável por validar nomes de usuário
		 * @param  string  $field Campo a ser validado
		 * @return boolean     	  Status da validação
		 */
		public function field_username($field){
			if(!preg_match('/^[a-zA-Z0-9]{3,}$/', trim($this->request[$field]))){
				$this->setError($field,102);
				return $this->resetValid(false);
			}
			return $this->resetValid(true);
		}

		/**
		 * Método responsável por validar se o valor do campo é numérico
		 * @param  string  $field Campo a ser validado
		 * @return boolean     	  Status da validação
		 */
		public function field_numeric($field){
			if(!is_numeric(trim($this->request[$field]))){
				$this->setError($field,103);
				return $this->resetValid(false);
			}
			return $this->resetValid(true);
		}

		/**
		 * Método responsável por validar limites de um determinado valor
		 * @param  string  $field 	 Campo a ser validado
		 * @param  string  $operator Operador de verificação
		 * @param  integer $length 	 Valor de base
		 * @return boolean     	  	 Status da validação
		 */
		public function field_length($field, $operator, $length){
			$count=strlen(trim($this->request[$field]));
			switch($operator){
				case "<":
					if($count < $length)
						return $this->resetValid(true);
					break;
				case ">":
					if($count > $length)
						return $this->resetValid(true);
					break;
				case "=":			
					if($count == $length)
						return $this->resetValid(true);
					break;
				case "<=":
					if($count <= $length)
						return $this->resetValid(true);
					break;
				case ">=":
					if($count >= $length)
						return $this->resetValid(true);
					break;
				default:
					if($count < $length)
						return $this->resetValid(true);
			}
			$this->setError($field, 104);
			return $this->resetValid(false);
		}
		
		/**
		 * Método responsável por validar se o valor de determinado campo trata-se de um e-mail
		 * @param  string  $field Campo a ser validado
		 * @return boolean     	  Status da validação
		 */
		public function field_email($field){
			$email = trim($this->request[$field]);
			if(filter_var($email, FILTER_VALIDATE_EMAIL))
				return $this->resetValid(true);
			$this->setError($field, 105);
			return $this->resetValid(false);
		}
		
		/**
		 * Método responsável por armazenar os erros
		 * @param  string $field  Nome do campo
		 * @param  integer $error Código do erro
		 * @return boolean   	  Status do processo
		 */
		private function setError($field, $error){
			if(!array_key_exists($field, $this->errors) || $this->errors[$field] !== $error){
				$tmpArray = array($field => $error);
				$this->errors = array_merge_recursive($this->errors, $tmpArray);	
				return $this->resetValid(true);		
			}
		}

		/**
		 * Método responsável por atribuir mensagens textuais aos códigos de erros
		 * @return array Array com os erros
		 */
		private function defineTextFromErrors(){
			$errors=$this->errors;
			$message=$errors;
			if(is_array($errors) && count($errors) > 0){
				$message=array();
				foreach($errors as $key => $value){
					$msg=DataHelper::converter($this->errors_msg[$value],array(
						'%%campo%%'=>$key
					));
					$message[$key]=$msg;
				}
			}
			return $message;
		}

		/**
		 * Método responsável por padronizar as mensagens de erro para o AlertHelper
		 * @return array Array com os erros modelados para o AlertHelper
		 */
		private function renderErrors(){
			$messages=$this->defineTextFromErrors();
			$message=array();
			$html='';
			if(is_array($messages) && count($messages) > 0){
				$message=array("danger","Por favor, verifique os erros abaixo:");
				foreach($messages as $key => $value)
					$html.=$value.'<br />';
				$message[2]=$html;
			}
			return $message;
		}

		/**
		 * Método responsável por retornar os erros
		 * @return array Array com os erros modelados para o AlertHelper
		 */
		public function getErrors(){
			return $this->renderErrors();
		}

		/**
		 * Método responsável por resetar o atributo valid
		 * @param  boolean $status Status temporário
		 * @return boolean         Status definitivo do processo de validação
		 */
		private function resetValid($status){
			array_push($this->validCheckPoint,$status);
			$i=0;
			foreach($this->validCheckPoint as $check)
				if($check == false)
					$i++;
			$this->valid = (($i == 0) ? true : false);
		}
	}
