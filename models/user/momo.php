<?php
function create_momo_url($order_id,$amount,$message) {

    $endpoint = MOMO_GATEWAY_URL;
    $partnerCode = MOMO_PARTNER_CODE;
    $accessKey = MOMO_ACCESS_KEY;
    $secretKey = MOMO_SECRET_KEY;
    $redirectUrl = MOMO_REDIRECT_URL;
    $orderId = $order_id;
    $orderInfo = $message;
    $ipnUrl = MOMO_IPN_URL;
    $extraData = "";
    $requestId = time() . "";
    $requestType = "payWithATM";
    $rawHash = "accessKey=" . $accessKey . "&amount=" . $amount . "&extraData=" . $extraData . "&ipnUrl=" . $ipnUrl . "&orderId=" . $orderId . "&orderInfo=" . $orderInfo . "&partnerCode=" . $partnerCode . "&redirectUrl=" . $redirectUrl . "&requestId=" . $requestId . "&requestType=" . $requestType;
    $signature = hash_hmac("sha256", $rawHash, $secretKey);
    $data = array(
        'partnerCode' => $partnerCode,
        'partnerName' => "Test",
        "storeId" => "MomoTestStore",
        'requestId' => $requestId,
        'amount' => $amount,
        'orderId' => $orderId,
        'orderInfo' => $orderInfo,
        'redirectUrl' => $redirectUrl,
        'ipnUrl' => $ipnUrl,
        'lang' => 'vi',
        'extraData' => $extraData,
        'requestType' => $requestType,
        'signature' => $signature
    );
    $result = execPostRequest($endpoint, json_encode($data));
    $jsonResult = json_decode($result, true);
    return $jsonResult['payUrl'];
}

function execPostRequest($url, $data)
{
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt(
        $ch,
        CURLOPT_HTTPHEADER,
        array(
            'Content-Type: application/json',
            'Content-Length: ' . strlen($data)
        )
    );
    curl_setopt($ch, CURLOPT_TIMEOUT, 5);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 5);
    //execute post
    $result = curl_exec($ch);
    //close connection
    curl_close($ch);
    return $result;
}

function check_callback_momo() {
    // Nhận dữ liệu từ Momo
    $data = $_REQUEST;
    if(empty($data)) return 0;

    // Lấy thông tin cần thiết
    $partnerCode = $data['partnerCode'];
    $orderId = $data['orderId'];
    $requestId = $data['requestId'];
    $amount = $data['amount'];
    $orderInfo = $data['orderInfo'];
    $orderType = $data['orderType'];
    $transId = $data['transId'];
    $resultCode = $data['resultCode']; // Trạng thái thanh toán
    $message = $data['message'];
    $payType = $data['payType'];
    $responseTime = $data['responseTime'];
    $extraData = $data['extraData'];
    $signature = $data['signature'];

    // Tạo chữ ký để xác thực
    $rawHash = "accessKey=" . MOMO_ACCESS_KEY .
               "&amount=" . $amount .
               "&extraData=" . $extraData .
               "&message=" . $message .
               "&orderId=" . $orderId .
               "&orderInfo=" . $orderInfo .
               "&orderType=" . $orderType .
               "&partnerCode=" . $partnerCode .
               "&payType=" . $payType .
               "&requestId=" . $requestId .
               "&responseTime=" . $responseTime .
               "&resultCode=" . $resultCode .
               "&transId=" . $transId;

    $expectedSignature = hash_hmac("sha256", $rawHash, MOMO_SECRET_KEY);
    // Kiểm tra chữ ký
    if ($signature  === $expectedSignature) {
        // Chữ ký hợp lệ, xử lý kết quả thanh toán
        if ($resultCode == '0') return 1;
        else return 2;
    }else return 0;
}