<?php if ( ! defined( 'ABSPATH' )  ) { die; } // Cannot access directly. ?>
<section id="purchase_codet4" data-email="<?php echo esc_attr( get_option( 'admin_email' ) ); ?>">
 <h2 id="heading_codet4"><?php esc_html_e('Start your business journey with Kalles', 'kalles'); ?></h2>
 <p id="txt_codet4"><?php The4Helper::ksesHTML('Use Kalles and explore all the tools and services you need to start, run, and
  grow your business.<br />We know that Kalles will make your life easier by
  improving your workflow. With the tools that Kalles gives you,<br />
  you will realize your true design potential without the need to know any
  coding.<br />
  We would be glad if you help us to improve our theme, installation process or
  documentation.'); ?>
 </p>
 <p id="res_codet4" class="fs__16 dn"></p>
 <input placeholder="<?php esc_attr_e('Enter your purchase code', 'kalles') ?>" id="ipt_codet4" type="text" />
 <a id="btn_codet4" href="<?php echo esc_url( 'https://lic.the4.co/'); ?>" class="pr oh">
  <svg
   xmlns="http://www.w3.org/2000/svg"
   width="45"
   height="40"
   viewBox="0 0 38 38"
   class="imp_icon_ld"
  >
   <defs>
    <linearGradient x1="8.042%" y1="0%" x2="65.682%" y2="23.865%" id="a">
     <stop stop-color="#fff" stop-opacity="0" offset="0%"></stop>
     <stop stop-color="#fff" stop-opacity=".631" offset="63.146%"></stop>
     <stop stop-color="#fff" offset="100%"></stop>
    </linearGradient>
   </defs>
   <g fill="none" fill-rule="evenodd">
    <g transform="translate(1 1)">
     <path
      d="M36 18c0-9.94-8.06-18-18-18"
      id="Oval-2"
      stroke="url(#a)"
      stroke-width="2"
      transform="rotate(152.865 18 18)"
     >
      <animateTransform
       attributeName="transform"
       type="rotate"
       from="0 18 18"
       to="360 18 18"
       dur="0.9s"
       repeatCount="indefinite"
      ></animateTransform>
     </path>
     <circle
      fill="#fff"
      cx="36"
      cy="18"
      r="1"
      transform="rotate(152.865 18 18)"
     >
      <animateTransform
       attributeName="transform"
       type="rotate"
       from="0 18 18"
       to="360 18 18"
       dur="0.9s"
       repeatCount="indefinite"
      ></animateTransform>
     </circle>
    </g>
   </g>
  </svg>
  <span><?php esc_html_e('Start Kalles', 'kalles'); ?></span>
 </a>
 <p id="minor_codet4">
  <a href="<?php echo esc_url('https://bit.ly/2tHbq4e'); ?>" target="_blank"
   ><?php esc_html_e('Where Is My Purchase Code?', 'kalles'); ?></a
  >
  <a href="<?php echo esc_url('https://bit.ly/3lST9WX'); ?>" target="_blank"><?php esc_html_e('Buy A New License?', 'kalles'); ?></a>
 </p>
</section>
