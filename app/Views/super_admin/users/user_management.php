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
                    <h4 class="card-title"><?php echo !empty($id) && $id > 0 ? 'Update' : 'New'; ?> Restaurant's User</h4>
                </div>
                <?php $validationErrors = service('validation')->getErrors();?>
                <div class="card-body">
                    <div class="basic-form">
                        <form method="post" action="<?php echo site_url(); ?>super_admin/User/userManagement" enctype="multipart/form-data">
                        <?= csrf_field() ?>
                            <?php
                            if(!isset($id)){

                                $id=0;
                            }
                            if($id > 0)
                            {
                            ?>
                                <input type="hidden" name="id" value="<?php echo $id; ?>">
                            <?php } ?>
                            <div class="mb-3">
                                <select name="restaurant_id" class="default-select  form-control wide" required>
                                    <?php
                                    foreach($restaurantKeyValueData as $rlkey=>$rlvalue){
                                    ?>
                                        <option value="<?= $rlkey; ?>" <?php echo !empty($user_list) && $user_list['restaurant_id']==$rlkey?'selected':'';?>><?= $rlvalue; ?></option>
                                    <?php } ?>
                                </select>
                                <span style="color:red;"><?php echo !empty($validationErrors['restaurant_id']) ? $validationErrors['restaurant_id'] : ''; ?></span>
                            </div>
                            <div class="mb-3">
                                <input type="text" name="full_name" class="form-control input-default " placeholder="Full Name" value="<?php echo !empty($user_list)?$user_list['full_name']:'';?>" required>
                                <span style="color:red;"><?php echo !empty($validationErrors['full_name']) ? $validationErrors['full_name'] : ''; ?></span>
                            </div>
                            <div class="mb-3">
                                <textarea class="form-control" name="address" rows="4" id="comment" placeholder="Address" required><?php echo !empty($user_list)?$user_list['address']:'';?></textarea>
                                <span style="color:red;"><?php echo !empty($validationErrors['address']) ? $validationErrors['address'] : ''; ?></span>
                            </div>
                            <div class="mb-3">
                                <input type="text" name="mobile" class="form-control input-default " placeholder="Mobile" value="<?php echo !empty($user_list)?$user_list['mobile']:'';?>" required>
                                <span style="color:red;"><?php echo !empty($validationErrors['mobile']) ? $validationErrors['mobile'] : ''; ?></span>
                            </div>
                            <div class="mb-3">
                                <input type="text" name="email" class="form-control input-default " placeholder="Email" value="<?php echo !empty($user_list)?$user_list['email']:'';?>" required>
                                <span style="color:red;"><?php echo !empty($validationErrors['email']) ? $validationErrors['email'] : ''; ?></span>
                            </div>
                            <div class="mb-3">
                                <select name="gender" class="default-select  form-control wide" required>
                                    <option value="M" <?php echo !empty($user_list) && $user_list['gender']=='M'?'selected':'';?>>Male</option>
                                    <option value="F" <?php echo !empty($user_list) && $user_list['gender']=='F'?'selected':'';?>>Female</option>
                                </select>
                                <span style="color:red;"><?php echo !empty($validationErrors['gender']) ? $validationErrors['gender'] : ''; ?></span>
                            </div>
                            <div class="mb-3">
                                <input type="text" name="username" class="form-control input-default " placeholder="Username" value="<?php echo !empty($user_list)?$user_list['username']:'';?>" required>
                                <span style="color:red;"><?php echo !empty($validationErrors['username']) ? $validationErrors['username'] : ''; ?></span>
                            </div>
                            <div class="mb-3">
                                <select name="role" class="default-select  form-control wide" required>
                                    <option value="User" <?php echo !empty($user_list) && $user_list['role']=='User'?'selected':'';?>>User</option>
                                    <option value="Super_Admin" <?php echo !empty($user_list) && $user_list['role']=='Super_Admin'?'selected':'';?>>Super Admin</option>
                                </select>
                                <span style="color:red;"><?php echo !empty($validationErrors['role']) ? $validationErrors['role'] : ''; ?></span>
                            </div>
                            <?php if($id>0){ ?>
                                <input type="hidden" name="password" value="<?php echo $user_list['password']; ?>">
                            <?php } else{ ?>
                            <div class="mb-3">
                                <input type="text" name="password" class="form-control input-default " placeholder="Password" value="<?php echo !empty($user_list)?$user_list['password']:'';?>" required>
                                <span style="color:red;"><?php echo !empty($validationErrors['password']) ? $validationErrors['password'] : ''; ?></span>
                            </div>
                            <?php } ?>
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