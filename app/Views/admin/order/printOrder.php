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
    <table width="100%" align="center">
      <tr>
        <td></td>
        <td align="center">INVOICE</td>
        <td></td>
      </tr>
      <tr>
        <td></td>
        <td align="center">Babumosai Restora</td>
        <td></td>
      </tr>
      <tr>
        <td></td>
        <td align="center">INVOICE NO- <?php echo "INV".$order['invoice_no']; ?></td>
        <td></td>
      </tr>
      <tr>
        <td></td>
        <td align="center"><?php echo date('d/m/Y H:i:s', strtotime($order['created_at'])); ?></td>
        <td></td>
      </tr>
      <tr>
        <td></td>
        <td align="center">ORDER ID- <?php echo $order['order_id']; ?></td>
        <td></td>
      </tr>
      <tr>
        <td></td>
        <td align="center">Call Us- 9093865094</td>
        <td></td>
      </tr>
      <tr>
        <td></td>
        <td>
          <div style="text-align: center;">
            <?php for($i=1; $i<=9; $i++){ ?>
              <i class="fa fa-snowflake-o" aria-hidden="true"></i>
            <?php } ?>
          </div>
        </td>
        <td></td>
      </tr>
      <tr>
        <td ></td>
        <td>
          <table cellspacing="0" style="min-height: 80px;width: 100%;">
              <tr>
                <th align="left">Item</th>
                <th align="center">MRP</th>
                <th align="center">Qty</th>
                <th align="center">GST %</th>
                <th align="right">Total</th>
            </tr>
            <?php
            $total_price=0;
            $total_product_price=0;
            $total_delivery_charges=0;
            if(!empty($orderitem)){
              foreach($orderitem as $odata){
            ?>
            <tr>
              <td align="left"><?php echo $odata['product']['name']; ?></td>
              <td align="center"><?php echo number_format($odata['product_amount'],0); ?></td>
              <td align="center"><?php echo $odata['quantity']; ?></td>
              <td align="center"><?php echo $odata['product_gst_percentage']; ?></td>
              <td align="right"><?php echo ($odata['product_amount']*$odata['quantity']); ?></td>
            </tr>
            <?php
               }
              }
              $total_price = $order['order_amount'];
            ?>
          </table>
        </td>
        <td></td>
      </tr>
      <tr>
        <td ></td>
        <td>
          <hr style="border: 1px solid #000;">
        </td>
        <td ></td>
      </tr>
      <tr>
        <td></td>
        <td>
          <table style="width:100%">
            <tr>
              <td colspan="2"><span style="font-weight: 400;">TOTAL</span></td>
              <td align="right"><?php echo number_format($total_price, 2); ?></td>
            </tr>
            <tr>
              <td colspan="2"><span style="font-weight: 400;">Discount</span></td>
            <td align="right">
              <?php echo number_format($order['discount_amount'], 2); ?>
                
              </td>
            </tr>
            <tr >
            <td colspan="2"><span style="font-weight: 400;">Net Total</span></td>

            <td align="right"><?php echo number_format(($total_price-$order['discount_amount']), 2); ?></td>
          </tr>
            <tr >
            <td colspan="2"><span style="font-weight: 400;">Net Total with GST</span></td>
            <td align="right"><?php echo number_format(($order['total_amount_after_gst']), 2); ?></td>
          </tr>
          </table>
        </td>
        <td></td>
      </tr>
      
      <tr>
          <td colspan="3" align="left">Order Type : <?php echo $order['order_type']; echo $order['order_type']=='TABLE'? '( NO- '.$order['table_no']. ')':''; ?></td>
      </tr>
      <tr>
        <td></td>
        <td>
          <div style="text-align: center;">
            <?php for($i=1; $i<=9; $i++){ ?>
              <i class="fa fa-snowflake-o" aria-hidden="true"></i>
            <?php } ?>
          </div>
        </td>
        <td></td>
      </tr>
      <tr>
        <td></td>
        <td><h3 style="text-align: center; font-weight: 400;padding: 10px;font-size: 15px;">THANK YOU, VISIT AGAIN</h3></td>
        <td></td>
      </tr>
    </table>
  </div>
<script>
print();
</script>