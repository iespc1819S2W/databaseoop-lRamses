<?php
$base = __DIR__;
 require_once("$base/model/autor.class.php");
 $autor=new Autor();
 /*
 $res=$autor->getAll();
 if ($res->correcta) {
    foreach ($res->dades as $row){
        echo $row['ID_AUT']."-".$row['NOM_AUT']." ".$row["FK_NACIONALITAT"]."<br>";
    }
 } else {
     echo $res->missatge;
 }
 }
*/
/* Intertar Autor 
 $res=$autor->insert(array("NOM_AUT"=>"HHHola","FK_NACIONALITAT"=>"ESP")); 
  //  echo "Error insertant";  // Error per l'usuari
    error_log($res->missatge,3,"$base/log/errors.log");  // Error per noltros  
*/

    // Mostrar un autor
    $tupla=$autor->get(1);
    if($tupla->correcta){
    	$dades=$tupla->dades;
    	 echo $dades['ID_AUT']."-".$dades['NOM_AUT']." ".$dades['FK_NACIONALITAT'];
    } else {
    	echo $dades->missatge;
    }
   // Update $query="UPDATE AUTORS SET NOM_AUT = '$nom', FK_NACIONALITAT = '$nacionalitat' where ID_AUT=$id";
   $autor->update(array("ID_AUT"=>6550,"NOM_AUT"=>"HolaPedroNuevaNacionalidad","FK_NACIONALITAT"=>"ESPANYOLA")); 
   
   /* borrar autor 
   $autor->delete(6554);
   */
   $res=$autor->filtrar("Hola","NOM_AUT","desc",10);
    if ($res->correcta) {
    foreach ($res->dades as $row){
        echo $row['ID_AUT']."-".$row['NOM_AUT']." ".$row["FK_NACIONALITAT"]."<br>";
    }
 } else {
     echo $res->missatge;
 }

