<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

function send_mail($to,$subject,$content) {
    // Gửi mail
    require_once 'PHPMailer/src/Exception.php';
    require_once 'PHPMailer/src/PHPMailer.php';
    require_once 'PHPMailer/src/SMTP.php';
    $mail = new PHPMailer(true);
    try {
        $mail->SMTPSecure = MAILER_SMTP;
        $mail->Host = MAILER_HOST;
        $mail->Port = MAILER_PORT;
        $mail->Username = MAILER_USERNAME;
        $mail->Password = MAILER_PASSWORD;
        $mail->SMTPKeepAlive = true;
        $mail->Mailer = "smtp";
        $mail->IsSMTP();
        $mail->SMTPAuth = true;
        $mail->CharSet = 'utf-8';
        $mail->SMTPDebug = 0;

        //Recipients
        $mail->setFrom(MAILER_USERNAME, MAILER_YOURNAME);
        $mail->addAddress($to, 'John Doe');

        // Content
        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body = $content;
        $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
        $mail->send();
    } catch (Exception $e) {
        die("Lỗi gửi mail : {$mail->ErrorInfo}");
    }
}

/**
 * Hàm này trả về giao diện thanh toán
 * @param array $data_checkout mảng dữ liệu hoá đơn
 * @return string
 */
function content_checkout($data_checkout)
{
    // giải nén mảng 
    extract($data_checkout);
    // tạo row giỏ hàng
    $row_cart = "";
    $i = 0;
    foreach ($list_cart as $row) {
        extract($row);
        $i++;
        $total_product = $price_product * $quantity_product_in_cart;
        $row_cart .= "
        <tr>
            <td>$i</td>
            <td>" . $name_product . "</td>
            <td>" . $quantity_product_in_cart . "</td>
            <td>" . number_format( $price_product) . " VNĐ</td>
            <td>" . number_format($total_product) . " VNĐ</td>
        </tr>";
    }
    return "
<!DOCTYPE html>
<html lang='vi'>
<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0 20%;
            background-color: #f4f4f4;
        }
        .invoice-container {
            background-color: #ffffff;
            border-radius: 5px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
        }
        .header {
            background-color: #ffcc00; /* Màu vàng cam */
            padding: 20px 20%;
            border-radius: 5px;
            text-align: center;
            margin-bottom: 20px;
        }
        .header h2 {
            margin: 12px 0;
            font-size: 24px;
        }
        .header p {
            margin: 5px 0;
            font-size: 14px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        tr:hover {
            background-color: #f1f1f1;
        }
        .info {
            display: flex;
            justify-content:space-between;
            margin: 4px 0;
        }
        .info .head-info {
            font-weight: bold;
            margin-right: 5px;
        }
    </style>
</head>
<body>
    <div class='invoice-container'>
        <div class='header'>
            <h2>Thông Tin Hoá Đơn</h2>
            <div class='info'>
                <div class='head-info'>Mã đơn hàng:</div>
                <div class='body-info'> " . $id_order . "</div>
            </div>
            <div class='info'>
                <div class='head-info'>Địa chỉ giao hàng:</div>
                <div class='body-info'> " . $address_order . "</div>
            </div>
            <div class='info'>
                <div class='head-info'>Ghi chú đơn hàng:</div>
                <div class='body-info'> " . $note_order . "</div>
            </div>
            <div class='info'>
                <div class='head-info'>Tổng tiền:</div>
                <div class='body-info'> " . number_format($total_cart) . " VNĐ</div>
            </div>
            <div class='info'>
                <div class='head-info'>Phương thức thanh toán:</div>
                <div class='body-info'> " . $method_payment . " </div>
            </div>
        </div>
        <table>
            <thead>
                <tr>
                    <th>STT</th>
                    <th>Tên sản phẩm</th>
                    <th>Số lượng</th>
                    <th>Giá</th>
                    <th>Thành tiền</th>
                </tr>
            </thead>
            <tbody>" . $row_cart . " </tbody>
        </table>
    </div>
</body>
</html>";

}