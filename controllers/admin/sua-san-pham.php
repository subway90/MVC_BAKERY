<?php

# [MODEL]
model('admin','product');

# [VARIABLE]
$error_valid = [];
$bool_encrypt_file = false;
$file = '';
# [HANDLE]

// lấy id sản phẩm
if(isset($_arrayURL[1]) && $_arrayURL[1]) {
    $id_product = clear_input($_arrayURL[1]);
    $get_product = get_one_product($id_product);
    if(!$get_product) view_error(404);
    extract($get_product);
    $old_image = $image_product;
}else view_error(404);
// lưu sản phẩm mới
if(isset($_POST['update_product'])) {
    // lấy input
    $id_category_product = clear_input($_POST['id_category_product']);
    $name_product = clear_input($_POST['name_product']);
    $description_product = clear_input($_POST['description_product']);
    $quantity_product = clear_input($_POST['quantity_product']);
    $price_product = clear_input($_POST['price_product']);
    $old_image = clear_input($_POST['old_image']);
    $image_product = $_FILES['image_product'];
     // nếu upload ảnh mới
    if(($_FILES['image_product']['tmp_name'])) $file = $_FILES['image_product'];
    // nếu có bật mã hoá ảnh
    if(isset($_POST['bool_encrypt_file'])) $bool_encrypt_file = true;

    // xử lí validate
    if(!$id_category_product) $error_valid[] = 'Vui lòng chọn danh mục sản phẩm';
    if(!$name_product) $error_valid[] = 'Vui lòng nhập tên sản phẩm';
    if(check_exist_one_by_name_except_id('product',$name_product,$id_product)) $error_valid[] = 'Tên sản phẩm này đã tồn tại';
    if(!$description_product) $error_valid[] = 'Vui lòng nhập mô tả sản phẩm';
    if($quantity_product < 0 || $quantity_product > 1000) $error_valid[] = 'Số lượng sản phẩm phải từ 0 đến 1.000';
    if(!$price_product) $error_valid[] = 'Vui lòng nhập giá sản phẩm';
    else if($price_product < 0 || $price_product > 1000000000) $error_valid[] = 'Số lượng sản phẩm phải lớn hơn 0 VNĐ và bé hơn 100.000.000 VNĐ';
    if($file) {
        if($file['size'] > LIMIT_SIZE_FILE*(1024*1024)) $error_valid[] = 'Dung lượng ảnh phải bé hơn '.LIMIT_SIZE_FILE.' MB';
        else {
            if($old_image) delete_file($old_image); // xoá ảnh cũ nếu có
            $old_image = save_file($bool_encrypt_file,'menu',$_FILES['image_product']); // lưu ảnh mới
        }
    }
    if(!$old_image) $error_valid[] = 'Vui lòng nhập ảnh sản phẩm';

    // lưu database
    if(empty($error_valid)) {
        pdo_execute(
            'UPDATE product SET
            id_category_product = '.$id_category_product.',
            quantity_product = '.$quantity_product.',
            price_product = '.$price_product.',
            name_product =  "'.$name_product.'",
            image_product = "'.$old_image.'",
            description_product =  "'.$description_product.'",
            updated_at = current_timestamp
            WHERE id_product = '.$id_product
        );
        // Thông báo toast
        toast_create('success','Cập nhật sản phẩm thành công');
        // Chuyển route
        route('admin/sua-san-pham/'.$id_product);
    }
}

# [DATA]
// Danh sách danh mục

$data = [
    'status_page' => false, // trạng thái trang : TRUE là thêm sản phẩm, FALSE là sửa sản phẩm
    'list_category_product' => get_list_category(), // lấy danh sách danh mục
    'id_category_product' => $id_category_product,
    'name_product' => $name_product,
    'description_product' => $description_product,
    'quantity_product' => $quantity_product,
    'price_product' => $price_product,
    'old_image' => $old_image,
    'error_valid' => $error_valid,
    'bool_encrypt_file' => $bool_encrypt_file,
];

# [RENDER]
view('admin','Thêm sản phẩm','product-detail',$data);