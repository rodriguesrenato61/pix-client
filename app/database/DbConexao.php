<?php

	namespace App\Database;

	use App\Utils\Config;

	class DbConexao {
		
		private static $pdo;
		
		public function getPdo(){
			try{
				if(!self::$pdo){
					$host = Config::getDbHost();
					$dbname = Config::getDbName();
					$user = Config::getDbUser();
					$password = Config::getDbPassword();
					
					self::$pdo = new \PDO("mysql:host={$host};dbname={$dbname}", $user, $password);
				}
				return self::$pdo;
			}catch(\PDOException $e){
				echo($e->getMessage());
			}
		}
		
		public function select($tbl, $query, $wheres, $page, $limit, $orderBy){
	
			$retorno = null;
			$paginate = false;
			$atual = 0;
			
			foreach($wheres as $k => $where){
				if($k == 0){
					$query .= " WHERE ";
				}else{
					$query .= " AND ";
				}
				$query .= "{$where['filtro']}";
			}
				
			if($orderBy){
				$query .= " ORDER BY";
				foreach($orderBy as $k => $order){
					if($k > 0){
						$query .= " ,";
					}
					$query .= " {$order}";
				}
			}
			
			if($page){
				$paginate = true;
				$atual = ($page - 1) * $limit;
				$query .= " LIMIT :atual, :limite";
			}
				
			$sql = $this->getPdo()->prepare($query);
			$w = array();
			foreach($wheres as $where){
				$w[] = [
					"nome" => $where['nome'],
					"valor" => $where['valor'],
					"tipo" => $where['tipo']
				];
				$sql->bindParam($where['nome'], $where['valor'], $where['tipo']);
			}
				
			if($paginate){
				$sql->bindParam(":atual", $atual, \PDO::PARAM_INT);
				$sql->bindParam(":limite", $limit, \PDO::PARAM_INT);
			}
			
			$sql->execute();
			
			$dados = [
				"query" => $query,
				"wheres" => $w,
				"registros" => $sql
			];
			
			if($paginate){
				$count = $this->selectCount($tbl, $wheres);
				$dados['paginate'] = [
					"atual" => $page,
					"limite" => $limit,
					"total" => $count
				];	
				
			}
			
			return $dados;
		}
		
		public function selectCount($tbl, $wheres){
			
			$retorno = null;
			$query = "SELECT COUNT(*) FROM {$tbl}";
			
			foreach($wheres as $k => $where){
				if($k == 0){
					$query .= " WHERE ";
				}else{
					$query .= " AND ";
				}
				$query .= "{$where['filtro']}";
			}
				
			$sql = $this->getPdo()->prepare($query);
			foreach($wheres as $where){
				$sql->bindParam($where['nome'], $where['valor'], $where['tipo']);
			}
			$sql->execute();
				
			if($sql->rowCount() > 0){
				$row = $sql->fetch();
				$retorno = intval($row[0]);
			}else{
				throw new \Exception("Erro ao pegar o número de registros da tabela {$tbl}!");
			}
			
			return $retorno;
		}
		
	}

?>
