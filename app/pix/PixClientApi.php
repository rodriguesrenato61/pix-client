<?php

    namespace App\Pix;

    use App\Repositories\PixAplicacaoRepository;

    class PixClientApi {

        private $pixAplicacaoRepository;

        private $baseUrl;
        private $appNome;
        private $appCod;
        private $appKey;
        private $accessToken;
        private $accessTokenExpiracao;

        public function __construct($db){
            $this->baseUrl = "https://localhost/projetos/payment-service/api/pix.php?op=";
            $this->pixAplicacaoRepository = new PixAplicacaoRepository($db);
        } 

        public function setAppNome($appNome){
            $this->appNome = $appNome;
        }

        public function setAppCod($appCod){
            $this->appCod = $appCod;
        }

        public function setAppKey($appKey){
            $this->appKey = $appKey;
        }

        public function setAccessToken($accessToken){
            $this->accessToken = $accessToken;
        }

        public function setAccessTokenExpiracao($accessTokenExpiracao){
            $this->accessTokenExpiracao = $accessTokenExpiracao;
        }

        private function geraAccessToken(){
		
			try {
				
				if($this->accessToken != null && $this->accessToken != ""){
					$agora = time();
					$expiracao = strtotime(date($this->accessTokenExpiracao));
					$tolerancia = 5;
					$diff = $expiracao - $agora;
					if($diff > $tolerancia){
                        $retorno = [
                            "success" => true,
                            "msg" => "AccessToken válido!"
                        ];
					}else{
						$retorno = $this->createAccessToken();
					}
				}else{
					$retorno = $this->createAccessToken();
				}
				
			} catch(\Exception $e){
                $retorno = [
                    "success" => false,
                    "msg" => "Erro, não foi possível gerar accessToken!",
                    "erro" => $e->getMessage()
                ];
			}
			
			return $retorno;
		}

		private function createAccessToken(){
			
			try {
				
				$endpoint = "{$this->baseUrl}auth";
               
                $request = [
                    "nome" => $this->appNome,
                    "codigo" => $this->appCod,
                    "key" => $this->appKey
                ];

				$headers = [
					"Content-Type: application/json"
				];
				
				//configuração do curl
                $curl = curl_init();
                curl_setopt_array($curl, [
                    CURLOPT_URL => $endpoint,
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_SSL_VERIFYHOST => 0,
                    CURLOPT_SSL_VERIFYPEER => 0,
                    CURLOPT_CUSTOMREQUEST => "POST",
                    CURLOPT_POSTFIELDS => json_encode($request),
                    CURLOPT_HTTPHEADER => $headers
                ]);
				
				$response = curl_exec($curl);
				curl_close($curl);
				
				$response = json_decode($response, true);
			
				if($response['success']){
					$dados = $response['dados'];
					$this->accessToken = $dados['accessToken'];
                    $dataExpiracao = time() + intval($dados['expiracao']);
					$this->accessTokenExpiracao = date('Y-m-d H:i:s', $dataExpiracao);

                    $this->pixAplicacaoRepository->updateAccessToken($this->accessToken, $this->accessTokenExpiracao);
					
					$retorno = [
                        "success" => true,
                        "msg" => "AccessToken criado com sucesso!"
                    ];
					
				}else{
                    $retorno = [
                        "success" => false,
                        "msg" => $response['msg']
                    ];
				}
			
			} catch (\Exception $e){
                $retorno = [
                    "success" => false,
                    "msg" => "Erro, não foi possível criar accessToken!",
                    "erro" => $e->getMessage()
                ];	
			}
			
			return $retorno;
		}
		
		public function getAccessToken(){
			$resultAccessToken = $this->geraAccessToken();
			if($resultAccessToken['success']){
				return $this->accessToken;
			}else{
				return null;
			}
		}

        //envia requisição
		private function send($method, $resource, $request = []){
			
			if($this->getAccessToken() != null){
			
				$endpoint = $this->baseUrl.$resource;
				
				$headers = [
					'Cache-Control: no-cache',
					'Content-Type: application/json',
					'Authorization: Bearer '.$this->accessToken
				];
				
				//configuração do curl
                $curl = curl_init();
                curl_setopt_array($curl, [
                    CURLOPT_URL => $endpoint,
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_CUSTOMREQUEST => $method,
                    CURLOPT_SSL_VERIFYHOST => 0,
                    CURLOPT_SSL_VERIFYPEER => 0,
                    CURLOPT_HTTPHEADER => $headers
                ]);
				
				switch($method){
					case "POST":
					case "PUT":
						curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($request));
					break;
				}
				
				$response = curl_exec($curl);
				curl_close($curl);
				$json = json_decode($response, true);
				
			}else{
				$json = null;
			}
			
			return $json;
		}

        public function criaPix($request){
            return $this->send("POST", "cria-pix", $request->toArray());
        }

        public function findPix($txid){
            return $this->send("GET", "find-pix&txid={$txid}");
        }

    }

?>