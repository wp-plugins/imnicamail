<?php
    class ImnicaMailWidget extends WP_Widget {
        function ImnicaMailWidget() {
            parent::WP_Widget('imnicamail-widget', 'ImnicaMail Widget', array('classname' => 'imnicamail-widget'));
        }

        function widget($args, $instance) {
            extract($args);                                                                    
            
            global $ImnicaMailPlugin;
            $options = $ImnicaMailPlugin->getAdminOptions();
            $title = apply_filters('widget_title', $instance['title']);
            
            include(IMNICAMAIL_PLUGIN_DIR.'/php/widget.php');
        }

        function update( $new_instance, $old_instance ) {
            return $new_instance;
        }

        function form($instance) {
            $title = esc_attr($instance['title']);
            ?>
                <p>
                  <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?>
                    <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" />
                  </label>
                </p>
            <?php
        }
    }
?>
