<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php'; // Pastikan file ini ada di folder "github"

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $subject = htmlspecialchars($_POST['subject']);
    $message = nl2br(htmlspecialchars($_POST['message']));

    $mail = new PHPMailer(true);
    $response = [];

    try {
        // Konfigurasi SMTP Gmail
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'rudiroyjaya.id@gmail.com'; // Email kamu
        $mail->Password   = 'wpsg qreb vdzg amqx'; // App Password Gmail
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587;

        // Pengaturan pengirim dan penerima
        $mail->setFrom($email, $name); // Menampilkan email klien sebagai pengirim
        $mail->addReplyTo($email, $name); // Jika dibalas, akan ke email pengirim form
        $mail->addAddress('rudiroyjaya.id@gmail.com'); // Penerima email kamu

        // Konten email yang lebih menarik
        $mail->isHTML(true);
        $mail->Subject = "" . htmlspecialchars($subject);
        $mail->Body    = "
            <div style='font-family: Arial, sans-serif; line-height: 1.6; padding: 20px; border: 1px solid #ddd; border-radius: 8px; background: #f9f9f9;'>
                <h2 style='color: #2C3E50;'>📧 Pesan Baru dari Website</h2>
                <p><strong>Nama:</strong> $name</p>
                <p><strong>Email:</strong> <a href='mailto:$email' style='color: #2980b9; text-decoration: none;'>$email</a></p>
                <p><strong>Subjek:</strong> $subject</p>
                <p><strong>Pesan:</strong></p>
                <div style='padding: 10px; background: #fff; border-left: 4px solid #2980b9;'>
                    $message
                </div>
                <br>
                <p style='font-size: 12px; color: #777;'>Email ini dikirim melalui formulir kontak website.</p>
            </div>";

        $mail->send();
        echo "<script>
            sessionStorage.setItem('successMessage', 'Your message has been sent. Thank you!');
            window.location.href = 'contact.html';
        </script>";
    } catch (Exception $e) {
        echo "<script>
            sessionStorage.setItem('errorMessage', 'Failed to send email: {$mail->ErrorInfo}');
            window.location.href = 'contact.html';
        </script>";
    }
} else {
    echo "<script>
        sessionStorage.setItem('errorMessage', 'Metode pengiriman tidak valid!');
        window.location.href = 'contact.html';
    </script>";
}
