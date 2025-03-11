<?php

# [AUTHOR]
author(['user','admin']);

# [MODEL]
model('user','invoice');

# [VARIABLE]
$username = $_SESSION['user']['username'];

# [HANDLE]



# [DATA]


$data = [
    'list_invoice' => get_all_invoice_by_username($username),
];

# [RENDER
view('user','Lịch sử mua hàng','invoice_history',$data);