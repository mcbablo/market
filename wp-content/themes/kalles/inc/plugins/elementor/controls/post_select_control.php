<?php
/**
 * Control select product for Elementor
 *
 * @since   1.1.1
 * @package Kalles
 */

namespace The4Addon;

class Post_Select_Control extends \Elementor\Base_Data_Control {

    public function get_type()
    {
        return 'kalles_post_select';
    }

    protected function get_default_settings()
    {
        return [
            'label_block' => true,
            'separator'   => 'after',
            'taxonomy'    => false,
            'post_type'   => false,
            'options'     => [],
            'multiple'    => true,
        ];
    }

    public function get_default_value() {}

    public function content_template()
    {
        $control_uid = $this->get_control_uid();

        ?>
            <# var multiple = ( data.multiple ) ? 'multiple' : ''; #>
            <div class="elementor-control-field">

                <label class="elementor-control-title">{{{ data.label }}}</label>

                <div class="elementor-control-input-wrapper">

                    <select {{ multiple }}
                        id="<?php echo esc_attr( $control_uid ); ?>"
                        class="elementor-select2" type="select2"
                        data-setting="{{ data.name }}"
                        data-post-type="{{ data.post_type }}"
                        data-placeholder="<?php echo esc_attr__( 'Search', 'kalles' ); ?>">

                        <# _.each( data.options, function( title, value ) {
                            var val = data.controlValue;

                            if ( typeof val == 'string' ) {
                                var selected = ( value == val ) ? 'selected' : '';
                            } else if ( val == null ) {
                                var val = _.values( val );
                                var selected = ( val.indexOf( value ) != -1 ) ? 'selected' : '';
                            }
                            #>

                            <option {{ selected }} value="{{ value }}">{{ title }}</option>
                        <# }) #>

                    </select>
                </div>

            </div>
            <# if ( data.description ) { #>
                <div class="elementor-control-field-description">{{{ data.description }}}</div>
            <# } #>

        <?php
    }

    public function enqueue()
    {
        wp_register_script( 'kalles_el_post_select', THE4_KALLES_PLUGINS_URL . '/elementor/assets/js/post_select_control.js', ['jquery'], '1.0.0', true );
        wp_enqueue_script( 'kalles_el_post_select' );
    }

}