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
                    <h4 class="card-title"><?php echo !empty($id) && $id > 0 ? 'Update' : 'New'; ?> Category</h4>
                </div>
                <?php $validationErrors = service('validation')->getErrors();?>
                <div class="card-body">
                    <div class="basic-form">
                        <form method="post" action="<?php echo site_url(); ?>super_admin/Category/categoryManagement" enctype="multipart/form-data">
                        <?= csrf_field() ?>
                            <?php
                            if($id > 0)
                            {
                            ?>
                                <input type="hidden" name="id" value="<?php echo $id; ?>">
                            <?php } ?>
                            <div class="mb-3">
                                <input type="text" name="name" class="form-control input-default " placeholder="Category Name" value="<?php echo !empty($category_list)?$category_list['name']:'';?>" require>
                                <span style="color:red;"><?php echo !empty($validationErrors['name']) ? $validationErrors['name'] : ''; ?></span>
                            </div>
                            <div class="mb-3">
                                <button type="submit" class="btn btn-primary mb-2">Submit</button>
                                <a href="<?php echo site_url().'super-admin-restaurant-list';?>" class="btn btn-danger mb-2">Cancel</a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
<?=$this->endSection()?>