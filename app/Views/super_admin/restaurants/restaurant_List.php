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
                    <h4 class="card-title">Resturant Management</h4>
                    <a href="<?php echo site_url(); ?>super_admin/Restaurant/restaurantManagement">+ New Restaurant</a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="example3" class="display" style="min-width: 845px">
                            <thead>
                                <tr>
                                    <th>Sl. No.</th>
                                    <th>Name</th>
                                    <th>Address</th>
                                    <th>Image</th>
                                    <th>Status</th>
                                    <th>Created At</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <?php if(!empty($restaurant_list))
                            {
                            ?>
                                <tbody>
                                    <?php $i=1;
                                     foreach($restaurant_list as $rl){ ?>
                                        <tr>
                                            <td><?php echo $i; ?></td>
                                            <td><?php echo $rl['name']; ?></td>
                                            <td><?php echo $rl['address']; ?></td>
                                            <td><img src="<?php echo site_url().'writable/uploads/restaurant_image/'.$rl['image']; ?>" width="60" height="60" /></td>
                                            <td><?php echo $rl['status']; ?></td>
                                            <td><?php echo date('d/m/Y H:i:s', strtotime($rl['created_at'])); ?></td>
                                            <td>
                                                <div class="form-check form-switch">
                                                    <input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckChecked" <?php echo $rl['status']==1 ? 'checked' : '' ;?> onchange="updateStatus(this, '<?php echo $rl['id']; ?>')" />
                                                </div>
                                            </td>
                                            <td>
                                                <div class="d-flex">
                                                    <a href="<?php echo site_url(); ?>super_admin/Restaurant/restaurantManagement/<?php echo $rl['id']; ?>" class="btn btn-primary shadow btn-xs sharp me-1"><i class="fas fa-pencil-alt"></i></a>
                                                    <a href="<?php echo site_url(); ?>super_admin/Restaurant/deleteRestaurant/<?php echo $rl['id']; ?>" class="btn btn-danger shadow btn-xs sharp" onclick="return confirm('Delete! Are you sure?')"><i class="fa fa-trash"></i></a>
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
    function updateStatus(obj, id)
    {
        $('.content-overlay').css('display','block');
        //var url = '<?php echo base_url(); ?>admin/country/updateStatus';
        //alert(url); 
        //return false;
        var userstatus = 0;
        if($(obj).prop("checked"))
        {
            userstatus = 1;
        }
        //alert(id); return false;
        //console.log(id); 
        var request = $.ajax({
        url: '<?php echo site_url(); ?>super_admin/Restaurant/updateStatus',
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