<div class="block">
	<h3>Add and Update Product Form</h3>
	<table class="settting_label_table">
		<tr valign="top">
			<th scope="row" class="col_first">Label</th>
			<th class="col_second">
				Value
			</th>
			<th class="col_third">
				Mandatory
			</th>
			<th colspan="2" class="col_fourth">Description</th>
		</tr>
		<tr valign="top">
			<td scope="row" class="col_first">Login field text</td>
			<td class="col_second">
				<input type="text" name="cmpdc_form_user" value="<?php echo esc_attr(!empty($form_user) ? $form_user : ''); ?>" />
			</td>
			<td  class="col_third" ></td>
			<td colspan="2" class="col_fourth">Enter the login field label.</td>
		</tr>

		<tr valign="top">
			<td scope="row" class="col_first">Password field text</td>
			<td class="col_second">
				<input type="text" name="cmpdc_form_password" value="<?php echo esc_attr(!empty($form_password) ? $form_password : ''); ?>" />
			</td>
			<td  class="col_third" ></td>
			<td colspan="2" class="col_fourth">Enter the password field label.</td>
		</tr>

		<tr valign="top">
			<td scope="row" class="col_first">Title field text</td>
			<td class="col_second">
				<input type="text" name="cmpdc_form_title" value="<?php echo esc_attr(!empty($form_title) ? $form_title : ''); ?>" />
			</td>
			<td class="col_third">
				<input type="hidden" name="cmpdc_form_title_mandatory" value="0"/>
				<input type="checkbox" name="cmpdc_form_title_mandatory" value="1" <?php echo esc_attr(!empty($form_title_mandatory) ? 'checked' : ''); ?> />
			</td>
			<td colspan="2" class="col_fourth">Enter the title field label.</td>
		</tr>

		<tr valign="top" class="col_first">
			<td scope="row" class="col_first">Title field placeholder text</td>
			<td class="col_second">
				<input type="text" name="cmpdc_form_title_placeholder" value="<?php echo esc_attr(!empty($form_title_placeholder) ? stripslashes($form_title_placeholder) : ''); ?>" />
			</td>
			<td  class="col_third" ></td>
			<td colspan="2" class="col_fourth">Enter the placeholder text for the title field.</td>
		</tr>

		<tr valign="top" class="col_first">
			<td scope="row" class="col_first">Description field text</td>
			<td class="col_second">
				<input type="text" name="cmpdc_form_description" value="<?php echo esc_attr(!empty($form_description) ? $form_description : ''); ?>" />
			</td>
			<td class="col_third">
				<input type="hidden" name="cmpdc_form_description_mandatory" value="0"/>
				<input type="checkbox" name="cmpdc_form_description_mandatory" value="1" <?php echo esc_attr(!empty($form_description_mandatory) ? 'checked' : ''); ?> />
			</td>
			<td colspan="2" class="col_fourth">Enter the description field label.</td>
		</tr>

		<tr valign="top" class="col_first">
			<td scope="row" class="col_first">Description field placeholder text</td>
			<td class="col_second">
				<input type="text" name="cmpdc_form_description_placeholder" value="<?php echo esc_attr(!empty($form_description_placeholder) ? $form_description_placeholder : ''); ?>" />
			</td>
			<td  class="col_third" ></td>
			<td colspan="2" class="col_fourth">Enter the placeholder text for the description field.</td>
		</tr>
		<tr valign="top" class="col_first">
			<td scope="row" class="col_first"> Product Pitch field text</td>
			<td class="col_second">
				<input type="text" name="cmpdc_form_product_pitch" value="<?php echo esc_attr(!empty($form_product_pitch) ? $form_product_pitch : ''); ?>" />
			</td>
			<td class="col_third">
				<input type="hidden" name="cmpdc_form_product_pitch_mandatory" value="0"/>
				<input type="checkbox" name="cmpdc_form_product_pitch_mandatory" value="1" <?php echo!empty($form_product_pitch_mandatory) ? 'checked' : '' ?> />
			</td>
			<td colspan="2" class="col_fourth">Enter the product pitch field label.</td>
		</tr>

		<tr valign="top" class="col_first">
			<td scope="row" class="col_first">Product Pitch field placeholder text</td>
			<td class="col_second">
				<input type="text" name="cmpdc_form_product_pitch_placeholder" value="<?php echo esc_attr(!empty($form_product_pitch_placeholder) ? $form_product_pitch_placeholder : ''); ?>" />
			</td>
			<td  class="col_third" ></td>
			<td colspan="2" class="col_fourth">Enter the placeholder text for the product pitch field.</td>
		</tr>


		<!-- Category -->
		<tr valign="top" class="col_first">
			<td scope="row" class="col_first">Categories field text</td>
			<td class="col_second">
				<input type="text" name="cmpdc_form_categories" value="<?php echo esc_attr(!empty($form_categories) ? $form_categories : ''); ?>" />
			</td>
			<td  class="col_third" ></td>
			<td colspan="2" class="col_fourth">Enter the categories field label.</td>
		</tr>

        <!-- Tag -->
        <tr valign="top" class="col_first">
            <td scope="row" class="col_first">Tags field text</td>
            <td class="col_second">
                <input type="text" name="cmpdc_form_tags" value="<?php echo esc_attr(!empty($form_tags) ? $form_tags : ''); ?>" />
            </td>
            <td  class="col_third" ></td>
            <td colspan="2" class="col_fourth">Enter the tags field label.</td>
        </tr>

		<!-- Pricing Model -->
		<tr valign="top" class="col_first">
			<td scope="row" class="col_first">Pricing Model field text</td>
			<td class="col_second">
				<input type="text" name="cmpdc_form_pricingmodel" value="<?php echo esc_attr(!empty($form_pricingmodel) ? $form_pricingmodel : ''); ?>" />
			</td>
			<td  class="col_third" ></td>
			<td colspan="2" class="col_fourth">Enter the pricing model field label.</td>
		</tr>

		<!-- Language Support -->
		<tr valign="top" class="col_first">
			<td scope="row" class="col_first">Language Support field text</td>
			<td class="col_second">
				<input type="text" name="cmpdc_form_languagesupport" value="<?php echo esc_attr(!empty($form_languagesupport) ? $form_languagesupport : ''); ?>" />
			</td>
			<td  class="col_third" ></td>
			<td colspan="2" class="col_fourth">Enter the language support field label.</td>
		</tr>

		<!-- Target Audience -->
		<tr valign="top" class="col_first">
			<td scope="row" class="col_first">Target Audience field text</td>
			<td class="col_second">
				<input type="text" name="cmpdc_form_targetaudience" value="<?php echo esc_attr(!empty($form_targetaudience) ? $form_targetaudience : ''); ?>" />
			</td>
			<td  class="col_third" ></td>
			<td colspan="2" class="col_fourth">Enter the target audience field label.</td>
		</tr>

		<tr valign="top" class="col_first">
			<td scope="row" class="col_first">Product e-mail field text</td>
			<td class="col_second">
				<input type="text" name="cmpdc_form_bemail" value="<?php echo esc_attr(!empty($form_bemail) ? $form_bemail : ''); ?>" />
			</td>
			<td  class="col_third" >
				<input type="hidden" name="cmpdc_form_bemail_mandatory" value="0"/>
				<input type="checkbox" name="cmpdc_form_bemail_mandatory" value="1" <?php echo!empty($form_bemail_mandatory) ? 'checked' : '' ?> />
			</td>
			<td colspan="2" class="col_fourth">Enter the email field label.</td>
		</tr>

		<tr valign="top" class="col_first">
			<td scope="row" class="col_first">Product e-mail field placeholder text</td>
			<td class="col_second">
				<input type="text" name="cmpdc_form_bemail_placeholder" value="<?php echo esc_attr(!empty($form_bemail_placeholder) ? $form_bemail_placeholder : ''); ?>" />
			</td>
			<td  class="col_third" ></td>
			<td colspan="2" class="col_fourth">Enter the placeholder text for the email field.</td>
		</tr>
		<tr valign="top" class="col_first">
			<td scope="row" class="col_first">Owner e-mail field text</td>
			<td class="col_second">
				<input type="text" name="cmpdc_form_bemail_contact" value="<?php echo esc_attr(!empty($form_bemail_contact) ? $form_bemail_contact : ''); ?>" />
			</td>
			<td  class="col_third" >
				<input type="hidden" name="cmpdc_form_bemail_contact_mandatory" value="0"/>
				<input type="checkbox" name="cmpdc_form_bemail_contact_mandatory" value="1" <?php echo!empty($form_bemail_contact_mandatory) ? 'checked' : '' ?> />
			</td>
			<td colspan="2" class="col_fourth">Enter the owner email field label.</td>
		</tr>

		<tr valign="top" class="col_first">
			<td scope="row" class="col_first">Owner e-mail field placeholder text</td>
			<td class="col_second">
				<input type="text" name="cmpdc_form_bemail_contact_placeholder" value="<?php echo esc_attr(!empty($form_bemail_contact_placeholder) ? $form_bemail_contact_placeholder : ''); ?>" />
			</td>
			<td  class="col_third" ></td>
			<td colspan="2" class="col_fourth">Enter the placeholder text for the owner email field.</td>
		</tr>
		<tr valign="top" class="col_first">
			<td scope="row" class="col_first">Text above Add logo field</td>
			<td class="col_second">
				<input type="text" name="cmpdc_form_add_product_image_text" value="<?php echo esc_attr(!empty($form_add_product_image_text) ? $form_add_product_image_text : ''); ?>" />
			</td>
			<td class="col_third">
			</td>
			<td colspan="2" class="col_fourth">Enter the text which will appear above 'add logo' field.</td>
		</tr>
		<tr valign="top" class="col_first">
			<td scope="row" class="col_first"> Add logo field text</td>
			<td class="col_second">
				<input type="text" name="cmpdc_form_add_product_image" value="<?php echo esc_attr(!empty($form_add_product_image) ? $form_add_product_image : ''); ?>" />
			</td>
			<td class="col_third">
				<input type="hidden" name="cmpdc_form_add_product_image_mandatory" value="0"/>
				<input type="checkbox" name="cmpdc_form_add_product_image_mandatory" value="1" <?php echo!empty($form_add_product_image_mandatory) ? 'checked' : '' ?> />
			</td>
			<td colspan="2" class="col_fourth">Enter the add logo field label.</td>
		</tr>



<tr valign="top">
		<td scope="row" class="col_first">Video URL field label</td>
		<td class="col_second">
			<input type="text" name="cmpdc_main_form_video_url" id="cmpdc_main_form_video_url" value="<?php echo esc_attr(!empty($main_form_video_url) ? $main_form_video_url : ''); ?>" placeholder="<?php echo esc_attr(!empty($main_form_video_url_placeholder) ? $main_form_video_url_placeholder : ''); ?>" />
		</td>
		<td class="col_third">
			<input type="hidden" name="cmpdc_main_form_video_url_mandatory" id="cmpdc_main_form_video_url_mandatory" value="0" />
			<input type="checkbox" name="cmpdc_main_form_video_url_mandatory" id="cmpdc_main_form_video_url_mandatory" value="1" <?php echo !empty($main_form_video_url_mandatory) ? ' checked' : '' ?> />
		</td>
		<td class="col_fourth" colspan="2">Enter a label for the Video URL field.</td>
	</tr>
	<tr valign="top">
		<td class="col_first" scope="row">Video URL placeholder field</td>
		<td class="col_second">
			<input type="text" name="cmpdc_main_form_video_url_placeholder" id="cmpdc_main_form_video_url_placeholder" value="<?php echo esc_attr(!empty($main_form_video_url_placeholder) ? $main_form_video_url_placeholder : ''); ?>" />
		</td>
		<td class="col_third"></td>
		<td class="col_fourth" colspan="2">Enter the placeholder for the Video URL field.</td>
	</tr>

	<tr valign="top">
		<td scope="row" class="col_first">Company Name field label</td>
		<td class="col_second">
			<input type="text" name="cmpdc_main_form_company_name" id="cmpdc_main_form_company_name" value="<?php echo esc_attr(!empty($main_form_company_name) ? $main_form_company_name : ''); ?>" placeholder="<?php echo esc_attr(!empty($main_form_company_name_placeholder) ? $main_form_company_name_placeholder : ''); ?>" />
		</td>
		<td class="col_third">
			<input type="hidden" name="cmpdc_main_form_company_name_mandatory" id="cmpdc_main_form_company_name_mandatory" value="0" />
			<input type="checkbox" name="cmpdc_main_form_company_name_mandatory" id="cmpdc_main_form_company_name_mandatory" value="1" <?php echo !empty($main_form_company_name_mandatory) ? ' checked' : '' ?> />
		</td>
		<td class="col_fourth" colspan="2">Enter a label for the Company Name field.</td>
	</tr>
	<tr valign="top">
		<td class="col_first" scope="row">Company Name placeholder field</td>
		<td class="col_second">
			<input type="text" name="cmpdc_main_form_company_name_placeholder" id="cmpdc_main_form_company_name_placeholder" value="<?php echo esc_attr(!empty($main_form_company_name_placeholder) ? $main_form_company_name_placeholder : ''); ?>" />
		</td>
		<td class="col_third"></td>
		<td class="col_fourth" colspan="2">Enter the placeholder for the Company Name field.</td>
	</tr>

	<tr valign="top">
		<td scope="row" class="col_first">Product Cost field label</td>
		<td class="col_second">
			<input type="text" name="cmpdc_main_form_product_cost" id="cmpdc_main_form_product_cost" value="<?php echo esc_attr(!empty($main_form_product_cost) ? $main_form_product_cost : ''); ?>" placeholder="<?php echo esc_attr(!empty($main_form_product_cost_placeholder) ? $main_form_product_cost_placeholder : ''); ?>" />
		</td>
		<td class="col_third">
			<input type="hidden" name="cmpdc_main_form_product_cost_mandatory" id="cmpdc_main_form_product_cost_mandatory" value="0" />
			<input type="checkbox" name="cmpdc_main_form_product_cost_mandatory" id="cmpdc_main_form_product_cost_mandatory" value="1" <?php echo !empty($main_form_product_cost_mandatory) ? ' checked' : '' ?> />
		</td>
		<td class="col_fourth" colspan="2">Enter a label for the Product Cost field.</td>
	</tr>
	<tr valign="top">
		<td class="col_first" scope="row">Product Cost placeholder field</td>
		<td class="col_second">
			<input type="text" name="cmpdc_main_form_product_cost_placeholder" id="cmpdc_main_form_product_cost_placeholder" value="<?php echo esc_attr(!empty($main_form_product_cost_placeholder) ? $main_form_product_cost_placeholder : ''); ?>" />
		</td>
		<td class="col_third"></td>
		<td class="col_fourth" colspan="2">Enter the placeholder for the Product Cost field.</td>
	</tr>

	<tr valign="top">
		<td scope="row" class="col_first">Purchase Link field label</td>
		<td class="col_second">
			<input type="text" name="cmpdc_main_form_purchase_link" id="cmpdc_main_form_purchase_link" value="<?php echo esc_attr(!empty($main_form_purchase_link) ? $main_form_purchase_link : ''); ?>" placeholder="<?php echo esc_attr(!empty($main_form_purchase_link_placeholder) ? $main_form_purchase_link_placeholder : ''); ?>" />
		</td>
		<td class="col_third">
			<input type="hidden" name="cmpdc_main_form_purchase_link_mandatory" id="cmpdc_main_form_purchase_link_mandatory" value="0" />
			<input type="checkbox" name="cmpdc_main_form_purchase_link_mandatory" id="cmpdc_main_form_purchase_link_mandatory" value="1" <?php echo !empty($main_form_purchase_link_mandatory) ? ' checked' : '' ?> />
		</td>
		<td class="col_fourth" colspan="2">Enter a label for the Purchase Link field.</td>
	</tr>
	<tr valign="top">
		<td class="col_first" scope="row">Purchase link placeholder field</td>
		<td class="col_second">
			<input type="text" name="cmpdc_main_form_purchase_link_placeholder" id="cmpdc_main_form_purchase_link_placeholder" value="<?php echo esc_attr(!empty($main_form_purchase_link_placeholder) ? $main_form_purchase_link_placeholder : ''); ?>" />
		</td>
		<td class="col_third"></td>
		<td class="col_fourth" colspan="2">Enter the placeholder for the Purchase link field.</td>
	</tr>

	<tr valign="top">
		<td scope="row" class="col_first">Page Link field label</td>
		<td class="col_second">
			<input type="text" name="cmpdc_main_form_page_link" id="cmpdc_main_form_page_link" value="<?php echo esc_attr(!empty($main_form_page_link) ? $main_form_page_link : ''); ?>" placeholder="<?php echo esc_attr(!empty($main_form_page_link_placeholder) ? $main_form_page_link_placeholder : ''); ?>" />
		</td>
		<td class="col_third">
			<input type="hidden" name="cmpdc_main_form_page_link_mandatory" id="cmpdc_main_form_page_link_mandatory" value="0" />
			<input type="checkbox" name="cmpdc_main_form_page_link_mandatory" id="cmpdc_main_form_page_link_mandatory" value="1" <?php echo !empty($main_form_page_link_mandatory) ? ' checked' : '' ?> />
		</td>
		<td class="col_fourth" colspan="2">Enter a label for the Page Link field.</td>
	</tr>
	<tr valign="top">
		<td class="col_first" scope="row">Page Link placeholder field</td>
		<td class="col_second">
			<input type="text" name="cmpdc_main_form_page_link_placeholder" id="cmpdc_main_form_page_link_placeholder" value="<?php echo esc_attr(!empty($main_form_page_link_placeholder) ? $main_form_page_link_placeholder : ''); ?>" />
		</td>
		<td class="col_third"></td>
		<td class="col_fourth" colspan="2">Enter the placeholder for the Page Link field.</td>
	</tr>

	<tr valign="top">
		<td scope="row" class="col_first">Demo Link field label</td>
		<td class="col_second">
			<input type="text" name="cmpdc_main_form_demo_link" id="cmpdc_main_form_demo_link" value="<?php echo esc_attr(!empty($main_form_demo_link) ? $main_form_demo_link : ''); ?>" placeholder="<?php echo esc_attr(!empty($main_form_demo_link_placeholder) ? $main_form_demo_link_placeholder : ''); ?>" />
		</td>
		<td class="col_third">
			<input type="hidden" name="cmpdc_main_form_demo_link_mandatory" id="cmpdc_main_form_demo_link_mandatory" value="0" />
			<input type="checkbox" name="cmpdc_main_form_demo_link_mandatory" id="cmpdc_main_form_demo_link_mandatory" value="1" <?php echo !empty($main_form_demo_link_mandatory) ? ' checked' : '' ?> />
		</td>
		<td class="col_fourth" colspan="2">Enter a label for the Demo Link field.</td>
	</tr>
	<tr valign="top">
		<td class="col_first" scope="row">Demo Link placeholder field</td>
		<td class="col_second">
			<input type="text" name="cmpdc_main_form_demo_link_placeholder" id="cmpdc_main_form_demo_link_placeholder" value="<?php echo esc_attr(!empty($main_form_demo_link_placeholder) ? $main_form_demo_link_placeholder : ''); ?>" />
		</td>
		<td class="col_third"></td>
		<td class="col_fourth" colspan="2">Enter the placeholder for the Demo Link field.</td>
	</tr>




		<tr valign="top">
			<td scope="row" class="col_first">Year Founded field text</td>
			<td class="col_second">
				<input type="text" name="cmpdc_form_year_founded" value="<?php echo esc_attr(!empty($form_year_founded) ? $form_year_founded : ''); ?>" />
			</td>
			<td  class="col_third" ></td>
			<td colspan="2" class="col_fourth">Enter the year founded field label.</td>
		</tr>


		<tr valign="top">
			<td scope="row" class="col_first"> Virtual address field text</td>
			<td class="col_second">
				<input type="text" name="cmpdc_form_virtual_address" value="<?php echo esc_attr(!empty($form_virtual_address) ? $form_virtual_address : ''); ?>" />
			</td>
			<td  class="col_third" ></td>
			<td colspan="2" class="col_fourth">Enter the Virtual address field label.</td>
		</tr>

		<tr valign="top">
			<td scope="row" class="col_first"> Address field text</td>
			<td class="col_second">
				<input type="text" name="cmpdc_form_address" value="<?php echo esc_attr(!empty($form_address) ? $form_address : ''); ?>" />
			</td>
			<td class="col_third">
				<input type="hidden" name="cmpdc_form_address_mandatory" value="0"/>
				<input type="checkbox" name="cmpdc_form_address_mandatory" value="1" <?php echo!empty($form_address_mandatory) ? 'checked' : '' ?> />
			</td>
			<td colspan="2" class="col_fourth">Enter the address field label.</td>
		</tr>

		<tr valign="top">
			<td scope="row" class="col_first">Address field placeholder text</td>
			<td class="col_second">
				<input type="text" name="cmpdc_form_address_placeholder" value="<?php echo esc_attr(!empty($form_address_placeholder) ? $form_address_placeholder : ''); ?>" />
			</td>
			<td  class="col_third" ></td>
			<td colspan="2" class="col_fourth">Enter the placeholder text for the address field.</td>
		</tr>
		<tr valign="top">
			<td scope="row" class="col_first"> City/Town field text</td>
			<td class="col_second">
				<input type="text" name="cmpdc_form_cityTown" value="<?php echo esc_attr(!empty($form_cityTown) ? $form_cityTown : ''); ?>" />
			</td>
			<td class="col_third">
				<input type="hidden" name="cmpdc_form_cityTown_mandatory" value="0"/>
				<input type="checkbox" name="cmpdc_form_cityTown_mandatory" value="1" <?php echo!empty($form_cityTown_mandatory) ? 'checked' : '' ?> />
			</td>
			<td colspan="2" class="col_fourth">Enter the City/Town field label.</td>
		</tr>

		<tr valign="top">
			<td scope="row" class="col_first">City/Town field placeholder text</td>
			<td class="col_second">
				<input type="text" name="cmpdc_form_cityTown_placeholder" value="<?php echo esc_attr(!empty($form_cityTown_placeholder) ? $form_cityTown_placeholder : ''); ?>" />
			</td>
			<td  class="col_third" ></td>
			<td colspan="2" class="col_fourth">Enter the placeholder text for the City/Town field.</td>
		</tr>
		<tr valign="top">
			<td scope="row" class="col_first"> State/County field text</td>
			<td class="col_second">
				<input type="text" name="cmpdc_form_stateCounty" value="<?php echo esc_attr(!empty($form_stateCounty) ? $form_stateCounty : ''); ?>" />
			</td>
			<td class="col_third">
				<input type="hidden" name="cmpdc_form_stateCounty_mandatory" value="0"/>
				<input type="checkbox" name="cmpdc_form_stateCounty_mandatory" value="1" <?php echo!empty($form_stateCounty_mandatory) ? 'checked' : '' ?> />
			</td>
			<td colspan="2" class="col_fourth">Enter the State/County field label.</td>
		</tr>

		<tr valign="top">
			<td scope="row" class="col_first">State/County field placeholder text</td>
			<td class="col_second">
				<input type="text" name="cmpdc_form_stateCounty_placeholder" value="<?php echo esc_attr(!empty($form_stateCounty_placeholder) ? $form_stateCounty_placeholder : ''); ?>" />
			</td>
			<td  class="col_third" ></td>
			<td colspan="2" class="col_fourth">Enter the placeholder text for the State/County field.</td>
		</tr>
		<tr valign="top">
			<td scope="row" class="col_first"> Postal Code field text</td>
			<td class="col_second">
				<input type="text" name="cmpdc_form_postalcode" value="<?php echo esc_attr(!empty($form_postalcode) ? $form_postalcode : ''); ?>" />
			</td>
			<td class="col_third">
				<input type="hidden" name="cmpdc_form_postalcode_mandatory" value="0"/>
				<input type="checkbox" name="cmpdc_form_postalcode_mandatory" value="1" <?php echo!empty($form_postalcode_mandatory) ? 'checked' : '' ?> />
			</td>
			<td colspan="2" class="col_fourth">Enter the Postal Code field label.</td>
		</tr>

		<tr valign="top">
			<td scope="row" class="col_first">Postal Code field placeholder text</td>
			<td class="col_second">
				<input type="text" name="cmpdc_form_postalcode_placeholder" value="<?php echo esc_attr(!empty($form_postalcode_placeholder) ? $form_postalcode_placeholder : ''); ?>" />
			</td>
			<td  class="col_third" ></td>
			<td colspan="2" class="col_fourth">Enter the placeholder text for the Postal Code field.</td>
		</tr>
		<tr valign="top">
			<td scope="row" class="col_first"> Region field text</td>
			<td class="col_second">
				<input type="text" name="cmpdc_form_region" value="<?php echo esc_attr(!empty($form_region) ? $form_region : ''); ?>" />
			</td>
			<td class="col_third">
				<input type="hidden" name="cmpdc_form_region_mandatory" value="0"/>
				<input type="checkbox" name="cmpdc_form_region_mandatory" value="1" <?php echo!empty($form_region_mandatory) ? 'checked' : '' ?> />
			</td>
			<td colspan="2" class="col_fourth">Enter the Region field label.</td>
		</tr>

		<tr valign="top">
			<td scope="row" class="col_first">Region field placeholder text</td>
			<td class="col_second">
				<input type="text" name="cmpdc_form_region_placeholder" value="<?php echo esc_attr(!empty($form_region_placeholder) ? $form_region_placeholder : ''); ?>" />
			</td>
			<td  class="col_third" ></td>
			<td colspan="2" class="col_fourth">Enter the placeholder text for the Region field.</td>
		</tr>
		<tr valign="top">
			<td scope="row" class="col_first"> Country field text</td>
			<td class="col_second">
				<input type="text" name="cmpdc_form_country" value="<?php echo esc_attr(!empty($form_country) ? $form_country : ''); ?>" />
			</td>
			<td class="col_third">
			</td>
			<td colspan="2" class="col_fourth">Enter the Country field label.</td>
		</tr>

		<tr valign="top">
			<td scope="row" class="col_first"> Add Google Map field text</td>
			<td class="col_second">
				<input type="text" name="cmpdc_form_add_google_map" value="<?php echo esc_attr(!empty($form_add_google_map) ? $form_add_google_map : ''); ?>" />
			</td>
			<td  class="col_third" ></td>
			<td colspan="2" class="col_fourth">Enter the add google map field label.</td>
		</tr>

		<tr valign="top">
			<td scope="row" class="col_first"> URL field text</td>
			<td class="col_second">
				<input type="text" name="cmpdc_form_web_url" value="<?php echo esc_attr(!empty($form_web_url) ? $form_web_url : ''); ?>" />
			</td>
			<td class="col_third">
				<input type="hidden" name="cmpdc_form_web_url_mandatory" value="0"/>
				<input type="checkbox" name="cmpdc_form_web_url_mandatory" value="1" <?php echo!empty($form_web_url_mandatory) ? 'checked' : '' ?> />
			</td>
			<td colspan="2" class="col_fourth">Enter the Web address field label.</td>
		</tr>

		<tr valign="top" class="col_first">
			<td scope="row" class="col_first">URL field placeholder text</td>
			<td class="col_second">
				<input type="text" name="cmpdc_form_web_url_placeholder" value="<?php echo esc_attr(!empty($form_web_url_placeholder) ? $form_web_url_placeholder : ''); ?>" />
			</td>
			<td  class="col_third" ></td>
			<td colspan="2" class="col_fourth">Enter the placeholder text for the URL field.</td>
		</tr>

		<tr valign="top">
			<td scope="row" class="col_first"> Facebook field text</td>
			<td class="col_second">
				<input type="text" name="cmpdc_form_facebook_name" value="<?php echo esc_attr(!empty($form_facebook_name) ? $form_facebook_name : ''); ?>" />
			</td>
			<td class="col_third">
				<input type="hidden" name="cmpdc_form_facebook_name_mandatory" value="0"/>
				<input type="checkbox" name="cmpdc_form_facebook_name_mandatory" value="1" <?php echo!empty($form_facebook_name_mandatory) ? 'checked' : '' ?> />
			</td>
			<td colspan="2" class="col_fourth">Enter the email field label.</td>
		</tr>

		<tr valign="top">
			<td scope="row" class="col_first">Facebook field placeholder text</td>
			<td class="col_second">
				<input type="text" name="cmpdc_form_facebook_name_placeholder" value="<?php echo esc_attr(!empty($form_facebook_name_placeholder) ? $form_facebook_name_placeholder : ''); ?>" />
			</td>
			<td  class="col_third" ></td>
			<td colspan="2" class="col_fourth">Enter the placeholder text for the email field .</td>
		</tr>
		<tr valign="top">
			<td scope="row" class="col_first"> Twitter field text</td>
			<td class="col_second">
				<input type="text" name="cmpdc_form_twitter_name" value="<?php echo esc_attr(!empty($form_twitter_name) ? $form_twitter_name : ''); ?>" />
			</td>
			<td class="col_third">
				<input type="hidden" name="cmpdc_form_twitter_name_mandatory" value="0"/>
				<input type="checkbox" name="cmpdc_form_twitter_name_mandatory" value="1" <?php echo!empty($form_twitter_name_mandatory) ? 'checked' : '' ?> />
			</td>
			<td colspan="2" class="col_fourth">Enter the twitter field label.</td>
		</tr>

		<tr valign="top">
			<td scope="row" class="col_first">Twitter field placeholder text</td>
			<td class="col_second">
				<input type="text" name="cmpdc_form_twitter_name_placeholder" value="<?php echo esc_attr(!empty($form_twitter_name_placeholder) ? $form_twitter_name_placeholder : ''); ?>" />
			</td>
			<td  class="col_third" ></td>
			<td colspan="2" class="col_fourth">Enter the placeholder text for the twitter field .</td>
		</tr>

		<tr valign="top">
			<td scope="row" class="col_first"> Google+ field text</td>
			<td class="col_second">
				<input type="text" name="cmpdc_form_google" value="<?php echo esc_attr(!empty($form_google) ? $form_google : ''); ?>" />
			</td>
			<td class="col_third">
				<input type="hidden" name="cmpdc_form_google_mandatory" value="0"/>
				<input type="checkbox" name="cmpdc_form_google_mandatory" value="1" <?php echo!empty($form_google_mandatory) ? 'checked' : '' ?> />
			</td>
			<td colspan="2" class="col_fourth">Enter the google+ field label.</td>
		</tr>

		<tr valign="top">
			<td scope="row" class="col_first">Google+ field placeholder text</td>
			<td class="col_second">
				<input type="text" name="cmpdc_form_google_placeholder" value="<?php echo esc_attr(!empty($form_google_placeholder) ? $form_google_placeholder : ''); ?>" />
			</td>
			<td  class="col_third" ></td>
			<td colspan="2" class="col_fourth">Enter the placeholder text for the google+ field .</td>
		</tr>

		<tr valign="top">
			<td scope="row" class="col_first"> LinkedIn field text</td>
			<td class="col_second">
				<input type="text" name="cmpdc_form_linkedin" value="<?php echo esc_attr(!empty($form_linkedin) ? $form_linkedin : ''); ?>" />
			</td>
			<td class="col_third">
				<input type="hidden" name="cmpdc_form_linkedin_mandatory" value="0"/>
				<input type="checkbox" name="cmpdc_form_linkedin_mandatory" value="1" <?php echo!empty($form_linkedin_mandatory) ? 'checked' : '' ?> />
			</td>
			<td colspan="2" class="col_fourth">Enter the linkedin field label.</td>
		</tr>

		<tr valign="top">
			<td scope="row" class="col_first">LinkedIn field placeholder text</td>
			<td class="col_second">
				<input type="text" name="cmpdc_form_linkedin_placeholder" value="<?php echo esc_attr(!empty($form_linkedin_placeholder) ? $form_linkedin_placeholder : ''); ?>" />
			</td>
			<td  class="col_third" ></td>
			<td colspan="2" class="col_fourth">Enter the placeholder text for the linkedin field .</td>
		</tr>
		<tr valign="top">
			<td scope="row" class="col_first"> RSS field text</td>
			<td class="col_second">
				<input type="text" name="cmpdc_form_rss" value="<?php echo esc_attr(!empty($form_rss) ? $form_rss : ''); ?>" />
			</td>
			<td class="col_third">
				<input type="hidden" name="cmpdc_form_rss_mandatory" value="0"/>
				<input type="checkbox" name="cmpdc_form_rss_mandatory" value="1" <?php echo!empty($form_rss_mandatory) ? 'checked' : '' ?> />
			</td>
			<td colspan="2" class="col_fourth">Enter the RSS field label.</td>
		</tr>
		<tr valign="top">
			<td scope="row" class="col_first">RSS field placeholder text</td>
			<td class="col_second">
				<input type="text" name="cmpdc_form_rss_placeholder" value="<?php echo esc_attr(!empty($form_rss_placeholder) ? $form_rss_placeholder : ''); ?>" />
			</td>
			<td  class="col_third" ></td>
			<td colspan="2" class="col_fourth">Enter the placeholder text for the rss field .</td>
		</tr>

		<!-- Additional Links -->
		<?php
			$additionalLinkLabel_1 = CMPD_Settings::getOption(CMPD_Settings::OPTION_ADD_LINKS_LABEL1);
			$additionalLinkLabel_1 = !empty($additionalLinkLabel_1) ? $additionalLinkLabel_1 : $form_add_link1;
			$additionalLinkLabel_2 = CMPD_Settings::getOption(CMPD_Settings::OPTION_ADD_LINKS_LABEL2);
			$additionalLinkLabel_2 = !empty($additionalLinkLabel_2) ? $additionalLinkLabel_2 : $form_add_link2;
			$additionalLinkLabel_3 = CMPD_Settings::getOption(CMPD_Settings::OPTION_ADD_LINKS_LABEL3);
			$additionalLinkLabel_3 = !empty($additionalLinkLabel_3) ? $additionalLinkLabel_3 : $form_add_link3;
			$additionalLinkLabel_4 = CMPD_Settings::getOption(CMPD_Settings::OPTION_ADD_LINKS_LABEL4);
			$additionalLinkLabel_4 = !empty($additionalLinkLabel_4) ? $additionalLinkLabel_4 : $form_add_link4;
		?>

		<!-- Additional Links Labels -->
		<tr valign="top">
			<td scope="row" class="col_first">
				<?php echo esc_html($additionalLinkLabel_1); ?> field text
			</td>
			<td class="col_second">
				<input type="text" name="cmpdc_form_add_link1" value="<?php echo esc_html(!empty($form_add_link1) ? $form_add_link1 : ''); ?>" />
			</td>
			<td class="col_third"></td>
			<td colspan="2" class="col_fourth">Enter the label text for <?php echo esc_html($additionalLinkLabel_1); ?></td>
		</tr>
		<tr valign="top">
			<td scope="row" class="col_first">
				<?php echo esc_html($additionalLinkLabel_2); ?> field text
			</td>
			<td class="col_second">
				<input type="text" name="cmpdc_form_add_link2" value="<?php echo esc_html(!empty($form_add_link2) ? $form_add_link2 : ''); ?>" />
			</td>
			<td class="col_third"></td>
			<td colspan="2" class="col_fourth">Enter the label text for <?php echo esc_html($additionalLinkLabel_2); ?></td>
		</tr>
		<tr valign="top">
			<td scope="row" class="col_first">
				<?php echo esc_html($additionalLinkLabel_3); ?> field text
			</td>
			<td class="col_second">
				<input type="text" name="cmpdc_form_add_link3" value="<?php echo esc_html(!empty($form_add_link3) ? $form_add_link3 : ''); ?>" />
			</td>
			<td class="col_third"></td>
			<td colspan="2" class="col_fourth">Enter the label text for <?php echo esc_html($additionalLinkLabel_3); ?></td>
		</tr>
		<tr valign="top">
			<td scope="row" class="col_first">
				<?php echo esc_html($additionalLinkLabel_4); ?> field text
			</td>
			<td class="col_second">
				<input type="text" name="cmpdc_form_add_link4" value="<?php echo esc_html(!empty($form_add_link4) ? $form_add_link4 : ''); ?>" />
			</td>
			<td class="col_third"></td>
			<td colspan="2" class="col_fourth">Enter the label text for <?php echo esc_html($additionalLinkLabel_4); ?></td>
		</tr>		

		<!-- Additional Links Placeholders -->
		<tr valign="top">
			<td scope="row" class="col_first">
				<?php echo esc_html($additionalLinkLabel_1); ?> placeholder text
			</td>
			<td class="col_second">
				<input type="text" name="cmpdc_form_add_link1_placeholder" value="<?php echo esc_html(!empty($form_add_link1_placeholder) ? $form_add_link1_placeholder : ''); ?>" />
			</td>
			<td class="col_third"></td>
			<td class="col_fourth" colspan="2">Enter the placeholder for <?php echo esc_html($additionalLinkLabel_1); ?></td>
		</tr>
		<tr valign="top">
			<td scope="row" class="col_first">
				<?php echo esc_html($additionalLinkLabel_2); ?> placeholder text
			</td>
			<td class="col_second">
				<input type="text" name="cmpdc_form_add_link2_placeholder" value="<?php echo esc_html(!empty($form_add_link2_placeholder) ? $form_add_link2_placeholder : ''); ?>" />
			</td>
			<td class="col_third"></td>
			<td class="col_fourth" colspan="2">Enter the placeholder for <?php echo esc_html($additionalLinkLabel_2); ?></td>
		</tr>
		<tr valign="top">
			<td scope="row" class="col_first">
				<?php echo esc_html($additionalLinkLabel_3); ?> placeholder text
			</td>
			<td class="col_second">
				<input type="text" name="cmpdc_form_add_link3_placeholder" value="<?php echo esc_html(!empty($form_add_link3_placeholder) ? $form_add_link3_placeholder : ''); ?>" />
			</td>
			<td class="col_third"></td>
			<td class="col_fourth" colspan="2">Enter the placeholder for <?php echo esc_html($additionalLinkLabel_3); ?></td>
		</tr>
		<tr valign="top">
			<td scope="row" class="col_first">
				<?php echo esc_html($additionalLinkLabel_4); ?> placeholder text
			</td>
			<td class="col_second">
				<input type="text" name="cmpdc_form_add_link4_placeholder" value="<?php echo esc_html(!empty($form_add_link4_placeholder) ? $form_add_link4_placeholder : ''); ?>" />
			</td>
			<td class="col_third"></td>
			<td class="col_fourth" colspan="2">Enter the placeholder for <?php echo esc_html($additionalLinkLabel_4); ?></td>
		</tr>

		<!-- Additional Fields -->
		<?php
			$additionalFieldLabel_1 = CMPD_Settings::getOption(CMPD_Settings::OPTION_ADD_FIELDS_LABEL1);
			$additionalFieldLabel_1 = !empty($additionalFieldLabel_1) ? $additionalFieldLabel_1 : $form_add_field1;
			$additionalFieldLabel_2 = CMPD_Settings::getOption(CMPD_Settings::OPTION_ADD_FIELDS_LABEL2);
			$additionalFieldLabel_2 = !empty($additionalFieldLabel_2) ? $additionalFieldLabel_2 : $form_add_field2;
			$additionalFieldLabel_3 = CMPD_Settings::getOption(CMPD_Settings::OPTION_ADD_FIELDS_LABEL3);
			$additionalFieldLabel_3 = !empty($additionalFieldLabel_3) ? $additionalFieldLabel_3 : $form_add_field3;
			$additionalFieldLabel_4 = CMPD_Settings::getOption(CMPD_Settings::OPTION_ADD_FIELDS_LABEL4);
			$additionalFieldLabel_4 = !empty($additionalFieldLabel_4) ? $additionalFieldLabel_4 : $form_add_field4;
		?>

		<!-- Additional Fields Labels -->
		<tr valign="top">
			<td scope="row" class="col_first">
				<?php echo esc_html($additionalFieldLabel_1); ?> field text
			</td>
			<td class="col_second">
				<input type="text" name="cmpdc_form_add_field1" value="<?php echo esc_html(!empty($form_add_field1) ? $form_add_field1 : ''); ?>" />
			</td>
			<td class="col_third"></td>
			<td colspan="2" class="col_fourth">Enter the label text for <?php echo esc_html($additionalFieldLabel_1); ?></td>
		</tr>
		<tr valign="top">
			<td scope="row" class="col_first">
				<?php echo esc_html($additionalFieldLabel_2); ?> field text
			</td>
			<td class="col_second">
				<input type="text" name="cmpdc_form_add_field2" value="<?php echo esc_html(!empty($form_add_field2) ? $form_add_field2 : ''); ?>" />
			</td>
			<td class="col_third"></td>
			<td colspan="2" class="col_fourth">Enter the label text for <?php echo esc_html($additionalFieldLabel_2); ?></td>
		</tr>
		<tr valign="top">
			<td scope="row" class="col_first">
				<?php echo esc_html($additionalFieldLabel_3); ?> field text
			</td>
			<td class="col_second">
				<input type="text" name="cmpdc_form_add_field3" value="<?php echo esc_html(!empty($form_add_field3) ? $form_add_field3 : ''); ?>" />
			</td>
			<td class="col_third"></td>
			<td colspan="2" class="col_fourth">Enter the label text for <?php echo esc_html($additionalFieldLabel_3); ?></td>
		</tr>
		<tr valign="top">
			<td scope="row" class="col_first">
				<?php echo esc_html($additionalFieldLabel_4); ?> field text
			</td>
			<td class="col_second">
				<input type="text" name="cmpdc_form_add_field4" value="<?php echo esc_html(!empty($form_add_field4) ? $form_add_field4 : ''); ?>" />
			</td>
			<td class="col_third"></td>
			<td colspan="2" class="col_fourth">Enter the label text for <?php echo esc_html($additionalFieldLabel_4); ?></td>
		</tr>

		<!-- Additional Fields Placeholders -->
		<tr valign="top">
			<td scope="row" class="col_first">
				<?php echo esc_html($additionalFieldLabel_1); ?> placeholder text
			</td>
			<td class="col_second">
				<input type="text" name="cmpdc_form_add_field1_placeholder" value="<?php echo esc_html(!empty($form_add_field1_placeholder) ? $form_add_field1_placeholder : ''); ?>" />
			</td>
			<td class="col_third"></td>
			<td class="col_fourth" colspan="2">Enter the placeholder for <?php echo esc_html($additionalFieldLabel_1); ?></td>
		</tr>
		<tr valign="top">
			<td scope="row" class="col_first">
				<?php echo esc_html($additionalFieldLabel_2); ?> placeholder text
			</td>
			<td class="col_second">
				<input type="text" name="cmpdc_form_add_field2_placeholder" value="<?php echo esc_html(!empty($form_add_field2_placeholder) ? $form_add_field2_placeholder : ''); ?>" />
			</td>
			<td class="col_third"></td>
			<td class="col_fourth" colspan="2">Enter the placeholder for <?php echo esc_html($additionalFieldLabel_2); ?></td>
		</tr>
		<tr valign="top">
			<td scope="row" class="col_first">
				<?php echo esc_html($additionalFieldLabel_3); ?> placeholder text
			</td>
			<td class="col_second">
				<input type="text" name="cmpdc_form_add_field3_placeholder" value="<?php echo esc_html(!empty($form_add_field3_placeholder) ? $form_add_field3_placeholder : ''); ?>" />
			</td>
			<td class="col_third"></td>
			<td class="col_fourth" colspan="2">Enter the placeholder for <?php echo esc_html($additionalFieldLabel_3); ?></td>
		</tr>
		<tr valign="top">
			<td scope="row" class="col_first">
				<?php echo esc_html($additionalFieldLabel_4); ?> placeholder text
			</td>
			<td class="col_second">
				<input type="text" name="cmpdc_form_add_field4_placeholder" value="<?php echo esc_html(!empty($form_add_field4_placeholder) ? $form_add_field4_placeholder : ''); ?>" />
			</td>
			<td class="col_third"></td>
			<td class="col_fourth" colspan="2">Enter the placeholder for <?php echo esc_html($additionalFieldLabel_4); ?></td>
		</tr>		
		

		<tr valign="top">
			<td scope="row" class="col_first"> Phone field text</td>
			<td class="col_second">
				<input type="text" name="cmpdc_form_phone" value="<?php echo esc_attr(!empty($form_phone) ? $form_phone : ''); ?>" />
			</td>
			<td class="col_third">
				<input type="hidden" name="cmpdc_form_phone_mandatory" value="0"/>
				<input type="checkbox" name="cmpdc_form_phone_mandatory" value="1" <?php echo!empty($form_phone_mandatory) ? 'checked' : '' ?> />
			</td>
			<td colspan="2" class="col_fourth">Enter the phone field label.</td>
		</tr>

		<tr valign="top">
			<td scope="row" class="col_first">Phone field placeholder text</td>
			<td class="col_second">
				<input type="text" name="cmpdc_form_phone_placeholder" value="<?php echo esc_attr(!empty($form_phone_placeholder) ? $form_phone_placeholder : ''); ?>" />
			</td>
			<td  class="col_third" ></td>
			<td colspan="2" class="col_fourth">Enter the placeholder text for the phone field .</td>
		</tr>


<tr valign="top">
	<td scope="row" class="col_first">Gallery image #1 label</td>
	<td class="col_second">
		<input type="text" name="cmpdc_form_add_gallery_image_1" id="cmpdc_form_add_gallery_image_1" value="<?php echo esc_attr(!empty($form_add_gallery_image_1) ? $form_add_gallery_image_1 : ''); ?>" />
	</td>
	<td class="col_third"></td>
	<td class="col_fourth" colspan="2">Enter the text for the Gallery Image #1 label.</td>
</tr>

<tr valign="top">
	<td scope="row" class="col_first">Gallery image #2 label</td>
	<td class="col_second">
		<input type="text" name="cmpdc_form_add_gallery_image_2" id="cmpdc_form_add_gallery_image_2" value="<?php echo esc_attr(!empty($form_add_gallery_image_2) ? $form_add_gallery_image_2 : ''); ?>" />
	</td>
	<td class="col_third"></td>
	<td class="col_fourth" colspan="2">Enter the text for the Gallery Image #2 label.</td>
</tr>

<tr valign="top">
	<td scope="row" class="col_first">Gallery image #3 label</td>
	<td class="col_second">
		<input type="text" name="cmpdc_form_add_gallery_image_3" id="cmpdc_form_add_gallery_image_3" value="<?php echo esc_attr(!empty($form_add_gallery_image_3) ? $form_add_gallery_image_3 : ''); ?>" />
	</td>
	<td class="col_third"></td>
	<td class="col_fourth" colspan="2">Enter the text for the Gallery Image #3 label.</td>
</tr>

<tr valign="top">
	<td scope="row" class="col_first">Gallery image #4 label</td>
	<td class="col_second">
		<input type="text" name="cmpdc_form_add_gallery_image_4" id="cmpdc_form_add_gallery_image_4" value="<?php echo esc_attr(!empty($form_add_gallery_image_4) ? $form_add_gallery_image_4 : ''); ?>" />
	</td>
	<td class="col_third"></td>
	<td class="col_fourth" colspan="2">Enter the text for the Gallery Image #4 label.</td>
</tr>

		<tr valign="top">
			<td scope="row" class="col_first">Captcha field text</td>
			<td class="col_second">
				<input type="text" name="cmpdc_form_captcha_text" value="<?php echo esc_attr(!empty($form_captcha_text) ? $form_captcha_text : ''); ?>" />
			</td>
			<td  class="col_third" ></td>
			<td colspan="2" class="col_fourth">Enter the captcha field label.</td>
		</tr>

		<tr valign="top">
			<td scope="row" class="col_first">Suggest a Product Button text</td>
			<td class="col_second">
				<input type="text" name="cmpdc_form_button_text" value="<?php echo esc_attr(!empty($form_button_text) ? $form_button_text : ''); ?>" />
			</td>
			<td  class="col_third" ></td>
			<td colspan="2" class="col_fourth">Enter the button label.</td>
		</tr>
		<tr valign="top">
			<td scope="row" class="col_first">Update a Product Button text</td>
			<td class="col_second">
				<input type="text" name="cmpdc_form_button_text_update" value="<?php echo esc_attr(!empty($form_button_text_update) ? $form_button_text_update : ''); ?>" />
			</td>
			<td  class="col_third" ></td>
			<td colspan="2" class="col_fourth">Enter the button label.</td>
		</tr>

		<tr valign="top">
			<td scope="row" class="col_first">Login and Edit text</td>
			<td class="col_second">
				<input type="text" name="cmpdc_form_login_label" value="<?php echo esc_attr(!empty($form_login_label) ? $form_login_label : ''); ?>" />
			</td>
			<td  class="col_third" ></td>
			<td colspan="2" class="col_fourth">Enter the login and edit label.</td>
		</tr>

		<tr valign="top">
			<td scope="row" class="col_first">Return link text</td>
			<td class="col_second">
				<input type="text" name="cmpdc_form_back_label" value="<?php echo esc_attr(!empty($form_back_label) ? $form_back_label : ''); ?>" />
			</td>
			<td  class="col_third" ></td>
			<td colspan="2" class="col_fourth">Enter the return label.</td>
		</tr>

		<tr valign="top">
			<td scope="row" class="col_first">Login Button text</td>
			<td class="col_second">
				<input type="text" name="cmpdc_form_button2_text" value="<?php echo esc_attr(!empty($form_button2_text) ? $form_button2_text : ''); ?>" />
			</td>
			<td  class="col_third" ></td>
			<td colspan="2" class="col_fourth">Enter the button label.</td>
		</tr>

		<tr valign="top">
			<td scope="row" class="col_first">Saved notification</td>
			<td class="col_second">
				<input type="text" name="cmpdc_settings_saved" value="<?php echo esc_attr(!empty($cmpdc_settings_saved) ? $cmpdc_settings_saved : ''); ?>" />
			</td>
			<td  class="col_third" ></td>
			<td colspan="2" class="col_fourth">Enter the text displayed after the product is saved.</td>
		</tr>

		<tr valign="top">
			<td scope="row" class="col_first">Moderation notification</td>
			<td class="col_second">
				<input type="text" name="cmpdc_settings_moderation" value="<?php echo esc_attr(!empty($cmpdc_settings_moderation) ? $cmpdc_settings_moderation : ''); ?>" />
			</td>
			<td  class="col_third" ></td>
			<td colspan="2" class="col_fourth">Enter the text displayed after the product is being held for moderation.</td>
		</tr>

		<tr valign="top">
			<td scope="row" class="col_first">Published notification</td>
			<td class="col_second">
				<input type="text" name="cmpdc_settings_published" value="<?php echo esc_attr(!empty($cmpdc_settings_published) ? $cmpdc_settings_published : ''); ?>" />
			</td>
			<td  class="col_third" ></td>
			<td colspan="2" class="col_fourth">Enter the text displayed after the product is published immediately.</td>
		</tr>
	</table>
</div>
<div class="block">
	<h3>Claim Product</h3>
<?php //claim product  ?>
	<table class=" settting_label_table">
		<tr valign="top">
			<td scope="row" class="col_first">Claim this product label</td>
			<td class="col_second">
				<input type="text" name="cmpdc_form_claim_text" value="<?php echo esc_attr(!empty($form_claim_text) ? $form_claim_text : ''); ?>" />
			</td>
			<td  class="col_third" ></td>
			<td colspan="2" class="col_fourth">Enter the Claim this product label.</td>
		</tr>
		<tr valign="top">
			<td scope="row" class="col_first">Name label</td>
			<td class="col_second">
				<input type="text" name="cmpdc_form_claim_name" value="<?php echo esc_attr(!empty($form_claim_name) ? $form_claim_name : ''); ?>" />
			</td>
			<td  class="col_third" ></td>
			<td colspan="2" class="col_fourth">Enter the Name label.</td>
		</tr>
		<tr valign="top">
			<td scope="row" class="col_first">Email label</td>
			<td class="col_second">
				<input type="text" name="cmpdc_form_claim_email" value="<?php echo esc_attr(!empty($form_claim_email) ? $form_claim_email : ''); ?>" />
			</td>
			<td  class="col_third" ></td>
			<td colspan="2" class="col_fourth">Enter the Email label.</td>
		</tr>
		<tr valign="top">
			<td scope="row" class="col_first">Claim button label</td>
			<td class="col_second">
				<input type="text" name="cmpdc_form_claim_button" value="<?php echo esc_attr(!empty($form_claim_button) ? $form_claim_button : ''); ?>" />
			</td>
			<td  class="col_third" ></td>
			<td colspan="2" class="col_fourth">Enter the Claim button label.</td>
		</tr>
		<tr valign="top">
			<td scope="row" class="col_first">Success on claim message</td>
			<td class="col_second">
				<input type="text" name="cmpdc_form_claim_success" value="<?php echo esc_attr(!empty($form_claim_success) ? $form_claim_success : ''); ?>" />
			</td>
			<td  class="col_third" ></td>
			<td colspan="2" class="col_fourth">Enter the success on claim message.</td>
		</tr>
		<tr valign="top">
			<td scope="row" class="col_first"> "Fill all mandatory fields" on claim message</td>
			<td class="col_second">
				<input type="text" name="cmpdc_form_claim_fill_all" value="<?php echo esc_attr(!empty($form_claim_fill_all) ? $form_claim_fill_all : ''); ?>" />
			</td>
			<td  class="col_third" ></td>
			<td colspan="2" class="col_fourth">Enter the "Fill all mandatory fields" on claim label.</td>
		</tr>
		<tr valign="top">
			<td scope="row" class="col_first">Warning on claim message</td>
			<td class="col_second">
				<input type="text" name="cmpdc_form_claim_warning" value="<?php echo esc_attr(!empty($form_claim_warning) ? $form_claim_warning : ''); ?>" />
			</td>
			<td  class="col_third" ></td>
			<td colspan="2" class="col_fourth">Enter the warning on claim message.</td>
		</tr>
		<tr valign="top">
			<td scope="row" class="col_first">Wrong Captcha on claim message</td>
			<td class="col_second">
				<input type="text" name="cmpdc_form_claim_wrong_captcha" value="<?php echo esc_attr(!empty($form_claim_wrong_captcha) ? $form_claim_wrong_captcha : ''); ?>" />
			</td>
			<td  class="col_third" ></td>
			<td colspan="2" class="col_fourth">Enter the Wrong Captcha message.</td>
		</tr>
		<tr valign="top">
			<td scope="row" class="col_first">Pending claim message</td>
			<td class="col_second">
				<input type="text" name="cmpdc_form_claim_pending" value="<?php echo esc_attr(!empty($form_claim_pending) ? $form_claim_pending : ''); ?>" />
			</td>
			<td  class="col_third" ></td>
			<td colspan="2" class="col_fourth">Enter the Pending claim message. The message is displayed when there's at least one pending claim.</td>
		</tr>
<?php // resend login and password  ?>
	</table>
</div>
<div class="block">
	<h3>Recover Login and Password</h3>
<?php //claim product  ?>
	<table class=" settting_label_table">
		<tr valign="top">
			<td scope="row" class="col_first">Recover login and password label</td>
			<td class="col_second">
				<input type="text" name="cmpdc_form_recover_text" value="<?php echo esc_attr(!empty($form_recover_text) ? $form_recover_text : ''); ?>" />
			</td>
			<td  class="col_third" ></td>
			<td colspan="2" class="col_fourth">Enter the recover login and password label.</td>
		</tr>

		<tr valign="top">
			<td scope="row" class="col_first">Email label</td>
			<td class="col_second">
				<input type="text" name="cmpdc_form_recover_email" value="<?php echo esc_attr(!empty($form_recover_email) ? $form_recover_email : ''); ?>" />
			</td>
			<td  class="col_third" ></td>
			<td colspan="2" class="col_fourth">Enter the Email label.</td>
		</tr>
		<tr valign="top">
			<td scope="row" class="col_first">recover button label</td>
			<td class="col_second">
				<input type="text" name="cmpdc_form_recover_button" value="<?php echo esc_attr(!empty($form_recover_button) ? $form_recover_button : ''); ?>" />
			</td>
			<td  class="col_third" ></td>
			<td colspan="2" class="col_fourth">Enter the recover button label.</td>
		</tr>
		<tr valign="top">
			<td scope="row" class="col_first">Success on recover message</td>
			<td class="col_second">
				<input type="text" name="cmpdc_form_recover_success" value="<?php echo esc_attr(!empty($form_recover_success) ? $form_recover_success : ''); ?>" />
			</td>
			<td  class="col_third" ></td>
			<td colspan="2" class="col_fourth">Enter the success on recover message.</td>
		</tr>
		<tr valign="top">
			<td scope="row" class="col_first"> "Fill all mandatory fields" on recover message</td>
			<td class="col_second">
				<input type="text" name="cmpdc_form_recover_fill_all" value="<?php echo esc_attr(!empty($form_recover_fill_all) ? $form_recover_fill_all : ''); ?>" />
			</td>
			<td  class="col_third" ></td>
			<td colspan="2" class="col_fourth">Enter the "Fill all mandatory fields" on recover label.</td>
		</tr>
		<tr valign="top">
			<td scope="row" class="col_first">Wrong email on recover message</td>
			<td class="col_second">
				<input type="text" name="cmpdc_form_recover_warning" value="<?php echo esc_attr(!empty($form_recover_warning) ? $form_recover_warning : ''); ?>" />
			</td>
			<td  class="col_third" ></td>
			<td colspan="2" class="col_fourth">Enter the Wrong email on recover message.</td>
		</tr>
	</table>

</div>
<div class="block">
	<h3>Other</h3>
<?php //claim product  ?>
	<table class=" settting_label_table">
		<tr valign="top">
			<td scope="row" class="col_first">Show/hide label</td>
			<td class="col_second">
				<input type="text" name="cmpdc_form_showhide_text" value="<?php echo esc_attr(!empty($form_showhide_text) ? $form_showhide_text : ''); ?>" />
			</td>
			<td  class="col_third" ></td>
			<td colspan="2" class="col_fourth">Enter the "Show/hide" label.</td>
		</tr>
		<tr valign="top">
			<td scope="row" class="col_first">Mandatory field missing text</td>
			<td class="col_second">
				<input type="text" name="cmpdc_form_mandatory_text" value="<?php echo esc_attr(!empty($form_mandatory_text) ? $form_mandatory_text : ''); ?>" />
			</td>
			<td  class="col_third" ></td>
			<td colspan="2" class="col_fourth">Enter the alert text when one of the mandatory fields is missing.</td>
		</tr>
	</table>
</div>