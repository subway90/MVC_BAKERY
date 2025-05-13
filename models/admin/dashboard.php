<?php

/**
 * Trả về doanh thu theo từng loại
 * @param string $type :
 * 
 * today : Hôm nay
 * 
 * yesterday : Hôm qua
 * 
 * this week : Tuần này
 * 
 * last week : Tuần trước
 * 
 * this month : Tháng này
 * 
 * last month : Tháng trước
 * 
 * @return int Doanh thu (VNĐ)
 */
function revenue($type) {

    // key truy vấn
    $arr_type = [
        'today',
        'yesterday',
        'this week',
        'last week',
        'this month',
        'last month',
    ];

    // check key truy vấn, nếu không trùng -> báo lỗi 404
    if(!in_array($type,$arr_type)) view_error(404);

    
    // CURDATE  : truy vấn ngày hôm nay
    // WEEKDAY  : truy vấn chỉ số của ngày trong tuần (với thứ 2 = 0, chủ nhật = 6)
    // DATE_SUB : giảm ngày
    // DATE_ADD : tăng ngày
    // INTERVAL : khoảng giá trị bạn muốn thêm (tương đương +- khi đi với hàm tăng giảm như DATE_SUB, DATE_ADD)

    // truy vấn hôm nay
    if($type === 'today') {
        $query_date = 'date(i.created_at) = CURDATE()';
    }
    // truy vấn ngày hôm qua
    elseif($type === 'yesterday') {
        $query_date = 'date(i.created_at) = CURDATE() - INTERVAL 1 DAY';
    }
    
    // truy vấn tuần này => từ thứ 2 tuần này -> chủ nhật tuần này
    else if($type === 'this week') {
        $query_date = 'date(i.created_at) >= DATE_SUB(CURDATE(), INTERVAL WEEKDAY(CURDATE()) DAY)
    AND i.created_at < DATE_ADD(DATE_SUB(CURDATE(), INTERVAL WEEKDAY(CURDATE()) DAY), INTERVAL 7 DAY)';
    }

    // truy vấn tuần trước => từ thứ 2 tuần trước -> chủ nhật tuần trước
    else if($type === 'last week') {
        $query_date = 'date(i.created_at) >= DATE_SUB(CURDATE(), INTERVAL WEEKDAY(CURDATE()) + 7 DAY)
    AND i.created_at < DATE_SUB(CURDATE(), INTERVAL WEEKDAY(CURDATE()) DAY)';
    }

    // truy vấn tháng này
    else  if($type === 'this month') {
        $query_date = 'MONTH(i.created_at) = MONTH(CURDATE())
    AND YEAR(i.created_at) = YEAR(CURDATE())';
    }

    // truy vấn tháng trước
    else  if($type === 'last month') {
        $query_date = 'MONTH(i.created_at) = MONTH(CURDATE() - INTERVAL 1 MONTH)
    AND YEAR(i.created_at) = YEAR(CURDATE() - INTERVAL 1 MONTH)';
    }

    // test return
    // return pdo_query(
    //     'SELECT i.*, SUM(id.quantity_invoice * id.price_invoice) total
    //     FROM invoice i
    //     JOIN invoice_detail id
    //     ON i.id_invoice = id.id_invoice
    //     WHERE status_invoice = 3
    //     AND '.$query_date.' 
    //     GROUP BY i.id_invoice
    //     ORDER BY i.created_at ASC'
    // );

    // trả về
    return pdo_query_value(
        'SELECT SUM(id.quantity_invoice * id.price_invoice) total
        FROM invoice i
        JOIN invoice_detail id
        ON i.id_invoice = id.id_invoice
        WHERE status_invoice = 3
        AND '.$query_date
    );
}

/**
 * Thống kê doanh thu từng tháng của năm hiện tại
 * @return array
 */
function revenue_year() {
    return pdo_query(
        'SELECT MONTH(i.created_at) AS month,SUM(id.quantity_invoice * id.price_invoice) AS total
        FROM invoice i
        JOIN invoice_detail id
        ON i.id_invoice = id.id_invoice
        WHERE YEAR(i.created_at) = YEAR(CURDATE())
        GROUP BY MONTH(i.created_at)
        ORDER BY month'
    );
}

function render_compare_revenue($type) {

    // loại so sánh
    if($type === 'today') {
        // lấy doanh thu
        $value_1 = revenue('today');
        $value_2 = revenue('yesterday');
    }
    else if($type === 'week') {
        // lấy doanh thu
        $value_1 = revenue('this week');
        $value_2 = revenue('last week');
    }
    else if($type === 'month') {
        // lấy doanh thu
        $value_1 = revenue('this month');
        $value_2 = revenue('last month');
    }
    else view_error(404);


        // so sánh
        if($value_1 > $value_2) {
            $indicator = 'rise';
            $icon = 'up';
            $percen = round(($value_1 / $value_2 - 1) * 100,2);
        }
        else {
            $indicator = 'fall';
            $icon = 'down';
            $percen = round((1 - $value_1 / $value_2) * 100,2);
        }


    return <<<HTML
    <div class="saw-indicator__delta saw-indicator__delta--{$indicator}">
        <div class="saw-indicator__delta-direction">
            <i class="fas fa-angle-{$icon}"></i>
        </div>
        <div class="saw-indicator__delta-value">{$percen} %</div>
    </div>
    HTML;
}