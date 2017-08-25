<?php 

	/**
	 * @name: CPFCNPJ
	 * @description: Classe auxiliar para validação de CPF/CPNJ
	 * @author: Bruno C. Santos
	 * @version: 1.0
	 */
	class CPFCNPJ{

		/**
		 * Método responsável por determinar se o valor do campo validado é CPF ou CNPJ
		 * @param  integer $value CPF/CPNJ
		 * @return string         Tipo de informação
		 */
		public function verifica_cpf_cnpj($value){
			if(strlen($value)===11){
				return 'CPF';
			}elseif(strlen($value) === 14){
				return 'CNPJ';
			}else{
				return false;
			}
		}

		/**
		 * Método responsável por multiplicar os dígitos pelas posições
		 * @param  string  $digitos      Dígitos
		 * @param  integer $posicoes     Posições
		 * @param  integer $soma_digitos Soma dos digitos
		 * @return string                Dígitos atualizados
		 */
		public function calc_digitos_posicoes($digitos, $posicoes = 10, $soma_digitos = 0) {
			// Faz a soma dos dígitos com a posição
			for ($i = 0; $i < strlen($digitos); $i++){
				// Preenche a soma com o dígito vezes a posição
				$soma_digitos = $soma_digitos + ($digitos[$i] * $posicoes);
				$posicoes--;
				// Parte específica para CNPJ
				if($posicoes < 2) 
					$posicoes = 9;
			}
			// Captura o resto da divisão entre $soma_digitos dividido por 11
			$soma_digitos = $soma_digitos % 11;

			if($soma_digitos < 2){
				$soma_digitos = 0;
			}else{
				$soma_digitos = 11 - $soma_digitos;
			}

			// Concatena mais um dígito aos primeiro nove dígitos
			$digitos_atualizados = $digitos . $soma_digitos;

			return $digitos_atualizados;
		}
	 
		/**
		 * Método responsável por validar se o campo é um CPF válido
		 * @param  string  $value CPF
		 * @return boolean        Status do processo
		 */
		public function valida_cpf($value) {
			$digitos = substr($value, 0, 9);
			$novo_cpf = $this->calc_digitos_posicoes($digitos);
			$novo_cpf = $this->calc_digitos_posicoes($novo_cpf, 11); 
			// Verifica se o novo CPF gerado é idêntico ao CPF enviado
			return (($novo_cpf === $value) ? true : false);
		}
	 
		/**
		 * Método responsável por validar se o campo é um CNPJ válido
		 * @param  string  $value CPNJ
		 * @return boolean        Status do processo
		 */
		public function valida_cnpj ($value) {
			$primeiros_numeros_cnpj = substr($value, 0, 12);
			$primeiro_calculo = $this->calc_digitos_posicoes($primeiros_numeros_cnpj, 5);
			$segundo_calculo = $this->calc_digitos_posicoes($primeiro_calculo, 6);
			$cnpj = $segundo_calculo;
	 		return (($cpnj===$value) ? true : false);
		}
	}

?>