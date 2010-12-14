<?php echo $before_widget; ?>                                                                   
    <?php if ($title) echo "{$before_title}{$title}{$after_title}"; ?>    
    <div class="widget-content">
        <form action="<?php echo $options['FormHtml']['action'] ?>" method="<?php echo $options['FormHtml']['method'] ?>">
            <?php foreach ($options['FormHtml']['hidden_fields'] as $hidden_field) : ?>
                <?php echo $hidden_field; ?>
            <?php endforeach; ?>
            <?php foreach ($options['FormHtml']['normal_fields'] as $normal_field) : if ('true' == $normal_field['enabled']) : ?>
                <?php echo $normal_field['input']; ?>
            <?php endif; endforeach; ?>
            <?php 
                if (0 < strlen($options['submit_button_text'])) {
                    $html = str_get_html($options['FormHtml']['submit_field']);
                    $submit_field_html = $html->find('input[type=submit]', 0);
                    $submit_field_html->value = $options['submit_button_text']; 
                    echo $submit_field_html->outertext;
                } else {
                    echo $options['FormHtml']['submit_field'];      
                }
              ?>
        </form>
    </div>
<?php echo $after_widget; ?>
