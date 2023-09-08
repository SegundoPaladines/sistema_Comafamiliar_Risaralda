<?php
// Initialize the session
session_start();
 
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) ||!isset($_SESSION["user"]) || $_SESSION["loggedin"] !== true || $_SESSION["user"] !== 'admin'){
    header("location: index.php");
    exit;
}
// Include config file
require_once "conexion_database.php";
 
// Define variables and initialize with empty values
$username = $password = $confirm_password = "";
$username_err = $password_err = $confirm_password_err = "";
$nombres = $nombres_err = "";
$apellidos = $apellidos_err = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Validate username
    if(empty(trim($_POST["username"]))){
        $username_err = "Por favor ingrese un usuario.";
    } else{
        // Prepare a select statement
        $sql = "SELECT id FROM admins WHERE username = ?";
        
        if($stmt = mysqli_prepare($conexion, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_username);
            
            // Set parameters
            $param_username = trim($_POST["username"]);
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                /* store result */
                mysqli_stmt_store_result($stmt);
                
                if(mysqli_stmt_num_rows($stmt) == 1){
                    $username_err = "Este usuario ya fue tomado.";
                } else{
                    $username = trim($_POST["username"]);
                }
            } else{
                echo "Al parecer algo salió mal.";
            }
        }
         
        // Close statement
        mysqli_stmt_close($stmt);
    }

    // Validate names
    if(empty(trim($_POST["nombres"]))){
        $nombres_err = "Por favor ingresa nombres";     
    } elseif(strlen(trim($_POST["nombres"])) < 1){
        $nombres_err = "los nombres deben tener al menos 1 caracteres.";
    } else{
        $nombres = trim($_POST["nombres"]);
    }
    
     // Validate names
     if(empty(trim($_POST["apellidos"]))){
        $apellidos_err = "Por favor ingresa apellidos";     
    } elseif(strlen(trim($_POST["apellidos"])) < 1){
        $apellidos_err = "los apellidos deben tener al menos 1 caracteres.";
    } else{
        $apellidos = trim($_POST["apellidos"]);
    }

    // Validate password
    if(empty(trim($_POST["password"]))){
        $password_err = "Por favor ingresa una contraseña.";     
    } elseif(strlen(trim($_POST["password"])) < 6){
        $password_err = "La contraseña al menos debe tener 6 caracteres.";
    } else{
        $password = trim($_POST["password"]);
    }
    
    // Validate confirm password
    if(empty(trim($_POST["confirm_password"]))){
        $confirm_password_err = "Confirma tu contraseña.";     
    } else{
        $confirm_password = trim($_POST["confirm_password"]);
        if(empty($password_err) && ($password != $confirm_password)){
            $confirm_password_err = "No coincide la contraseña.";
        }
    }
    
    // Check input errors before inserting in database
    if(empty($username_err) && empty($nombres_err)&& empty($apellidos_err)&& empty($password_err) && empty($confirm_password_err)){
        
        // Prepare an insert statement
        $sql = "INSERT INTO admins (nombres, apellidos, username, password) VALUES (?, ?, ?, ?)";
         
        if($stmt = mysqli_prepare($conexion, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "ssss", $param_nombres, $param_apellidos, $param_username, $param_password);
            
            // Set parameters
            $param_username = $username;
            $param_nombres=$nombres;
            $param_apellidos=$apellidos;
            $param_password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Redirect to login page
                header("location: welcome.php");
            } else{
                echo "Algo salió mal, por favor inténtalo de nuevo.";
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
	<meta name="viewport" content="width=device-width, initial-scale=1">
     <title>Registrar Administradores</title>
     <link rel="stylesheet" href="./css/login.css">	
     <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
     <link rel="stylesheet" href="./css/estilos.css">
     <link rel="stylesheet" href="./css/tabla.css">	
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
                </td>
                <td width="8%">
                    <a href="welcome.php"><div id="user_gerente">
                        <center><i class="fa-solid fa-house"></i><br>
                        <p>Menú</p></center>
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

<table id="log-contenido">
    <tr>
        <td>
            <div id="info">
               <img src="/doc/img/reg_nuevos.png"  width="90%" height="70%">
            </div>
        </td>
        <td>
            <div id="log">
                <div class="caja1">
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <div class="form-group <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">

                            <div class="formtlo">Registrar Administrador</div>

                            <div class="ub1">&#128273; Ingresar usuario

                                <input type="text" name="username" class="form-control" value="<?php echo $username; ?>">
                                                <span class="help-block"><?php echo $username_err; ?></span>
                            </div>
                        </div>

                        <div class="ub1">&#128273; Ingresar Nombres

                            <div class="form-group <?php echo (!empty($nombres_err)) ? 'has-error' : ''; ?>">
                                <input type="text" name="nombres" class="form-control" value="<?php echo $nombres; ?>">
                                                <span class="help-block"><?php echo $nombres_err; ?></span>
                            </div>

                        </div>

                        <div class="ub1">&#128273; Ingresar Apellidos
                            <div class="form-group <?php echo (!empty($apellidos_err)) ? 'has-error' : ''; ?>">
                                <input type="text" name="apellidos" class="form-control" value="<?php echo $apellidos; ?>">
                                                <span class="help-block"><?php echo $apellidos_err; ?></span>
                            </div>
                        </div>

                        <div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">

                            <div class="ub1">&#128274; Ingresar contraseña

                                <input type="password" id="txtpassword" name="password" class="form-control" value="<?php echo $password; ?>">
                                                <span class="help-block"><?php echo $password_err; ?></span>
                                    
                            </div>
                        </div>

                            <div class="form-group <?php echo (!empty($confirm_password_err)) ? 'has-error' : ''; ?>">
                                <div class="ub1">&#128274; Confirmar contraseña
                                    <input type="password" id="txtpassword" name="confirm_password" class="form-control" value="<?php echo $confirm_password; ?>">
                                    <span class="help-block"><?php echo $confirm_password_err; ?></span>
                            </div>
                        <div class="ub1">
                            <input type="checkbox" onclick="verpassword()">Mostrar contraseña
                        </div>

                        <div aling="center">
                            <input clas="btn-login" type="submit" value="Ingresar">
                            <input type="reset" value="Cancelar">
                        <hr>
                        </div>
                    </form>
                </div>
            </div>
        </td>
    </tr>
</table>
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