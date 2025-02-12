<?php


/**
 * Hàm này tạo url dẫn đến trang thanh toán vnpay
 * @param string $id_order Mã hoá đơn
 * @param string $amount Số tiền
 * @param string $message Nội dung
 * @return string url thanh toán
 */
function create_vnpay_url($id_order,$amount,$message) {
    // cấu hình vnpay
    error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED);
    $id_order = $_SESSION['checkout']['id_order'];
    $vnp_Amount = $amount * 100;
    $vnp_IpAddr = $_SERVER['REMOTE_ADDR'];
    $vnpUrl = VNPAY_URL_SANDBOX;
    // mảng data vnpay
    $vnpData = [
        "vnp_Version" => "2.1.0",
        "vnp_TmnCode" => VNPAY_TMNCODE,
        "vnp_Amount" => $vnp_Amount,
        "vnp_Command" => "pay",
        "vnp_CreateDate" => date('YmdHis'),
        "vnp_CurrCode" => "VND",
        "vnp_IpAddr" => $_SERVER['REMOTE_ADDR'],
        "vnp_Locale" => "vn",
        "vnp_OrderInfo" => 'Thanh toán hoá đơn ' . $id_order,
        "vnp_OrderType" => "other",
        "vnp_ReturnUrl" => VNPAY_URL_RETURN,
        "vnp_TxnRef" => $id_order,
        "vnp_ExpireDate" => date('YmdHis', strtotime('+15 minutes', strtotime(date("YmdHis")))),
    ];
    // code xử lí tạo url vnpay
    ksort($vnpData);
    $queryString = http_build_query($vnpData);
    $vnp_SecureHash = hash_hmac('sha512', $queryString, VNPAY_HASHKEY);
    $vnpUrl .= "?" . $queryString . '&vnp_SecureHash=' . $vnp_SecureHash;

    return $vnpUrl;
}

/**
 * Hàm này để kiểm tra GET Vnpay callback có chính xác không
 * @param array $data Mảng dữ liệu $_GET
 * @return int trạng thái, nếu null là sai GET_, 1: thành công, 2: thất bại
 */
function check_callback_vnpay($data) {
    if (isset($_GET['vnp_SecureHash']) && $_GET['vnp_SecureHash']) {
        // xử lí
        $vnp_SecureHash = $_GET['vnp_SecureHash'];
        $vnpData = array();
        foreach ($_GET as $key => $value) {
            if (substr($key, 0, 4) == "vnp_") $vnpData[$key] = $value;
        }
        // bỏ phần tử vnp_SecureHash
        unset($vnpData['vnp_SecureHash']);
        // tạo mã hash
        ksort($vnpData);
        $queryString = http_build_query($vnpData);
        $secureHash = hash_hmac('sha512', $queryString, VNPAY_HASHKEY);
        
        // Request call-back trả về hợp lệ
        if ($secureHash == $vnp_SecureHash) {
            // Xét trạng thái thanh toán VNPAY trả về
            if ($_GET['vnp_ResponseCode'] == '00') return 1;
            else return 2;
        }
    }
    return 0;

}