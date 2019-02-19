<?php if ($text_payment) { ?>
<div class="information"><?php echo $text_payment; ?></div>
<?php }?>
<form action="<?php echo $action; ?>" method="post" id="payment">
	
	<input id="token_account" name="token_account" value="<?php echo $token_account; ?>" type="hidden"/>
	<input id="order_number" name="order_number" value="<?php echo $order_number;?>" type="hidden"/>
	<input id="customer[email]" name="customer[email]" value="<?php echo $email;?>" type="hidden"/>
	<input id="customer[name]" name="customer[name]" value="<?php echo $name;?>" type="hidden"/>
	<input id="customer[addresses][][postal_code]" name="customer[addresses][][postal_code]" value="<?php echo $postal_code;?>" type="hidden"/>
	<input id="customer[addresses][][street]" name="customer[addresses][][street]" value="<?php echo $street;?>" type="hidden"/>
	<input id="customer[addresses][][number]" name="customer[addresses][][number]" value="<?php echo $number;?>" type="hidden"/>
	<input id="customer[addresses][][completion]" name="customer[addresses][][completion]" value="<?php echo $completion;?>" type="hidden"/>
	<input id="customer[addresses][][neighborhood]" name="customer[addresses][][neighborhood]" value="<?php echo $neighborhood;?>" type="hidden"/>
	<input id="customer[addresses][][city]" name="customer[addresses][][city]" value="<?php echo $city;?>" type="hidden"/>
	<input id="customer[addresses][][state]" name="customer[addresses][][state]" value="<?php echo $state;?>" type="hidden"/>
	<input id="customer[contacts][][number_contact]" name="customer[contacts][][number_contact]" value="<?php echo $number_contact;?>" type="hidden"/>
	<input id="customer[contacts][][type_contact]" name="customer[contacts][][type_contact]" value="<?php echo $type_contact;?>" type="hidden"/>
        <input id="free" name="free" value="<?php echo $free; ?>" type="hidden"/>
	
	<?php
	foreach ($products as $product) {
		$options_names = '';
		$model = ($product['model'] != '') ? $product['model'].'-' : '';
		
		foreach ($product['option'] as $option) { 
			$options_names .= '/'.$option['name'];
		}?>
		
		<input id="transaction_product[][code]" name="transaction_product[][code]" value="<?php echo $product['product_id'];?>" type="hidden"/>
		<input id="transaction_product[][description]" name="transaction_product[][description]" value="<?php echo $model.$product['name'].$options_names;?>" type="hidden"/>
		<input id="transaction_product[][quantity]" name="transaction_product[][quantity]" value="<?php echo $product['quantity'];?>" type="hidden"/>
		<input id="transaction_product[][price_unit]" name="transaction_product[][price_unit]" value="<?php echo $product['value'];?>" type="hidden"/>
		<input id="transaction_product[][sku_code]" name="transaction_product[][sku_code]" value="" type="hidden"/>
			
	<?php 
	}?>
	
	<?php if($discount_total != 0) { ?>
	 <input id="price_discount" name="price_discount" value="<?php echo $discount_total; ?>" type="hidden"/>
	<?php } ?>
	
	<input id="price_additional" name="price_additional" value="0.00" type="hidden"/>
	<input id="shipping_type" name="shipping_type" value="<?php echo $shipping_type; ?>" type="hidden"/>
	<input id="shipping_price" name="shipping_price" value="<?php echo $shipping_total; ?>" type="hidden"/>
	<input id="url_notification" name="url_notification" value="<?php echo $url_notification; ?>" type="hidden"/>
	<!-- <input id="url_success" name="url_success" value="<?php echo $url_sucess; ?>" type="hidden"/> -->
	<!-- <input id="url_process" name="url_process" value="<?php echo $url_process; ?>" type="hidden"/> -->
	
</form>
<div class="buttons">
  <div class="right"><a id="button-confirm" class="btn btn-primary"><span><?php echo $text_confirm_order; ?></span></a></div>   
</div>
<script type="text/javascript"><!--
$('#button-confirm').bind('click', function() {
	$.ajax({
		type: 'GET',
		url: 'index.php?route=extension/payment/traycheckout/confirm',
		beforeSend: function() {
			$('#button-confirm').attr('disabled', true);
			
			$('#payment').before('<div class="attention"><img src="catalog/view/theme/default/image/loading.gif" alt="" /> <?php echo $text_wait; ?></div>');
		},
		success: function() {
			$('#payment').submit();
		}
	});
});
//--></script>