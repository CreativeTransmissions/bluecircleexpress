<form class="admin-form box-form round" id="edit_product_form" method="post" autocomplete="false">
	<fieldset>
		<legend>Update Customer details:</legend>
		<div class="inline-field">
			<label for="name">Product Name</label>
			<input class="input-long" type="text" name="name" id="name"/>
		</div>
		<div class="inline-field">
			<label for="group">Paddle Id</label>
			<input class="input-long" type="text" name="paddleid" id="paddleid"/>
		</div>
		<div class="inline-field">
			<label for="group">Other Fields (if any)</label>
			<input class="input-long" type="text" name="" id=""/>
		</div>		
		<div class="inline-field">
			<label for="group">Other Fields (if any)</label>
			<input class="input-long" type="text" name="" id=""/>
		</div>


	</fieldset>
	<fieldset>
		<div class="inline-field textareafield-margin">		
			<textarea class="input-longs"  name="description" placeholder='Product Description' id="description" cols="97" rows="6"/> </textarea>
		</div>
	</fieldset>

	<input type="hidden" name="id" value=""/>
	<input type="hidden" name="action" value="ct_save_record"/>
	<input type="hidden" name="update" value="ct_products"/>
	<div class="inline-field">
		<?php submit_button('Save Product Details', 'primary', 'save_product', true, array('class'=>'submit')); ?>
	</div>
	<div class="inline-field">
		<div class="spinner"></div>
	</div>
	<div class="clear"></div>
</form>
<form id="table-form" class="admin-form" method="post" action="options.php" autocomplete="false">
	<?php settings_fields( 'ct_products' ); ?>
	<?php do_settings_sections( 'ct_products' ); ?>
	<table id="ct_products_table" class="settings-table">
		<thead>
			<tr><th>Paddle Id</th><th>Name</th><th>Description</th><th class="actions"><div class="spinner"></div></th></tr>
		</thead>
		<tbody>
		<tr><td colspan="4" class="empty-table"><div class="spinner"></div><?php echo $this->empty_message; ?></td></tr>
		</tbody>
	</table>
</form>
