<?php
/**
 * The Age verify Popup
 *
 * @since   1.0.0
 * @package Kalles
 */
?>
<?php
	$day_next = cs_get_option('popup-age_verify_day_next') ? cs_get_option('popup-age_verify_day_next') : 30;
	$date_of_birth = cs_get_option('popup-age_verify_use_age');
	$age_limit = cs_get_option('popup-age_verify_age') ? cs_get_option('popup-age_verify_age') : 18;
	$bg_image = cs_get_option('popup-age_verify_bg_img') ? cs_get_option('popup-age_verify_bg_img') : '';
?>

	<div class="popup_age_wrap mfp-with-anim tc mfp-hide lazyload"
	data-stt='{<?php echo '"day_next": ' . esc_attr( $day_next ) . ', "date_of_birth": ' . esc_attr( $date_of_birth ) . ', "age_limit": ' . esc_attr( $age_limit ); ?>}'
	<?php if (!empty($bg_image)) echo 'data-bgset="' . esc_attr( $bg_image['url'] ) .'" data-parent-fit="width" data-sizes="auto"'; ?>
	>
   <div class="age_verify_txt">
        <h4><?php echo esc_html( cs_get_option('popup-age_verify_heading') ); ?></h4>
        <p class="mg__0"><?php The4Helper::ksesHTML( cs_get_option('popup-age_verify_content') ); ?></p>
   </div>
   <div class="age_verify_txt_error dn">
      <h4><?php echo esc_html( cs_get_option('popup-age_verify_text_forbidden_1') ) ?></h4>
      <p class="mg__0"><?php The4Helper::ksesHTML( cs_get_option('popup-age_verify_text_forbidden_2') ) ?></p>
   </div>
   <?php if ($date_of_birth) :  ?>
   <div class="row no-gutters age_date_of_birth">
	  <div class="col-12 col-md-4">
	    <select name="agemonth" class="w__100" id="agemonth">
	      <option value="12">- <?php esc_html_e('Month', 'kalles') ?> -</option>
	      <option value="1"><?php esc_html_e('January', 'kalles') ?></option>
	      <option value="2"><?php esc_html_e('February', 'kalles') ?></option>
	      <option value="3"><?php esc_html_e('March', 'kalles') ?></option>
	      <option value="4"><?php esc_html_e('April', 'kalles') ?></option>
	      <option value="5"><?php esc_html_e('May', 'kalles') ?></option>
	      <option value="6"><?php esc_html_e('June', 'kalles') ?></option>
	      <option value="7"><?php esc_html_e('July', 'kalles') ?></option>
	      <option value="8"><?php esc_html_e('August', 'kalles') ?></option>
	      <option value="9"><?php esc_html_e('September', 'kalles') ?></option>
	      <option value="10"><?php esc_html_e('October', 'kalles') ?></option>
	      <option value="11"><?php esc_html_e('November', 'kalles') ?></option>
	      <option value="12"><?php esc_html_e('December', 'kalles') ?></option>
	  </select>
	  </div>
	  <div class="col-12 col-md-4">
	    <select name="ageday" class="w__100" id="ageday">
	      <option value="28">- <?php esc_html_e('Day', 'kalles') ?> -</option>
	      <?php for ($i=1; $i <= 31 ; $i++) : ?>
	      	<?php echo '<option value="' . esc_attr( $i ) .'"> ' . esc_html( $i ) .' </option>'; ?>
	      <?php endfor; ?>
	    </select>
	  </div>
	  <div class="col-12 col-md-4"><select name="ageyear" class="w__100" id="ageyear">
	      <option value="<?php echo date('Y'); ?>">- Year -</option>
	       <?php for ($i=(int)date('Y') - 5; $i >= 1910  ; $i--) : ?>
	      	<?php echo '<option value="' . esc_attr( $i ) .'"> ' . esc_html( $i ) .' </option>'; ?>
	       <?php endfor; ?>
	    </select>
	  </div>

	</div>
	<?php endif; ?>
	<div class="age_verify_buttons">
      <a href="#" data-no-instant="" 
      	rel="nofollow" 
      	class="age_verify_allowed" >
      		<?php echo esc_html( cs_get_option('popup-age_verify_btn_allowed') ); ?>
      </a>
      <a href="#" data-no-instant="" rel="nofollow" class="age_verify_forbidden" ><?php echo esc_html( cs_get_option('popup-age_verify_btn_forbidden') ) ?></a>
   </div>
</div>