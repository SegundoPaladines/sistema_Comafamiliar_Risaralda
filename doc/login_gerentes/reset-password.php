<?php
// Initialize the session
session_start();
 
// Check if the user is logged in, otherwise redirect to login page
if(!isset($_SESSION["loggedin"]) ||!isset($_SESSION["user"]) || $_SESSION["loggedin"] !== true || $_SESSION["user"] !=='gerente'){
    header("location: index.php");
    exit;
}
 
// Include config file
require_once "conexion_database.php";
 
// Define variables and initialize with empty values
$new_password = $confirm_password = "";
$new_password_err = $confirm_password_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Validate new password
    if(empty(trim($_POST["new_password"]))){
        $new_password_err = "Please enter the new password.";     
    } elseif(strlen(trim($_POST["new_password"])) < 6){
        $new_password_err = "La contraseña al menos debe tener 6 caracteres.";
    } else{
        $new_password = trim($_POST["new_password"]);
    }
    
    // Validate confirm password
    if(empty(trim($_POST["confirm_password"]))){
        $confirm_password_err = "Por favor confirme la contraseña.";
    } else{
        $confirm_password = trim($_POST["confirm_password"]);
        if(empty($new_password_err) && ($new_password != $confirm_password)){
            $confirm_password_err = "Las contraseñas no coinciden.";
        }
    }
        
    // Check input errors before updating the database
    if(empty($new_password_err) && empty($confirm_password_err)){
        // Prepare an update statement
        $sql = "UPDATE gerentes SET password = ? WHERE id = ?";
        
        if($stmt = mysqli_prepare($conexion, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "si", $param_password, $param_id);
            
            // Set parameters
            $param_password = password_hash($new_password, PASSWORD_DEFAULT);
            $param_id = $_SESSION["id"];
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Password updated successfully. Destroy the session, and redirect to login page
                session_destroy();
                header("location: index.php");
                exit();
            } else{
                echo "Algo salió mal, por favor vuelva a intentarlo.";
            }
        }
        
        // Close statement
        mysqli_stmt_close($stmt);
    }
    
    // Close connection
    mysqli_close($conexion);
}
?>
 

<html>
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
        <div class="caja1" id="cambiar_contrasena">
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post"> 
                        <div class="form-group <?php echo (!empty($new_password_err)) ? 'has-error' : ''; ?>">
            <div class="formtlo ">Cambiar contraseña</div>

            <div class="ub1">&#128274; Nueva contraseña</div>

            <input  id="txtpassword" type="password" name="new_password" class="form-control" value="<?php echo $new_password; ?>">
            <span class="help-block"><?php echo $new_password_err; ?></span>
            </div>


            <div class="form-group <?php echo (!empty($confirm_password_err)) ? 'has-error' : ''; ?>">

            <div class="ub1">&#128274; Confirmar contraseña</div>

                            <input  id="txtpassword" type="password" name="confirm_password" class="form-control">
                            <span class="help-block"><?php echo $confirm_password_err; ?></span>
                        </div>

            <div class="ub1">
            <input type="checkbox" onclick="verpassword()" >Mostrar contraseña
            </div>


            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Guardar">
            </div>


            </form>

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
<script>
  function verpassword(){
      var tipo = document.getElementById("txtpassword");
      if(tipo.type == "password")
	  {
          tipo.type = "text";
      }
	  else
	  {
          tipo.type = "password";
      }
  }
</script>
</html>