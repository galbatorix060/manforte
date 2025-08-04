<?php
$to = "galbatorix060@gmail.com"; // CAMBIA con la tua email di destinazione
$subject = "Nuova candidatura da sito Manforte";

$nomeCognome = htmlspecialchars($_POST['nomeCognome']);
$email = htmlspecialchars($_POST['email']);
$telefono = htmlspecialchars($_POST['telefono']);
$posizione = htmlspecialchars($_POST['posizione']);

$boundary = md5(uniqid(time()));
$headers = "From: $email\r\n";
$headers .= "Reply-To: $email\r\n";
$headers .= "MIME-Version: 1.0\r\n";
$headers .= "Content-Type: multipart/mixed; boundary=\"$boundary\"\r\n";

$body = "--$boundary\r\n";
$body .= "Content-Type: text/plain; charset=utf-8\r\n\r\n";
$body .= "Hai ricevuto una nuova candidatura dal sito.\n\n";
$body .= "Nome e Cognome: $nomeCognome\n";
$body .= "Email: $email\n";
$body .= "Telefono: $telefono\n";
$body .= "Posizione: $posizione\n\n";

// Allegato 1: foto
if (isset($_FILES['foto']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK) {
    $fileTmp = $_FILES['foto']['tmp_name'];
    $fileName = $_FILES['foto']['name'];
    $fileType = mime_content_type($fileTmp);
    $fileData = chunk_split(base64_encode(file_get_contents($fileTmp)));

    $body .= "--$boundary\r\n";
    $body .= "Content-Type: $fileType; name=\"$fileName\"\r\n";
    $body .= "Content-Transfer-Encoding: base64\r\n";
    $body .= "Content-Disposition: attachment; filename=\"$fileName\"\r\n\r\n";
    $body .= "$fileData\r\n";
}

// Allegato 2: curriculum
if (isset($_FILES['curriculum']) && $_FILES['curriculum']['error'] === UPLOAD_ERR_OK) {
    $fileTmp = $_FILES['curriculum']['tmp_name'];
    $fileName = $_FILES['curriculum']['name'];
    $fileType = mime_content_type($fileTmp);
    $fileData = chunk_split(base64_encode(file_get_contents($fileTmp)));

    $body .= "--$boundary\r\n";
    $body .= "Content-Type: $fileType; name=\"$fileName\"\r\n";
    $body .= "Content-Transfer-Encoding: base64\r\n";
    $body .= "Content-Disposition: attachment; filename=\"$fileName\"\r\n\r\n";
    $body .= "$fileData\r\n";
}

$body .= "--$boundary--";

if (mail($to, $subject, $body, $headers)) {
    echo "✅ Candidatura inviata con successo.";
} else {
    echo "❌ Errore durante l'invio della candidatura.";
}
?>
