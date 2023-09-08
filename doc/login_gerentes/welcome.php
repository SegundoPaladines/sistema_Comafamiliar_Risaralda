<?php
// Initialize the session
session_start();
 
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) ||!isset($_SESSION["user"]) || $_SESSION["loggedin"] !== true || $_SESSION["user"] !=='gerente'){
    header("location: index.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Welcome</title>
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
                    <a href="reset-password.php" target="blank"><div id="user_gerente">
                        <center><i class="fa-solid fa-gear"></i><br>
                        <p>Cambiar Contraseña</p></center>
                    </div></a>
                </td>
                <td width="8%">
                    <a href="logout.php"><div>
                        <center><i class="fa-solid fa-arrow-right-from-bracket"></i>
                        <p>Salir <br></p></center>
                    </div><a>
                </td>
            </tr>
        </table>
    </div>
</header>
<body>
<div id="contenedor1">
    <center><table class="table1" width="90%">
            <tr>
                <td width="30%"><img src="./images/undraw_designer_re_5v95.svg"></td>
                <td width="20%"></td>
                <td width="50%">
                    <div class="con_texto"><p class="txt_1"><b>Lista De Actividades</b></p></div>
                    <div width="100%">
                        <table id="actividades" width="100%">
                            <tr>
                                <td width="100%">
                                    <a href="realizar_critica.php"><div class="actividad">
                                        <table width="100%">
                                            <tr>
                                                <td width="60%">
                                                    Realizar Critica
                                                </td>
                                                <td width="20%"></td>
                                                <td width="20%">
                                                    <i class="fa-solid fa-gear"></i><br>
                                                </td>
                                            </tr>
                                        </table>
                                    </div></a>
                                </td>
                            </tr>
                            <!-- -->
                            <tr>
                                <td width="100%">
                                    <a href="consultar_critica.php"><div class="actividad">
                                        <table width="100%">
                                            <tr>
                                                <td width="60%">
                                                   Consultar Critica
                                                </td>
                                                <td width="20%"></td>
                                                <td width="20%">
                                                    <i class="fa-solid fa-gear"></i><br>
                                                </td>
                                            </tr>
                                        </table>
                                    </div></a>
                                </td>
                            </tr>
                            <!-- -->
                            <tr>
                                <td width="100%">
                                    <a href="realizar_documentacion.php"><div class="actividad">
                                        <table width="100%">
                                            <tr>
                                                <td width="60%">
                                                   Realizar Documentacion
                                                </td>
                                                <td width="20%"></td>
                                                <td width="20%">
                                                    <i class="fa-solid fa-gear"></i><br>
                                                </td>
                                            </tr>
                                        </table>
                                    </div></a>
                                </td>
                            </tr>
                        <!-- -->

                        <tr>
                                <td width="100%">
                                    <a href="consultar_documentacion.php"><div class="actividad">
                                        <table width="100%">
                                            <tr>
                                                <td width="60%">
                                                   Consultar Documentacion
                                                </td>
                                                <td width="20%"></td>
                                                <td width="20%">
                                                    <i class="fa-solid fa-gear"></i><br>
                                                </td>
                                            </tr>
                                        </table>
                                    </div></a>
                                </td>
                            </tr>
                        <!-- -->

                        </table>	
                    </div>
                </td>
            </tr>
        </table></center>
   </div>
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