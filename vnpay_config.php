<?php
define("VNPAY_TMN_CODE", "9FHQFJV7");
define("VNPAY_HASH_SECRET", "51CNF74EOXHO7VEELB0W6Z8P6PI8G4MZ");
define("VNPAY_URL", "https://sandbox.vnpayment.vn/paymentv2/vpcpay.html");
define("VNPAY_RETURN_URL", "http://localhost:3000/vnpay_return.php");

function convertToDateTime($dateString)
{
    // Tạo đối tượng DateTime với định dạng yyyyMMddHHmmss và đặt múi giờ GMT+7
    $dateTime = DateTime::createFromFormat('YmdHis', $dateString, new DateTimeZone('Asia/Bangkok')); // GMT+7

    if ($dateTime === false) {
        return "Invalid date format.";
    } else {
        return $dateTime;
    }
}
class PaymentService
{
    static public function createUrlPayment($orderId, $total)
    {
        var_dump(array($orderId, $total));
        $vnp_TmnCode = VNPAY_TMN_CODE; // Mã website tại VNPAY
        $vnp_HashSecret = VNPAY_HASH_SECRET; // Chuỗi bí mật
        $vnp_Url = VNPAY_URL; // URL API của VNPAY
        $vnp_Returnurl = VNPAY_RETURN_URL; // URL callback sau khi thanh toán

        $vnp_TxnRef = $orderId; // Mã đơn hàng
        $vnp_OrderInfo = 'Thanh toan don hang test' . $orderId;
        $vnp_OrderType = 'billpayment';
        $vnp_Amount = $total * 100; // Số tiền thanh toán, đơn vị là VND
        $vnp_Locale = 'vn';
        $vnp_IpAddr = $_SERVER['REMOTE_ADDR'];
        $date = new DateTime("now", new DateTimeZone('Asia/Bangkok'));
        $vnp_CreateDate = $date->format('YmdHis');
        $inputData = array(
            "vnp_Version" => "2.1.0",
            "vnp_TmnCode" => $vnp_TmnCode,
            "vnp_Amount" => $vnp_Amount,
            "vnp_Command" => "pay",
            "vnp_CreateDate" => $vnp_CreateDate,
            "vnp_CurrCode" => "VND",
            "vnp_IpAddr" => $vnp_IpAddr,
            "vnp_Locale" => $vnp_Locale,
            "vnp_OrderInfo" => $vnp_OrderInfo,
            "vnp_OrderType" => $vnp_OrderType,
            "vnp_ReturnUrl" => $vnp_Returnurl,
            "vnp_TxnRef" => $vnp_TxnRef,
        );

        ksort($inputData);
        $query = "";
        $i = 0;
        $hashdata = "";
        foreach ($inputData as $key => $value) {
            if ($i == 1) {
                $hashdata .= '&' . urlencode($key) . "=" . urlencode($value);
            } else {
                $hashdata .= urlencode($key) . "=" . urlencode($value);
                $i = 1;
            }
            $query .= urlencode($key) . "=" . urlencode($value) . '&';
        }

        $vnp_Url = $vnp_Url . "?" . $query;
        if (isset($vnp_HashSecret)) {
            $vnpSecureHash = hash_hmac('sha512', $hashdata, $vnp_HashSecret);
            $vnp_Url .= 'vnp_SecureHash=' . $vnpSecureHash;
        }

        echo $vnp_Url;
        // die;

        header('Location: ' . $vnp_Url);
        exit();
    }
}
