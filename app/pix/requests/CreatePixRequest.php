<?php

	namespace App\Pix\Requests;

	class CreatePixRequest {
	
		private $tipoDevedor;
		private $devedorNome;
		private $devedorCpfCnpj;
		private $valor;
		private $solicitacaoPagador;
		private $recebedorId;
		private $infoAdicionais;

		public function toArray(){
			$request = [
				"devedor" => [
					"tipo" => $this->tipoDevedor,
					"nome" => $this->devedorNome,
					"cpfCnpj" => $this->devedorCpfCnpj 
				],
				"valor" => $this->valor,
				"solicitacaoPagador" => $this->solicitacaoPagador,
				"recebedorId" => $this->recebedorId
			];

			if($this->infoAdicionais != null && count($this->infoAdicionais) > 0){
				$infoAdicionais = array();
				foreach($this->infoAdicionais as $info){
					$infoAdicionais[] = [
						"nome" => $info['nome'],
						"valor" => $info['valor']
					];
				}
				$request['infoAdicionais'] = $infoAdicionais;
			}

			return $request;
		}

		public function setTipoDevedor($tipoDevedor){
			$this->tipoDevedor = $tipoDevedor;
		}
		
		public function getTipoDevedor(){
			return $this->tipoDevedor;
		}

		public function setDevedorNome($devedorNome){
			$this->devedorNome = $devedorNome;
		}
		
		public function getDevedorNome(){
			return $this->devedorNome;
		}

		public function setDevedorCpfCnpj($devedorCpfCnpj){
			$this->devedorCpfCnpj = $devedorCpfCnpj;
		}
		
		public function getDevedorCpfCnpj(){
			return $this->devedorCpfCnpj;
		}

		public function setValor($valor){
			$this->valor = $valor;
		}
		
		public function getValor(){
			return $this->valor;
		}

		public function setSolicitacaoPagador($solicitacaoPagador){
			$this->solicitacaoPagador = $solicitacaoPagador;
		}
		
		public function getSolicitacaoPagador(){
			return $this->solicitacaoPagador;
		}
		
		public function setRecebedorId($recebedorId){
			$this->recebedorId = $recebedorId;
		}

		public function getRecebedorId(){
			return $this->recebedorId;
		}

		public function setInfoAdicionais($infoAdicionais){
			$this->infoAdicionais = $infoAdicionais;
		}
		
		public function getInfoAdicionais(){
			return $this->infoAdicionais;
		}
		
	}

?>
