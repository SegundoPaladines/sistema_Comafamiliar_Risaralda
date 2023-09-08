<?php
session_start();
if(!isset($_SESSION["loggedin"]) ||!isset($_SESSION["user"]) || $_SESSION["loggedin"] !== true || $_SESSION["user"] !=='admin'){
    header("location: index.php");
    exit;
}

include ('conexion_database.php');
$id = $_GET["id"];
$admins="SELECT *  FROM `admins` WHERE id LIKE '$id'";
$admin = mysqli_query($conexion, $admins);
$eliminar="DELETE  FROM `admins` WHERE id LIKE '$id'";  
$resultado=mysqli_query($conexion, $eliminar);
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
	</header>';
	<body>
			<div id="relleno_2"></div>
			<center>
				<div id="p_c">
					<div id="contenedor_tabla_empleados">
							<center><table id="empleados">
								<?php
								while($row = mysqli_fetch_assoc($admin)){
								?>
									<tr>
										<td width="70%">
											<div>
												El Administrador &nbsp;&nbsp;
												<?php
													echo $row["nombres"];
												?>
												&nbsp;&nbsp;
												<?php
													echo $row["apellidos"];
												?>
												&nbsp;&nbsp; Fue Elininado Con Exito
											</div>
										</td>
										<td width="30%">
											<div id="link">
												<a href="eliminar_usuarios.php">Volver</a>
											</div>
										</td>
								<?php
								} mysqli_free_result($admin);
								?>

							</table></center>
					</div>
				</div>
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