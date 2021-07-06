<?php
 
if($_POST) {
    $visitor_name = "";
    $visitor_email = "";
    $email_title = "";
    $concerned_department = "";
    $visitor_message = "";
     
    $first_name = $_POST['first_name'];
    $last_name     = $_POST['last_name'];
    $email    = $_POST['email'];
    $phone   = $_POST['phone'];
    $select_price   = $_POST['select_price'];
    $select_service   = $_POST['select_service'];
    $subject  = $_POST['subject'];
    $comments = $_POST['comments'];
    $verify   = $_POST['verify'];

    if(isset($_POST['first_name'])) {
      $first_name = filter_var($_POST['first_name'], FILTER_SANITIZE_STRING);
    }
     
    if(isset($_POST['email'])) {
        $email = str_replace(array("\r", "\n", "%0a", "%0d"), '', $_POST['email']);
        $email = filter_var($email, FILTER_VALIDATE_EMAIL);
    }
     
    if(isset($_POST['comments'])) {
        $comments = htmlspecialchars($_POST['comments']);
    }
     
    $address = "delivetters.app@gmail.com";
    $e_subject = 'Has sido contactado por ' . $first_name . '.';

    $e_body = "Has sido contactado por  $first_name. $first_name del sercicio seleccionado $select_service, su mensaje adicional es el siguiente para este proyecto." . PHP_EOL . PHP_EOL;
    $e_content = "\"$comments\"" . PHP_EOL . PHP_EOL;
    $e_reply = "Puede ponerse en contacto con $first_name por correo electrónico, $email o por teléfono $phone";
 

    $msg = wordwrap( $e_body . $e_content . $e_reply, 70 );

    $headers = "From: $email" . PHP_EOL;
    $headers .= "Reply-To: $email" . PHP_EOL;
    $headers .= "MIME-Version: 1.0" . PHP_EOL;
    $headers .= "Content-type: text/plain; charset=utf-8" . PHP_EOL;
    $headers .= "Content-Transfer-Encoding: quoted-printable" . PHP_EOL;
         
    if(mail($address,$e_subject, $msg, $headers)) {
        echo "<p>Thank you for contacting us, $first_name. You will get a reply within 24 hours.</p>";
    } else {
        echo '<p>We are sorry but the email did not go through.</p>';
    }
     
} else {
    echo '<p>Something went wrong</p>';
}
 
?>