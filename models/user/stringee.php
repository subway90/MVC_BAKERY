<?php

include 'Stringee/StringeeCurlClient.php';


/**
 * Hàm này dùng để gọi voice gửi otp đến số điện thoại
 * @param string $to Số điện thoại người nhận
 * @param string $otp Mã otp
 * @return void trạng thái của cuộc gọi
 */
function stringee_send_otp($to,$otp) {
    // lấy key
    $keySid = STRINGEE_SID_KEY;
    $keySecret = STRINGEE_SECRET_KEY;
    // chỉnh sửa số điện thoại về dạng '84xxxxxxxx'
    $to = substr($to,1); // xoá kí tự đầu chuỗi
    $to = '84'.$to; // thểm kí tự 84 vào đầu số

    $curlClient = new StringeeCurlClient($keySid, $keySecret);
    $url = 'https://api.stringee.com/v1/call2/callout';

    $data = '{
        "from": {
            "type": "external",
            "number": "'.STRINGEE_PHONE.'",
            "alias": "'.STRINGEE_PHONE.'"
        },
        
        "to": [{
            "type": "external",
            "number": "'.$to.'",
            "alias": "'.$to.'"
        }],
    
        "actions": [
            {
                "action": "talk",
                "text": "Mã xác thực của bạn là: '.implode(';', str_split($otp)).'",
                "voice": "hn_female_thutrang_phrase_48k-hsmm",
                "loop": '.STRINGEE_LOOP_VOICE.',
                "speed": '.STRINGEE_SPEED_VOICE.',
            }

        ]
    }';

    $resJson = $curlClient->post($url, $data, 15);
    $status = json_decode($resJson->getStatusCode());

    // print result API Server Stringee return
    // $content = $resJson->getContent();
    // echo '$status: ' . $status . '<br>';
    // echo '$content: ' . $content . '<br>';

    if($status != '200') die('Chức năng gọi voice gửi OTP bị gián đoạn, vui lòng thử lại sau ! <br><a href="'.URL.'">&rarr; Quay về Trang chủ</a>');
}




