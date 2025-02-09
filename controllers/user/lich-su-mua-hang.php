<?php

# [AUTHOR]
author(['user','admin']);

# [MODEL]
model('user','order');

# [VARIABLE]
$username = $_SESSION['user']['username'];

# [HANDLE]



# [DATA]


$data = [
    'list_order' => get_all_order_by_username($username),
];

# [RENDER
view('user','Lịch sử mua hàng','order_history',$data);