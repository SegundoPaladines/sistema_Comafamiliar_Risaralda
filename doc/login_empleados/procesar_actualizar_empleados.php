<?php
    include ('conexion_database.php');
    $id = $_POST["id"];
    $critica = $_POST["critica"];
    $ct="SELECT criticas FROM `empleados` WHERE id LIKE '$id'";
    $crit = mysqli_query($conexion, $ct);
    $cts="";
    while($row = mysqli_fetch_assoc($crit)){
        $cts=$row["criticas"];
    }
    $criticas=$critica.", \n".$cts;
    $incertar="UPDATE `empleados` SET criticas = '$criticas' WHERE id LIKE '$id'";
    $resultado = mysqli_query($conexion, $incertar);
    if($resultado){
       header("location: realizar_critica.php");
    } else{
        echo "Algo salió mal, por favor inténtalo de nuevo.";
        echo $criticas;
    }
?>