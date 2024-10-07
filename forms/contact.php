<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';  // Assurez-vous que PHPMailer est correctement installé

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $name = htmlspecialchars(trim($_POST['name']));
  $email = htmlspecialchars(trim($_POST['email']));
  $subject = htmlspecialchars(trim($_POST['subject']));
  $message = htmlspecialchars(trim($_POST['message']));

  if (!empty($name) && !empty($email) && !empty($subject) && !empty($message)) {
    $mail = new PHPMailer(true);

    try {
      // Paramètres SMTP
      $mail->isSMTP();
      $mail->Host = 'smtp.mail.us-east-1.awsapps.com';  // Serveur SMTP de WorkMail
      $mail->SMTPAuth = true;
      $mail->Username = 'contact@piscismart.com';  // Ton adresse email WorkMail
      $mail->Password = 'Piscismart@2023';  // Mot de passe WorkMail
      $mail->SMTPSecure = 'tls';  // Encryption TLS
      $mail->Port = 587;  // Port SMTP sécurisé

      // Paramètres de l'e-mail
      $mail->setFrom('contact@piscismart.com', 'piscismart');  // Expéditeur
      $mail->addAddress('contact@piscismart.com');  // Destinataire

      // Contenu du message
      $mail->isHTML(true);
      $mail->Subject = $subject;
      $mail->Body = "<strong>Nom:</strong> $name<br><strong>Email:</strong> $email<br><strong>Message:</strong><br>$message";
      $mail->AltBody = "Nom: $name\nEmail: $email\nMessage: $message";

      // Essayer d'envoyer l'email
      if ($mail->send()) {
        echo 'Le message a été envoyé avec succès.';
      } else {
        echo 'Erreur lors de l\'envoi du message.';
      }
    } catch (Exception $e) {
      echo "Erreur SMTP: {$mail->ErrorInfo}";
    }
  } else {
    echo 'Veuillez remplir tous les champs du formulaire.';
  }
} else {
  echo 'Le formulaire n\'a pas été soumis.';
}
