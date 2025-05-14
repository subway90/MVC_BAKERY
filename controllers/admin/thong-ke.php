<?php

# [MODEL]
model('admin','dashboard');

# [VARIABLE]
$type = 'nam';

# [HANDLE]

// Nếu user muốn coi chart week, month -> get. còn không sẽ mặc định là year
if(isset($_arrayURL[1]) && $_arrayURL[1] && in_array($_arrayURL[1],['tuan','thang'])) $type = $_arrayURL[1];

if($type === 'nam') {
    $label = 'Tháng';
    $title_chart = 'Doanh thu năm';
    $data_chart = revenue_chart($type);
}
elseif($type === 'thang') {
    $label = 'Tuần';
    $title_chart = 'Doanh thu tháng';
    $data_chart = revenue_chart($type);
}
elseif($type === 'tuan') {
    $label = '';
    $title_chart = 'Doanh thu tuần';
    $data_chart = revenue_chart($type);
}

# [DATA]
$data = [
    'title_chart' => $title_chart,
    'data_chart' => $data_chart,
    'type_chart' => $type,
    'label_chart' => $label,
];

# [RENDER]
view('admin','Thống kê','dashboard',$data);