<?php if ( ! defined( 'ABSPATH' )  ) { die; } // Cannot access directly. ?>

<?php if ( The4_Admin_Activation::isActive() ) : ?>
 <div class="active-icon">
  <svg height="512" viewBox="0 0 128 128" width="512" xmlns="http://www.w3.org/2000/svg"><g><circle cx="64" cy="64" fill="#4ce797" r="43.125"/><circle cx="64" cy="64" fill="#e7f8fc" r="34.544"/><path d="m58.211 81.479a3.894 3.894 0 0 1 -2.694-1.079l-11.569-11.1a3.892 3.892 0 1 1 5.388-5.618l8.59 8.239 20.468-24.03a3.893 3.893 0 1 1 5.927 5.048l-23.147 27.171a3.893 3.893 0 0 1 -2.767 1.364c-.065.003-.13.005-.196.005z" fill="#4ce797"/></g></svg>

</div>
<p class="box-text text-active-info"><?php esc_html_e( 'Theme actived', 'kalles') ?></p>
<p class="box-text text-active-info"><?php esc_html_e( 'Start your business journey with Kalles', 'kalles') ?></p>
<div class="w__full aligncenter flex mt__20">
  <a class="tc t4-deactive" href="#" 
      data-skey="<?php echo esc_attr( wp_create_nonce( 't4_deactive_theme' ) ); ?>" 
      data-email="<?php echo esc_attr( get_option( 'admin_email' ) ); ?>" 
      data-evanto_key="<?php echo esc_attr( get_option( 'envate_purchase_code_kalleswp' ) ); ?>">
      <?php esc_html_e( 'Deactive theme', 'kalles' ) ?>
      
  </a>
</div>
<?php endif; ?>