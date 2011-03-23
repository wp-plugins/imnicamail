<div class="im-form">
    <form action="<?php echo $options['FormHtml']['action'] ?>" method="<?php echo $options['FormHtml']['method'] ?>">
        <?php foreach ($options['FormHtml']['hidden_fields'] as $hidden_field) : ?>
            <?php echo $hidden_field; ?>
        <?php endforeach; ?>
        <?php foreach ($options['FormHtml']['normal_fields'] as $normal_field) : if ('true' == $normal_field['enabled']) : ?>
            <?php echo $normal_field['input']; ?>
        <?php endif; endforeach; ?>
        <?php 
            if (1 == intval($options['use_image_button'])) {
                ?>
                    <input type="image" value="<?php echo $options['submit_button_text']; ?>" src="<?php echo $options['image_url']; ?>" />
                <?php
            } else if (0 < strlen($options['submit_button_text'])) {
                $html = str_get_html($options['FormHtml']['submit_field']);
                $submit_field_html = $html->find('input[type=submit]', 0);
                $submit_field_html->value = $options['submit_button_text']; 
                echo $submit_field_html->outertext;
            } else {
                echo $options['FormHtml']['submit_field'];      
            }
          ?>
    </form>
    <?php if (1 == intval($options['powered_by'])) : ?>
    <div style="text-align: center; font-size: 9px;"> 
        <p>Powered by <a title="Imnica Mail email marketing" href="http://www.imnicamail.com/?aff_id=<?php echo $options['affiliate_id']; ?>" target="_blank">Imnica Mail email marketing</a></p>
    </div>
    <?php endif; ?>
</div>