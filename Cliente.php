<?php

require_once("Conexion.php");

class Cliente extends Conexion{

    private $id, $nombres, $ape_paterno, $ape_materno, $direccion, $correo;
    
    #getters y setter de atributos
    public function setID($id){
        $this->id = $id;
        return $this;
    }

    public function setNombres($nombres){
        $this->nombres = $nombres;
        return $this;
    }

    public function setApePaterno($ape_paterno){
        $this->ape_paterno = $ape_paterno;
        return $this;
    }

    public function setApeMaterno($ape_materno){
        $this->ape_materno = $ape_materno;
        return $this;
    }

    public function setDireccion($direccion){
        $this->direccion = $direccion;
        return $this;
    }

    public function setCorreo($correo){
        $this->correo = $correo;
        return $this;
    }

    //Regresa todos los registros de bd
    public static function getAllClients(){
        $conexion = new Conexion();
        $conexion->connect();
        $pre = mysqli_prepare($conexion->con, "SELECT * FROM clientes");
        $pre->execute();
        $res = $pre->get_result();
        $clients = [];
        while ($client = $res->fetch_object(Cliente::class)){
            $clients[] = [
                "id" => $client->id,
                "nombres" => $client->nombres,
                "ape_paterno" => $client->ape_paterno,
                "ape_materno" => $client->ape_materno,
                "direccion" => $client->direccion,
                "correo" => $client->correo,
            ];
        }

        return json_encode($clients);
    }

    //obtener cliente por id 
    public static function getClientByID($id){
        $conexion = new Conexion();
        $conexion->connect();
        $pre = mysqli_prepare($conexion->con, 'SELECT * FROM clientes WHERE id = ? ');
        $pre->bind_param('i', $id);
        $pre->execute();
        $res = $pre->get_result();

        //$client = [];
        while ($c = $res->fetch_object(Cliente::class)){
            $client = [
                "id" => $c->id,
                "nombres" => $c->nombres,
                "ape_paterno" => $c->ape_paterno,
                "ape_materno" => $c->ape_materno,
                "direccion" => $c->direccion,
                "correo" => $c->correo,
            ];
        }

        return json_encode($client);
    }

    public function create(){
        $this->connect();
        $pre = mysqli_prepare($this->con,'INSERT INTO clientes (nombres, ape_paterno, ape_materno, direccion, correo) VALUES (?,?,?,?,?)');
        $pre->bind_param('sssss', $this->nombres, $this->ape_paterno, $this->ape_materno, $this->direccion,$this->correo);
        $pre->execute();
    }

    public function update(){
        $this->connect();
        $pre = mysqli_prepare($this->con, 'UPDATE clientes SET nombres = ?, ape_paterno = ?, ape_materno= ?, direccion = ?, correo = ? WHERE id = ?');
        $pre->bind_param('sssssi', $this->nombres,$this->ape_paterno,$this->ape_materno,$this->direccion,$this->correo,$this->id);
        $pre->execute();
    }

    public function delete(){
        $this->connect();
        $pre = mysqli_prepare($this->con, 'DELETE FROM clientes WHERE id = ?');
        $pre->bind_param('i', $this->id);
        $pre->execute();
    }
    
}