<?php
//incluimos phpmailer
require "src/Exception.php";
require "src/PHPMailer.php";
require "POP3.php";
require "src/class.phpmailer.php";
require 'vendor/autoload.php';
use PHPMailer\PHPMailer\POP3;

//variables de metodo post
 $emailAddress = $_POST['email'];
 $primer_nombre = $_POST['primer_nombre'];
 $apellidos = $_POST['apellidos'];
 $correo_electronico = $_POST['correo_electronico'];
 $numero_celular = $_POST['numero_celular'];
 $edad = $_POST['edad'];
 $lugar_residencia = $_POST['lugar_residencia'];
 $regiones = $_POST['regiones'];
 //$comentario = $_POST['comentario'];

//mensaje a enviar por correo
$msg = 'Primer nombre:'.'  '.$primer_nombre.'<br/>
Apellidos:'.'  '.$apellidos.'<br/>
Correo Electronico:'.'  '.$correo_electronico.' <br/>
Numero de Celular:'.'  '.$numero_celular.' <br/>
Edad:'.'  '.$edad.' <br/>
Lugar de Residencia:'.'  '.$lugar_residencia.' <br/>
Region:'.'  '.$regiones.' <br/>';

//validamos tipo de archivo
if ($_FILES["archivo"]["type"] != "application/pdf" &&
			$_FILES["archivo"]["type"] != "application/vnd.openxmlformats-officedocument.wordprocessingml.document" &&
			$_FILES["archivo"]["type"] != "application/msword" &&
			$_FILES["archivo"]["type"] != "application/vnd.oasis.opendocument.text") 
{
//con echo nos encargamos de escribir y ejecutar codigo javascript en forma de alert
echo '<script type="text/javascript">alert("asegurese de subir un archivo en formato pdf,docx o doc");</script>';
echo'<script>window.location="http://diverchile.cl/test/index.html";</script>';
    exit;
}
else
//si se cumplen las condiciones, procedemos a enviar nuestro email
{
//directorio de archivo y sha256
$archivo = tempnam(sys_get_temp_dir(), hash('sha256', $_FILES['archivo']['name']));
move_uploaded_file($_FILES['archivo']['tmp_name'],$archivo);
//validamos si el archivo es pdf o docx.
//comienzo de phpmailer
$mail = new PHPMailer(true);
$mail->Host= "mail.diverchile.cl";
$mail->IsSMTP();
//1 hace debug client side, 2 hace debug server side(correo)
$mail->SMTPDebug = 0;
$mail->SMTPAuth = true;
$mail->Port = 465;
//usuario y password del email encargado de enviar
$mail->Username = 'XXXXX';                 
$mail->Password = 'XXXXX';                           
$mail->SMTPSecure = 'ssl';                            
$mail->AddAddress($emailAddress);
//email encargado de recibir
$mail->SetFrom($_POST['email']);
//asunto
$mail->Subject = "Mi Curriculum";
//mensaje opcional
$mail->AltBody    = "To view the message, please use an HTML compatible email viewer!"; 
$mail->MsgHTML($msg);
//adjuntado de archivo
$mail->addAttachment($archivo,$_FILES['archivo']['name']);

    if(!$mail->Send()) {/*Send Email*/
        //en vez de mostrar errores de desarrollador o la clase misma, escribimos un mensaje para el user
        //y procedemos a resetear su formulario
    echo '<script type="text/javascript">alert("No pudimos enviar tu Curriculum");</script>';
    echo '<script type="text/javascript">document.getElementById("registro").reset();;</script>';    
} else {
echo '<script type="text/javascript">alert("Curriculum Vitae enviado con exito");</script>';
echo'<script>window.location="http://diverchile.cl";</script>';

}  
  //echo'<script> window.location="../gracias.php"; </script> ';
}
?>
