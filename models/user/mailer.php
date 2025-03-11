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
    $total_cart = number_format($total_cart);
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
    return
<<<HTML
<!DOCTYPE html>
<html lang='vi'>
<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <style>
        body {
            font-family: Verdana, sans-serif	;
            margin: 0;
            background-color: #f4f4f4;
        }
        .invoice-container {
            background-color: #ffffff;
            border-radius: 5px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            padding: 12px;
        }
        .header {
            background-color: #ffcc00;
            padding: 20px;
            border-radius: 5px;
            text-align: center;
            margin-bottom: 20px;
        }
        .header h2 {
            margin: 24px 0;
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
            font-size: 12px;
        }
        th, td {
            border: 1px solid  #00000020;
            padding: 10px;
            text-align: center;
        }
        th {
            background-color: #ffcc0050;
        }
        .head-info {
            font-weight: bold;
            text-align: start;
        }
        .body-info {
            margin-left: 6px;
            text-align: end;
        }
    </style>
</head>
<body>
    <div class='invoice-container'>
        <div class='header'>
            <h2>Thông Tin Hoá Đơn</h2>
            <table  >
                <tr>
                    <td class='head-info'>Mã đơn hàng:</td>
                    <td class='body-info'> {$id_invoice}</td>
                </tr>
                <tr>
                    <td class='head-info'>Địa chỉ giao hàng:</td>
                    <td class='body-info'> {$address_invoice}</td>
                </tr>
                <tr>
                    <td class='head-info'>Ghi chú đơn hàng:</td>
                    <td class='body-info'> {$note_invoice}</td>
                </tr>
                <tr>
                    <td class='head-info'>Tổng tiền:</td>
                    <td class='body-info'>{$total_cart} VNĐ</td>
                </tr>
                <tr>
                    <td class='head-info'>Phương thức thanh toán:</td>
                    <td class='body-info'>{$method_payment}</td>
                </tr>
            </table>
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
            <tbody>{$row_cart}</tbody>
        </table>
    </div>
</body>
</html>
HTML;
}