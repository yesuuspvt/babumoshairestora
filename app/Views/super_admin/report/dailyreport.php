<?= $this->extend('super_admin/layout/default') ?>

<?=$this->section("stylesheets")?>
<style>
    table.dataTable thead th {
        font-size: 14px !important;
        font-weight: 500 !important;
    }
    .card-body input[type="radio"] {
    visibility: visible !important;
}
</style>
    <link href="<?php echo site_url(); ?>assets/admin/vendor/datatables/css/jquery.dataTables.min.css" rel="stylesheet">

    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/dt/dt-1.10.13/datatables.min.css"/>
    <!-- Include Required Prerequisites soma started -->

<!-- <link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/bootstrap/3/css/bootstrap.css" /> -->
 
<!-- Include Date Range Picker -->

<link rel="stylesheet" type="text/css" href="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.css" />
<?=$this->endSection()?>

<?=$this->section("scripts")?>
    <script type="text/javascript" src="https://cdn.datatables.net/v/dt/dt-1.10.13/datatables.min.js"></script>
	<script type="text/javascript" src="https://cdn.datatables.net/1.10.13/js/dataTables.bootstrap.min.js"></script>

    <script src="<?php echo site_url(); ?>assets/admin/vendor/datatables/js/jquery.dataTables.min.js"></script>
    <script src="<?php echo site_url(); ?>assets/admin/js/plugins-init/datatables.init.js"></script>

    <!-- Include Required Prerequisites soma started -->
<!-- <script type="text/javascript" src="//cdn.jsdelivr.net/jquery/1/jquery.min.js"></script> -->
<script type="text/javascript" src="//cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>

 
<!-- Include Date Range Picker -->
<script type="text/javascript" src="//cdn.jsdelivr.net/bootstrap.daterangepicker/2/daterangepicker.js"></script>

<?=$this->endSection()?>

<?=$this->section("content")?>
    <div class="row">
        <div class="col-12">
            <div class="card" style="height:100%;">
                <div class="card-header">
                    <h4 class="card-title"> Report<h4>
                </div>
                <div class="card-body">
                    <form method="post" action="<?php echo site_url(); ?>report/<?php echo $title; ?>" enctype="multipart/form-data">
                        <?= csrf_field() ?>
                        <input type="hidden" name="startdate" id="startdate" value="<?php echo date('Y-m-d'); ?>">
                        <input type="hidden" name="enddate" id="enddate" value="<?php echo date('Y-m-d'); ?>">
                        <input type="hidden" name="month" id="month" value="<?php echo date('m'); ?>">
                        <input type="hidden" name="year" id="year" value="<?php echo date('Y'); ?>">
                        <div class="row">
                        <div class="col-3"></div>
                            <?php if($title=='report_daywise'){?>
                            <div class="col-3">
                                <ul>
                                    <li>
                                        <input type="radio" id="daily" name="report" value="Daily" checked onclick="changeReportType('daily')">
                                        <label for="daily">Daily</label>
                                    </li>
                                    <li>
                                        <input type="radio" id="monthly" name="report" value="Monthly" onclick="changeReportType('monthly')">
                                        <label for="monthly">Monthly</label>
                                    </li>
                                    <li>
                                        <input type="radio" id="yearly" name="report" value="Yearly"  onclick="changeReportType('yearly')">
                                        <label for="yearly">Yearly</label>
                                    </li>
                                    <!-- <li><input type="submit"/></li> -->
                                </ul>
                            </div>
                            <div class="col-3">
                                <ul>
                            
                                    <li  class="d-block" id="dailyReport">
                                        <input type="text" name="daterange" value="" />
                                    </li>
                                
                                    <li  class="d-none" id="monthlyReport">
                                        <span label for="selectmonthly">Month:</label>
                                        <select name="monthly" id="selectmonthly">
                                            <option value=''>--Select Month--</option>
                                            <option value='1'>Janaury</option>
                                            <option value='2'>February</option>
                                            <option value='3'>March</option>
                                            <option value='4'>April</option>
                                            <option value='5'>May</option>
                                            <option value='6'>June</option>
                                            <option value='7'>July</option>
                                            <option value='8'>August</option>
                                            <option value='9'>September</option>
                                            <option value='10'>October</option>
                                            <option value='11'>November</option>
                                            <option value='12'>December</option>
                                        </select>
                                        <span label for="selectyearly">Year:</label>
                                        <select name="yearly" id="selectyearly0">
                                            <option value=''>--Select Year--</option>
                                            <?php for ($i=2023; $i <2033 ; $i++) { 
                                               
                                                    echo "<option value='$i'>$i</option>";
                                            }?>
                                        </select>
                                    </li>
                                    
                                    <li class="d-none" id="yearReport">
                                        <span label for="selectyearly">Year:</label>
                                        <select name="yearly" id="selectyearly1">
                                            <option value=''>--Select Year--</option>
                                            <?php for ($i=2023; $i <2033 ; $i++) { 
                                                
                                                    echo "<option value='$i'>$i</option>";
                                            } ?>
                                        </select>
                                    </li>
                                
                                </ul>
                            </div>
                            <?php }elseif($title=='payment_type'){ ?>
                                <div class="col-3">
                                    <ul>
                                        <li>
                                            <input type="radio" id="daily" name="report" value="Cash" checked onclick="changeReportType('daily')">
                                            <label for="cash">Cash</label>
                                        </li>
                                        <li>
                                            <input type="radio" id="monthly" name="report" value="Digital" onclick="changeReportType('monthly')">
                                            <label for="monthly">Digital</label>
                                        </li>
                                        <!-- <li><input type="submit"/></li> -->
                                    </ul>
                                </div>
                                <div class="col-3">
                                    <ul>
                                
                                        <li  >
                                            <input type="text" name="daterange" value="" />
                                        </li>
                                    
                                    
                                    </ul>
                                </div>
                            <?php }else{ ?>
                                <div class="col-3">
                                  
                                    <ul>
                                        <li>
                                            <input type="radio" id="daily" name="report" value="Summery" checked onclick="changeReportType('daily')" hidden>
                                            <!-- <label for="cash">Cash</label> -->
                                        </li>
                                        <li  >
                                            <input type="text" name="daterange" value="" />
                                        </li>
                                    
                                        <!-- <li><input type="submit"/></li> -->
                                    </ul>
                                </div>
                            <?php } ?>
                            <div class="col-3"></div>
                        </div>
                       
                    </form>
                </div>
                 <div class="card-body">
                    <div id="products">
                        <div class="row mx-0">
                            <div class="table-responsive">
                                <!-- <form method="post" action="<?php echo site_url(); ?>admin/Order/placeOrder" enctype="multipart/form-data">
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
                                </form> -->
                                <table id="item-list" class="table table-bordered table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th>id</th>
                                            <th>order id</th> 
                                            <th>user id</th> 
                                            <th>invoice no</th>
                                            <th>order amount</th> 
                                            <th>discount type</th>
                                            <th>discount amount</th> 
                                            <th>gst amount</th> 
                                            <th>total amount</th>
                                            <th>total amount after gst</th>
                                            <th>payment type</th>
                                            <th>order type</th>
                                            <th>table no</th> 
                                        </tr>
                                    </thead>
                                    <tbody>


                                    </tbody>
                                </table>
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

        function changeReportType(report_type)
    {
        $('#yearReport').removeClass('d-block');
        $('#monthlyReport').removeClass('d-block');
        $('#dailyReport').removeClass('d-block');
        $('#yearReport').removeClass('d-none');
        $('#monthlyReport').removeClass('d-none');
        $('#dailyReport').removeClass('d-none');
        console.log(report_type);
        switch (report_type) {
            case 'daily':
                $('#dailyReport').addClass('d-block');
                $('#monthlyReport').addClass('d-none');
                $('#yearReport').addClass('d-none');
            break;
            case 'monthly':
                $('#monthlyReport').addClass('d-block');
                $('#dailyReport').addClass('d-none');
                $('#yearReport').addClass('d-none');
            break;
            case 'yearly':
                $('#yearReport').addClass('d-block');
                $('#dailyReport').addClass('d-none');
                $('#monthlyReport').addClass('d-none');
            break;
            default:
                break;
        }

     
      
    }
    $(document).ready(function() {
        // $('#startdate').val(new data());
        // $('#enddate').val();
        // $('#month').val();
        // $('#year').val();
    var item_table= $('#item-list').DataTable({
        ajax: {
        url: '<?php echo site_url(); ?>get_items',
        type: 'GET',
        data: function (d) {
            d. report=  $('input[name="report"]:checked').val();
        d.startdate=$('#startdate').val();
        d.enddate=     $('#enddate').val();
        d.month=     $('#month').val();
        d.year=     $('#year').val();
        },
		// 'data': {
        // //    from_date: $("#from_date").val(),
        // report:  $('input[name="report"]:checked').val(),
        // startdate:$('#startdate').val(),
        // enddate:     $('#enddate').val(),
        // month:     $('#month').val(),
        // year:     $('#year').val(),
        // },
		},
		columns: [
			{ data: 'id' },
			{ data: 'order_id' },
            { data: 'user_id'}, 
            { data: 'invoice_no'},
            { data: 'order_amount'}, 
            { data: 'discount_type'},
            { data: 'discount_amount'}, 
            { data: 'gst_amount'}, 
            { data: 'total_amount'},
            { data: 'total_amount_after_gst'},
            { data: 'payment_type'},
            { data: 'order_type'},
            { data: 'table_no'}, 
		],
		processing: true,
		serverSide: true
    });

	$("#selectyearly0").on("change",function(){
        alert($('#selectyearly0').val());
        
        $('#year').val($("#selectyearly0").val())
		item_table.draw();
	})
    $("#selectyearly1").on("change",function(){
        alert($('#selectyearly1').val());
        
        $('#year').val($("#selectyearly1").val())
		item_table.draw();
	})
    $("#selectmonthly").on("change",function(){
         $('#month').val($("#selectmonthly").val()),
		item_table.draw();
	})
    $('input[name="report"]').on("click", function() {
        item_table.draw();
    });
    // $("#startdate").on("change",function(){
	// 	item_table.draw();
	// })
	$('input[name="daterange"]').daterangepicker(
        {
            locale: {
                format: 'YYYY/MM/DD'
            },
            // startDate: '2013-01-01',
            // endDate: '2013-12-31'
        }, 
        function(start, end, label) {
            var startdate=start.format('YYYY-MM-DD')
            var enddate=end.format('YYYY-MM-DD')
            $('#startdate').val(startdate);

            $('#enddate').val(enddate);
            // setTimeout(() => {
                item_table.draw();
            // }, 10);
            // item_table.draw();

            // alert("A new date range was chosen: " + start.format('YYYY-MM-DD') + ' to ' + end.format('YYYY-MM-DD'));
        });
});

        </script>
<?=$this->endSection()?>


    