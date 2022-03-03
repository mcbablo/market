<?php if ( ! defined( 'ABSPATH' )  ) { die; } // Cannot access directly. ?>
<ul class="my-2">
<?php

  $data_feed = The4_Admin_Dashboard::get_feed_news();

  if ( ! empty( $data_feed ) ) :
    foreach ( $data_feed as $item ) :
?>
  <li class="p-1 ">
    <a href="<?php echo esc_url( $item['link'] ); ?>" class="text-blue-500 mb-2 text-md" target="_blank"><?php echo esc_html( $item['title'] ); ?></a>
    <p><?php The4Helper::ksesHTML( $item['content'] ); ?></p>
  </li>
  <?php endforeach ?>
<?php endif; ?>
</ul>
<div class="new-extenal-link">
  <div class="new-extenal-link__item">
    <a class="flex items-center" href="#">
      <?php esc_html_e( 'Blog', 'kalles' ) ?>
      <span aria-hidden="true" class="dashicons dashicons-external"></span>
    </a>
  </div>
  <div class="new-extenal-link__item">
    <a class="flex items-center" href="#">
      <?php esc_html_e( 'Support', 'kalles' ) ?>
      <span aria-hidden="true" class="dashicons dashicons-external"></span>
    </a>
  </div>
  <div class="new-extenal-link__item">
    <a class="flex items-center" href="#">
      <?php esc_html_e( 'Contact', 'kalles' ) ?>
      <span aria-hidden="true" class="dashicons dashicons-external"></span>
    </a>
  </div>
</div>