<?php
// Initialize the session
session_start();
 
// Check if the user is logged in, if not then redirect him to login page
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
    <title>Eliminar Usuarios</title>
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
        <div id="p_c">
            <div id="contenedor_tabla_empleados">
                <center><h3> Lista de Funcionarios </h3></center>
                <div><input class="buscador" data-table="emp" type="text" placeholder="Buscar Funcionario"></div>
                <center><table id="empleados" class="emp">
                    <thead>
                        <th width="15%">
                            Nombres
                        </th>
                        <th width="15%">
                            Apellidos
                        </th>
                        <th width="40%">
                            Criticas
                        </th>
                        <th width="10%">
                            Cargo
                        </th>
                        <th width="20%">
                            Accion
                        </th>
                    </thead>
                    <?php
                    include ('conexion_database.php');
                    $empleados="SELECT*  FROM `empleados`";
                    $resultado = mysqli_query($conexion, $empleados);
                    while($row = mysqli_fetch_assoc($resultado)){
                    ?>
                        <tr>
                            <td width="15%">
                                <div>
                                    <?php
                                        echo $row["nombres"];
                                    ?>
                                </div>
                            </td>
                            <td width="15%">
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
                            <td width="10%">
                                Empleado
                            </td>
                            <td width="20%">
                                <div id="link">
                                    <a href="eliminar_empleados.php?id=<?php echo $row["id"];?>">Eliminar Empleado</a>
                                </div>
                            </td>
                        </tr>
                    <?php
                    } mysqli_free_result($resultado);
                    ?>

                    <?php
                    include ('conexion_database.php');
                    $gerentes="SELECT*  FROM `gerentes`";
                    $resultado = mysqli_query($conexion, $gerentes);
                    while($row = mysqli_fetch_assoc($resultado)){
                    ?>
                        <tr>
                            <td width="15%">
                                <div>
                                    <?php
                                        echo $row["nombres"];
                                    ?>
                                </div>
                            </td>
                            <td width="15%">
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
                            <td width="10%">
                                Gerente
                            </td>
                            <td width="20%">
                                <div id="link">
                                    <a href="eliminar_gerentes.php?id=<?php echo $row["id"];?>">Eliminar Gerente</a>
                                </div>
                            </td>
                        </tr>
                    <?php
                    } mysqli_free_result($resultado);
                    ?>

                    <?php
                    include ('conexion_database.php');
                    $id=$_SESSION["id"];
                    $admins="SELECT*  FROM `admins` WHERE id NOT LIKE '$id'";
                    $resultado = mysqli_query($conexion, $admins);
                    while($row = mysqli_fetch_assoc($resultado)){
                    ?>
                        <tr>
                            <td width="15%">
                                <div>
                                    <?php
                                        echo $row["nombres"];
                                    ?>
                                </div>
                            </td>
                            <td width="15%">
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
                            <td width="10%">
                                Administrador
                            </td>
                            <td width="20%">
                                <div id="link">
                                    <a href="eliminar_admis.php?id=<?php echo $row["id"];?>">Eliminar Administrador</a>
                                </div>
                            </td>
                        </tr>
                    <?php
                    } mysqli_free_result($resultado);
                    ?>

                </table></center>
            </div>
        </div>
    </center>
 <!--Llamado al scrip del Buscador-->
 <script src="/doc/login_administradores/js/buscador.js"></script>
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