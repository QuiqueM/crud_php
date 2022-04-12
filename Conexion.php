<?php

class Conexion {
    public $con;

    public function connect(){
        $this->con = mysqli_connect('localhost','root','','crud_php');
    }
}