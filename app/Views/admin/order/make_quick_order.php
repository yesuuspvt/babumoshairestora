<?= $this->extend('admin/layout/default') ?>

<?=$this->section("stylesheets")?>
    <link href="<?php echo site_url(); ?>assets/admin/vendor/datatables/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="<?php echo site_url(); ?>assets/css/quickSearch.css" rel="stylesheet">
<?=$this->endSection()?>

<?=$this->section("scripts")?>
    <script src="<?php echo site_url(); ?>assets/admin/vendor/datatables/js/jquery.dataTables.min.js"></script>
    <script src="<?php echo site_url(); ?>assets/admin/js/plugins-init/datatables.init.js"></script>
<?=$this->endSection()?>

<?=$this->section("content")?>
    <div class="row">
        <div class="col-12">
            <div class="card" style="height:100%;">
                <div class="row card-header">
                    <div class="col-lg-4">
                        <h4 class="card-title">Order Management</h4>
                    </div>
                    <div class="col-lg-4">&nbsp;</div>
                    <div class="col-lg-4">
                        <a href="<?php echo site_url(); ?>admin/Order/cartData"><span>Cart Item(s) <span id="cart_items" class="badge badge-primary badge-pill"><?php echo !empty($_SESSION['orderIds'])? count($_SESSION['orderIds']) : '0'; ?> </span></span></a>
                    </div>
                </div>
                <div class="card-body">
                    <!-- Product Listing...-->
                    <div class="col-12">
                        <div class="dropdown" style="width: 100%;">
                            <button onclick="myFunction()" class="btn btn-primary" style="width: 100%;">Search Product</button>
                            <div id="myDropdown" class="dropdown-content" style="width: 100%;">
                                <input type="text" placeholder="Search.." id="myInput" onkeyup="filterFunction()" style="width: 100%;">
                                <?php 
                                    if(!empty($product_list))
                                    {
                                        foreach($product_list as $pl)
                                        {
                                ?>
                                            <a href="#about" style="width: 100%;">
                                                <img style="width: 70px;" src="<?php echo site_url().'writable/uploads/product_image/'.$pl['image'][0]; ?>" alt=""> <?= $pl['name'] ?>
                                                <button class="btn btn-primary btn-sm" style="float: right; padding-right: 10px;">Add to Bill</button>
                                            </a>
                                <?php
                                        }
                                    }
                                ?>
                            </div>
                        </div>
                        <div id="products">
                            <div class="row mx-0">
                                <div class="table-responsive">
                                    <form method="post" action="<?php echo site_url(); ?>admin/Order/placeOrder" enctype="multipart/form-data">
                                    <?= csrf_field() ?>
                                        <table id="example3" class="display" style="min-width: 845px">
                                            <thead>
                                                <tr>
                                                    <th>Sl. No.</th>
                                                    <th>Product Image</th>
                                                    <th>Product Name</th>
                                                    <th>Product Price</th>
                                                    <th>Qunatity</th>
                                                    <th>Total Item Price</th>
                                                    <th>Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                if(!empty($product_list))
                                                {
                                                    $i = 1;
                                                    foreach($product_list as $pl)
                                                    {
                                                ?>
                                                        <tr id="product_id_<?php echo $pl['id']; ?>">
                                                            <td><?php echo $i++; ?></td>
                                                            <td><?php 
                                                                foreach($pl['image'] as $pimg)
                                                                {
                                                            ?>
                                                                    <img src="<?php echo site_url().'writable/uploads/product_image/'.$pimg; ?>" style="float:left; margin:5px;" width="50" height="50" alt="">
                                                            <?php
                                                                }
                                                            ?></td>
                                                            <td><?php echo $pl['name']; ?></td>
                                                            <td><?php echo $pl['price']; ?></td>
                                                            <td><input name="quantity_<?php echo $pl['id']; ?>" value="0" onchange="updateQuantity(this.value, <?php echo $pl['id']; ?>, <?php echo $pl['price']; ?>)" /></td>
                                                            <td id="itemTotalAmt_<?php echo $pl['id']; ?>">0</td>
                                                            <td><a class="btn btn-danger shadow btn-xs sharp" onclick="deleteItem(<?php echo $pl['id']; ?>)"><i class="fa fa-trash"></i></a></td>
                                                        </tr>
                                                <?php
                                                    }
                                                }
                                                ?>
                                                <tr>
                                                    <td colspan="5">Total Order Amount</td>
                                                    <td id="totalOrderAmt">0</td>
                                                    <td>&nbsp;</td>
                                                </tr>
                                                <tr>
                                                    <td colspan="5">Discount Amount</td>
                                                    <td><input type="text" name="discount" /></td>
                                                    <td>&nbsp;</td>
                                                </tr>
                                                <tr>
                                                    <td colspan="5">Order Table No.</td>
                                                    <td><input type="text" name="order_table_no" /></td>
                                                    <td>&nbsp;</td>
                                                </tr>
                                                <tr>
                                                    <td colspan="5">Customer Name</td>
                                                    <td><input type="text" name="customer_name" /></td>
                                                    <td>&nbsp;</td>
                                                </tr>
                                                <tr>
                                                    <td colspan="5">Customer Phone</td>
                                                    <td><input type="text" name="customer_phone" /></td>
                                                    <td>&nbsp;</td>
                                                </tr>
                                                <tr>
                                                    <td colspan="5">Customer Address</td>
                                                    <td><textarea name="customer_address" row="4" col="8"></textarea></td>
                                                    <td>&nbsp;</td>
                                                </tr>
                                                <tr>
                                                    <td colspan="7"><button type="submit" class="btn btn-primary">Placed Order</button></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- <div id="products">
                        <div class="row mx-0" id="product_list">
                            <?php 
                                if(!empty($product_list))
                                {
                                    $i=0;
                                    foreach($product_list as $pl)
                                    {
                            ?>
                                        <div class="col-lg-4 col-md-6 <?php if($i>0){?> pt-md-0 pt-3 <?php } ?>">
                                            <div class="card d-flex flex-column align-items-center">
                                                <div class="product-name"><?= $pl['name'] ?></div>
                                                <div class="card-img"> <img src="<?php echo site_url().'writable/uploads/product_image/'.$pl['image'][0]; ?>" alt=""> </div>
                                                <div class="card-body pt-5">
                                                    <div class="d-flex align-items-center price">
                                                        <div class="del mr-2"  style="text-decoration: none;"><span class="text-dark"><?= $pl['price'] ?> INR</span></div>
                                                    </div>
                                                    <div class="del mr-2"><button type="button" class="btn btn-primary btn-sm" onclick="addToBill(<?php echo $pl['id']; ?>)">Add to Bill</button></div>
                                                </div>
                                            </div>
                                        </div>
                            <?php
                                    $i++;
                                    }
                                }
                            ?>
                        </div>
                    </div> -->
                </div>
            </div>
        </div>
    </div>
    <input type="hidden" name="<?= csrf_token() ?>" value="<?= csrf_hash() ?>" id="csrf"/>
<?=$this->endSection()?>
<?=$this->section("stylesheets")?>
<link href="<?php echo site_url(); ?>assets/css/productlist.css" rel="stylesheet">
<?=$this->endSection()?>
<?=$this->section("scripts")?>
<script src="<?php echo site_url(); ?>assets/js/productlist.js"></script>
<script>
    function addToBill(id)
    {
        
        $('.content-overlay').css('display','block');
        //return false;
        var request = $.ajax({
        url: '<?php echo site_url(); ?>admin/Order/addToBill',
        type: "POST",
        data: { id: id, csrf_test_name: $('#csrf').val(),},
        dataType: "json"
        });
        request.done(function(res){
            console.log(res);
            if(res.SUCCESS == 1)
            {
                $('.content-overlay').css('display','none');
                $('#cart_items').html(res.DATA);
            }
            else if(res.ERROR==1){
                $('.content-overlay').css('display','none');
            }
        });
        request.fail(function(jqXHR, textStatus) {
            $('.content-overlay').css('display','none');
        });	
    }
    function filterProduct()
    {
        var categoryIds = [];
        $('.product_filterData:checked').each(function() {
            categoryIds.push(this.value); 
        });
        $('.content-overlay').css('display','block');
        var request = $.ajax({
        url: '<?php echo site_url(); ?>admin/Order/productLoading',
        type: "POST",
        data: { id: categoryIds, csrf_test_name: $('#csrf').val(),},
        dataType: "json"
        });
        request.done(function(res){
            console.log(res);
            if(res.SUCCESS == 1)
            {
                $('.content-overlay').css('display','none');
                $('#product_list').html(res.DATA);
                console.log(res.DATA);
            }
            else if(res.ERROR==1){
                $('.content-overlay').css('display','none');
                $('#product_list').html(res.DATA);
                console.log(res.DATA);
            }
        });
        request.fail(function(jqXHR, textStatus) {
            $('.content-overlay').css('display','none');
        });	
    }
    /* When the user clicks on the button,
    toggle between hiding and showing the dropdown content */
    function myFunction() {
        document.getElementById("myDropdown").classList.toggle("show");
    }

    function filterFunction() {
        var input, filter, ul, li, a, i;
        input = document.getElementById("myInput");
        filter = input.value.toUpperCase();
        div = document.getElementById("myDropdown");
        a = div.getElementsByTagName("a");
        for (i = 0; i < a.length; i++) {
            txtValue = a[i].textContent || a[i].innerText;
            if (txtValue.toUpperCase().indexOf(filter) > -1) {
            a[i].style.display = "";
            } else {
            a[i].style.display = "none";
            }
        }
    }
</script>
<?=$this->endSection()?>