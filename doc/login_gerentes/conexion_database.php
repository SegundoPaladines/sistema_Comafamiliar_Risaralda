<?php
$ubicacion="localhost";
$usuario="root";
$password="";
$bd="comfamiliar_risaralda_DB";
$conexion=mysqli_connect($ubicacion,$usuario,$password,$bd);

// prueba de conexion mientras el desarrollo

if ($conexion) {
	// echo "realizado";
}else{
	echo "hay un problema de conexon";
}
?>