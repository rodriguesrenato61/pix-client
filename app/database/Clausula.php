<?php

	namespace App\Database;

	class Clausula {
					
		private $filtro;
		private $nome;
		private $valor;
		private $tipo;

		public function toArray(){
			return [
				"filtro" => $this->filtro,
				"nome" => $this->nome,
				"valor" => $this->valor,
				"tipo" => $this->tipo
			];
		}
		
		public function setFiltro($filtro){
			$this->filtro = $filtro;
		}
		
		public function getFiltro(){
			return $this->filtro;
		}
		
		public function setNome($nome){
			$this->nome = $nome;
		}
		
		public function getNome(){
			return $this->nome;
		}
		
		public function setValor($valor){
			$this->valor = $valor;
		}
		
		public function getValor(){
			return $this->valor;
		}
		
		public function setTipo($tipo){
			$this->tipo = $tipo;
		}
		
		public function getTipo(){
			return $this->tipo;
		}
		
	}

?>
