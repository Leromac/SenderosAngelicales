<?php
	// Primero revisamos que las variables que vienen de los formularios no se encuentren vacías
	$valida = 0;
	
	if (empty($_POST['nombre'])){
?> 
		<script language="javascript">
			alert("NO SE ESPECIFICO NINGUN NOMBRE.");
			location="index.html";
		</script>
<?php
		$valida = $valida+1;
		//echo "NO SE ESPECIFICO NINGUN NOMBRE.";
	}
	
	if (empty($_POST['fecha'])){
?>
		<script>
			alert("NO SE INGRESO NINGUNA FECHA DE NACIMIENTO.");
			location="index.html";
		</script>
<?php
		$valida = $valida+1;
		//echo "NO SE INGRESO NINGUNA FECHA DE NACIMIENTO.";
	}
	
	if (empty($_POST['correo'])){
?>
		<script>
			alert("NO SE ESPECIFICO NINGUN CORREO ELECTRONICO.");
			location="index.html";;
		</script>
<?php
		$valida = $valida+1;
		//echo "NO SE ESPECIFICO NINGUN CORREO.";
	}
	
	if (empty($_POST['ciudad'])){
?>
		<script>
			alert("NO SE ESPECIFICO NINGUNA CIUDAD.");
			location="index.html";
		</script>
<?php
		$valida = $valida+1;
		//echo "NO SE ESPECIFICO NINGUN PAIS.";
	}
	
	if (empty($_POST['caso'])){
?>
		<script>
			alert("POR FAVOR, NO ENVIE EL CASO EN BLANCO.");
			location="index.html";
		</script>
<?php
		$valida = $valida+1;
		//echo "POR FAVOR, NO ENVIE EL CASO EN BLANCO.";
	}
	// Luego validamos con strchr la primera ocurrencia de la arroba y el punto, es decir, validamos
	// que sea un email lo que se escribe en el campo correspondiente
	if ((!strchr($_POST['correo'],"@")) || (!strchr($_POST['correo'],"."))){
?>	
		<script>
			alert("EL CORREO INGRESADO, NO ES UN CORREO VALIDO.");
			location="index.html";
		</script>
<?php
		//echo "EL CORREO INGRESADO, NO ES UN CORREO VALIDO.";
		// Esta bandera se activa en false si no es un email válido
		$valida = $valida+1;
	} 
	
	// Si todo sale bien
	require_once "class.phpmailer.php";
	
	$mail = new PHPMailer();
	
	if (($valida == 0)){
		$mail->IsSMTP();
		$mail->SMTPAuth     = true;
		$mail->Host         = 'localhost'; // Reemplazar por el servidor de su sitio
		//$mail->Host         = 'mail.santerosdelamor.co.cc'; // Reemplazar por el servidor de su sitio
		$mail->Port         = 25;
		$mail->Username     = 'maestrosdelamor@angelesyamor.net'; // Reemplazar por la cuenta de correo a usar PARA ENVIAR el correo
		$mail->Password     = 'david060500';
		
		$email= $_POST['correo'];
		$body = "<HTML><BODY>NOMBRE: ".(strtoupper($_POST['nombre']))."<br /> FECHA NACIMIENTO: ".(strtoupper($_POST['fecha']))."<br /> CORREO RESPUESTA: ".$_POST['correo']."<br /> CIUDAD: ".(strtoupper($_POST['ciudad']))."<br /> NOMBRE PAREJA: ".(strtoupper($_POST['npareja']))."<br /> FECHA NACIMIENTO PAREJA: ".(strtoupper($_POST['fpareja']))."<br /> CASO: <br /> ".(strtoupper($_POST['caso']))."</BODY></HTML>";
	
		$mail->IsHTML(true);
		
		//$mail->SetFrom($email, $email);
		$mail->Subject = "Senderos - ".(strtoupper($_POST['nombre']));
		$mail->MsgHTML($body);
		$mail->AddAddress('maestrosdelamor@angelesyamor.net'); // Reemplazar por la cuenta de correo a usar PARA RECIBIR EL CORREO	
		
		if ($mail->Send()){
   		?>
			<script>
				alert("LOS DATOS HAN SIDO ENVIADOS CON EXITO.\n\n DENTRO DE POCO TE CONTACTAREMOS.");
				location="index.htm";
			</script>
		<?php
		} else {
   		?>
			<script>
				alert("HA FALLADO EL ENVIO DE LOS DATOS, POR FAVOR INTENTELO NUEVAMENTE.");
				location="index.html";
			</script>
		<?php
		}
	}
?> 