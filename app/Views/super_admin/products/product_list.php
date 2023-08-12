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
                    <h4 class="card-title">Product Management</h4>
                    <a href="<?php echo site_url(); ?>super_admin/Product/productManagement">+ New Product</a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="example3" class="display" style="min-width: 845px">
                            <thead>
                                <tr>
                                    <th>Sl. No.</th>
                                    <!-- <th>Cafe Name</th> -->
                                    <th>Category</th>
                                    <th>Name</th>
                                    <th>Price</th>
                                    <!-- <th>Description</th> -->
                                    <th>Images</th>
                                    <th>Created At</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <?php if(!empty($product_list))
                            {
                            ?>
                                <tbody>
                                    <?php $i=1;
                                    //print_r($product_list); 
                                     foreach($product_list as $pl){ ?>
                                        <tr>
                                            <td><?php echo $i++; ?></td>
                                            <!-- <td><?php //echo $restaurant_list[$pl['restaurant_id']]; ?></td> -->
                                            <td><?php echo $product_category[$pl['category_id']]; ?></td>
                                            <td><?php echo $pl['name']; ?></td>
                                            <td><?php echo $pl['price']; ?></td>
                                            <!-- <td><?php //echo $pl['description']; ?></td> -->
                                            <!-- <td><img src="<?php //echo site_url().'writable/uploads/restaurant_image/'.$rl['image']; ?>" width="60" height="60" /></td>
                                            <td><?php //echo $rl['status']; ?></td> -->
                                            <td>
                                                <?php 
                                                    if(!empty($pl['images']))
                                                    {
                                                        foreach($pl['images'] as $image)
                                                        {
                                                    ?>
                                                        <div class="d-inline-flex position-relative">
                                                            <span class="position-absolute top-0 start-100 translate-middle p-1 bg-danger border border-light rounded-circle" title="Delete Image" onClick="deleteImage(<?php echo $image['id']; ?>)">
                                                                <span class="visually-hidden">New alerts</span>
                                                            </span>
                                                            <img class="rounded-4 shadow-4" src="<?php echo site_url().'writable/uploads/product_image/'.$image['image']; ?>" alt="Avatar" style="width: 50px; height: 50px;">
                                                        </div>
                                                    <?php
                                                        }
                                                    }
                                                ?>
                                            </td>
                                            <td><?php echo date('Y-m-d', strtotime($pl['created_at'])); ?></td>
                                            <td>
                                                <div class="form-check form-switch">
                                                    <input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckChecked" <?php echo $pl['is_available']==1 ? 'checked' : '' ;?> onchange="updateStatus(this, '<?php echo $pl['id']; ?>')" />
                                                </div>
                                            </td>
                                            <td>
                                                <div class="d-flex">
                                                    <a href="<?php echo site_url(); ?>super_admin/Product/productManagement/<?php echo $pl['id']; ?>" class="btn btn-primary shadow btn-xs sharp me-1"><i class="fas fa-pencil-alt"></i></a>
                                                    <a href="<?php echo site_url(); ?>super_admin/Product/deleteProduct/<?php echo $pl['id']; ?>" class="btn btn-danger shadow btn-xs sharp" onclick="return confirm('Delete! Are you sure?')"><i class="fa fa-trash"></i></a>
                                                </div>												
                                            </td>		
                                        </tr>                                    
                                    <?php } ?>
                                </tbody>
                            <?php
                            }
                            ?>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <input type="hidden" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>" id="csrf"/>
<?=$this->endSection()?>
<?=$this->section("scripts")?>
<script>
    function deleteImage(id)
    {
        var cnf = confirm("Do you want to delete ? ");
        if(!cnf)
        { 
            return false;
        }
        $('.content-overlay').css('display','block');
        var request = $.ajax({
        url: '<?php echo site_url(); ?>super_admin/Product/deleteProductImage',
        type: "POST",
        data: { id: id, csrf_test_name: $('#csrf').val(),},
        dataType: "json"
        });
        request.done(function(res){
            console.log(res);
            if(res.SUCCESS == 1)
            {
                $('.content-overlay').css('display','none');
                location.reload();
            }
            else if(res.ERROR==1){
                alert('Image not deleted, Please try after sometime')
                $('.content-overlay').css('display','none');
            }
        });
        request.fail(function(jqXHR, textStatus) {
            if(userstatus==1)
            {
                $(obj).prop('checked', false);
            }
            else{
                $(obj).prop('checked', true);
            }
            $('.content-overlay').css('display','none');
        });	
    }
    function updateStatus(obj, id)
    {
        $('.content-overlay').css('display','block');
        var userstatus = 0;
        if($(obj).prop("checked"))
        {
            userstatus = 1;
        } 
        var request = $.ajax({
        url: '<?php echo site_url(); ?>super_admin/Product/updateStatus',
        type: "POST",
        data: { id: id, status:userstatus, csrf_test_name: $('#csrf').val(),},
        dataType: "json"
        });
        request.done(function(res){
            console.log(res);
            if(res.SUCCESS == 1)
            {
                $('.content-overlay').css('display','none');
            }
            else if(res.ERROR==1){
                if(userstatus==1)
                {
                    $(obj).prop('checked', false);
                }
                else{
                    $(obj).prop('checked', true);
                }
                $('.content-overlay').css('display','none');
            }
        });
        request.fail(function(jqXHR, textStatus) {
            if(userstatus==1)
            {
                $(obj).prop('checked', false);
            }
            else{
                $(obj).prop('checked', true);
            }
            $('.content-overlay').css('display','none');
        });		
    }
</script>
<?=$this->endSection()?>