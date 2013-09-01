<?php
/* PHP Form Mailer - Midominio e internetbogota formulario v1.1, Ultima actualización 3 Noviembre 2011!
     (Fácil de usar más seguro mas compatible) gratis:

                  www.midominio.com.co

      sirve para palataformas Linux, este archivo debe ir acompañado de los archivos registro.htm y debug.flag
      
	  Edición:
	  Debe tener en cuenta editar las lineas 14, 15, 16, 82, 84, 89, 109, 110, 111, esto se puede mover hacia arriba y hacia abajo si insertan más lineas
*/

// ------- three variables you MUST change below  -------------------------------------------------------
$replyemail="consultas@senderosangelicales.com"; //change to your email address
$valid_ref1="http://senderosangelicales.com/"; //chamge to your domain name
$valid_ref2="http://www.senderosangelicales.com/"; //chamge to your domain name

// -------- No changes required below here -------------------------------------------------------------
// email variable not set - load $valid_ref1 page
if (!isset($_POST['email']))
{
 echo "<script language=\"JavaScript\"><!--\n ";
 echo "top.location.href = \"$valid_ref1\"; \n// --></script>";
 exit;
}
$ref_page=$_SERVER["HTTP_REFERER"];
$valid_referrer=0;
if($ref_page==$valid_ref1) $valid_referrer=1;
elseif($ref_page==$valid_ref2) $valid_referrer=1;
if((!$valid_referrer) OR ($_POST["block_spam_bots"]!=12))//you can change this but remember to change it in the contact form too
{
 echo '<h2>ERROR - not sent. <a href="#" onClick="history.go(-1)">Click here to go back</a>';
 if (file_exists("debug.flag")) echo '<hr>"$valid_ref1" and "$valid_ref2" are incorrect within the file:<br>
                                      contact_process.php <br><br>On your system these should be set to: <blockquote>
									  $valid_ref1="'.str_replace("www.","",$ref_page).'"; <br>
									  $valid_ref2="'.$ref_page.'";
									  </blockquote></h2>Copy and paste the two lines above 
									  into the file: contact_process.php <br> (replacing the existing variables and settings)';
 exit;
}

//check user input for possible header injection attempts!
//function is_forbidden($str,$check_all_patterns = true)
{
 $patterns[0] = 'content-type:';
 $patterns[1] = 'mime-version';
 $patterns[2] = 'multipart/mixed';
 $patterns[3] = 'Content-Transfer-Encoding';
 $patterns[4] = 'to:';
 $patterns[5] = 'cc:';
 $patterns[6] = 'bcc:';
 $forbidden = 0;
 for ($i=0; $i<count($patterns); $i++)
  {
   $forbidden = eregi($patterns[$i], strtolower($str));
   if ($forbidden) break;
  }
 //check for line breaks if checking all patterns
 if ($check_all_patterns AND !$forbidden) $forbidden = preg_match("/(%0a|%0d|\\n+|\\r+)/i", $str);
 if ($forbidden)
 {
  echo "<font color=red><center><h3>STOP! Message not sent.</font></h3><br><b>
        The text you entered is forbidden, it includes one or more of the following:
        <br><textarea rows=9 cols=25>";
  foreach ($patterns as $key => $value) echo $value."\n";
  echo "\\n\n\\r</textarea><br>Click back on your browser, remove the above characters and try again.
        </b><br><br><br><br>Thankfully protected by phpFormMailer freely available from:
        <a href=\"http://thedemosite.co.uk/phpformmailer/\">http://thedemosite.co.uk/phpformmailer/</a>";
  exit();
 }
}
//foreach ($_REQUEST as $value) is_forbidden($value);

$nombre = $_POST["nombre"];
$empresa = $_POST["empresa"];
$email = $_POST["email"];
$telefonos = $_POST["telefonos"];
$como = $_POST["como"];
$thesubject = $_POST["thesubject"];
$themessage = $_POST["themessage"];

$success_sent_msg='<p align="center"><img src="http://www.senderosangelicales.com/imagenes/fondos/senderos%20angelicales.png" </p>
                   
                   <p align="center"><strong>Registro en línea Senderos Angelicales<br>
                   <p align="center"><strong>Su mensaje se ha enviado con éxito</strong>
                   y será respondido lo antes posible</p>
                   <p align="center">Una copia de este mensaje le será enviada al correo que suministró.</p>
                   <p align="center">Gracias por contactarnos.</p>
				   <p align="center"><a href="http://senderosangelicales.com">Haga click aquí para continuar</a> ';

$replymessage = "Hola $nombre

Gracias por contactarnos.

Estaremos atentos a su solicitud y le estaremos respondiendo lo antes posible.

Si en los próximos dias no nos hemos comunicado con usted por favor llamenos a los teléfonos citados en el sitio web en Bogotá o envienos un correo electrónico

Esta es una auto respuesta de nuestro servicio de contacto en línea:
--------------------------------------------------
Asunto: $thesubject

Producto que le interesa:

$themessage
--------------------------------------------------

Muchas Gracias
Mi dominio, midominio.com.co
Teléfonos: 7598640, 3002083587
Correo electrónico: info@midominio.com.co";

$themessage = "Nombre: $nombre \n Paciente: $empresa \n Email: $email \n Telefonos: $telefonos \n Como se enteró del hogar: $como \n Información que le interesa: $themessage";
mail("$replyemail",
     "$thesubject",
     "$themessage",
     "From: $email\nReply-To: $email");
mail("$email",
     "Receipt: $thesubject",
     "$replymessage",
     "From: $replyemail\nReply-To: $replyemail");
echo $success_sent_msg;
/*
  PHP Form Mailer - phpFormMailer (easy to use and more secure than many cgi form mailers)
   FREE from:

    www.midominio.com.co       */
?>

