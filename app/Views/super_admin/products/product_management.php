<?= $this->extend('super_admin/layout/default') ?>

<?=$this->section("stylesheets")?>
    <link href="<?php echo site_url(); ?>assets/admin/vendor/datatables/css/jquery.dataTables.min.css" rel="stylesheet">
<?=$this->endSection()?>

<?=$this->section("scripts")?>
    <script src="<?php echo site_url(); ?>assets/admin/vendor/datatables/js/jquery.dataTables.min.js"></script>
    <script src="<?php echo site_url(); ?>assets/admin/js/plugins-init/datatables.init.js"></script>
<?=$this->endSection()?>

<?=$this->section("content")?>
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title"><?php echo !empty($id) && $id > 0 ? 'Update' : 'New'; ?> Product</h4>
                </div>
                <?php $validationErrors = service('validation')->getErrors();?>
                <div class="card-body">
                    <div class="basic-form">
                        <form method="post" action="<?php echo site_url(); ?>super_admin/Product/productManagement" enctype="multipart/form-data">
                        <?= csrf_field() ?>
                            <?php
                            if($id > 0)
                            {
                                //print_r($product_list); 
                                //echo $product_list['category_id']; 
                            ?>
                                <input type="hidden" name="id" value="<?php echo $id; ?>">
                            <?php } ?>
                            <div class="mb-3">
                                <select name="category_id" class="default-select  form-control wide" title="Product Category" require>
                                    <?php
                                    foreach($product_category as $pckey=>$pcvalue){
                                    ?>
                                        <option value="<?= $pckey; ?>" <?php echo !empty($product_list) && $product_list['category_id']==$pckey?'selected':'';?>><?= $pcvalue; ?></option>
                                    <?php } ?>
                                </select>
                                <span style="color:red;"><?php echo !empty($validationErrors['category_id']) ? $validationErrors['category_id'] : ''; ?></span>
                            </div>
                            <div class="mb-3">
                                <select name="restaurant_id" class="default-select  form-control wide" title="Restaurant" require>
                                    <?php
                                    foreach($restaurant_list as $rlkey=>$rlvalue){
                                    ?>
                                        <option value="<?= $rlkey; ?>" <?php echo !empty($product_list) && $product_list['restaurant_id']==$rlkey?'selected':'';?>><?= $rlvalue; ?></option>
                                    <?php } ?>
                                </select>
                                <span style="color:red;"><?php echo !empty($validationErrors['restaurant_id']) ? $validationErrors['restaurant_id'] : ''; ?></span>
                            </div>
                            <div class="mb-3">
                                <input type="text" name="name" class="form-control input-default " placeholder="Product Name" value="<?php echo !empty($product_list)?$product_list['name']:'';?>" require>
                                <span style="color:red;"><?php echo !empty($validationErrors['name']) ? $validationErrors['name'] : ''; ?></span>
                            </div>
                            <div class="mb-3">
                                <input type="text" name="price" class="form-control input-default " placeholder="Product Price" value="<?php echo !empty($product_list)?$product_list['price']:'';?>" require>
                                <span style="color:red;"><?php echo !empty($validationErrors['price']) ? $validationErrors['price'] : ''; ?></span>
                            </div>
                            <div class="mb-3">
                                <textarea class="form-control" name="description" rows="4" id="comment" placeholder="Description" require><?php echo !empty($product_list)?$product_list['description']:'';?></textarea>
                                <span style="color:red;"><?php echo !empty($validationErrors['description']) ? $validationErrors['description'] : ''; ?></span>
                            </div>
                            <div class="mb-3">
                                <input type="file" name="images[]" multiple="" class="form-control input-default " placeholder="Upload Product Image" <?php echo $id > 0 ? '' : 'require'; ?>>
                                <span style="color:red;"><?php echo !empty($validationErrors['image']) ? $validationErrors['image'] : ''; ?></span>
                            </div>
                            <div class="mb-3">
                                <button type="submit" class="btn btn-primary mb-2">Submit</button>
                                <a href="<?php echo site_url().'super-admin-product-list';?>" class="btn btn-danger mb-2">Cancel</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
<?=$this->endSection()?>