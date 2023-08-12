<?= $this->extend('admin/layout/default') ?>

<?=$this->section("stylesheets")?>
    <link href="<?php echo site_url(); ?>assets/admin/vendor/datatables/css/jquery.dataTables.min.css" rel="stylesheet">
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
        td{
            padding: 0px !important;
        }
        select {
            outline: none;
            padding: 2px 12px !important;
            margin: 0px 4px;
            color: #999;
            font-size: 0.85rem;
            width: 140px;
        }
    </style>
<?=$this->endSection()?>

<?=$this->section("scripts")?>
    <script src="<?php echo site_url(); ?>assets/admin/vendor/datatables/js/jquery.dataTables.min.js"></script>
    <script src="<?php echo site_url(); ?>assets/admin/js/plugins-init/datatables.init.js"></script>
<?=$this->endSection()?>

<?=$this->section("content")?>
    <div class="row">
        <div class="col-6">
            <div class="card" style="height:100%;">
                <div class="card-header">
                    <h4 class="card-title">KOT Order</h4>
                </div>
                <div class="card-body">
                    <div id="products">
                        <div class="row">
                            <div class="col-lg-12">
                            <div class="table-responsive">
                                <form method="post" action="<?php echo site_url(); ?>admin/Order/placeOrder" enctype="multipart/form-data">
                                <?= csrf_field() ?>
                                    <table id="example3" class="display table" cellpadding="3" cellspacing="3">
                                        <thead>
                                            <tr>
                                                <td>Name</td>
                                                <td>Price</td>
                                                <td>Qunatity</td>
                                                <td>Total</td>
                                                <td>Action</td>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            if(!empty($order_item))
                                            {
                                                $i = 1;
                                                foreach($order_item as $pl)
                                                {
                                            ?>
                                                    <tr id="product_id_<?php echo $pl['product_id']; ?>">
                                                        <!-- <td><?php 
                                                            //foreach($pl['product_image'] as $pimg)
                                                            //{
                                                        ?>
                                                                <img src="<?php //echo site_url().'writable/uploads/product_image/'.$pimg['image']; ?>" style="float:left; margin:5px;" width="50" height="50" alt="">
                                                        <?php
                                                            //}
                                                        ?></td> -->
                                                        <td><?php echo $pl['product']['name']; ?></td>
                                                        <td><?php echo $pl['product']['price']; ?></td>
                                                        <td><input size="2" name="quantity_<?php echo $pl['id']; ?>" value="<?php echo $pl['quantity']; ?>" onchange="updateOrderQuantity(this.value, <?php echo $pl['product_id']; ?>, <?php echo $pl['order_id']; ?>)" /></td>
                                                        <td id="itemTotalAmt_<?php echo $pl['product_id']; ?>"><?php echo ($pl['product_amount']*$pl['quantity']); ?></td>
                                                        <td><a class="btn btn-danger shadow btn-xs sharp" onclick="deleteItem(<?php echo $pl['product_id']; ?>, <?php echo $pl['order_id']; ?>)"><i class="fa fa-trash"></i></a></td>
                                                    </tr>
                                            <?php
                                                }
                                            }
                                            ?>
                                            <tr>
                                                <td colspan="4">Total Order Amount</td>
                                                <td id="totalOrderAmt"><?php echo $order['order_amount']; ?></td>
                                            </tr>
                                            <tr>
                                                <td colspan="4">Discount Amount</td>
                                                <td><input size="5" type="text" name="discount" value="<?php echo $order['discount_amount']; ?>" onChange="updateOrdeDiscountAmount(this.value, <?php echo $pl['order_id']; ?>)"/></td>
                                            </tr>
                                            <tr>
                                                <td colspan="4">Total Amount</td>
                                                <td><?php echo $order['total_amount']; ?></td>
                                            </tr>
                                            <tr>
                                                <td colspan="4">Order Table No.</td>
                                                <td><?php echo $order['table_no']; ?></td>
                                            </tr>
                                            <!--<tr>
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
                                                <td colspan="5"><a href="<?php echo site_url(); ?>print-kot-orders/<?php echo $order['id']; ?>" class="btn btn-primary btn-sm">Print KOT Order</a>
                                                <a target="_blank" href="<?php echo site_url(); ?>admin/Order/printOrder/<?php echo $order['id']; ?>" class="btn btn-primary btn-sm">Generate Bill</a>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </form>
                            </div>
                        </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <!-- </div>
    <div class="row"> -->
        <div class="col-6">
            <div class="card" style="height:100%;">
                <div class="row card-header">
                    <div class="col-lg-4">
                        <h4 class="card-title">Products</h4>
                    </div>
                    <div class="col-lg-4">&nbsp;</div>
                    <!-- <div class="col-lg-4">
                        <a href="<?php echo site_url(); ?>admin/Order/cartData"><span>Cart Item(s) <span id="cart_items" class="badge badge-primary badge-pill"><?php echo !empty($_SESSION['orderIds'])? count($_SESSION['orderIds']) : '0'; ?> </span></span></a>
                    </div> -->
                </div>
                <div class="card-body">
                    <!-- Filtering Bar -->
                    <!-- <div id="filterbar" class="collapse">
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
                    </div> -->

                    <!-- Product Listing...-->
                    <div id="products">
                        <div class="row">
                            <div class="col-12 mb-2">
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
                                                <div class="card-img"> <img style="padding-top: 0px;"  src="<?php echo site_url().'writable/uploads/product_image/'.$pl['image'][0]; ?>" alt=""> </div>
                                                <div class="card-body pt-5">
                                                    <div class="d-flex align-items-center price">
                                                        <div class="del mr-2"  style="text-decoration: none;"><span class="text-dark"><?= $pl['price'] ?> INR</span></div>
                                                    </div>
                                                    <div class="del mr-2 align-items-center"><button  type="button" class="btn btn-primary btn-sm" onclick="addToKOTOrder(<?php echo $pl['id']; ?>, <?php echo $order['id']; ?>)">Add</button></div>
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
    function addToKOTOrder(product_id, order_id)
    {
        $('.content-overlay').css('display','block');
        var request = $.ajax({
        url: '<?php echo site_url(); ?>admin/Order/insertProductToKotOrder',
        type: "POST",
        data: { product_id: product_id,order_id:order_id, csrf_test_name: $('#csrf').val(),},
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
    function updateQuantity(qty, id, price)
    {
        console.log(qty);
        var totalOrderAmt = Math.floor($('#totalOrderAmt').text());
        var totalItemAmt = (qty*price);
        totalOrderAmt += totalItemAmt;
        $('#itemTotalAmt_'+id).html(totalItemAmt);
        $('#totalOrderAmt').html(totalOrderAmt);
    }
    function deleteItem(product_id,order_id)
    {
        var cnf = confirm("Do you want to delete KOT order item ? ");
        if(!cnf)
        {
            return false;
        }
        $('.content-overlay').css('display','block');
        var request = $.ajax({
        url: '<?php echo site_url(); ?>admin/Order/deleteKOTItem',
        type: "POST",
        data: { product_id: product_id,order_id:order_id, csrf_test_name: $('#csrf').val(),},
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
                $('.content-overlay').css('display','none');
                alert('The item not removed, plz try later');
            }
        });
        request.fail(function(jqXHR, textStatus) {
            $('.content-overlay').css('display','none');
            alert('Something went wrong try later');
        }); 
    }
    function updateOrderQuantity(quantity,product_id,order_id)
    {
        // var cnf = confirm("Do you want to delete KOT order item ? ");
        // if(!cnf)
        // {
        //     return false;
        // }
        $('.content-overlay').css('display','block');
        var request = $.ajax({
        url: '<?php echo site_url(); ?>admin/Order/updateKOTOrderQuantity',
        type: "POST",
        data: { quantity:quantity, product_id: product_id,order_id:order_id, csrf_test_name: $('#csrf').val(),},
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
                $('.content-overlay').css('display','none');
                alert('The item not removed, plz try later');
            }
        });
        request.fail(function(jqXHR, textStatus) {
            $('.content-overlay').css('display','none');
            alert('Something went wrong try later');
        }); 
    }
    function updateOrdeDiscountAmount(amount,order_id)
    {
        $('.content-overlay').css('display','block');
        var request = $.ajax({
        url: '<?php echo site_url(); ?>admin/Order/updateKOTOrderDiscountAmount',
        type: "POST",
        data: { amount:amount, order_id:order_id, csrf_test_name: $('#csrf').val(),},
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
                $('.content-overlay').css('display','none');
                alert('The item not removed, plz try later');
            }
        });
        request.fail(function(jqXHR, textStatus) {
            $('.content-overlay').css('display','none');
            alert('Something went wrong try later');
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
            console.log(res);
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
        filterProduct($(this).val())
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
<?=$this->endSection()?>