<?php

    class Conexion{

        private $con;

        public function __construct()
        {
            $this->con=new mysqli('localhost','root','','leasehub');

            if($this->con->connect_error){
                die("Conexion Fallida".$this->con->connect_error);
            }
        }

        public function getConexion(){

            return $this->con;
        }
    }

?>