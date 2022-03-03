<?php if ( ! defined( 'ABSPATH' )  ) { die; } // Cannot access directly. ?>
<div class="t4-system-status">
	<?php
		$system_status = the4_admin_get_system_status();
		foreach ( $system_status as $item) :
	?>
	<div class="t4-system-status-item">
		<span class="status-item-title color__text">
			<?php echo esc_html( $item['title'] ); ?>
		</span>
		<?php if ( !empty( $item['help_link'] ) && ! $item['status'] ) : ?>
			<a target="_blank" class="t4-system-status-item__help" href="<?php echo esc_url( $item['help_link'] ); ?>">
				<img src="<?php echo THE4_KALLES_ADMIN_URL;?>/assets/images/help.svg">
			</a>
		<?php endif; ?>
		<?php if ( $item['status'] ) : ?>
			<img src="<?php echo THE4_KALLES_ADMIN_URL;?>/assets/images/green-check.svg">
		<?php else : ?>
			<img src="<?php echo THE4_KALLES_ADMIN_URL;?>/assets/images/red-x-line.svg">
		<?php endif; ?>
	</div>
	<?php endforeach; ?>
</div>
