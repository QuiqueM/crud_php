<?php

require_once("Cliente.php");

/*$cliente = new Cliente();
$cliente->setNombres("enrique ")
        ->setApePaterno("Martinez")
        ->setApeMaterno("Ramirez")
        ->setDireccion("av Carranza #510")
        ->setCorreo("m_r_enrique")
        ->create();*/

if(isset($_GET['accion'])){
    if($_GET['accion'] == 'getClients'){
        $clients = Cliente::getAllClients();
        echo $clients;
    } else {
        if($_GET['accion'] == 'getClientByID'){
            $cliente = Cliente::getClientByID(intval($_GET['id']));
            echo $cliente;
        } else {
            if($_GET['accion'] == 'delete'){
                $cliente = new Cliente();
                $cliente->setID(intval($_GET['id']))->delete();
                
            } 
        }
    }
} else {
    if(isset($_POST['accion'])){
        if($_POST['accion'] == 'update'){
            $cliente = new Cliente();
            $cliente->setID($_POST['id'])
                    ->setNombres($_POST['nombres'])
                    ->setApePaterno($_POST['ape_paterno'])
                    ->setApeMaterno($_POST['ape_materno'])
                    ->setDireccion($_POST['direccion'])
                    ->setCorreo($_POST['correo'])
                    ->update();
        } else {
            if($_POST['accion'] == 'create'){
                $cliente = new Cliente();
                $cliente->setNombres($_POST['nombres'])
                        ->setApePaterno($_POST['ape_paterno'])
                        ->setApeMaterno($_POST['ape_materno'])
                        ->setDireccion($_POST['direccion'])
                        ->setCorreo($_POST['correo'])
                        ->create();
            }
        }
    }
}