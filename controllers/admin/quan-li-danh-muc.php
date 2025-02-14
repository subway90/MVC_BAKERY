<?php
# [VARIABLE]
$status_page = true;
$input_name = $show_modal = '';
$error_valid = [];

# [MODEL]
model('admin','category');


# [HANDLE]
// Thêm danh mục mới
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

// Mở modal sửa danh mục
if(isset($_POST['open_edit'])) {
    // lấy id
    $id_category_product = clear_input($_POST['open_edit']);
    // lấy thông tin danh mục
    $get_one = get_one_category_by_id($id_category_product);
    // kiểm tra
    if(!$get_one) toast_create('warning','Danh mục với ID = '.$id_category_product.' không tồn tại');
    else{
        // mở modal edit
        $show_modal = 'modalEditCategoryProduct';
        // lưu dữ liệu vào session
        $_SESSION['edit_category'] = [
            'id' => $get_one['id_category_product'],
            'name' => $get_one['name_category_product'],
        ];
    }
}

// Sửa danh mục
if(isset($_POST['edit_category']) && !empty($_SESSION['edit_category'])) {
    // lấy input
    $id_category_product = clear_input($_POST['edit_category']);
    $name = clear_input($_POST['name']);
    // lưu tên mới vào session
    $_SESSION['edit_category']['name'] = $name;
    // xử lí validate
    if(!$name) $error_valid[] = 'Vui lòng nhập tên danh mục';
    if(!check_name_exits_for_update($id_category_product,$name)) $error_valid[] = 'Tên danh mục này đã tồn tại';
    // thông báo lỗi valid
    if(!empty($error_valid)) $show_modal = 'modalEditCategoryProduct'; // mở modal edit
    else {
        // cập nhật database
        pdo_execute(
            'UPDATE category_product SET name_category_product = "'.$name.'", updated_at = current_timestamp
            WHERE id_category_product ='.$id_category_product
        );
        // thông báo toast
        toast_create('success','Cập nhật thành công danh mục ID ='.$id_category_product);
        // xoá session
        unset($_SESSION['edit_category']);
        // chuyển route
        route('admin/quan-li-danh-muc');
    }
}

// Xoá danh mục
if(isset($_POST['delete'])) {
    // lấy input
    $id = clear_input($_POST['delete']);
    // kiểm tra tồn tại
    if(!get_one_category_by_id($id)) toast_create('danger','Danh mục ID = '.$id.' không tồn tại');
    else {
        // thực hiện xoá
        delete_one('category_product',$id);
        // thông báo toast
        toast_create('success','Xoá thành công danh mục ID ='.$id);
        // chuyển route
        route('admin/quan-li-danh-muc');
    }
}


// Xem danh sách xoá
if(isset($_arrayURL[1]) && $_arrayURL[1] == 'danh-sach-xoa') $status_page = false;



# [DATA]
// Lấy danh sách danh mục
if($status_page) $list_category_product = get_all_category('IS NULL');
else $list_category_product = get_all_category('');

$data = [
    'list_category_product' => $list_category_product,
    'status_page' => $status_page,
    'input_name' => $input_name,
    'show_modal' => $show_modal,
    'error_valid' => $error_valid,
];

# [RENDER]
view('admin','Danh sách danh mục','category',$data);