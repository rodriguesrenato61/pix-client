<?php

	namespace App\Forms;

	class CreatePixForm {
	
		private $tipoDevedor;
		private $nomeDevedor;
		private $cpfCnpj;
		private $valor;
		private $solicitacao;
		private $recebedor;
		private $infoAdicionais;
		private $erros;
        private $params;

        public function parse($params){
			$this->params = $params;
			$this->tipoDevedor = $params['tipoDevedor'];
			$this->nomeDevedor = $params['nomeDevedor'];
			$this->cpfCnpj = $params['cpfCnpj'];
			$this->valor = $params['valor'];
			$this->solicitacao = $params['solicitacao'];
			$this->recebedor = $params['recebedor'];;
			$this->infoAdicionais = array();
			if(isset($params['infoAdicionais']) && count($params['infoAdicionais']) > 0){
				foreach($params['infoAdicionais'] as $info){
					$this->infoAdicionais[] = $nfo;
				}
			}
		
		}
		
		public function isValido(){
			
			$this->erros = array();
			if($this->tipoDevedor == ""){
				$this->erros[] = "Tipo devedor vazio!";
			}
			
			if($this->nomeDevedor == ""){
				$this->erros[] = "Nome devedor vazio!";
			}
			
			if($this->cpfCnpj == ""){
				$this->erros[] = "Devedor cpfCnpj vazio!";
			}
			
			if($this->valor == ""){
				$this->erros[] = "Valor vazio!";
			}
			
			if($this->solicitacao == ""){
				$this->erros[] = "Solicitação pagador vazio!";
			}
			
			if($this->recebedor == ""){
				$this->erros[] = "Recebedor vazio!";
			}
			
			if(count($this->erros) > 0){
				return false;
			}
			
			return true;
		}

        public function toArray(){
            return $this->params;
		}
		
		public function getErros(){
			return $this->erros;
		}
		
		public function getTipoDevedor(){
			return $this->tipoDevedor;
		}
		
		public function getNomeDevedor(){
			return $this->nomeDevedor;
		}
		
		public function getCpfCnpj(){
			return $this->cpfCnpj;
		}
		
		public function getValor(){
			return $this->valor;
		}
		
		public function getSolicitacao(){
			return $this->solicitacao;
		}
		
		public function getRecebedor(){
			return $this->recebedor;
		}
		
		public function getInfoAdicionais(){
			return $this->infoAdicionais;
		}
		
	}

?>
