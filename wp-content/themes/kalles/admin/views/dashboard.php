<?php if ( ! defined( 'ABSPATH' )  ) { die; } // Cannot access directly. ?>
<?php
	$name = t4_white_label('white_label-theme_name', 'The4 Dashboard');
 ?>
<div class="t4_wrapper">
	<header>
		<div class="container-fluid">
			<div class="page-title"><?php echo esc_html( $name ); ?></div>
		</div>
	</header>
	<main>
		<div class="container-fluid">
			<?php if ( The4_Admin_Activation::isActive() ) : ?>
			<div class="row">
				<div class="col-lg-4 col-md-1 t4-theme-document t4-item-wrapper">
			  		<div class="t4-items">
			  			<h3 class="t4-item-heading"><?php esc_html_e('Theme document', 'kalles'); ?></h3>
			  			<div class="t4-item-content">
			  				<?php get_template_part( 'admin/views/templates/admin-theme-document' ); ?>
			  			</div>
			  		</div>
			 	</div>

			 	<div class="col-lg-4 col-md-1 t4-theme-active t4-item-wrapper">
			  		<div class="t4-items">
			  			<h3 class="t4-item-heading"><?php esc_html_e('Theme activation', 'kalles'); ?></h3>
			  			<div class="t4-item-content tc">
			  				<?php get_template_part( 'admin/views/templates/admin-theme-activation' ); ?>
			  			</div>
			  		</div>
			 	</div>
			 	<div class="col-lg-4 col-md-1 t4-system t4-item-wrapper">
			  		<div class="t4-items">
			  			<h3 class="t4-item-heading"><?php esc_html_e('System status', 'kalles'); ?></h3>
			  			<div class="t4-item-content">
			  				<?php get_template_part( 'admin/views/templates/admin-system-status' ); ?>
			  			</div>
			  		</div>
			 	</div>
			</div> <!-- .row -->
			<?php else : ?>
				<?php get_template_part( 'admin/views/templates/theme-active' ); ?>
		<?php endif; ?>
		</div>
	</main>
<?php if ( The4_Admin_Activation::isActive() ) : ?>
	<div class="t4-background-bg"></div>
	<?php endif; ?>
</div>