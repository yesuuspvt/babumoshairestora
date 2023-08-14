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
                    <h4 class="card-title"><?php echo !empty($id) && $id > 0 ? 'Update' : 'New'; ?> Item</h4>
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
                                <select name="category_id" class="default-select  form-control wide" title="Item Category" require>
                                    <?php
                                    foreach($product_category as $pckey=>$pcvalue){
                                    ?>
                                        <option value="<?= $pckey; ?>" <?php echo !empty($product_list) && $product_list['category_id']==$pckey?'selected':'';?>><?= $pcvalue; ?></option>
                                    <?php } ?>
                                </select>
                                <span style="color:red;"><?php echo !empty($validationErrors['category_id']) ? $validationErrors['category_id'] : ''; ?></span>
                            </div>
                            
                            <div class="mb-3">
                                <input type="text" name="name" class="form-control input-default " placeholder="Item Name" value="<?php echo !empty($product_list)?$product_list['name']:'';?>" require>
                                <span style="color:red;"><?php echo !empty($validationErrors['name']) ? $validationErrors['name'] : ''; ?></span>
                            </div>
                            <div class="mb-3">
                                <input type="text" name="unit" class="form-control input-default " placeholder="Item Unit" value="<?php echo !empty($product_list)?$product_list['unit']:'';?>" require>
                                <span style="color:red;"><?php echo !empty($validationErrors['unit']) ? $validationErrors['unit'] : ''; ?></span>
                            </div>
                            <div class="mb-3">
                                <input type="text" name="price" class="form-control input-default " placeholder="Item Unit Price/Rate" value="<?php echo !empty($product_list)?$product_list['price']:'';?>" require>
                                <span style="color:red;"><?php echo !empty($validationErrors['price']) ? $validationErrors['price'] : ''; ?></span>
                            </div>
                            <div class="mb-3">
                                <input type="text" name="gst" class="form-control input-default " placeholder="GST %" value="<?php echo !empty($product_list)?$product_list['gst']:'';?>" require>
                                <span style="color:red;"><?php echo !empty($validationErrors['gst']) ? $validationErrors['gst'] : ''; ?></span>
                            </div>
                            <div class="mb-3">
                                <input type="file" name="images[]" multiple="" class="form-control input-default " placeholder="Upload Item Image" <?php echo $id > 0 ? '' : 'require'; ?>>
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