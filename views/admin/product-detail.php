<div id="top" class="sa-app__body">
<form method="post" enctype="multipart/form-data">
    <div class="mx-sm-2 px-2 px-sm-3 px-xxl-4 pb-6">
                    <div class="container">
                        <div class="py-5">
                            <div class="row g-4 align-items-center">
                                <div class="col">
                                    <nav class="mb-2" aria-label="breadcrumb">
                                        <ol class="breadcrumb breadcrumb-sa-simple">
                                            <li class="breadcrumb-item"><a href="<?=URL_ADMIN?>quan-li-san-pham">Quản lí sản phẩm</a></li>
                                            <li class="breadcrumb-item active" aria-current="page">Thêm sản phẩm</li>
                                        </ol>
                                    </nav>
                                </div>
                                <div class="col-auto d-flex"><a href="<?=URL_ADMIN?>quan-li-san-pham" class="btn btn-secondary me-3">Hủy</a>
                                <button name="add_product" class="btn btn-primary" type="submit" >Lưu</button></div>
                            </div>
                        </div>
                        <div class="sa-entity-layout px-lg-5"
                            data-sa-container-query="{&quot;920&quot;:&quot;sa-entity-layout--size--md&quot;,&quot;1100&quot;:&quot;sa-entity-layout--size--lg&quot;}">
                            <div class="sa-entity-layout__body">
                                <div class="sa-entity-layout__main">
                                <div class="card">
                                        <div class="card-body p-5 row">
                                            <div class="col-12 mb-3 h2 fs-exact-18">Nhập thông sản phẩm</div>
                                            <div class="">
                                                <?=show_error($error_valid)?>
                                            </div>
                                            <div class="col-12 form-floating my-3 px-3">
                                                <select name="id_category_product" class="form-select rounded rounded-5" id="id_category_product" aria-label="ttg">
                                                    <option value="">--- chọn danh mục ---</option>
                                                    <?php foreach($list_category_product as $category) {?>
                                                    <option <?=$id_category_product == $category['id_category_product'] ? 'selected' : '' ?> value="<?= $category['id_category_product']?>"><?= $category['name_category_product'] ?></option>
                                                    <?php }?>
                                                </select>
                                                <label class="ms-3" for="id_category_product">Danh mục sản phẩm</label>
                                            </div>
                                            <div class="col-12 form-floating my-3 px-3">
                                                <input name="name_product" value="<?= $name_product ?>" type="text" class="form-control rounded rounded-5" id="name_product" placeholder="name@example.com">
                                                <label class="ms-3" for="name_product">Tên sản phẩm</label>
                                            </div>
                                            <div class="col-12 form-floating my-3 px-3">
                                                <textarea name="description_product" class="form-control rounded rounded-5" placeholder="Nhập mô tả sản phẩm" id="description_product"><?= $description_product ?></textarea>
                                                <label class="ms-3" for="description_product">Mô tả sản phẩm</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card mt-5">
                                        <div class="card-body p-5 row">
                                            <div class="col-12 h2 mb-3 fs-exact-18">Kho hàng</div>
                                            <div class="col-12 p-0 px-3 input-group my-3 flex-nowrap">
                                                <div class="form-floating w-100">
                                                    <input name="quantity_product" value="<?= $quantity_product ?>" type="number" class="form-control" id="quantity" placeholder="Username">
                                                    <label for="quantity_product">Số lượng</label>
                                                </div>
                                                <span class="input-group-text">cái</span>
                                            </div>
                                            <div class="col-12 p-0 px-3 input-group my-3 flex-nowrap">
                                                <div class="form-floating w-100">
                                                    <input name="price_product" value="<?= $price_product ?>" type="number" class="form-control" id="quantity" placeholder="Username">
                                                    <label for="price_product">Giá</label>
                                                </div>
                                                <span class="input-group-text">VNĐ</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="sa-entity-layout__sidebar">
                                    <div class="card w-100">
                                        <div class="card-body p-5">
                                            <div class="mb-5 h2 fs-exact-18">Ảnh sản phẩm</div>
                                            <div class="form-control">
                                                <div class="max-w-20x">
                                                    <?php
                                                    if(empty($old_image)){ ?>
                                                    <img src="<?=DEFAULT_IMAGE?>" id="image" class="w-100 h-auto" width="320" height="320" alt="image product" />
                                                    <?php }else{ ?>
                                                    <img src="<?=URL_STORAGE?><?=$old_image?>" id="image" class="w-100 h-auto" width="320" height="320" alt="image product" />
                                                    <div class="text-info text-center mt-2"><?=$old_image?></div>
                                                    <?php } ?>
                                                </div>
                                            </div>
                                            <div class="mt-4">
                                                    <div class="my-3">
                                                        <label class="form-check form-switch">
                                                            <input <?= $bool_encrypt_file ? 'checked' : '' ?> type="checkbox" name="bool_encrypt_file" class="form-check-input"/>
                                                            <span class="form-check-label" >Mã hoá tên ảnh</span>
                                                        </label>
                                                        <small class="text-muted">
                                                            Việc tắt mã hoá tên ảnh để giúp cho SEO Webiste
                                                        </small>
                                                    </div>
                                                    <input type="file" id="imageFile" name="image_product" onchange="chooseFile(this)" class="form-control" accept="image/jpeg,image/png, image/gif" >
                                                    <input hidden type="text" name="old_image" value="<?=$old_image?>">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
    </div>
</div>
</form>