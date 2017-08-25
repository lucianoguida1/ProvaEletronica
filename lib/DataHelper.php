<?php
	class DataHelper{

		/**
		 * Método responsável por realizar o tratamento de strings
		 * @param  string  $string String que será tratada
		 * @param  string  $filter Tipo de filtro que será aplicado
		 * @param  boolean $html   Define se a string retornada terá ou não tags HTML
		 * @return string  $string String tratada
		 */
		public static function tratar($string,$filter="",$html=false){
			if(!empty($filter)){
				switch ($filter) {
					case 'uw':
						$string=ucwords($string);
						break;
					case 'sl':
						$string=strtolower($string);
						break;
					case 'su':
						$string=strtoupper($string);
						break;
					case 'nl' :
						$string=nl2br($string);
						break;
					case 'slug' :
						$string=strtolower( preg_replace("[^a-zA-Z0-9-]", "-", strtr(utf8_decode(trim($string)), utf8_decode("áàãâéêíóôõúüñçÁÀÃÂÉÊÍÓÔÕÚÜÑÇ "),"aaaaeeiooouuncAAAAEEIOOOUUNC-")) );
						$string=str_replace(" ", "-", $string);
						$string=str_replace("&nbsp;", "-", $string);
						break;
					case 'sanitize':
						$string = preg_replace('/[áàãâä]/ui', 'a', $string);
					    $string = preg_replace('/[éèêë]/ui', 'e', $string);
					    $string = preg_replace('/[íìîï]/ui', 'i', $string);
					    $string = preg_replace('/[óòõôö]/ui', 'o', $string);
					    $string = preg_replace('/[úùûü]/ui', 'u', $string);
					    $string = preg_replace('/[ç]/ui', 'c', $string);
					    // $string = preg_replace('/[,(),;:|!"#$%&/=?~^><ªº-]/', '_', $string);
					    $string = preg_replace('/[^a-z0-9]/i', '', $string);
					    $string = preg_replace('/_+/', '', $string); // ideia do Bacco :)
						break;
				}
			}
			$string=addslashes(trim($string));
			return ($html) ? $string : str_replace("\\","",strip_tags($string));
		}

		/**
		 * Método responsável por realizar o tratamento das super globais
		 * @param  array $request 		  Array nativo com campos e valores passados
		 * @param  const $data    		  Constante que será tratada
		 * @param  array $custom_filters  Filtros customizados para determinados campos
		 * @return array                  Constate tratada
		 */
		public static function tratamento(array $request,$data,array $custom_filters=array()){
			$filters=array();
			foreach ($request as $key => $value) {
				if(!array_key_exists($key, $custom_filters))
					$filters[$key]=constant('FILTER_SANITIZE_STRING');
			}
			if(is_array($custom_filters) && is_array($custom_filters))
				$filters=array_merge($filters,$custom_filters);
			return filter_input_array($data, $filters);
		}

		/**
		 * Método responsável por atribuir variáveis a tags de marcação customizadas
		 * @param  string $message Mensagem que terá as tags que serão convertidas
		 * @param  array  $params  Array com tag e seu respectivo valor
		 * @return string          Mensagem processada
		 */
		public static function converter($message,array $params){
			if(!is_array($params) || empty($params))
				return $message;
			$search=array_keys($params);
			$replace=array_values($params);
			return str_replace($search, $replace, $message);
		}
	}