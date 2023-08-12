<?= $this->extend('admin/layout/default') ?>

<?=$this->section("stylesheets")?>
    <link href="<?php echo site_url(); ?>assets/admin/vendor/datatables/css/jquery.dataTables.min.css" rel="stylesheet" />
    <style>
        .header {
        /* display: flex; */
        }

        .header p {
        flex: 1;
        font-weight: bold;
        }

        .results {
        display: flex;
        }

        .results p {
        flex: 1;
        }
        #filter{
            margin-bottom: 10px;
        }
        td{
            padding: 0px !important;
        }
        select {
            outline: none;
            padding: 2px 2px !important;
            margin: 0px !important;
            color: #999;
            font-size: 0.85rem;
            width: 140px;
        }
        [data-sidebar-style="full"][data-layout="vertical"] .menu-toggle .deznav .metismenu>li:hover>ul li .nav-text{
            display: inline-block !important;
        }
    </style>
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
                    <div class="col-lg-4" style="text-align: right;">
                        <a href="<?php echo site_url(); ?>admin/Order/cartData"><span>Cart Item(s) <span id="cart_items" class="badge badge-primary badge-pill"><?php echo !empty($_SESSION['orderIds'])? count($_SESSION['orderIds']) : '0'; ?> </span></span></a>
                    </div>
                </div>
                <div class="row mt-2">
                    <div class="col-2">
                        <div id="filterbar" class="collapse">
                                <form method="post" action="<?php echo site_url(); ?>admin/Order/makeOrder" enctype="multipart/form-data">
                                    <?= csrf_field() ?>
                                    <div class="box border-bottom">
                                        <div class="box-label text-uppercase d-flex align-items-center">Category Filter</div>
                                        <div id="inner-box" class="collapse mt-2 mr-1">
                                            <?php
                                                if(!empty($product_category_list))
                                                {
                                                    foreach($product_category_list as $pclKey=>$pclValue)
                                                    {
                                                
                                            ?>
                                                        <div class="my-1"> <label class="tick"><?= $pclValue ?> 
                                                            <input name="category_name[]" type="checkbox" value="<?= $pclKey ?>" class="product_filterData" onclick="filterProduct()"/>
                                                            <span class="check"></span> </label> </div>
                                            <?php   } 
                                                }
                                            ?>
                                        </div>
                                    </div>
                                </form>
                            </div>
                    </div>
                    <div class="col-5">
                            <!-- Filtering Bar -->
                            

                            <!-- Product Listing...-->
                            <div id="products">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <input id="filter" type="text" placeholder="Search Product..." class="form-control" />
                                    </div>
                                </div>
                                <div class="row" id="results">
                                    <?php 
                                        if(!empty($product_list))
                                        {
                                            $i=0;
                                            foreach($product_list as $pl)
                                            {
                                    ?>
                                                <div class="col-lg-4 col-md-6">
                                                    <div class="card d-flex flex-column align-items-center">
                                                        <div class="product-name"><?= $pl['name'] ?></div>
                                                        <div class="card-img"> <img style="padding-top: 0px;" src="<?php echo site_url().'writable/uploads/product_image/'.$pl['image'][0]; ?>" alt=""> </div>
                                                        <div class="card-body">
                                                            <div class="d-flex align-items-center price">
                                                                <div class="del mr-2"  style="text-decoration: none;"><span class="text-dark"><?= $pl['price'] ?> INR</span></div>
                                                            </div>
                                                            <div class="del mr-2"><button style="font-size: 9px !important;" type="button" class="btn btn-primary btn-sm" onclick="addToBill(<?php echo $pl['id']; ?>)">Add to KOT</button></div>
                                                        </div>
                                                    </div>
                                                </div>
                                    <?php
                                            $i++;
                                            }
                                        }
                                    ?>
                                </div>
                            </div>
                    </div>
                    <div class="col-5">
                            <div id="products">
                                <h4 class="card-title">Cart Items for KOT</h4>
                                <div class="row">
                                    <div class="col-lg-12">
                                    <div class="table-responsive">
                                        <form method="post" action="<?php echo site_url(); ?>admin/Order/placeOrder" enctype="multipart/form-data">
                                        <?= csrf_field() ?>
                                            <?php
                                            if(!empty($kot_order_product_list))
                                            {
                                            ?>
                                            <table class="table table-responsive-md" style="font-size: 12px;">
                                                <thead>
                                                    <tr>
                                                        <!-- <th>Product Image</th> -->
                                                        <td><strong>Name</strong></td>
                                                        <td><strong>Product Price</strong></td>
                                                        <td><strong>Qunatity</strong></td>
                                                        <td><strong>Total Price</strong></td>
                                                        <td><strong>Action</strong></td>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php
                                                        //echo 'sfsfsf '.count($kot_order_product_list);
                                                        //print_r($kot_order_product_list); exit;
                                                        $i = 1;
                                                        foreach($kot_order_product_list as $pl)
                                                        {
                                                            if(empty($pl))
                                                            {
                                                                break;
                                                            }
                                                    ?>
                                                            <tr id="product_id_<?php echo $pl['id']; ?>">
                                                                <!-- <td><?php 
                                                                    foreach($pl['image'] as $pimg)
                                                                    {
                                                                ?>
                                                                        <img src="<?php echo site_url().'writable/uploads/product_image/'.$pimg; ?>" style="float:left; margin:5px;" width="50" height="50" alt="">
                                                                <?php
                                                                    }
                                                                ?></td> -->
                                                                <td><?php echo $pl['name']; ?></td>
                                                                <td><?php echo $pl['price']; ?></td>
                                                                <td><input size="2" name="quantity_<?php echo $pl['id']; ?>" value="0" onchange="updateQuantity(this.value, <?php echo $pl['id']; ?>, <?php echo $pl['price']; ?>)" /></td>
                                                                <td id="itemTotalAmt_<?php echo $pl['id']; ?>">0</td>
                                                                <td><a class="btn btn-danger shadow btn-xs sharp" onclick="deleteItem(<?php echo $pl['id']; ?>)"><i class="fa fa-trash"></i></a></td>
                                                            </tr>
                                                    <?php
                                                        }
                                                    ?>
                                                    <tr>
                                                        <td colspan="3">Total Order Amount</td>
                                                        <td id="totalOrderAmt">0</td>
                                                        <td>&nbsp;</td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="3">Discount Amount</td>
                                                        <td><input size="10" type="text" name="discount" value="0" /></td>
                                                        <td>&nbsp;</td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="3">Order Type</td>
                                                        <td>
                                                            <select name="order_type" onchange="checkOrderType()">
                                                                <option value="TABLE">Table</option>
                                                                <option value="PERCEL">PERCEL</option>
                                                            </select>
                                                        </td>
                                                        <td>&nbsp;</td>
                                                    </tr>
                                                    <tr id="table_no_row">
                                                        <td colspan="3">Order Table No.</td>
                                                        <td><input size="2" type="number" name="order_table_no" onkeyup="checkTableNo(this.value)"  /></td>
                                                        <td>&nbsp;</td>
                                                    </tr>
                                                    <!-- <tr>
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
                                                    </tr> -->
                                                    <tr>
                                                        <td colspan="7"><button type="submit" class="btn btn-primary btn-sm" disabled="true" id="generate_kot">Generate KOT</button></td>
                                                    </tr>
                                                    
                                                </tbody>
                                            </table>
                                            <?php } else{
                                                echo '<p>Cart Item not available</p>';
                                            } ?>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
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
    function checkOrderType()
    {
        if($("select[name='order_type']").val() == "TABLE")
        {
            $("#generate_kot").attr("disabled",true);
            $("#table_no_row").css("display","");
            
        }
        else
        {
            $("#generate_kot").removeAttr("disabled");
            $("#table_no_row").css("display","none");
        }

    }
    function checkTableNo(value){
        if(value > 0)
        {
            $("#generate_kot").removeAttr("disabled");
        }
        else if(value == '')
        {
            $("#generate_kot").attr("disabled",true);
        }
        else
        {
            $("#generate_kot").attr("disabled",true);
        }
    }
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
                //$('#cart_items').html(res.DATA);
                location.reload();
            }
            else if(res.ERROR==1){
                $('.content-overlay').css('display','none');
            }
        });
        request.fail(function(jqXHR, textStatus) {
            $('.content-overlay').css('display','none');
        });	
    }
    function filterProduct(product_name='')
    {
        var categoryIds = [];
        $('.product_filterData:checked').each(function() {
            categoryIds.push(this.value); 
        });
        $('.content-overlay').css('display','block');
        var request = $.ajax({
        url: '<?php echo site_url(); ?>admin/Order/productLoading',
        type: "POST",
        data: { id: categoryIds,product_name:product_name, csrf_test_name: $('#csrf').val(),},
        dataType: "json"
        });
        request.done(function(res){

            if(res.SUCCESS == 1)
            {
                $('.content-overlay').css('display','none');
                $('#results').html(res.DATA);
            }
            else if(res.ERROR==1){
                $('.content-overlay').css('display','none');
                $('#results').html(res.DATA);
            }
        });
        request.fail(function(jqXHR, textStatus) {
            $('.content-overlay').css('display','none');
        });	
    }
    $("#filter").keyup(function() {
      filterProduct($(this).val());
      // Retrieve the input field text and reset the count to zero
      // var filter = $(this).val(),
      //   count = 0;

      // // Loop through the comment list
      // $('#results .results').each(function() {


      //   // If the list item does not contain the text phrase fade it out
      //   if ($(this).text().search(new RegExp(filter, "i")) < 0) {
      //     $(this).hide();  // MY CHANGE

      //     // Show the list item if the phrase matches and increase the count by 1
      //   } else {
      //     $(this).show(); // MY CHANGE
      //     count++;
      //   }

      // });

    });
</script>
<script>
    function updateQuantity(qty, id, price)
    {
        var totalOrderAmt = Math.floor($('#totalOrderAmt').text());
        var totalItemAmt = (qty*price);
        totalOrderAmt += totalItemAmt;
        $('#itemTotalAmt_'+id).html(totalItemAmt);
        $('#totalOrderAmt').html(totalOrderAmt);
    }
    function deleteItem(id)
    {
        var cnf = confirm("Do you want to delete cart item ? ");
        if(!cnf)
        {
            return false;
        }
        $('.content-overlay').css('display','block');
        var request = $.ajax({
        url: '<?php echo site_url(); ?>admin/Order/deleteCartItem',
        type: "POST",
        data: { id: id, csrf_test_name: $('#csrf').val(),},
        dataType: "json"
        });
        request.done(function(res){
            console.log(res);
            if(res.SUCCESS == 1)
            {
                $('.content-overlay').css('display','none');
                // var totalOrderAmt = Math.floor($('#totalOrderAmt').text());
                // var itemPrice = Math.floor($('#itemTotalAmt_'+id).text());
                // totalOrderAmt -= itemPrice;
                // $('#totalOrderAmt').html(totalOrderAmt);
                // $('#product_id_'+id).remove();
                location.reload();
            }
            else if(res.ERROR==1){
                $('.content-overlay').css('display','none');
            }
        });
        request.fail(function(jqXHR, textStatus) {
            $('.content-overlay').css('display','none');
        });	
    }
    $(document).ready(function(){
        $(this).find("#main-wrapper").addClass("menu-toggle");
        $(this).find(".hamburger").addClass("is-active");
    })
</script>
<?=$this->endSection()?>