<?php

# [DATA]
$data = [
    "vnpay" => [
        "number" => "9704198526191432198",
        "name" => "NGUYEN VAN A",
        "date" => "07/15",
        "otp" => 123456,
        "docs" => "https://sandbox.vnpayment.vn/apis/vnpay-demo/"
    ],
    "momo" => [
        "number" => "9704000000000018",
        "name" => "NGUYEN VAN A",
        "date" => "03/07",
        "otp" => "OTP",
        "docs" => "https://developers.momo.vn/v3/vi/docs/payment/onboarding/test-instructions/#th%C3%B4ng-tin-test-th%E1%BA%BB-atm"
    ]
];

# [RENDER]
view_json(200,$data);