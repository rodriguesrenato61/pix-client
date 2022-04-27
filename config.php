<?php

    //ambiente desenvolvimento(desenv), produção(prod)
    const AMBIENTE = "desenv";

    //Variáveis de ambiente de desenvolvimento
    const DBNAME_DESENV = "pix_client_db";
    const DB_HOST_DESENV = "localhost";
    const DB_USER_DESENV = "root";
    const DB_PASSWORD_DESENV = "";
    const BASE_URL_DESENV = "https://localhost/projetos/git/pix-client";
    const API_URL_DESENV = "https://www.rrodrigues.dev.br/payment-service/api/pix.php";
    const AUTHORIZATION_HEADER_NAME_DESENV = "Autorizacao";

    //Variáveis de ambiente de produção
    const DBNAME = "NOME_DO_BANCO";
    const DB_HOST = "HOST_DO_BANCO";
    const DB_USER = "USER_DO_BANCO";
    const DB_PASSWORD = "SENHA_DO_BANCO";
    const BASE_URL = "URL_RAIZ_DA_APLICAÇÃO";
    const API_URL = "URL_ONLINE_DA_API_PAYMENT_SERVICE";
    const AUTHORIZATION_HEADER_NAME = "NOME_COLOCATO_PARA_O_HEADER_AUTHORIZATION";

?>
