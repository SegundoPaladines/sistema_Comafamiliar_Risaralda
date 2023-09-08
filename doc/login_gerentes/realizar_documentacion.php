<?php
include ('conexion_database.php');
// Initialize the session
session_start();
 
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) ||!isset($_SESSION["user"]) || $_SESSION["loggedin"] !== true || $_SESSION["user"] !=='gerente'){
    header("location: index.php");
    exit;
}
if (isset($_POST['submit'])) {
    if(is_uploaded_file($_FILES['fichero']['tmp_name'])) {
     
      // creamos las variables para subir a la db
        $ruta = "documentacion/";
        $nombrefinal= trim ($_FILES['fichero']['name']); //Eliminamos los espacios en blanco
        $nombrefinal= str_replace(" ", "", $nombrefinal);//Sustituye una expresión regular
        $upload= $ruta.$nombrefinal;
       
        if(rename($_FILES['fichero']['tmp_name'], $upload)) { //movemos el archivo a su ubicacion 
                    
          echo "<b>Upload exitoso!. Datos:</b><br>";  
          echo "Nombre: <i><a href=\"".$ruta . $nombrefinal."\">".$_FILES['fichero']['name']."</a></i><br>";  
          echo "Tipo MIME: <i>".$_FILES['fichero']['type']."</i><br>";  
          echo "Peso: <i>".$_FILES['fichero']['size']." bytes</i><br>";  
          echo "<br><hr><br>";  

         $nombre  = $_POST["nombre"]; 
         $description  = $_POST["description"];
         $r_completa = $ruta.$nombrefinal;
         $tamano = $_FILES['fichero']['size'];
         $tamano=$tamano/1024;
         $tipo=$_FILES['fichero']['type'];

         $sql = "INSERT INTO archivos(name, description, ruta, tipo, size) VALUES ('$nombre', '$description', '$r_completa', '$tipo', '$tamano')";
         $resultado = mysqli_query($conexion, $sql);
         if($resultado){
            echo'<script type="text/javascript">
                    alert("Documentado con exito");
                    window.location.href="realizar_documentacion.php";
                  </script>';
        } else{
          echo'<script type="text/javascript">
                alert("Error, por favor vuelve a intentar");
                window.location.href="realizar_documentacion.php";
              </script>';
        } 
      }  
    }  
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
<div id="contenedor1">
  <div id="form_documentar">
      <table>
        <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="post" enctype="multipart/form-data">
            <tr>
                <td>
                    Seleccione archivo:  
                </td>
                <td>
                  <input id="btn_select_arch" name="fichero" type="file" size="150" maxlength="150">  
                </td>
            </tr>
            <tr>
                <td>
                  Nombre:
                </td>
                <td>
                  <input class="inpt_1" name="nombre" type="text" size="70" maxlength="70"> 
                </td>
            </tr>
            <tr>
                <td>
                  Descripcion:
                </td>
                <td>
                  <input class="inpt_1" name="description" type="text" size="100" maxlength="250">
                </td>
            </tr>
            <tr>
                <td colspan="2">
                  <center><div class="input-wrapper">
                    <i id ="icono_up" class="fa-solid fa-arrow-up-from-bracket"></i> <input id="btn_subir_arch" name="submit" type="submit" value="SUBIR ARCHIVO">
                  </div><center>
                 
                </td>
            </tr>
          </form>
        </table>
      </div>
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
<body> 

</body>