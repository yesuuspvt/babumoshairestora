<?= $this->extend('admin/layout/default') ?>

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
            <div class="card" style="height:100%;">
                <div class="card-header">
                    <h4 class="card-title">Cart Management</h4>
                </div>
                <div class="card-body">
                    <div id="products">
                        <div class="row mx-0">
                            <div class="table-responsive">
                                <form method="post" action="<?php echo site_url(); ?>admin/Order/placeOrder" enctype="multipart/form-data">
                                <?= csrf_field() ?>
                                    <table class="table table-responsive-md" style="min-width: 845px">
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
                                                <td><input type="text" name="discount" value="0" /></td>
                                                <td>&nbsp;</td>
                                            </tr>
                                            <tr>
                                                <td colspan="5">Order Table No.</td>
                                                <td><input type="text" name="order_table_no" /></td>
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
                                                <td colspan="7"><button type="submit" class="btn btn-primary">Generate KOT</button></td>
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
                var totalOrderAmt = Math.floor($('#totalOrderAmt').text());
                var itemPrice = Math.floor($('#itemTotalAmt_'+id).text());
                totalOrderAmt -= itemPrice;
                $('#totalOrderAmt').html(totalOrderAmt);
                $('#product_id_'+id).remove();
            }
            else if(res.ERROR==1){
                $('.content-overlay').css('display','none');
            }
        });
        request.fail(function(jqXHR, textStatus) {
            $('.content-overlay').css('display','none');
        });	
    }
</script>
<?=$this->endSection()?>