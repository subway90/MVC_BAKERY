 <!-- sa-app__body -->
 <div id="top" class="sa-app__body">
    <div class="mx-sm-2 px-2 px-sm-3 px-xxl-4 pb-6">
        <div class="container">
            <div class="py-5">
                <div class="row g-4 align-items-center">
                    <div class="col">
                        <nav class="mb-2" aria-label="breadcrumb">
                            <ol class="breadcrumb breadcrumb-sa-simple">
                                <?php if($status_page) { ?>
                                <li class="breadcrumb-item active" aria-current="page">Danh sách hoạt động</li>
                                <?php }else{?>
                                <li class="breadcrumb-item active" aria-current="page">Danh sách xoá</li>
                                <?php }?>
                            </ol>
                        </nav>
                    </div>
                    <div class="col-auto d-flex">
                        <?php if(!$status_page) {?>
                            <a href="<?=URL_ADMIN?>quan-li-san-pham" class="btn btn-outline-success">Quay về Danh sách hoạt động</a>
                        <?php } else {?>
                            <a href="<?=URL_ADMIN?>quan-li-san-pham/them" class="btn btn-primary me-3"><i class="fa fas fa-plus me-2"></i>Thêm</a>
                            <a href="<?=URL_ADMIN?>quan-li-san-pham/danh-sach-xoa" class="btn btn-outline-danger"><i class="fa fas fa-trash me-2"></i>Danh sách xoá</a>
                        <?php }?>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="p-4"><input type="text" placeholder="Nhập thông tin tìm kiếm"
                        class="form-control form-control--search mx-auto" id="table-search" /></div>
                <div class="sa-divider"></div>
                <table class="sa-datatables-init" data-order="[[ 0, &quot;asc&quot; ]]"
                    data-sa-search-input="#table-search">
                    <thead>
                        <tr>
                            <th class="w-min">ID</th>
                            <th class="min-w-5x">Thông tin sản phẩm</th>
                            <th class="min-w-5x">Danh mục</th>
                            <th class="min-w-5x">Số lượng</th>
                            <th class="min-w-5x">Ngày tạo</th>
                            <?php if($status_page) {?>
                                <th class="min-w-5x">Ngày cập nhật</th>
                            <?php }else{ ?>
                                <th class="min-w-5x">Ngày xoá</th>
                            <?php }?>
                            <th class="min-w-10x" data-orderable="false">Hành động</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                    foreach ($list_product as $product) {
                        extract($product);
                    ?>  
                        <tr>
                            <td>
                                <div class="">
                                    <?= $id_product ?>
                                </div>
                            </td>
                            <td>
                            <a class="text-dark" href="<?=URL_ADMIN?>chi-tiet-san-pham/<?=$slug_product?>"><strong><?= $name_product ?></strong></a>
                                <div class="small text-muted">
                                    <?= $description_product ?>
                                </div>
                            </td>
                            <td> 
                               <div class="badge badge-sa-primary"><a href="<?=URL_ADMIN?>quan-li-danh-muc"><?= $name_category_product ?></a></div>
                            </td>
                            <td> 
                                <?= ($quantity_product) ? '<div class="badge badge-sa-success">'.$quantity_product.' cái</div>' : '<div class="badge badge-sa-warning">0 cái</div>' ?> 
                            </td>
                            <td>
                                <?= format_time($created_at,'DD/MM/YYYY lúc hh:mm:ss') ?>
                            </td>
                            <td>
                            <?php if($status_page) {?>
                                <?= $updated_at ? format_time($created_at,'DD/MM/YYYY lúc hh:mm:ss') : '<span class="text-muted small">Chưa cập nhật</span>'?>
                            <?php }else{ ?>
                                <?= format_time($deleted_at,'DD/MM/YYYY lúc hh:mm:ss') ?>
                            <?php }?>
                            </td>
                            <td class="">
                                <form method="post">
                                    <?php if($status_page) {?>
                                    <button name="open_edit" value="<?=$id_product?>" type="submit" class="btn btn-sm btn-outline-primary me-3" data-bs-toggle="modal" data-bs-target="#modalEditCategoryProduct"><i class="fa fas fa-edit me-2"></i> Sửa</button>
                                    <button name="delete" value="<?=$id_product?>" type="submit" class="btn btn-sm btn-outline-danger me-3"><i class="fa fas fa-trash me-2"></i> Xoá</button>
                                    <?php }else{ ?>
                                    <button name="restore" value="<?=$id_product?>" type="submit" class="btn btn-sm btn-outline-dark me-3"><i class="fa fas fa-trash-restore me-2"></i> Khôi phục</button>
                                    <button onclick="delete_force(<?=$id_product?>)" type="button" class="btn btn-sm btn-danger me-3" data-bs-toggle="modal" data-bs-target="#modalDeleteProduct"><i class="fa fas fa-trash me-2"></i> Xoá vĩnh viễn</button>
                                    <?php }?>
                                </form>
                            </td>
                        </tr>
                    <?php
                    }
                    ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php
if(isset($_SESSION['edit_category'])) {
    extract($_SESSION['edit_category'])
?>
<div class="modal fade" id="modalEditCategoryProduct" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Sửa danh mục ID = <?=$id?></h5>
                <button type="button" class="sa-close sa-close--modal" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="post">
            <div class="modal-body px-5">
                <?=show_error($error_valid)?>
                <div class="form-floating mb-3">
                    <input name="name" value="<?=$name?>" type="text" class="form-control" id="name" placeholder="input">
                    <label for="name">Tên danh mục</label>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Huỷ</button>
                <button name="edit_category" value="<?=$id?>" type="submit" class="btn btn-primary">Lưu</button>
            </div>
            </form>
        </div>
    </div>
</div>
<?php }?>


<?php if(!$status_page) {?>
<!-- Modal xoá vĩnh viễn -->
<div class="modal fade" id="modalDeleteProduct" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Xoá vĩnh viễn sản phẩm</h5>
                <button type="button" class="sa-close sa-close--modal" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="post">
                <input type="hidden" name="id_force" value="">
            <div class="modal-body text-center px-5">
                <div class="mb-5">
                    Bạn có chắc chắn xoá ? Việc xoá vĩnh viễn sẽ không thể khôi phục lại !
                </div>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Huỷ</button>
                <button name="delete_force" type="submit" class="btn btn-danger">Xoá</button>
            </div>
            </form>
        </div>
    </div>
</div>

<script>
function delete_force(id) {
    document.querySelector('input[name="id_force"]').value = id;
    var myModal = new bootstrap.Modal(document.getElementById('modalDeleteProduct'));
    myModal.show();
}
</script>
<?php }?>