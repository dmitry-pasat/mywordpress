<div class="block">
    <h3>Form Settings</h3>

    <table class="">

        <tr valign="top">
            <th scope="row">Show Captcha</th>
            <td>
                <input type="hidden" name="cmpdc_captcha" value="0" />
                <input type="checkbox" name="cmpdc_captcha" <?php echo !empty($captcha) ? 'checked="checked"' : '' ?> value="1" />
            </td>
            <td  class="cmpd_field_help_container">Select this option if you want to secure the form with Captcha. <a href="https://www.google.com/recaptcha/admin/create">To use this option you need to provide Captcha keys. </a></td>
        </tr>

        <tr valign="top">
            <th scope="row">Captcha key</th>
            <td>
                <input type="text" name="cmpdc_captcha_key" value="<?php echo!empty($captcha_key) ? $captcha_key : ''; ?>" />
            </td>
            <td  class="cmpd_field_help_container">Enter the captcha key.</td>
        </tr>

        <tr valign="top">
            <th scope="row" >Captcha secret key</th>
            <td>
                <input type="text" name="cmpdc_captcha_private_key" value="<?php echo!empty($captcha_private_key) ? $captcha_private_key : ''; ?>" />
            </td>
            <td  class="cmpd_field_help_container">Enter the captcha secret key.</td>
        </tr>

        <tr valign="top">
            <th scope="row"><label for="cmpdc_form_show_social_media_section">Show Social Media Section</label></th>
            <td>
                <input type="hidden" name="cmpdc_form_show_social_media_section" value="0" />
                <input type="checkbox"
                       name="cmpdc_form_show_social_media_section"
                       id="cmpdc_form_show_social_media_section"
				    <?php checked('1', $form_show_social_media_section, true); ?> value="1" />
            </td>
            <td class="cmbd_field_help_container">
                Defines whether you want to show Social Media Section in Product Form
            </td>
        </tr>

        <tr valign="top">
            <th scope="row"><label for="cmpdc_form_show_categories_as_checkboxes">Show Categories as Checkboxes</label></th>
            <td>
                <input type="hidden" name="cmpdc_form_show_categories_as_checkboxes" value="0" />
                <input type="checkbox"
                       name="cmpdc_form_show_categories_as_checkboxes"
                       id="cmpdc_form_show_categories_as_checkboxes"
				    <?php checked('1', $form_show_categories_as_checkboxes, true); ?> value="1" />
            </td>
            <td class="cmbd_field_help_container">
                Defines whether you want to show Categories as checkboxes or as multi select in Product Form
            </td>
        </tr>

        <tr valign="top">
            <th scope="row"><label for="cmpdc_form_show_tags">Show Tags Field</label></th>
            <td>
                <input type="hidden" name="cmpdc_form_show_tags" value="0" />
                <input type="checkbox"
                       name="cmpdc_form_show_tags"
                       id="cmpdc_form_show_tags"
				    <?php checked('1', $form_show_tags, true); ?> value="1" />
            </td>
            <td class="cmbd_field_help_container">
                Defines whether you want to show Tags input field in Product Form
            </td>
        </tr>

        <tr valign="top">
            <th scope="row">Use textareas instead of WordPress Editor</th>
            <td>
                <input type="hidden" name="cmpdc_textareas" value="0" />
                <input type="checkbox" name="cmpdc_textareas" <?php echo !empty($textareas) ? 'checked="checked"' : ''; ?> value="1" />
            </td>
            <td class="cmpd_field_help_container"></td>
        </tr>


    </table>
</div>

<div class="block">
    <h3>Moderation Settings</h3>
    <table class="">
        <tr valign="top">
            <th scope="row">Moderate new products</th>
            <td>
                <input type="hidden" name="cmpdc_moderation" value="0" />
                <input type="checkbox" name="cmpdc_moderation" <?php echo !empty($moderation) ? 'checked="checked"' : '' ?> value="1" />
            </td>
            <td  class="cmpd_field_help_container">Select this option if you want to have the new submited product moderated.</td>
        </tr>


        <tr valign="top">
            <th scope="row">Who can add a product:</th>
            <td><select multiple name="cmpdc_allow_add_product_roles[]" >
                    <?php foreach ($roles as $role_k => $role_v): ?>
                        <option value="<?php echo esc_attr($role_k); ?>" <?php echo (!empty($allow_roles) && in_array($role_k, $allow_roles) ? 'selected="selected"' : '') ?>><?php echo esc_html($role_v); ?></option>
                    <?php endforeach; ?>
                </select></td>
            <td  class="cmpd_field_help_container">Which roles should be able to add a product to the directory? (select more by holding down ctrl key)</td>
        </tr>

        <tr valign="top">
            <th scope="row">Choose a text to display for roles who cannot see form:</th>
            <td>
                <textarea name="cmpdc_text_for_unauthorized_roles" placeholder="'Suggest product form is displayed only for: [list of roles]'" cols="40" rows="5"><?php echo esc_html(!empty($text_for_unauthorized_roles) ? $text_for_unauthorized_roles : ''); ?></textarea>
            </td>
            <td  class="cmpd_field_help_container"> In case the user don't have access to add a product, this text will be presented to him</td>
        </tr>

    </table>
</div>

<div class="block">
    <h3>Notification Settings</h3>
    <table class="">

        <tr valign="top" class=" whole-line">
            <th scope="row">Admin panel notification</th>
            <td>
                <input type="hidden" name="cmpdc_panel_notification" value="0" />
                <input type="checkbox" name="cmpdc_panel_notification" <?php echo !empty($panel_notification) ? 'checked="checked"' : '' ?> value="1" />
            </td>
            <td  class="cmpd_field_help_container">Select this option if you want the admin to see notifications in admin dashboard when a new product was added.(Works only when "Moderate new product" option is enable) </td>
        </tr>

        <tr valign="top">
            <th scope="row">Admin email notification</th>
            <td>
                <input type="hidden" name="cmpdc_notification" value="0" />
                <input type="checkbox" name="cmpdc_notification" <?php echo !empty($notification) ? 'checked="checked"' : '' ?> value="1" />
            </td>
            <td  class="cmpd_field_help_container">Select this option if you want the admin to recive notification when a new product has been added.</td>
        </tr>

        <tr valign="top">
            <th scope="row">Admin email</th>
            <td>
                <input type="text" name="cmpdc_notification_admin" value="<?php echo esc_attr($notification_admin); ?>" />
            </td>
            <td  class="cmpd_field_help_container"> Enter the admin e-mail/e-mails splited by "," or leave empty so the e-mail will be send to WordPress administrator.</td>
        </tr>

        <tr valign="top">
            <th scope="row">Admin email notification subject</th>
            <td>
                <input type="text" name="cmpdc_notification_subject" value="<?php echo esc_attr(!empty($notification_subject) ? $notification_subject : ''); ?>" />
            </td>
            <td  class="cmpd_field_help_container">Enter the admin email notification subject.</td>
        </tr>

        <tr valign="top" class=" whole-line">
            <th scope="row">Admin email notification content</th>
            <td>
                <textarea name="cmpdc_notification_text" placeholder="Write notification message here" cols="40" rows="5"><?php echo esc_html(!empty($notification_text) ? $notification_text : ''); ?></textarea>
            </td>
            <td  class="cmpd_field_help_container">This option let you define the admin notification content. (Works only when the admin notification is enabled). <br/><br/> You can use tag [product] to display the name and [url] to display the link of the product. </td>
        </tr>

        <tr valign="top">
            <th scope="row">Admin claim email notification subject</th>
            <td>
                <input type="text" name="cmpdc_claim_notification_subject" value="<?php echo esc_attr(!empty($claim_notification_subject) ? $claim_notification_subject : ''); ?>" />
            </td>
            <td  class="cmpd_field_help_container">Enter the admin claim email notification subject.</td>
        </tr>

        <tr valign="top" class=" whole-line">
            <th scope="row">Admin claim email notification content</th>
            <td>
                <textarea name="cmpdc_claim_notification_text" placeholder="Write notification message here" cols="40" rows="5"><?php echo esc_html(!empty($claim_notification_text) ? $claim_notification_text : ''); ?></textarea>
            </td>
            <td  class="cmpd_field_help_container">This option let you define the claim notification content. (Works only when the admin notification is enabled). <br/><br/> You can use tag [product], [url], [email], [name], [accept_url] to display the name of the product, claimer name and email and url to accept the notification. </td>
        </tr>

        <tr valign="top">
            <th scope="row">User - status changed email notification</th>
            <td>
                <input type="hidden" name="cmpdc_user_notification" value="0" />
                <input type="checkbox" name="cmpdc_user_notification" <?php echo !empty($user_notification) ? 'checked="checked"' : '' ?> value="1" />
            </td>
            <td  class="cmpd_field_help_container">Select this option if you want the user to receive notification when the status of their product has been changed.</td>
        </tr>
        <tr valign="top">
            <th scope="row">User - status changed email notification subject</th>
            <td>
                <input type="text" name="cmpdc_user_notification_subject" value="<?php echo esc_attr(!empty($user_notification_subject) ? $user_notification_subject : ''); ?>" />
            </td>
            <td  class="cmpd_field_help_container">Enter the user email notification subject.</td>
        </tr>

        <tr valign="top" class=" whole-line">
            <th scope="row">User - status changed email notification content</th>
            <td>
                <textarea name="cmpdc_user_notification_text" placeholder="Write user notification message here" cols="40" rows="5"><?php echo esc_html(!empty($user_notification_text) ? $user_notification_text : ''); ?></textarea>
            </td>
            <td  class="cmpd_field_help_container">This option let you define the user notification content. (Works only when user notification is enabled). <br/><br/> You can use tags: [product], [old_status], [new_status] to display the name, old status and new status of the product)</td>
        </tr>


        <tr valign="top">
            <th scope="row">User - claim rejected email notification</th>
            <td>
                <input type="hidden" name="cmpdc_claim_rejected_notification" value="0" />
                <input type="checkbox" name="cmpdc_claim_rejected_notification" <?php echo !empty($claim_rejected_notification) ? 'checked="checked"' : '' ?> value="1" />
            </td>
            <td  class="cmpd_field_help_container">Select this option if you want the user to receive notification when their product claim has been rejected.</td>
        </tr>
        <tr valign="top">
            <th scope="row">User - claim rejected email notification subject</th>
            <td>
                <input type="text" name="cmpdc_claim_rejected_notification_subject" value="<?php echo esc_attr(!empty($claim_rejected_notification_subject) ? $claim_rejected_notification_subject : ''); ?>" />
            </td>
            <td  class="cmpd_field_help_container">Enter the subject of the claim rejected e-mail.</td>
        </tr>

        <tr valign="top" class=" whole-line">
            <th scope="row">User - claim rejected email notification content</th>
            <td>
                <textarea name="cmpdc_claim_rejected_notification_text" placeholder="Write user notification message here" cols="40" rows="5"><?php echo esc_html(!empty($claim_rejected_notification_text) ? $claim_rejected_notification_text : ''); ?></textarea>
            </td>
            <td  class="cmpd_field_help_container">This option let you define the user notification content. (Works only when user notification is enabled). <br/><br/> You can use tag: [product] to indicate product name.</td>
        </tr>

        <tr valign="top">
            <th scope="row">User access email notification subject</th>
            <td>
                <input type="text" name="cmpdc_access_notification_title" value="<?php echo esc_attr(!empty($access_notification_title) ? $access_notification_title : ''); ?>" />
            </td>
            <td  class="cmpd_field_help_container">Enter the user access email notification subject.</td>
        </tr>
        <tr valign="top" class=" whole-line">
            <th scope="row">User access email notification content</th>
            <td>
                <textarea name="cmpdc_access_notification_text" placeholder="Write user notification message here" cols="40" rows="5"><?php echo esc_html(!empty($access_notification_text) ? $access_notification_text : ''); ?></textarea>
            </td>
            <td  class="cmpd_field_help_container">This option let you define the user notification content. <br/><br/> You can use tags: [product], [status], [login], [password], [url] to display the name, status of the product, user login and password and your login panel url.</td>
        </tr>
    </table>

</div>

<div class="block">
    <h3>Add a Product Form</h3>
    <table class="">
        <tr valign="top">
            <th scope="row">Suggest a Product Page ID:</th>
            <td>
				<input type="text" name="<?php echo CMProductDirectoryCommunityProductBackend::CMPDC_MAIN_FORM_PAGE_ID?>" value="<?php echo $form_page_id; ?>"  />
            </td>
            <td  class="cmpd_field_help_container">Select the ID of the page with the [community_product_form] shortcode. All backlinks will be pointing to that page.</td>
        </tr>
        <tr valign="top">
            <th scope="row">"Suggest a Product Form"</th>
            <td>
                <?php if (!empty($form_page_id) && get_post($form_page_id)): ?>
                    <span><a href="<?php echo esc_attr(admin_url('post.php?post=' . urlencode($form_page_id) . '&action=edit')); ?>" target="_blank"> edit </a></span>
                <?php endif; ?>
            </td>
            <td  class="cmpd_field_help_container">Link to the page with "Suggest a product" form. You can click the edit to open the page editor.</td>
        </tr>
        <tr valign="top">
            <th scope="row">Add "Suggest a Product" link on product directory index page</th>
            <td>
                <input type="hidden" name="cmpdc_form_page_id_on" value="0"/>
                <input type="checkbox" name="cmpdc_form_page_id_on" value="1"  <?php checked($form_page_id_on,1,1)?>  />
            </td>
            <td  class="cmpd_field_help_container">You can add a link to the suggest a product form placed on top of each product directory index page.</td>
        </tr>
        <tr valign="top">
            <th scope="row">Maximum number of categories</th>
            <td>
                <input type="number" name="cmpdc_form_categories_limit" value="<?php echo esc_attr(!empty($form_categories_limit) ? $form_categories_limit : ''); ?>" />
            </td>
            <td  class="cmpd_field_help_container">You can set the maximum number of categories which can be added to a product (If empty then limit is disabled).</td>
        </tr>
    </table>
</div>

<div class="block">
    <h3>Product Claim Settings</h3>
    <table class="">
        <tr valign="top">
            <th scope="row">Claims management</th>
           <td>
                <input type="hidden" name="cmpdc_form_claim_on" value="0"/>
                <input type="checkbox" name="cmpdc_form_claim_on" value="1" <?php checked($form_claim_on,1,1)?>  />
            </td>
            <td  class="cmpd_field_help_container">Checking this option enables the ability to claim products for your sites users.</td>
        </tr>
        <tr valign="top">
            <th scope="row">Login form on product page</th>
           <td>
                <input type="hidden" name="cmpdc_login_on_product_page" value="0"/>
                <input type="checkbox" name="cmpdc_login_on_product_page" value="1" <?php checked($login_on_product_page,1,1)?>  />
            </td>
            <td  class="cmpd_field_help_container">Checking this option enables the ability to log in on the product page.</td>
        </tr>
        <tr valign="top">
            <th scope="row">Require captcha for claims</th>
           <td>
                <input type="hidden" name="cmpdc_form_claim_captcha" value="0"/>
                <input type="checkbox" name="cmpdc_form_claim_captcha" value="1" <?php checked($form_claim_captcha,1,1)?>  />
            </td>
            <td  class="cmpd_field_help_container">Checking this option adds the captcha check to the "Claim product" form securing the claim form from the robots.</td>
        </tr>
        <tr valign="top">
            <th scope="row">Allow multiple pending claims for one product</th>
           <td>
                <input type="hidden" name="cmpdc_form_claim_multi_claims" value="0"/>
                <input type="checkbox" name="cmpdc_form_claim_multi_claims" value="1" <?php checked($form_claim_multi_claims,1,1)?>  />
            </td>
            <td  class="cmpd_field_help_container">Unchecking this option means, there can be only one pending claim to each product, so until the claim is resolved the form will be hidden. Otherwise the form will be visible until some claim is approved.</td>
        </tr>
    </table>
</div>

<div class="block">
    <h3>Product Recovery Settings</h3>
    <table class="">
        <tr valign="top">
            <th scope="row">Recovery management</th>
            <td>
                <input type="hidden" name="cmpdc_form_recover_on" value="0"/>
                <input type="checkbox" name="cmpdc_form_recover_on" value="1" <?php checked($form_recover_on,1,1)?>  />
            </td>
            <td  class="cmpd_field_help_container">If this option is checked the recover product login and password option is enabled</td>
        </tr>
    </table>
</div>
