<?php if (isset($oct_popup_cart_data['status']) && $oct_popup_cart_data['status']) { ?>
	<div id="cart">
	  <a onclick="get_oct_popup_cart();"><span id="cart-total"><?php echo $text_items; ?></span></a>
	</div>
<?php } else { ?>
	<div id="cart">
	  <a href="<?php echo $cart; ?>"><span id="cart-total"><?php echo $text_items; ?></span></a>
	</div>
<?php } ?>