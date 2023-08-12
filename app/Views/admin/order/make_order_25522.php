<?= $this->extend('admin/layout/default') ?>

<?=$this->section("stylesheets")?>
    <link href="<?php echo site_url(); ?>assets/admin/vendor/datatables/css/jquery.dataTables.min.css" rel="stylesheet" />
    <style>
	.header {
	  display: flex;
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
		padding: 10px;
	    margin: 10px;
	    width: 70%;
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
                    <div class="col-lg-4">
                        <a href="<?php echo site_url(); ?>admin/Order/cartData"><span>Cart Item(s) <span id="cart_items" class="badge badge-primary badge-pill"><?php echo !empty($_SESSION['orderIds'])? count($_SESSION['orderIds']) : '0'; ?> </span></span></a>
                    </div>
                </div>
                <div class="card-body">
                    <!-- Filtering Bar -->
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

                    <!-- Product Listing...-->
                    <div id="products">
                    	<input id="filter" type="text" placeholder="Search Product..." />
                        <div class="row mx-0" id="results">
                            <?php 
                                if(!empty($product_list))
                                {
                                    $i=0;
                                    foreach($product_list as $pl)
                                    {
                            ?>
                                        <div class="col-lg-4 col-md-6 results <?php if($i>0){?> pt-md-0 pt-3 <?php } ?>">
                                            <div class="card d-flex flex-column align-items-center">
                                                <div class="product-name"><?= $pl['name'] ?></div>
                                                <div class="card-img"> <img src="<?php echo site_url().'writable/uploads/product_image/'.$pl['image'][0]; ?>" alt=""> </div>
                                                <div class="card-body pt-5">
                                                    <div class="d-flex align-items-center price">
                                                        <div class="del mr-2"  style="text-decoration: none;"><span class="text-dark"><?= $pl['price'] ?> INR</span></div>
                                                    </div>
                                                    <div class="del mr-2"><button type="button" class="btn btn-primary btn-sm" onclick="addToBill(<?php echo $pl['id']; ?>)">Add to KOT</button></div>
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
    $("#filter").keyup(function() {

      // Retrieve the input field text and reset the count to zero
      var filter = $(this).val(),
        count = 0;

      // Loop through the comment list
      $('#results .results').each(function() {


        // If the list item does not contain the text phrase fade it out
        if ($(this).text().search(new RegExp(filter, "i")) < 0) {
          $(this).hide();  // MY CHANGE

          // Show the list item if the phrase matches and increase the count by 1
        } else {
          $(this).show(); // MY CHANGE
          count++;
        }

      });

    });
</script>
<?=$this->endSection()?>