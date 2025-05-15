<?php

# [MODEL]
model('admin','dashboard');

# [VARIABLE]
$type = 'ngay';
$end = date('Y-m-d'); //ngày kết thúc (hôm nay)
$start = date('Y-m-d',strtotime($end . '- 7 days')); // ngày bắt đầu (7 ngày trước)

# [HANDLE]
// Lọc chart theo duration và group by
if(isset($_POST['filter_chart']) && $_POST['duration_time'] && $_POST['type_chart']) {

    // input
    $duration_time = $_POST['duration_time'];
    // Nếu user muốn coi chart week, month -> get. còn không sẽ mặc định là year
    if(in_array($_POST['type_chart'],['tuan','thang','nam'])) $type = $_POST['type_chart'];

    // tách duration ra start và end
    $arr_duration = explode(' đến ',$duration_time);
    
    // convert theo định dạng SQL : YYYY-MM-DD
    if(count($arr_duration) == 2) {
        $start = convert_to_date_sql($arr_duration[0]);
        $end = convert_to_date_sql($arr_duration[1]);
    }
}

# [DATA]
$data = [
    'title_chart' => 'Biểu đồ thống kê',
    'data_chart' => data_chart($start,$end,$type),
    'type_chart' => $type,
    'duration_time' => format_time($start.' 00:00:00','DD-MM-YYYY').' đến '.format_time($end.' 00:00:00','DD-MM-YYYY'),
];

# [RENDER]
view('admin','Thống kê','dashboard',$data);