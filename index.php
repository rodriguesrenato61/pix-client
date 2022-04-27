<?php

    require_once("vendor/autoload.php");

    use App\Services\PixClientService;
    use App\Utils\Config;

    $service = new PixClientService();

?>
<!DOCTYPE html>
<html lang="pt-br" dir="ltr">
    <head>
        <meta charset="UTF-8">
        <!-- importando css do bootstrap -->
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
        <link rel="stylesheet" href="css/styles.css">
        <link rel="stylesheet" href="css/modal-box.css">
        <link rel="stylesheet" href="css/spinner.css">
        <!--importando o jquery-->
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
		<!--importando javascript do bootstrap-->
		<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
        <title> Ciar Pix </title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
    </head>
    <body>

        <div id="modalfundo">
        </div>

        <div class="spinner">
        </div>

        <!-- Modal -->
		<div id="modal-pix" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="TituloModalCentralizado" aria-hidden="true">
			<div class="modal-dialog modal-dialog-centered" role="document">
				<div class="modal-content">
					<div class="modal-header" id="modal-head">
						<button type="button" class="close" data-dismiss="modal" aria-label="Fechar">
							<span aria-hidden="true">&times;</span>
						</button>
					</div> <!-- fim modal-header -->
					<div id="modal-body" class="modal-body">
					
					</div> <!-- fim modal-body -->
				</div> <!-- fim modal-content -->
				
			</div> <!-- fim modal-dialog -->
		</div> <!-- fim modal-pix -->

        <div class="container">
            <input type="hidden" id="base-url" value="<?php echo(Config::getBaseUrl()); ?>" />
            <div class="title">Criar Pix</div>
            <form id="form-cria-pix" action="#">
                <div class="pix-details">
                    <div class="input-box">
                        <span class="details">Recebedor</span>
                        <select id="recebedor">
                            <?php
                                $recebedores = $service->getRecebedores();
                                if(count($recebedores) > 0){
                                    foreach($recebedores as $r){
                                        echo("<option value='{$r['id']}'>{$r['nome']}</option>");
                                    }
                                }else{
                                    echo("<option value=''>Nenhum Recebedor</option>");
                                }
                            ?>
                        </select>
                    </div>
                   
                    <div class="input-box">
                        <span class="details">Devedor</span>
                        <input type="text" id="nome-devedor" placeholder="Nome devedor" maxlength="75" required>
                    </div>
                    <div class="input-box">
                        <span class="details">Tipo Devedor</span>
                        <select id="tipo-devedor">
                            <option value="cpf">CPF</option>
                            <option value="cnpj">CNPJ</option>
                        </select>
                    </div>
                    <div class="input-box">
                        <span id="cpf-cnpj-title" class="details">CPF</span>
                        <input type="text" id="cpf-cnpj" placeholder="CPF" maxlength="11" required>
                    </div>
                    <div class="input-box">
                        <span class="details">Valor</span>
                        <input type="text" id="valor" placeholder="Valor" required>
                    </div>
                    <div class="input-box">
                        <span class="details">Solicitação Pagador</span>
                        <input type="text" id="solicitacao-pagador" placeholder="Solicitação pagador" maxlength="75" required>
                    </div>
                </div>

                <div class="button">
                    <input type="submit" id="btn-cria-pix" value="Gerar Pix">
                </div>

            </form>
        </div>
        <script type="text/javascript" src="js/scripts.js"></script>
    </body>
</html>