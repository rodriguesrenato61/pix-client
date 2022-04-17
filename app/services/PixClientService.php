<?php

    namespace App\Services;

    use App\Database\DbConexao;
    use App\Repositories\PixAplicacaoRepository;
    use App\Repositories\PixRecebedorRepository;
    use App\Pix\PixClientApi;
    use App\Pix\Requests\CreatePixRequest;

    class PixClientService {

        private $db;
        private $pixAplicacaoRepository;
        private $pixRecebedorRepository;
        private $pixClientApi;

        public function __construct(){
            $this->db = new DbConexao();
            $this->pixAplicacaoRepository = new PixAplicacaoRepository($this->db);
            $this->pixRecebedorRepository = new PixRecebedorRepository($this->db);
            $this->pixClientApi = new PixClientApi($this->db);
        }

        private function setCredenciais($aplicacao){
            $this->pixClientApi->setAppNome($aplicacao['nome']);
            $this->pixClientApi->setAppCod($aplicacao['appCod']);
            $this->pixClientApi->setAppKey($aplicacao['appKey']);
            $this->pixClientApi->setAccessToken($aplicacao['accessToken']);
            $this->pixClientApi->setAccessTokenExpiracao($aplicacao['accessTokenExpiracao']);
        }

        public function criaPix($form){
            $retorno = null;
            if($form->isValido()){

                $recebedor = $this->pixRecebedorRepository->findById($form->getRecebedor());
                if($recebedor != null){

                    $aplicacao = $this->pixAplicacaoRepository->getCredenciais();
                    if($aplicacao != null){

                        $this->setCredenciais($aplicacao);
                       //falta infoAdicionais
                        $request = new CreatePixRequest;
                        $request->setTipoDevedor($form->getTipoDevedor());
                        $request->setDevedorNome($form->getNomeDevedor());
                        $request->setDevedorCpfCnpj($form->getCpfCnpj());
                        $request->setValor($form->getValor());
                        $request->setSolicitacaoPagador($form->getSolicitacao());
                        $request->setRecebedorId($form->getRecebedor());

                        $response = $this->pixClientApi->criaPix($request);
                        $retorno = [
                            "success" => $response['success'],
                            "statusCode" => $response['statusCode'],
                            "msg" => $response['msg'],
                            "dados" => [
                                "request" => $request->toArray(),
                                "response" => $response
                            ]
                        ];

                    }else{
                        $retorno = [
                            "success" => false,
                            "statusCode" => 404,
                            "msg" => "Aplicação não encontrada!"
                        ];
                    }

                }else{
                    $retorno = [
                        "success" => false,
                        "statusCode" => 404,
                        "msg" => "Recebedor não encontrado!"
                    ];
                }

            }else{
                $retorno = [
                    "success" => false,
                    "statusCode" => 400,
                    "msg" => "Dados incorretos!",
                    "erros" => $form->getErros()
                ]; 
            }

            return $retorno;
        }

        public function findPix($txid){
            $retorno = array();
            if($txid != ""){
                $aplicacao = $this->pixAplicacaoRepository->getCredenciais();
                if($aplicacao != null){

                    $this->setCredenciais($aplicacao);

                    $response = $this->pixClientApi->findPix($txid);
                    $retorno = [
                        "success" => $response['success'],
                        "statusCode" => $response['statusCode'],
                        "msg" => $response['msg'],
                        "dados" => [
                            "txid" => $txid,
                            "response" => $response
                        ]
                    ];

                }else{
                    $retorno = [
                        "success" => false,
                        "statusCode" => 404,
                        "msg" => "Aplicação não encontrada!"
                    ];
                }
            }else{
                $retorno = [
                    "success" => false,
                    "statusCode" => 400,
                    "msg" => "Txid vazio!"
                ];
            }

            return $retorno;
        }
        
        public function getRecebedores(){
            return $this->pixRecebedorRepository->findAll();
        }

    }

?>