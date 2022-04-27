<?php

    namespace App\Utils;

    abstract class Config {

        public static function getAmbiente(){
            return AMBIENTE;
        }

        public static function getDbName(){
            return (AMBIENTE == "prod") ? DBNAME : DBNAME_DESENV;
        }

        public static function getDbHost(){
            return (AMBIENTE == "prod") ? DB_HOST : DB_HOST_DESENV;
        }

        public static function getDbUser(){
            return (AMBIENTE == "prod") ? DB_USER : DB_USER_DESENV;
        }

        public static function getDbPassword(){
            return (AMBIENTE == "prod") ? DB_PASSWORD : DB_PASSWORD_DESENV;
        }

        public static function getBaseUrl(){
            return (AMBIENTE == "prod") ? BASE_URL : BASE_URL_DESENV;
        }

        public static function getApiUrl(){
            return (AMBIENTE == "prod") ? API_URL : API_URL_DESENV;
        }

        public static function getAuthorizationHeader(){
            return (AMBIENTE == "prod") ? AUTHORIZATION_HEADER_NAME : AUTHORIZATION_HEADER_NAME_DESENV;
        }

    }

?>