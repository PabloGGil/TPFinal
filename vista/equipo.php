<?php
/* ----------------------------------------------------------------
variables que vienen del front


----------------------------------------------------------------*/
require_once "../modelo/class.Personaje.php";
require_once "../modelo/class.Usuario.php";
$data = json_decode(file_get_contents('php://input'), true);
// $_SESSION['username'];
// if($_POST){
switch  ($data['q']){  
    case "consulta":{
        $relacion=new Usuario( $data['username']);
        $retorno=$relacion->consultarPoke($data['username']);
    }
    break;
    case "alta":
        {
        if(isset( $data['username'])&&isset($data['nombre'])&&isset($data['imagen'])&&isset($data['peso'])&&isset($data['altura'])){
            $username  =  $data['username'];       
            $nombrePoke  =  $data['nombre'];
            $imagen  =  $data['imagen'];
            $altura  =  $data['altura'];
            $peso  =  $data['peso'];
            $poke= new Personaje($nombrePoke,$imagen , $peso,$altura );
            $retorno=$poke->insertarReg();
            //if($retorno['rc']==0){
                $grupo=new Usuario($username);
                $retorno=$grupo->VincularPoke($nombrePoke);
        }}break;
       
    case "baja":{
        $username  =  $data['username'];  
        $nombrePoke  =  $data['nombre'];   
        $grupo=new Usuario($username);
        $retorno=$grupo->DesvincularPoke($nombrePoke);
        }
}
header('Content-Type: application/json');
http_response_code(200);
echo json_encode($retorno,JSON_PARTIAL_OUTPUT_ON_ERROR);
// }