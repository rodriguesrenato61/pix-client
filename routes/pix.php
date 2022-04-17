<?php
	
	require_once("../vendor/autoload.php");
	
	use App\Controllers\PixClientController;
	
	if(isset($_GET['op'])){
		
		$op = $_GET['op'];
		$controller = new PixClientController();
		
		switch($op){
		
			case "cria-pix":
				$response = $controller->criaPix();
			break;
			case "find-pix":
				$response = $controller->findPix();
			break;
			default:
                $response = [
                    "success" => false,
                    "statusCode" => 400,
                    "msg" => "Rota não encontrada!"
                ];
			break;
			
		}
		
	}else{
        $response = [
            "success" => false,
            "statusCode" => 400,
            "msg" => "Rota não especificada!"
        ];
	}
	
	http_response_code($response['statusCode']);
	echo json_encode($response);

?>