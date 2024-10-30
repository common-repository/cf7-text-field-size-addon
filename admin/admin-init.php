<?php
function cf7_custom_fields_enqueue_scripts() {
  // Enqueue JavaScript file
  wp_enqueue_script( 'cf7-custom-fields-script', plugins_url( '/js/cf7-custom-fields.js', __FILE__ ), array( 'jquery' ), '1.0', true );

  // Enqueue CSS file
  wp_enqueue_style( 'cf7-custom-fields-style', plugins_url( '/css/cf7-custom-fields.css', __FILE__ ) );
}
//add_action( 'wp_enqueue_scripts', 'cf7_custom_fields_enqueue_scripts' );



add_action('wpcf7_admin_init', 'cf7_ts_add_tag_generator_country_code', 15);
function cf7_ts_add_tag_generator_country_code()
{
    $tag_generator = WPCF7_TagGenerator::get_instance();
    $tag_generator->add('custom_text_field', __('Text with length', 'cf7_ts'), 'cf7_text_field_size');
}

function cf7_text_field_size($CF7_TS, $CF7_TS_args = '')
{
    $CF7_TS_args = wp_parse_args($CF7_TS_args, array());
    $type = $CF7_TS_args['id'];

?>
    <div class="control-box cf7-ts-control-box">
        <fieldset>
            <legend><?php echo __('Create drop-down field for country code number with flag drop-down.', 'cf7_ts'); ?></legend>

            <table class="form-table">
                <tbody>
                    <tr>
                        <th scope="row"><?php echo esc_html(__('Is required', 'cf7_ts')); ?></th>
                        <td>
                            <fieldset>
                                <legend class="screen-reader-text"><?php echo esc_html(__('Is required', 'cf7_ts')); ?></legend>
                                <label><input type="checkbox" name="required" /> <?php echo esc_html(__('Required field', 'cf7_ts')); ?></label>
                            </fieldset>
                        </td>
                    </tr>

                    <tr>
                        <th scope="row"><label for="<?php echo esc_attr($CF7_TS_args['content'] . '-name'); ?>"><?php echo esc_html(__('Name', 'cf7_ts')); ?></label></th>
                        <td><input type="text" name="name" class="tg-name oneline" id="<?php echo esc_attr($CF7_TS_args['content'] . '-name'); ?>" /></td>
                    </tr>

                    <tr>
                        <th scope="row"><label for="<?php echo esc_attr($CF7_TS_args['content'] . '-id'); ?>"><?php echo esc_html(__('ID attribute', 'cf7_ts')); ?></label></th>
                        <td><input type="text" name="id" class="idvalue oneline option" id="<?php echo esc_attr($CF7_TS_args['content'] . '-id'); ?>" /></td>
                    </tr>

                    <tr>
                        <th scope="row"><label for="<?php echo esc_attr($CF7_TS_args['content'] . '-class'); ?>"><?php echo esc_html(__('Class attribute', 'cf7_ts')); ?></label></th>
                        <td><input type="text" name="class" class="classvalue oneline option" id="<?php echo esc_attr($CF7_TS_args['content'] . '-class'); ?>" /></td>
                    </tr>

                    <tr>
                        <th scope="row"><label for="<?php echo esc_attr($CF7_TS_args['content'] . '-minlength'); ?>"><?php echo esc_html(__('Minlength', 'cf7_ts')); ?></label></th>
                        <td><input type="number" name="minlength" class="classvalue oneline option" id="<?php echo esc_attr($CF7_TS_args['content'] . '-minlength'); ?>" /></td>
                    </tr>

                    <tr>
                        <th scope="row"><label for="<?php echo esc_attr($CF7_TS_args['content'] . '-maxlength'); ?>"><?php echo esc_html(__('Maxlength', 'cf7_ts')); ?></label></th>
                        <td><input type="number" name="maxlength" class="classvalue oneline option" id="<?php echo esc_attr($CF7_TS_args['content'] . '-maxlength'); ?>" /></td>
                    </tr>

                </tbody>
            </table>
        </fieldset>
    </div>

    <div class="insert-box">
        <input type="text" name="<?php echo esc_attr($type); ?>" class="tag code" readonly="readonly" onfocus="this.select()" />

        <div class="submitbox">
            <input type="button" class="button button-primary insert-tag" value="<?php echo __('Insert Tag', 'cf7_ts'); ?>" />
        </div>

        <br class="clear" />
    </div>
<?php
}