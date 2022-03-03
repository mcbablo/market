<?php
namespace The4;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}
?>

<script type="text/template" id="tmpl-the4-template-modal__header">
 <div class="elementor-templates-modal__header">
  <div class="elementor-templates-modal__header__logo-area">
   <div class="elementor-templates-modal__header__logo the4-elementor__header-logo">
    <span class="the4-templates-modal__header-logo">

    </span>
    <span class="elementor-templates-modal__header__logo__title">The4 Library</span>
   </div>

   <div class=" the4-template-library-header-preview-back" id="elementor-template-library-header-preview-back">
 	<i class="eicon-" aria-hidden="true"></i>
 	<span>Back</span>
 </div>

  </div>
  <div class="elementor-templates-modal__header__menu-area">

  </div>
  <div class="elementor-templates-modal__header__items-area">
   <div
    class="
     the4-templates-modal__header__close
     elementor-templates-modal__header__close--normal
     elementor-templates-modal__header__item
    "
   >
    <i class="eicon-close" aria-hidden="true" title="Close"></i>
    <span class="elementor-screen-only">Close</span>
   </div>

   <div id="elementor-template-library-header-tools">

    <div id="elementor-template-library-header-actions">
     <div
      id="the4-template-library-header-sync"
      class="elementor-templates-modal__header__item"
     >
      <i class="eicon-sync" aria-hidden="true" title="Sync Library"></i>
      <span class="elementor-screen-only">Sync Library</span>
     </div>
    </div>
   </div>
   <div id="elementor-template-library-header-preview-insert-wrapper" class="elementor-templates-modal__header__item">

   </div>
  </div>
 </div>
</script>

<script type="text/template" id="tmpl-the4-elementor-insert-button">
	<a class="the4-template-library-template-action the4-template-library-template-insert elementor-button" data-block-id={{data}}>
		<i class="eicon-file-download" aria-hidden="true"></i>
		<span class="elementor-button-title">Insert</span>
	</a>
</script>