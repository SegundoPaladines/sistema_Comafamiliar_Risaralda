<?php

session_start();
 
if(!isset($_SESSION["loggedin"]) || !isset($_SESSION["user"]) || $_SESSION["loggedin"] !== true || $_SESSION["user"] !=='admin'){
    header("location: index.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Realizar Critica</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
    <link rel="stylesheet" href="./css/tabla.css">	
    <link rel="stylesheet" href="./css/estilos.css">
    <script src="https://kit.fontawesome.com/47c9cd5333.js" crossorigin="anonymous"></script>
</head>
<header>
    <div id="menu_encabezado">
        <table id="barra_log-in_usuarios">
            <tr>
                <td>
                    <img src="/doc/img/icono_comfamiliar.png" width="40%" height="20%">
                </td>
                <td width="60%">
                    <div>
                         <h3> Bienvenido Sr(a) <b><?php echo htmlspecialchars($_SESSION["nombres"]); ?></b> <b><?php echo htmlspecialchars($_SESSION["apellidos"]); ?></b>.</h3>
                    </div>
                </td>
                <td width="8%">
                    <a href="welcome.php"><div id="user_gerente">
                        <center><i class="fa-solid fa-house"></i><br>
                        <p>Menú</p></center>
                    </div></a>
                </td>
                <td width="8%">
                    <a href="logout.php" target="blank"><div>
                        <center><i class="fa-solid fa-arrow-right-from-bracket"></i>
                        <p>Salir <br></p></center>
                    </div><a>
                </td>
            </tr>
        </table>
    </div>
</header>
<body>
    <div id="relleno_2"></div>
    <center>
        <form action="procesar_actualizar_gerentes.php" method="post" id="fm1">
            <div id="contenedor_tabla_empleados">
                <center><h3> Lista de Gerentes </h3></center>
                <center><table id="empleados">
                    <thead>
                        <th width="0%">

                        </th>
                        <th width="20%">
                            Nombres
                        </th>
                        <th width="20%">
                            Apellidos
                        </th>
                        <th width="40%">
                            Criticas
                        </th>
                        <th width="20%">
                            Realizar Critica
                        </th>
                    </thead>
                    <?php
                    include ('conexion_database.php');
                    $id = $_GET["id"];
                    $gerentes="SELECT *  FROM `gerentes` WHERE id LIKE '$id'";
                    $resultado = mysqli_query($conexion, $gerentes);
                    while($row = mysqli_fetch_assoc($resultado)){
                    ?>
                        <tr>
                            <td width="0%">
                                <div>
                                    <input type="hidden" value="<?php echo $row["id"];?>" name="id">
                                </div>
                            </td>
                            <td width="20%">
                                <div>
                                    <?php
                                        echo $row["nombres"];
                                    ?>
                                </div>
                            </td>
                            <td width="20%">
                                <div>
                                    <?php
                                        echo $row["apellidos"];
                                    ?>
                                </div>
                            </td>
                            <td width="40%">
                            <div>
                                <?php
                                    echo $row["criticas"];
                                ?>
                            </div>
                            </td>
                            <td width="20%">
                                <div>
                                    <input type="text" name="critica">
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="5">
                                <center>
                                    <input id="guardar_c" type="submit" Value="Guardar"> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    <a id="vlv_c" href="realizar_critica.php"> Volver</a>
                                </center>
                            </td>
                        </tr>
                    <?php
                    } mysqli_free_result($resultado);
                    ?>

                </table></center>
            </div>
        </form>
    </center>
</body>
<fotter>
    <div id="pie_pagina">
        <center><table id="informacion" width="90%">
            <tr>
                <td width="50%" valign="top">
                    <p>
                        Comfamiliar Risaralda. <br><br>
                        PBX: (606) 3135600 Area De Gestion Documental <br><br>
                        PBX: (606) 3138700 Seccion De Gestion De Calidad <br><br>
                        PBX: (606) 3135700 Conmutador Servicios <br><br>
                        Opc. 1 Criticas - Opc. 2 Aportes - Opc. 3 Crédito- Opc. 4 Gestión Empresarial
                    </p>
                </td>
                <td width="50%" valign="top">
                    <p>
                        PQRS: 01 8000 948787 <br><br>
                        Horarios de atención Sede Administrativa <br><br>
                        Lunes a a Viernes: 7:00 AM a 12:00 M - 1:30 a 6:00 PM <br><br>
                        Correo para notificaciones judiciales: comfarda@comfamiliar.com
                    </p>
                </td>
            </tr>
            <tr><td colspan="2"><p class="final">Todos los Empleados deben Cumplir el Horario y Normativa establecida por la empresa Comfamiliar Rirsaralda</p></td> </tr>
        </table></center>
    </div>

</fotter>
</html>