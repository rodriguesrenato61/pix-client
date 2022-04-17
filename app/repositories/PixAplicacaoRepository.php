<?php
    
    namespace App\Repositories;

	class PixAplicacaoRepository {
	
		private $db;
		private $pdo;
		private $tbl;
        private $id;
		
		public function __construct($dbConexao){
			$this->tbl = "pix_aplicacao";
			$this->db = $dbConexao;
			$this->pdo = $this->db->getPdo();
            $this->id = 1;
		}

        public function getCredenciais(){
            $aplicacao = null;
            $sql = $this->pdo->prepare("SELECT * FROM {$this->tbl} WHERE id = :id LIMIT 1");
            $sql->bindParam(":id", $this->id, \PDO::PARAM_INT);
            $sql->execute();
            if($sql->rowCount() > 0){
                $registro = $sql->fetch();
                $aplicacao = [
                    "id" => $registro['id'],
                    "nome" => $registro['nome'],
                    "appCod" => $registro['app_cod'],
                    "appKey" => $registro['app_key'],
                    "accessToken" => $registro['access_token'],
                    "accessTokenExpiracao" => $registro['access_token_expiracao']
                ];
            }

            return $aplicacao;
        }

        public function updateAccessToken($accessToken, $expiracao){
            $sql = $this->pdo->prepare("UPDATE pix_aplicacao SET access_token = :access_token, access_token_expiracao = :access_token_expiracao WHERE id = :id");
            $sql->bindParam(":access_token", $accessToken, \PDO::PARAM_STR);
            $sql->bindParam(":access_token_expiracao", $expiracao, \PDO::PARAM_STR);
            $sql->bindParam(":id", $this->id, \PDO::PARAM_INT);
            $sql->execute();
        }
		
    }

?>