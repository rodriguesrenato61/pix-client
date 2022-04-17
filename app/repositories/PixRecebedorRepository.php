<?php
    
    namespace App\Repositories;

	class PixRecebedorRepository {
	
		private $db;
		private $pdo;
		private $tbl;
		
		public function __construct($dbConexao){
			$this->tbl = "pix_recebedores";
			$this->db = $dbConexao;
			$this->pdo = $this->db->getPdo();
		}

        public function findById($id){
            $recebedor = null;
            $sql = $this->pdo->prepare("SELECT * FROM {$this->tbl} WHERE id = :id LIMIT 1");
            $sql->bindParam(":id", $id, \PDO::PARAM_INT);
            $sql->execute();
            if($sql->rowCount() > 0){
                $registro = $sql->fetch();
                $recebedor = [
                    "id" => $registro['id'],
                    "nome" => $registro['nome']
                ];
            }

            return $recebedor;
        }

        public function findAll(){
            $rows = array();
            $sql = $this->pdo->prepare("SELECT * FROM {$this->tbl}");
            $sql->execute();
            if($sql->rowCount() > 0){
                while($registro = $sql->fetch()){
                    $rows[] = [
                        "id" => $registro['id'],
                        "nome" => $registro['nome']
                    ];
                }
            }

            return $rows;
        }

    }

?>