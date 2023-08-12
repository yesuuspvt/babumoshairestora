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
                    <h4 class="card-title">User Management</h4>
                    <a href="<?php echo site_url(); ?>super_admin/User/userManagement">+ New User</a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="example3" class="display" style="min-width: 845px">
                            <thead>
                                <tr>
                                    <th>Sl. No.</th>
                                    <th>Full Name</th>
                                    <th>Gender</th>
                                    <th>User ID</th>
                                    <th>Role</th>
                                    <th>Address</th>
                                    <th>Mobile</th>
                                    <th>Shift</th>
                                    <th>Modified At</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <?php if(!empty($user_list))
                            {
                            ?>
                                <tbody>
                                    <?php $i=1;
                                     foreach($user_list as $ul){ ?>
                                        <tr>
                                            <td><?php echo $i; ?></td>
                                            <td><?php echo $ul['full_name']; ?></td>
                                            <td><?php echo $ul['gender']=='M'?'Male':'Female'; ?></td>
                                            <td><?php echo $ul['username']; ?></td>
                                            <td><?php echo $ul['role']=='User'?"Client User":'Admin'; ?></td>
                                            <td><?php echo $ul['address']; ?></td>
                                            <td><?php echo $ul['mobile']; ?></td>
                                            <td><?php echo $ul['shift']=='day'?'Day':'Night'; ?></td>
                                            <td><?php echo date('d/m/Y H:i:s', strtotime($ul['modified_at'])); ?></td>
                                            <!-- <td>
                                                <div class="form-check form-switch">
                                                    <input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckChecked" <?php //echo $ul['is_active']==1 ? 'checked' : '' ;?> onchange="updateStatus(this, '<?php echo $ul['id']; ?>')" />
                                                </div>
                                            </td> -->
                                            <td>
                                                <div class="d-flex">
                                                    <a href="<?php echo site_url(); ?>super_admin/User/userManagement/<?php echo $ul['id']; ?>" class="btn btn-primary shadow btn-xs sharp me-1"><i class="fas fa-pencil-alt"></i></a>
                                                    <a href="<?php echo site_url(); ?>super_admin/User/deleteUser/<?php echo $ul['id']; ?>" class="btn btn-danger shadow btn-xs sharp" onclick="return confirm('Delete! Are you sure?')"><i class="fa fa-trash"></i></a>
                                                </div>												
                                            </td>		
                                        </tr>                                    
                                    <?php $i++; } ?>
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
        var userstatus = 0;
        if($(obj).prop("checked"))
        {
            userstatus = 1;
        }
        var request = $.ajax({
        url: '<?php echo site_url(); ?>super_admin/User/updateStatus',
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