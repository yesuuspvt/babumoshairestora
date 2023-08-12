<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
<style>
@media print {
  body * {
    visibility: hidden;
  }
  #section-to-print, #section-to-print * {
    visibility: visible;
  }
  #section-to-print {
    position: absolute;
    left: 0;
    top: 0;
  }
}
</style>
<div id="section-to-print">
    <table style="width: 100%;">
      <tr>
        <td colspan="3"><p style="text-align: center;font-size: 20px;">KOT</p></td>
      </tr>
      <tr>
        <td colspan="3"><h3 style="text-align: center;font-size: 17px;">URBAN CAFE</h3></td>
      </tr>
      <tr>
        <td colspan="3" align="center">KOT NO- <?php echo $order['invoice_no']; ?></td>
      </tr>
      <tr>
        <td colspan="3" align="center"><?php echo date('d/m/Y H:i:s', strtotime($order['created_at'])); ?></td>
      </tr>
      <tr>
        <td colspan="3" align="center">
            <?php for($i=1; $i<=9; $i++){ ?>
              <i class="fa fa-snowflake-o" aria-hidden="true"></i>
            <?php } ?>
        </td>
      </tr>
      <tr>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td>
          <table  cellspacing="0" style="width: 100%;">
              <tr>
                  <th align="left">Item</th>
                  <th>Qty</th>
                  <th>Status</th>
              </tr>
            <?php
            $total_price=0;
            $total_product_price=0;
            $total_delivery_charges=0;
            if(!empty($orderitem)){
              foreach($orderitem as $odata){ //is_kot_generated
            ?>
            <tr>
              <td align="left"><?php echo $odata['product']['name']; ?></td>
              <td align="center"><?php echo $odata['quantity']; ?></td>
              <td align="center"><?php echo $odata['is_kot_generated']==0?'R':'C'; ?></td>
            </tr>
            <?php
               }
              }
              $total_price = $order['order_amount'];
            ?>
          </table>
        </td>
      </tr>
      <tr>
          <td colspan="3" align="left">Order Type : <?php echo $order['order_type']; ?></td>
      </tr>
      <?php
      if($order['table_no'] !="")
      {
      ?>
      <tr>
          <td colspan="3" align="left">Table No : <?php echo $order['table_no']; ?></td>
      </tr>
      <?php
      }
      ?>
    </table>
  </div>
  <p style="text-align:center;"><a href="<?php echo base_url('admin/Order/editKotFinalOrder/')?>/<?php echo (int)$order['invoice_no']; ?>">Edit Order / Generate Bill</a></p>
<script>
print();
</script>