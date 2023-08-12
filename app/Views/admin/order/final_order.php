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
                    <h4 class="card-title">KOT To Final Order Management</h4>
                </div>
                <div class="card-body">
                    <div id="products">
                        <div class="row mx-0">
                            <div class="table-responsive">
                                <form method="post" action="<?php echo site_url(); ?>admin/Order/placeOrder" enctype="multipart/form-data">
                                <?= csrf_field() ?>
                                    <table id="example3" class="display" style="min-width: 845px">
                                        <thead>
                                            <tr>
                                                <th>Sl. No.</th>
                                                <th>KOT Invoice</th>
                                                <th>KOT Order</th>
                                                <th>Total Amount</th>
                                                <th>Order Type</th>
                                                <th>Table No.</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            if(!empty($order_list))
                                            {
                                                $i = 1;
                                                foreach($order_list as $pl)
                                                {
                                            ?>
                                                    <tr id="order_id_<?php echo $pl['id']; ?>">
                                                        <td><?php echo $i++; ?></td>
                                                        <td><?php echo $pl['invoice_no']; ?></td>
                                                        <td><?php echo $pl['order_id']; ?></td>
                                                        <td><?php echo $pl['total_amount']; ?></td>
                                                        <td><?php echo $pl['order_type']; ?></td>
                                                        <td><?php echo $pl['table_no']; ?></td>
                                                        <td><a href="<?php echo  site_url(); ?>admin/Order/editKotFinalOrder/<?php echo $pl['id']; ?>" target="_blank" class="btn btn-primary shadow btn-xs sharp me-1"><i class="fas fa-pencil-alt"></i></a>
                                                        <a onClick="deleteKotOrder(<?php echo $pl['id']; ?>)" class="btn btn-primary shadow btn-xs sharp me-1"><i class="fa fa-trash"></i></a></td>
                                                    </tr>
                                            <?php
                                                }
                                            }
                                            ?>
                                            <!-- <tr>
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
                                            </tr> -->
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
                                            </tr> 
                                            <tr>
                                                <td colspan="7"><button type="submit" class="btn btn-primary">Generate KOT</button></td>
                                            </tr>-->
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
    <!-- Modal Order View-->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                ...
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save changes</button>
            </div>
            </div>
        </div>
    </div>
    <!-- End Modal Order View -->
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
    function deleteKotOrder(order_id)
    {
        var cnf = confirm("Do you want to delete Kot Order ? ");
        if(!cnf)
        {
            return false;
        }
        $('.content-overlay').css('display','block');
        var request = $.ajax({
        url: '<?php echo site_url(); ?>admin/Order/deleteKotOrder',
        type: "POST",
        data: { order_id: order_id, csrf_test_name: $('#csrf').val(),},
        dataType: "json"
        });
        request.done(function(res){
            console.log(res);
            if(res.SUCCESS == 1)
            {
                $('.content-overlay').css('display','none');
                location.reload()
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