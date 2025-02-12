<?php
# [VARIABLE]
$status_page = true;
$input_name = $show_modal = '';
$error_valid = [];

# [MODEL]
model('admin','category');


# [HANDLE]
if(isset($_POST['add'])) {
    // lấy input
    $input_name = clear_input($_POST['input_name']);

    // xử lí validate
    if(!$input_name) $error_valid[] = 'Chưa nhập tên danh mục';
    $check_name = check_name_category_product_exist($input_name);
    if(!$check_name) $error_valid[] = 'Tên danh mục này đã tồn tại';
    // nếu có lỗi, thì tự động mở modal
    if(!empty($error_valid)) $show_modal = 'modalAddCategoryProduct';
    // lưu database
    else{
        pdo_execute(
            'INSERT INTO category_product (name_category_product) VALUES ("'.$input_name.'")'
        );
        // thông báo
        toast_create('success','Thêm thành công danh mục mới');
        // chuyển route
        route('admin/quan-li-danh-muc');
    }
}


# [DATA]
// Lấy danh sách danh mục
$list_category_product = get_all_category();

$data = [
    'list_category_product' => $list_category_product,
    'status_page' => $status_page,
    'input_name' => $input_name,
    'show_modal' => $show_modal,
    'error_valid' => $error_valid,
];

# [RENDER]
view('admin','Danh sách danh mục','category',$data);