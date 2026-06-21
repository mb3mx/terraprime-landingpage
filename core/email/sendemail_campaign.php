<?php
require 'PHPMailer/PHPMailerAutoload.php';


function sendEmail(
	$server_mail_user,
	$server_mail_password,
	$client,
	$subject,
	$template
) {
	// Configuración servidor SMTP
	$mail = new PHPMailer;
	$mail->isSMTP();                            // Set mailer to use SMTP
	$mail->SMTPDebug = false;
	$mail->Host = 'goldenluxurydev.com';             // Especificar el servidor de correo a utilizar 
	$mail->SMTPAuth = true;                     // Habilitar la autenticacion con SMTP
	$mail->Username = $server_mail_user;        // Correo electronico saliente ejemplo: tucorreo@gmail.com
	$mail->Password = $server_mail_password;    // Tu contraseña de gmail
 	$mail->Port = 587;

	/**Introduzca la dirección de la que debe aparecer el correo electrónico.
	 * Puede utilizar cualquier dirección que el servidor SMTP acepte como válida. 
	 * El segundo parámetro opcional para esta función es el nombre que se mostrará como el remitente
	 * en lugar de la dirección de correo electrónico en sí.
	 **/
	$mail->setFrom("notifications@goldenluxurydev.com", "Golden Luxury Huatulco");
	/**Introduzca la dirección de la que debe responder.
	 * El segundo parámetro opcional para esta función es el nombre que se mostrará para responder
	 **/
	$mail->addReplyTo("ventas@goldenluxurydev.com");

	// Quien lo recibe
	$mail->addAddress($client->recipient);   // Agregar quien recibe el e-mail enviado

	$mail->addCustomHeader('MIME-Version: 1.0');
	$urlApi = "https://goldenluxurydev.com/core/email/batch_email.php/v1.0/history/track?id=" . $client->id . "&recipient=" . $client->recipient;


	// Contenido
	$message = file_get_contents($template);
	$message = str_replace('{{name_api}}', $urlApi, $message);
	$mail->isHTML(true);  // Establecer el formato de correo electrónico en HTML

	$mail->Subject = $subject;
	$mail->msgHTML($message);
	// Activa la condificacción utf-8
	$mail->CharSet = 'UTF-8';

	if ($mail->send()) {
		$json = array(
			'status' => 200,
			'message' => "Correo enviado correctamente "
		);
	} else {
		$json = array(
			'status' => 409,
			'message' => "Ocurrió un error al enviar el correo."
		);
	}

	return $json;
}
