<?php
// Initialize the session
session_start();
 
// Check if the user is already logged in, if yes then redirect him to welcome page
if(isset($_SESSION["loggedin"]) && !isset($_SESSION["user"])&& $_SESSION["loggedin"] === true && $_SESSION["user"] === 'empleado'){
    header("location: welcome.php");
    exit;
  }
 
// Include config file
require_once "conexion_database.php";
 
// Define variables and initialize with empty values
$username = $password = "";
$username_err = $password_err = "";
$nombres = $apellidos = "";
 
// Processing form data when form is submitted
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // Check if username is empty
    if(empty(trim($_POST["username"]))){
        $username_err = "Por favor ingrese su usuario.";
    } else{
        $username = trim($_POST["username"]);
    }
    
    // Check if password is empty
    if(empty(trim($_POST["password"]))){
        $password_err = "Por favor ingrese su contraseña.";
    } else{
        $password = trim($_POST["password"]);
    }
    
    // Validate credentials
    if(empty($username_err) && empty($password_err)){
        // Prepare a select statement
        $sql = "SELECT id, nombres, apellidos, username, password FROM empleados WHERE username = ?";
        
        if($stmt = mysqli_prepare($conexion, $sql)){
            // Bind variables to the prepared statement as parameters
            mysqli_stmt_bind_param($stmt, "s", $param_username);
            
            // Set parameters
            $param_username = $username;
            
            // Attempt to execute the prepared statement
            if(mysqli_stmt_execute($stmt)){
                // Store result
                mysqli_stmt_store_result($stmt);
                
                // Check if username exists, if yes then verify password
                if(mysqli_stmt_num_rows($stmt) == 1){                    
                    // Bind result variables
                    mysqli_stmt_bind_result($stmt, $id, $nombres, $apellidos, $username, $hashed_password);
                    if(mysqli_stmt_fetch($stmt)){
                        if(password_verify($password, $hashed_password)){
                            // Password is correct, so start a new session
                            session_start();
                            
                            // Store data in session variables
                            $_SESSION["user"] = "empleado";
                            $_SESSION["loggedin"] = true;
                            $_SESSION["id"] = $id;
                            $_SESSION["nombres"] = $nombres;
                            $_SESSION["apellidos"] = $apellidos;
                            $_SESSION["username"] = $username;                            
                            
                            // Redirect user to welcome page
                            header("location: welcome.php");
                        } else{
                            // Display an error message if password is not valid
                            $password_err = "La contraseña que has ingresado no es válida.";
                        }
                    }
                } else{
                    // Display an error message if username doesn't exist
                    $username_err = "No existe cuenta registrada con ese nombre de usuario.";
                }
            } else{
                echo "Algo salió mal, por favor vuelve a intentarlo.";
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
     <title>Empleados</title>
     <link rel="stylesheet" href="./css/login.css">	
     <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
     <script src="https://kit.fontawesome.com/47c9cd5333.js" crossorigin="anonymous"></script>

</head>
<header>
    <div id="menu_encabezado">
            <table id="barra_log-in_usuarios">
                <tr>
                    <td>
                        <img src="/doc/img/icono_comfamiliar.png" width="40%" height="20%">
                    </td>
                    <td width="51%">
                        
                    </td>
                    <td width="8%">
                        <a href="/doc/login_administradores/index.php" target="blank"><div id="user_administrador">
                            <center><i class="fa-solid fa-id-card"></i><br>
                            <p>Administrador</p></center>
                        </div></a>
                    </td>
                    <td width="8%">
                        <a href="/doc/login_gerentes/index.php" target="blank"><div id="user_gerente">
                            <center><i class="fa-solid fa-user-tie"></i><br>
                            <p>Gerente</p></center>
                        </div></a>
                    </td>
                    <td width="10%">
                        <a href="/doc/index.html" target="blank"><div id="user_administrador">
                            <center><i class="fa-solid fa-house"></i><br>
                            <p>Inicio</p></center>
                        </div></a>
                    </td>
                </tr>
            </table>
    </div>
</header>
<body>

<table id="log-contenido">
    <tr>
        <td width="75%">
            <div id="info">
               <img src="/doc/img/empleado.png" width="100%">
            </div>
        </td>
        <td>
            <div id="log">
                <div class="caja1">
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                        <div class="form-group <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">

                            <div class="formtlo ">Iniciar sesión: Empleado</div>
                            <div class="ub1">&#128273; Ingresar usuario</div>

                            <input type="text" name="username" class="form-control" value="<?php echo $username; ?>">
                            <span class="help-block"><?php echo $username_err; ?></span>

                            </div>
                            <div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">

                            <div class="ub1">&#128274; Ingresar contraseña</div>

                            <input  id="txtpassword" type="password" name="password" class="form-control">
                            <span class="help-block"><?php echo $password_err; ?></span>


                            <div class="ub1">
                            <input type="checkbox" onclick="verpassword()" >Mostrar contraseña
                            </div>
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

    <div><img src="/doc/img/pie_pagina.png" alt=""></div>

    <div id="pie_pagina">
        <center><table id="informacion" width="90%">
            <tr>
                <td width="50%" valign="top">
                    <p>
                        Avenida Circunvalar No. 3-01. Pereira Risaralda. <br><br>
                        PBX: (606) 3135600 Conmutador Administrativo <br><br>
                        PBX: (606) 3138700 Conmutador Clínico <br><br>
                        PBX: (606) 3135700 Conmutador Servicios <br><br>
                        Opc. 1 Salud - Opc. 2 Aportes - Opc. 3 Crédito- Opc. 4 Gestión Empresarial
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
            <tr><td colspan="2"><p class="final">Todos los derechos reservados COMFAMILIAR RISARALDA 2017 | Cumplimiento Ley 1712 de 2014 Transparencia y Acceso a Información Pública</p></td> </tr>
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