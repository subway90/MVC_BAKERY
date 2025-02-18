<?php

/**
 * Kiểm tra một field nào đó có value tồn tại hay không
 * @param $field Tên field cần kiểm tra
 * @param $value Giá trị cần kiểm tra
 * @return boolean TRUE nếu tồn tại, ngược lại FALSE khi không tồn tại
 */
function check_one_exist_in_user_with_field($field,$value) {
    $result = pdo_query_one(
        'SELECT username FROM user WHERE '.$field.' ="'.$value.'" AND deleted_at IS NULL'
    );
    if($result) return 1;
    return 0;
}

/**
 * Kiểm tra username có theo yêu cầu kí tự từ a-z, A-Z, 0-9
 * @param string $input
 * @return bool
 */
function check_valid_username($input) {
    return preg_match('/^[a-zA-Z0-9]+$/', $input) === 1;
}

function create_user($full_name,$gender,$email,$username,$password) {
    try{
        pdo_execute(
            'INSERT INTO user (full_name,gender,email,username,password) VALUES ("'.$full_name.'",'.$gender.',"'.$email.'","'.$username.'","'.md5($password).'")'
        );
    }catch(PDOException $e) {
        die(_s_me_error.$e->getMessage()._e_me_error);
    }

    return 1;

}

/**
 * Truy vấn thông tin của một user bằng $username
 * @param string $username Username cần truy vấn
 * @return array
 */
function get_one_user_by_username($username) {
    return pdo_query_one(
        'SELECT u.username, u.email, u.full_name, u.gender, u.birth, u.created_at, u.updated_at, r.name_role
        FROM user u
        JOIN role r
        ON u.id_role = r.id_role
        WHERE u.deleted_at IS NULL
        AND u.username = "'.$username.'"'
    );
}