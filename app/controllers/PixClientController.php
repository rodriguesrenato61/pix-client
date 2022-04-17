<?php

    namespace App\Controllers;

    use App\Services\PixClientService;
    use App\Forms\CreatePixForm;

    class PixClientController {

        private $service;

        public function __construct(){
            $this->service = new PixClientService();
        }

        public function criaPix(){
			$response = array();
			try {
				
                if($_SERVER['REQUEST_METHOD'] == "POST"){ 
                    $params = [
                        "recebedor" => isset($_POST['recebedor']) ? filter_input(INPUT_POST, "recebedor", FILTER_SANITIZE_SPECIAL_CHARS) : "",
                        "tipoDevedor" => isset($_POST['tipoDevedor']) ? filter_input(INPUT_POST, "tipoDevedor", FILTER_SANITIZE_SPECIAL_CHARS) : "",
                        "cpfCnpj" => isset($_POST['cpfCnpj']) ? filter_input(INPUT_POST, "cpfCnpj", FILTER_SANITIZE_SPECIAL_CHARS) : "",
                        "nomeDevedor" => isset($_POST['nomeDevedor']) ? filter_input(INPUT_POST, "nomeDevedor", FILTER_SANITIZE_SPECIAL_CHARS) : "",
                        "valor" => isset($_POST['valor']) ? filter_input(INPUT_POST, "valor", FILTER_SANITIZE_SPECIAL_CHARS) : "",
                        "solicitacao" => isset($_POST['solicitacao']) ? filter_input(INPUT_POST, "solicitacao", FILTER_SANITIZE_SPECIAL_CHARS) : "",
                    ];

                    $form = new CreatePixForm;
                    $form->parse($params);
                    $response = $this->service->criaPix($form);
                        
                }else{
                    $response = [
                        "success" => false,
                        "statusCode" => 400,
                        "msg" => "Tipo de requisição errada, use POST!"
                    ];
                }
				
			} catch(\Exception $e){
                $response = [
                    "success" => false,
                    "statusCode" => 500,
                    "msg" => "Erro interno do servidor!",
                    "erro" => $e->getMessage()
                ];
			}
			
			return $response;
		}

        public function findPix(){
			$response = array();
			try {
				
                if($_SERVER['REQUEST_METHOD'] == "GET"){ 

                    $txid = isset($_GET['txid']) ? filter_input(INPUT_GET, "txid", FILTER_SANITIZE_SPECIAL_CHARS) : "";

                    $response = $this->service->findPix($txid);
                        
                }else{
                    $response = [
                        "success" => false,
                        "statusCode" => 400,
                        "msg" => "Tipo de requisição errada, use GET!"
                    ];
                }
				
			} catch(\Exception $e){
                $response = [
                    "success" => false,
                    "statusCode" => 500,
                    "msg" => "Erro interno do servidor!",
                    "erro" => $e->getMessage()
                ];
			}
			
			return $response;
		}


    }


?>