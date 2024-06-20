<?php
include_once "../config/DBUntil.php";
$errors = [];

require 'vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$mail = new PHPMailer(true);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (!isset($_POST['email']) || empty($_POST['email'])) {
        $errors['email'] = "Email is required";
    } elseif (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = "Invalid email format";
    } else {
        $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    }

    var_dump($email);
    if (empty($errors)) {
        date_default_timezone_set('Asia/Ho_Chi_Minh');
        $reset_token = bin2hex(random_bytes(32));

        $db = new DBUntil();
        $update_result = $db->update("user", [
            "reset_token" => $reset_token,
            "reset_token_expires" =>  date('Y-m-d H:i:s', strtotime('+1 hour'))
        ], "email = '$email'");

        if ($update_result) {
            // Construct reset link
            $reset_link = "http://localhost:3000/admin/reset-password.php?token=$reset_token";

            try {
                // Cấu hình máy chủ SMTP
                $mail->isSMTP();                                            // Sử dụng SMTP
                $mail->Host       = 'smtp.gmail.com';                       // Máy chủ SMTP của Gmail
                $mail->SMTPAuth   = true;                                   // Bật xác thực SMTP
                $mail->Username   = 'ngthanhvu205@gmail.com';                 // Địa chỉ email của bạn
                $mail->Password   = 'ncyp agwy mzvc zrwk';                        // Mật khẩu email của bạn
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         // Bật mã hóa TLS
                $mail->Port       = 587;                                    // Cổng TCP cho TLS

                // Người gửi
                $mail->setFrom('Bot@php1.com', 'Bot');

                // Người nhận
                $mail->addAddress($email, 'User Name');     // Thêm người nhận

                // Nội dung email
                $mail->isHTML(true);                                  // Đặt định dạng email là HTML
                $mail->Subject = 'Forgot password';
                $mail->Body    = '
                <table cellpadding="0" cellspacing="0" width="100%" bgcolor="#f9f9f9">
                <tr>
                    <td align="center" style="padding: 40px 0;">
                        <table cellpadding="0" cellspacing="0" width="600" style="background-color: #ffffff; border-radius: 8px; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
                            <tr>
                                <td align="center" style="padding: 40px 20px;">
                                    <h1 style="margin-bottom: 20px;">Forgot Password</h1>
                                    <p style="margin-bottom: 20px;">You recently requested to reset your password for your account. Click the button below to reset it.</p>
                                    <a href="' . $reset_link . '" style="display: inline-block; padding: 12px 24px; background-color: #007bff; color: #ffffff; text-decoration: none; border-radius: 4px;">Reset Password</a>
                                    <p style="margin-top: 20px;">If you did not request a password reset, please ignore this email or contact support.</p>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
                ';
                $mail->AltBody = 'End.';

                // Gửi email
                $mail->send();
                echo 'Message has been sent';
            } catch (Exception $e) {
                echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
            }
        } else {
            $errors['database'] = "An error occurred. Please try again later.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Bootstrap Example</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body>

    <div class="container mt-3">
        <h2>Reset password</h2>
        <form action="forgot-password.php" method="post">
            <div class="mb-3 mt-3">
                <label for="email">Email:</label>
                <input type="text" class="form-control" id="email" placeholder="Enter email" name="email">
                <?php
                if (isset($errors['email'])) {
                    echo "<p class='text-danger'>" . $errors['email'] . "</p>";
                }
                ?>
            </div>
            <button type="submit" class="btn btn-primary">Reset</button>
        </form>
    </div>

</body>

</html>