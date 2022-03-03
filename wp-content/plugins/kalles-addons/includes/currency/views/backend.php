<style>
	.currencies-list table,
	.currencies-list table td {
		border-collapse: collapse;
	}
	.currencies-list table thead {
		background-color: #4d5959;
		color: #fff;
	}
	.currencies-list table thead th {
		padding: 20px;
		border: 1px solid rgba(0,0,0,.1);
	}
	.currencies-list table tbody tr td {
	   text-align: center;
	   padding: 15px;
	   background: #fff;
	   border: 1px solid rgba(0,0,0,.1);
	}
	.currencies-list table tbody tr td a {
		text-decoration: none;
	}
	.currencies-list table tfoot {
		background-color: #f8f8f8;
	}
	.currencies-list table tfoot td {
		padding: 15px;
		border: 1px solid rgba(0,0,0,.1);
	}
	#dialog ul li {
		width: 100%;
		float: left;
	}
	#dialog .frm-label {
		float: left;
		min-width: 160px;
	}
	#dialog .frm-input {
		float: left;
	}
	.wp-core-ui .button, .wp-core-ui .button-secondary {
		border-radius: 5px;
		height: 34px;
		line-height: 32px;
		box-shadow: none;
		margin-left: 10px;
		padding: 0 20px;
	}
	.wp-core-ui .button.button-primary {
		border: none;
	}
</style>
<div class="currencies-container">
	<h2><?php _e( 'All Currencies', 'kalles-addons' ); ?></h2>
	<div class="currencies-list">
		<?php $default = Kalles_Addons_Currency::woo_currency(); ?>
		<table>
			<thead>
				<tr>
					<th><?php _e( 'Currency', 'kalles-addons' ); ?></th>
					<th><?php _e( 'Currency Position', 'kalles-addons' ); ?></th>
					<th><?php _e( 'Thousand Separator', 'kalles-addons' ); ?></th>
					<th><?php _e( 'Decimal Separator', 'kalles-addons' ); ?></th>
					<th><?php _e( 'Number of Decimals', 'kalles-addons' ); ?></th>
					<th><?php printf( __( 'Exchange Rate(In %s)', 'kalles-addons' ), $default['currency'] ); ?></th>
					<th><?php _e( 'Action', 'kalles-addons' ); ?></th>
				</tr>
			</thead>
			<tbody>
				<tr class="tr-not-found">
					<td colspan="7"><p style="text-align: center"> <?php _e( 'No currency found ...', 'kalles-addons' ); ?> </p></td>
				</tr>
			</tbody>
			<tfoot>
			<tr class="currencies-list-footer">
				<td colspan="7">
					<div class="currency-action" style="text-align: right;">
						<a class="button button-secondary" id="update-currency-rate" href="javascript:void(0);"><?php _e( 'Update Rate', 'kalles-addons' ); ?></a>
						<a class="button button-primary" id="add-new-currency" href="javascript:void(0);"><?php _e( 'New Currency', 'kalles-addons' ); ?></a>
					</div>
				</td>
			</tr>
			</tfoot>
		</table>
	</div>
</div>

<div class="currencies-auto-update-setting">
	<h2><?php _e( 'Auto update currency', 'kalles-addons' ); ?></h2>
	<form method="post" action="options.php">
		<?php settings_fields( 'the4-manage-currencies' ); ?>
		<?php do_settings_sections( 'the4-manage-currencies' ); ?>
		<?php
		$time_format = get_option( 'time_format' );
		$last_update_time = 'Never';
		$last_update_time = esc_attr( get_option( 'the4_currency_auto_update_last_time' ) );
		if ( $last_update_time != 'Never' ) { ?>
			<input name="the4_currency_auto_update_last_time" type="hidden" id="the4_currency_auto_update_last_time"  value="<?php echo $last_update_time;?>">
		<?php }  ?>
		<table class="form-table">
			<tbody>
			<tr>
				<th>
					<label for="the4_currency_api_key"><?php _e( 'Api Key', 'kalles-addons' ); ?></label>
				</th>
				<td>
					<input name="the4_currency_api_key" type="text" id="the4_currency_api_key"  value="<?php echo esc_attr( get_option('the4_currency_api_key') ); ?>">
					<p><?php _e( 'Get Free Api Key from <a href="https://fixer.io/signup/free" target="_blank">Fixer.io</a>', 'kalles-addons' ); ?></p>
				</td>
			</tr>
			<tr>
				<th>
					<label for="the4_currency_auto_update_hours"><?php _e( 'Auto update after', 'kalles-addons' ); ?></label>
				</th>
				<td>
					<input name="the4_currency_auto_update_hours" type="number" id="the4_currency_auto_update_hours"  value="<?php echo esc_attr( get_option('the4_currency_auto_update_hours') ); ?>"> hour(s)
					<p><?php _e( 'Type 0 if you want to disable this function.', 'kalles-addons' ); ?></p>
				</td>
			</tr>
			<?php if ( $last_update_time ) { ?>
				<tr>
					<th><label><?php _e( 'Last update:', 'kalles-addons' ); ?></label></th>
					<td><p><?php echo get_option( 'the4_currency_auto_update_last_time' );?></p></td>
				</tr>
			<?php } ?>
			</tbody>
		</table>
		<!-- <table class="form-table">
			<tbody>
				<tr>
					<th>
						<?php //_e( 'Auto update by location', 'kalles-addons' ); ?>
					</th>
					<td>
						<label>
							<input name="the4_currency_update_by_location" type="radio" id="the4_currency_update_by_location_1"  value="1" <?php //checked(get_option('the4_currency_update_by_location', 0), 1) ?>><?php //_e('Yes', 'kalles-addons'); ?>
						</label>&nbsp;&nbsp;
						<label>
							<input name="the4_currency_update_by_location" type="radio" id="the4_currency_update_by_location_0"  value="0" <?php //checked(get_option('the4_currency_update_by_location', 0), 0) ?>><?php //_e('No', 'kalles-addons'); ?>
						</label>
					</td>
				</tr>
			</tbody>
		</table> -->
		<?php
		submit_button();
		?>
	</form>
</div>

<div id="dialog" title="<?php _e( 'New Currency', 'kalles-addons' ); ?>" style="display: none;">
	<?php
		$currency_code_options = get_woocommerce_currencies();

		foreach ( $currency_code_options as $code => $name ) {
			$currency_code_options[ $code ] = $name . '(' . get_woocommerce_currency_symbol( $code ) . ')';
		}
	?>
	<form id="currency-form">
		<input type="hidden" name="action" value="save-currency"/>
		<ul>
			<li>
				<div class="frm-label"><?php _e( 'Currency', 'kalles-addons' ); ?></div>
				<div class="frm-input">
					<select name="currency">
						<?php foreach( $currency_code_options as $code => $name): ?>
							<option value="<?php echo esc_attr( $code ); ?>"><?php echo esc_html( $name ); ?></option>
						<?php endforeach; ?>
					</select>
				</div>
			</li>
			<li>
				<div class="frm-label"><?php _e( 'Currency Position', 'kalles-addons' ); ?></div>
				<div class="frm-input">
					<select name="woocommerce_currency_pos" id="woocommerce_currency_pos"  class="wc-enhanced-select enhanced" tabindex="-1" title="Currency Position">
						<option value="left" selected="selected"><?php _e( 'Left ($99.99)', 'kalles-addons' ); ?></option>
						<option value="right"><?php _e( 'Right (99.99$)', 'kalles-addons' ); ?></option>
						<option value="left_space"><?php _e( 'Left with space ($ 99.99)', 'kalles-addons' ); ?></option>
						<option value="right_space"><?php _e( 'Right with space (99.99 $)', 'kalles-addons' ); ?></option>
					</select>
				</div>
			</li>
			<li>
				<div class="frm-label"><?php _e( 'Thousand Separator', 'kalles-addons' ); ?></div>
				<div class="frm-input"><input name="woocommerce_price_thousand_sep" id="woocommerce_price_thousand_sep" type="text" style="width:50px;" value="," class="" placeholder=""></div>
			</li>
			<li>
				<div class="frm-label"><?php _e( 'Decimal Separator', 'kalles-addons' ); ?></div>
				<div class="frm-input"><input name="woocommerce_price_decimal_sep" id="woocommerce_price_decimal_sep" type="text" style="width:50px;" value="." class="" placeholder=""></div>
			</li>
			<li>
				<div class="frm-label"><?php _e( 'Number of Decimals', 'kalles-addons' ); ?></div>
				<div class="frm-input"><input name="woocommerce_price_num_decimals" id="woocommerce_price_num_decimals" type="number" style="width:50px;" value="2" class="" placeholder="" min="0" step="1"></div>
			</li>
			<li>
				<div class="frm-label"><?php _e( 'Exchange Rate', 'kalles-addons' ); ?></div>
				<div class="frm-input"><input name="woocommerce_price_rate" id="woocommerce_price_num_decimals" type="text" style="width:100px;" value="1" class="" placeholder="" min="0" step="1"></div>
			</li>
			<li style="text-align: right;">
			   <input type="submit" id="currency-submit" value="<?php _e( 'Save', 'kalles-addons' ); ?>">
			</li>
		</ul>
	</form>
</div>
<script>
	( function( $ ) {
		function loadCurrency() {
			$.ajax({
				url:'<?php echo admin_url( 'admin-ajax.php' ); ?>',
				type:'post',
				data: { action:'list-currency' },
				success:function( data ) {
					if( data.length > 5 ) {
						$( 'tr#tr-not-found' ).remove();
						$( '.currencies-list tbody' ).html( data );
					}
				}
			});
		}

		$(function() {
			loadCurrency();
			$( '#add-new-currency' ).click(function() {
				$( "#dialog" ).dialog({
					modal: true,
					minWidth: 500
				});
			});

			$( 'body' ).on( 'submit', '#currency-form',function( event ) {
				event.preventDefault();
				$.ajax({
					url:'<?php echo admin_url( 'admin-ajax.php' ); ?>',
					type:'post',
					data: $( 'form#currency-form' ).serialize(),
					dataType: 'json',
					success:function( data ) {
						if ( data.result == 0 ) {
							alert( 'Your data is incorrect. Please check it again.' );
						} else {
							$( '#dialog' ).dialog( 'close' );
							loadCurrency();
						}
					}
				});
			});

			$( 'body' ).on( 'click', '.remove-currency', function() {
				var currency = $(this).data( 'currency' );
				if ( confirm( 'are you sure ?' ) ) {
					$.ajax({
						url:'<?php echo admin_url( 'admin-ajax.php' ); ?>',
						type:'post',
						data: { action:'remove-currency', code: currency },
						dataType: 'json',
						success:function(data){
							loadCurrency();
						}
					});
				}
			});

			$( '#update-currency-rate' ).click( function() {
				// if ( confirm( 'Are you sure ?' ) ) {
					$.ajax({
						url:'<?php echo admin_url( 'admin-ajax.php' ); ?>',
						type:'post',
						data: {action:'update-currency-rate'},
						dataType: 'json',
						success:function( data ) {
							loadCurrency();
							alert( 'Done' );
						}
					});
				// }
			});
		});
	} )( jQuery );
</script>