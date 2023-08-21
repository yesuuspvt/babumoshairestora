<?= $this->extend('admin/layout/default') ?>

<?=$this->section("stylesheets")?>
<style>
    table.dataTable thead th {
        font-size: 14px !important;
        font-weight: 500 !important;
    }
</style>
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
                    <h4 class="card-title">Daily Report <h4>
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
                                                <th>Order Status</th>
                                                <th>Table No.</th>
                                                <th>total_amount_after_gst</th>
                                                <th>customer_aadhar_no</th>
                                                <th>customer_name</th>
                                                <th>customer_mobile</th>
                                                <th>customer_address</th>
                                                <th>payment_type</th>
                                                <th>discount_type</th>
                                                <th>discount_amount</th>
                                                <th>gst_amount</th>
                                                




                                                
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
                                                        <td class="<?php echo $pl['is_order_final']==0? 'text-warning': 'text-success' ?>"><?php echo $pl['is_order_final']==0?'Running':'Complete'; ?></td>
                                                        <td><?php echo $pl['table_no']; ?></td>
                                                        <td><?php echo $pl['total_amount_after_gst']; ?></td>
                                                        <td><?php echo $pl['customer_aadhar_no']; ?></td>
                                                        <td><?php echo $pl['customer_name']; ?></td>
                                                        <td><?php echo $pl['customer_mobile']; ?></td>
                                                        <td><?php echo $pl['customer_address']; ?></td>
                                                        <td><?php echo $pl['payment_type']; ?></td>
                                                        <td><?php echo $pl['discount_type']; ?></td>
                                                        <td><?php echo $pl['discount_amount']; ?></td>
                                                        <td><?php echo $pl['gst_amount']; ?></td>



                                                       
                                                            
                                                    </tr>
                                            <?php
                                                }
                                            }
                                            ?>
                                            
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