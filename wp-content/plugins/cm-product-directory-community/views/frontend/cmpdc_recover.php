<div class="clear"></div>
<style>
    .cmpdc_recover_button{
        margin-top:10px ;
        margin-bottom: 10px;
    }
</style>

<p>
    <strong> <?php echo esc_html($data['form_recover_text']); ?> </strong> <a href="javascript:void(0)" onclick="jQuery(this).parent().next().slideToggle()"><?php echo esc_html($data['form_showhide_text']); ?></a>
</p>

<form class="form_submit" class="cmpdc_recover_container" id="cmpdc_recover_form" method="post" style="display:<?php echo (empty($data['form_status']) ? 'none' : 'block'); ?>">
    <div class="cmpdc_settings_container">
        <?php
        if (!empty($data['form_status'])) {
            ?><style>
                .alert-success, .alert-warning{
                    border-radius: 5px;
                    padding: 10px;
                    margin-bottom: 5px;
                }
                .alert-success{
                    border: 2px solid #00cc00;
                }
                .alert-warning{
                    border: 2px solid red;
                }
            </style>
            <?php
            echo $data['form_status'];
            ?><div class="clear"></div><?php
        }
        ?>
        <div class="cmpdc_single_data">
            <label class="cmpdc_label" for="form_recover_email"><strong> <?php echo esc_html($data['form_recover_email']); ?>*</strong></label>
            <div class="clear"></div>
            <input class="cmpdc_input" id="form_recover_email" type="text" name="cmpdc_form_recover_email" required="required">
        </div>
        <div class="clear"></div>
        <input type="hidden" name="cmpdc_form_recover_post_id" value="<?php echo esc_attr($data['form_product_id']); ?>">

		<input class="button button-primary cmpdc_recover_button" name="cmpdc_recover" type="submit" value="<?php echo esc_html($data['form_recover_button']); ?>"/>

    </div>
</form>
<div class="clear"></div>