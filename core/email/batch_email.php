 
<?php
include("sendemail_campaign.php"); //Mando a llamar la funcion que se encarga de enviar el correo electronico

# Nuestra base de datos
require_once "config/bd.php";
/*===============================================
Cuando se envian datos de contacto desde la pagina de telemetry
===============================================*/
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);


if ($_SERVER['REQUEST_METHOD'] == "POST") {

	$data = json_decode(file_get_contents('php://input'), true);
	/*Configuracion de variables para enviar el correo*/
	$server_mail_user = "notifications@goldenluxurydev.com"; //Correo electronico saliente ejemplo: tucorreo@gmail.com
	$server_mail_password = "4dm1n-Mb3"; //Tu contraseña de gmail
	$template = "template2.html"; //Ruta de la plantilla HTML para enviar nuestro mensaje

	/*Inicio captura de datos enviados por $_POST para enviar el correo */
	$subject =  '🚨 ' . 'Una oferta que parece imposible - Golden Luxury Huatulco.';

	# Obtener base de datos
	$bd = obtenerBD();
	# Obtener clientes de BD
	$sql = "select  * from campaing_mails where active=1 and dispached=0";
	$sentencia = $bd->prepare($sql, [
		PDO::ATTR_CURSOR => PDO::CURSOR_SCROLL,
	]);
	$sentencia->execute();

	while ($clientMail = $sentencia->fetchObject()) {
		# Obtener los datos de la base de datos
		$client = new stdClass();
		$client->id = $clientMail->id;
		$client->recipient = $clientMail->email;

		$response = sendEmail(
			$server_mail_user,
			$server_mail_password,
			$client,
			$subject,
			$template
		);

		
		if ($response['status'] == 200) {

			$sentenciaUpdate = $bd->prepare("UPDATE campaing_mails SET dispached = ? WHERE id = ? AND email = ?");
			$sentenciaUpdate->bindValue(1, 1);
			$sentenciaUpdate->bindValue(2, $client->id);
			$sentenciaUpdate->bindValue(3, $client->recipient);
			if ($sentenciaUpdate->execute()) {
				$response['bd'] = "Campo dispached actualizado en bd";
				 echo json_encode($response, http_response_code($response['status']));
			} else {
				 echo json_encode($response, http_response_code($response['status']));
			}
		}
	}
}

if ($_SERVER['REQUEST_METHOD'] == "GET" && strpos($uri, '/v1.0/history/track')) {
	$idRecipient = trim($_GET['recipient']);
	# Obtener base de datos
	$bd = obtenerBD();
	$sentencia = $bd->prepare("UPDATE campaing_mails SET viewed = ? WHERE email = ?");
	$sentencia->bindValue(1, 1);
	$sentencia->bindValue(2, $idRecipient);

	if ($sentencia->execute()) {
		$respuesta = "https://goldenluxurydev.com/storage/marketing/images/logo.png";
	} else {
		$respuesta = "https://goldenluxurydev.com/storage/marketing/images/logo.png";
	}
	echo $respuesta;
	exit;
}
?>