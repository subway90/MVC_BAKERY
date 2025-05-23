<?php

# [MODEL]
model('admin','product');

# [VARIABLE]
$status_page = true; // trạng thái trang (danh sách hoạt động, danh sách xoá)

# [HANDLE]
// Xem danh sách xoá
if(isset($_arrayURL[1]) && $_arrayURL[1] == 'danh-sach-xoa') $status_page = false;

// Xoá sản phẩm
if(isset($_POST['delete'])) {
    // lấy input
    $id = clear_input($_POST['delete']);
    // kiểm tra tồn tại
    if(!check_exist_one('product',$id)) toast_create('danger','Sản phẩm ID = '.$id.' không tồn tại');
    else {
        // thực hiện xoá
        delete_one('product',$id);
        // thông báo toast
        toast_create('success','Xoá thành công sản phẩm ID ='.$id);
        // chuyển route
        route('admin/quan-li-san-pham');
    }
}

// Khôi phục sản phẩm
if(isset($_POST['restore'])) {
    // lấy input
    $id = clear_input($_POST['restore']);
    if(!check_exist_one_in_trash('product',$id)) toast_create('danger','Sản phẩm ID = '.$id.' không tồn tại trong danh sách xoá');
    else {
        //
        // thực hiện khôi phục
        restore_one('product',$id);
        // thông báo toast
        toast_create('success','Khôi phục thành công sản phẩm ID ='.$id);
        // chuyển route
        route('admin/quan-li-san-pham/danh-sach-xoa');
    }
}

# [DATA]
// Lấy danh sách danh mục
if($status_page) $list_product = get_all_product('IS NULL');
else $list_product = get_all_product('');

$data = [
    'status_page' => $status_page,
    'list_product' => $list_product,
];

# [RENDER]
view('admin','Quản lí sản phẩm','product',$data);