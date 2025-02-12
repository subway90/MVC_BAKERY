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
                            <a href="<?=URL_ADMIN?>quan-li-danh-muc" class="btn btn-outline-success">Quay về Danh sách hoạt động</a>
                        <?php } else {?>
                            <button type="button" class="btn btn-primary me-3" data-bs-toggle="modal" data-bs-target="#modalAddCategoryProduct"><i class="fa fas fa-plus me-2"></i> Thêm</button>
                            <a href="<?=URL_ADMIN?>quan-li-danh-muc/danh-sach-xoa" class="btn btn-outline-danger"><i class="fa fas fa-trash me-2"></i>Danh sách xoá</a>
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
                            <th class="min-w-10x">Tên danh mục</th>
                            <th class="min-w-5x">Trạng thái</th>
                            <th class="min-w-5x">Ngày tạo</th>
                            <th class="min-w-5x">Ngày cập nhật</th>
                            <th class="w-min" data-orderable="false"></th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                    foreach ($list_category_product as $category) {
                        extract($category);
                    ?>  
                        <tr>
                            <td>
                                <div class="">
                                    <?= $id_category_product ?>
                                </div>
                            </td>
                            <td>
                                <a class="text-dark" href="<?=URL_ADMIN?>chi-tiet-tin-tuc/<?=$slug_category_product?>"><strong><?= $name_category_product ?></strong></a>
                            </td>
                            <td class="text-nowrap"> <?= ($status_category_product == 1) ? '<div class="badge badge-sa-success">Hoạt động</div>' : '<div class="badge badge-sa-warning">Ẩn</div>' ?> </td>
                            <td><?= format_time($created_at,'DD/MM/YYYY lúc hh:mm:ss') ?></td>
                            <td><?= $updated_at ? format_time($created_at,'DD/MM/YYYY lúc hh:mm:ss') : '<span class="text-muted small">Chưa cập nhật</span>'?></td>
                            <td>
                                <div class="dropdown">
                                    <button class="btn btn-sa-muted btn-sm" type="button" id="customer-context-menu-0" data-bs-toggle="dropdown" aria-expanded="false" aria-label="More">
                                        <i class="fas fa-ellipsis-v"></i>
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="customer-context-menu-0">
                                        <?php if($status_page) {?>
                                        <li>
                                            <a class="dropdown-item text-danger" href="<?=URL_ADMIN?>danh-muc-tin-tuc/<?=$slug_category?>/xoa/<?=$id_blog?>"><i class="fa fa-sm me-1 fas fa-trash"></i> Xoá</a>
                                        </li>
                                        <?php }else{?>
                                        <li>
                                            <a class="dropdown-item text-success" href="<?=URL_ADMIN?>danh-muc-tin-tuc/<?=$slug_category?>/khoi-phuc/<?=$id_blog?>"><i class="fa fa-sm me-1 fas fa-trash-restore"></i> Khôi phục</a>
                                        </li>
                                        <?php }?>
                                    </ul>
                                </div>
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

<!-- Modal thêm danh mục -->



<div class="modal fade" id="modalAddCategoryProduct" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Thêm danh mục mới</h5>
                <button type="button" class="sa-close sa-close--modal" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="post">
            <div class="modal-body px-5">
                <?=show_error($error_valid)?>
                <div class="form-floating mb-3">
                    <input name="input_name" value="<?=$input_name?>" type="text" class="form-control" id="name" placeholder="input">
                    <label for="name">Tên danh mục</label>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Huỷ</button>
                <button name="add" type="submit" class="btn btn-primary">Lưu</button>
            </div>
            </form>
        </div>
    </div>
</div>
            