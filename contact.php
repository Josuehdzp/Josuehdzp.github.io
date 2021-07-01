<?php

if(!$_POST) exit;

// Verificación de la dirección de correo electrónico, no editar.
function isEmail($email) {
	return(preg_match("/^[-_.[:alnum:]]+@((([[:alnum:]]|[[:alnum:]][[:alnum:]-]*[[:alnum:]])\.)+(ad|ae|aero|af|ag|ai|al|am|an|ao|aq|ar|arpa|as|at|au|aw|az|ba|bb|bd|be|bf|bg|bh|bi|biz|bj|bm|bn|bo|br|bs|bt|bv|bw|by|bz|ca|cc|cd|cf|cg|ch|ci|ck|cl|cm|cn|co|com|coop|cr|cs|cu|cv|cx|cy|cz|de|dj|dk|dm|do|dz|ec|edu|ee|eg|eh|er|es|et|eu|fi|fj|fk|fm|fo|fr|ga|gb|gd|ge|gf|gh|gi|gl|gm|gn|gov|gp|gq|gr|gs|gt|gu|gw|gy|hk|hm|hn|hr|ht|hu|id|ie|il|in|info|int|io|iq|ir|is|it|jm|jo|jp|ke|kg|kh|ki|km|kn|kp|kr|kw|ky|kz|la|lb|lc|li|lk|lr|ls|lt|lu|lv|ly|ma|mc|md|me|mg|mh|mil|mk|ml|mm|mn|mo|mp|mq|mr|ms|mt|mu|museum|mv|mw|mx|my|mz|na|name|nc|ne|net|nf|ng|ni|nl|no|np|nr|nt|nu|nz|om|org|pa|pe|pf|pg|ph|pk|pl|pm|pn|pr|pro|ps|pt|pw|py|qa|re|ro|ru|rw|sa|sb|sc|sd|se|sg|sh|si|sj|sk|sl|sm|sn|so|sr|st|su|sv|sy|sz|tc|td|tf|tg|th|tj|tk|tm|tn|to|tp|tr|tt|tv|tw|tz|ua|ug|uk|um|us|uy|uz|va|vc|ve|vg|vi|vn|vu|wf|ws|ye|yt|yu|za|zm|zw)$|(([0-9][0-9]?|[0-1][0-9][0-9]|[2][0-4][0-9]|[2][5][0-5])\.){3}([0-9][0-9]?|[0-1][0-9][0-9]|[2][0-4][0-9]|[2][5][0-5]))$/i",$email));
}

if (!defined("PHP_EOL")) define("PHP_EOL", "\r\n");

$first_name     = $_POST['first_name'];
$last_name     = $_POST['last_name'];
$email    = $_POST['email'];
$phone   = $_POST['phone'];
$select_price   = $_POST['select_price'];
$select_service   = $_POST['select_service'];
$subject  = $_POST['subject'];
$comments = $_POST['comments'];
$verify   = $_POST['verify'];

if(trim($first_name) == '') {
	echo '<div class="error_message">Atención! Debe introducir tu nombre.</div>';
	exit();
}  else if(trim($email) == '') {
	echo '<div class="error_message">Atención! Introduzca una dirección de correo electrónico válida.</div>';
	exit();
} else if(!isEmail($email)) {
	echo '<div class="error_message">Atención! Ha introducido una dirección de correo electrónico inválida, inténtelo de nuevo.</div>';
	exit();
}

if(trim($comments) == '') {
	echo '<div class="error_message">Atención! Por favor escriba tu mensaje.</div>';
	exit();
}

if(get_magic_quotes_gpc()) {
	$comments = stripslashes($comments);
}


// Configuration option.
// Introduzca la dirección de correo electrónico a la que desea que se envíen los mensajes.
// Example $address = "joe.doe@yourdomain.com";

//$address = "example@themeforest.net";
$address = "delivetters.app@gmail.com";


// Configuration option.
// Por ejemplo, el asunto estándar aparecerá como: "Usted ha sido contactado por John Doe."

// Example, $e_subject = '$name . ' se ha puesto en contacto con usted a través de su sitio web.';

$e_subject = 'Has sido contactado por ' . $first_name . '.';


// Opción de configuración.
// Puede cambiar esto si cree que lo necesita.
// Desarrolladores, es posible que desee añadir más campos al formulario, en cuyo caso debe asegurarse de añadirlos aquí.

$e_body = "Has sido contactado por  $first_name. $first_name del sercicio seleccionado $select_service, su mensaje adicional es el siguiente. El presupuesto máximo del cliente es $select_price, para este proyecto." . PHP_EOL . PHP_EOL;
$e_content = "\"$comments\"" . PHP_EOL . PHP_EOL;
$e_reply = "Puede ponerse en contacto con $first_name por correo electrónico, $email o por teléfono $phone";

$msg = wordwrap( $e_body . $e_content . $e_reply, 70 );

$headers = "From: $email" . PHP_EOL;
$headers .= "Reply-To: $email" . PHP_EOL;
$headers .= "MIME-Version: 1.0" . PHP_EOL;
$headers .= "Content-type: text/plain; charset=utf-8" . PHP_EOL;
$headers .= "Content-Transfer-Encoding: quoted-printable" . PHP_EOL;

if(mail($address, $e_subject, $msg, $headers)) {

	// El correo electrónico se ha enviado con éxito, echo una página de éxito.

	echo "<fieldset>";
	echo "<div id='success_page'>";
	echo "<h1>Email enviado con éxito.</h1>";
	echo "<p>Gracias <strong>$first_name</strong>, su mensaje ha sido enviado a nosotros.</p>";
	echo "</div>";
	echo "</fieldset>";

} else {

	echo 'ERROR!';

}