<?php
date_default_timezone_set('Asia/Ho_Chi_Minh');

include_once "config/DBUntil.php";
include_once "config/mailconfig.php";

$vnp_HashSecret = "51CNF74EOXHO7VEELB0W6Z8P6PI8G4MZ";

if (isset($_GET['vnp_SecureHash']) && isset($_GET['vnp_TxnRef']) && isset($_GET['vnp_ResponseCode'])) {
    $vnp_SecureHash = $_GET['vnp_SecureHash'];
    unset($_GET['vnp_SecureHashType']);
    unset($_GET['vnp_SecureHash']);
    ksort($_GET);
    $hashData = "";
    foreach ($_GET as $key => $value) {
        $hashData .= '&' . urlencode($key) . '=' . urlencode($value);
    }
    $hashData = trim($hashData, '&');

    $secureHash = hash_hmac('sha512', $hashData, $vnp_HashSecret);

    if ($secureHash === $vnp_SecureHash) {
        $order_id = $_GET['vnp_TxnRef'];
        $vnp_ResponseCode = $_GET['vnp_ResponseCode'];

        $db = new DBUntil();
        $mailer = new Mailer();

        $getOrderid = $db->select("SELECT * FROM orders WHERE id = $order_id");
        $getOrderid = $getOrderid[0];
        $getUserid = $db->select("SELECT * FROM user WHERE id = $getOrderid[user_id]");
        $getUserid = $getUserid[0];
        $userName = $getUserid['fullname'];
        $userMail = $getUserid['email'];

        if ($vnp_ResponseCode == '00') {
            global $Mailer;
            $status = 'thành công';
            $subject = 'Xac nhan don hang';
            $body = '
            <table cellpadding="0" cellspacing="0" width="100%" bgcolor="#f9f9f9">
                <tr>
                    <td align="center" style="padding: 40px 0;">
                        <table cellpadding="0" cellspacing="0" width="600" style="background-color: #ffffff; border-radius: 8px; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
                            <tr>
                                <td align="center" style="padding: 40px 20px;">
                                    <h1 style="margin-bottom: 20px; color: ##28a745">Đặt hàng thành công</h1>
                                    <p style="margin-bottom: 20px;"></p>
                                    <a href="http://localhost:3000/history.php" style="display: inline-block; padding: 12px 24px; background-color: #007bff; color: #ffffff; text-decoration: none; border-radius: 4px;">Xem lịch sử đơn hàng</a>
                                    <p style="margin-top: 20px;">Cảm ơn bạn đã mua hàng!</p>
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
            ';
            $mailer->sendMail($userMail, $subject, $body, $userMail, 'ShopMall');
        } else {
            $status = 'thất bại';
        }

        if ($db->update("orders", ['status' => $status], "id = $order_id")) {
            $remove = $db->select("SELECT * FROM cart");
            if (!empty($remove)) {
                $removes = $remove[0]['id'];
                $db->delete("cart", "id = $removes");
            }

            header("Location: thankyou.php");
            exit();
        } else {
            echo "Error updating order status";
        }
    } else {
        echo "Invalid signature";
    }
} else {
    echo "Missing required parameters";
}
