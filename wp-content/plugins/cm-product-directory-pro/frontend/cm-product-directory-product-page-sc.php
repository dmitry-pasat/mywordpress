<?php

class CMPDProductPageShortcodes {

    // Taxonomy list
    public static function output_categories($atts = array()) {
        $output = '';
        $display = CMPD_Settings::getOption(CMPD_Settings::LIST_TAXONOMY_TERMS_CATEGORY);
        if ($display) {
            $tax_name = CMProductDirectoryShared::POST_TYPE_TAXONOMY; // regular categories
            $taxonomy = array(
                'name' => CMPD_Labels::getLocalized('cat_filter_label'),
                'slug' => 'cmcats',
                'terms' => wp_get_post_terms(get_the_ID(), $tax_name),
                'icon' => 'dashicons-category',
            );
            $output .= self::displayGivenTerms($taxonomy);
        }
        return apply_filters( 'cmpd_output_categories', $output, $atts );
    }

    public static function output_pricing_models($atts) {
        $output = '';
        $display = CMPD_Settings::getOption(CMPD_Settings::LIST_TAXONOMY_TERMS_PRICINGMODEL);
        if ($display) {
            $tax_name = CMProductDirectoryShared::POST_TYPE_TAX_PRICINGMODEL;
            $taxonomy = array(
                'name' => CMPD_Labels::getLocalized('pricingmodel_filter_label'),
                'terms' => wp_get_post_terms(get_the_ID(), $tax_name),
                'slug' => 'cmpd_pricing_model',
                'icon' => 'dashicons-tickets-alt',
            );
            $output .= self::displayGivenTerms($taxonomy);
        }
        return apply_filters( 'cmpd_output_display_pricing_models', $output, $atts );
    }

    public static function output_language_supports($atts) {
        $output = '';
        $display = CMPD_Settings::getOption(CMPD_Settings::LIST_TAXONOMY_TERMS_LANGUAGESUPPORT);
        if ($display) {
            $tax_name = CMProductDirectoryShared::POST_TYPE_TAX_LANGUAGESUPPORT;
            $taxonomy = array(
                'name' => CMPD_Labels::getLocalized('langsupport_filter_label'),
                'terms' => wp_get_post_terms(get_the_ID(), $tax_name),
                'slug' => 'cmpd_language_support',
                'icon' => 'dashicons-translation',
            );
            $output .= self::displayGivenTerms($taxonomy);
        }
        return apply_filters( 'cmpd_output_display_language_supports', $output, $atts );
    }

    public static function output_target_audiences($atts = array()) {
        $output = '';
        $display = CMPD_Settings::getOption(CMPD_Settings::LIST_TAXONOMY_TERMS_TARGETAUDIENCE);
        if ($display) {
            $tax_name = CMProductDirectoryShared::POST_TYPE_TAX_TARGETAUDIENCE;
            $taxonomy = array(
                'name' => CMPD_Labels::getLocalized('targetaudience_filter_label'),
                'slug' => 'cmpd_target_audience',
                'terms' => wp_get_post_terms(get_the_ID(), $tax_name),
                'icon' => 'dashicons-groups',
            );
            $output .= self::displayGivenTerms($taxonomy);
        }
        return apply_filters( 'cmpd_output_display_target_audiences', $output, $atts );
    }

    public static function output_tags($atts = array()) {
        $output = '';
        $display = CMPD_Settings::getOption(CMPD_Settings::LIST_TAXONOMY_TERMS_TAG);
        if ($display) {
            $tax_name = CMProductDirectoryShared::POST_TYPE_TAXONOMY_TAG; // tags
            $taxonomy = array(
                'name' => CMPD_Labels::getLocalized('tag_filter_label'),
                'slug' => 'cmtags',
                'terms' => wp_get_post_terms(get_the_ID(), $tax_name),
                'icon' => 'dashicons-tag',
            );
            $output .= self::displayGivenTerms($taxonomy);
        }
        return apply_filters( 'cmpd_output_tags', $output, $atts );
    }

    public static function displayGivenTerms($taxonomy, $atts = array()) {
        $output = '';
        if (!empty($taxonomy) && !empty($taxonomy['terms'])) {
            $productsPageID = CMPD_Settings::getOption(CMProductDirectory::SHORTCODE_PAGE_OPTION);
            $productPageLink = get_page_link($productsPageID) . '?query=&';

            $output .= '<ul class="cmpd-box-taxonomy">';
            $output .= '<li><span class="dashicons ' . esc_attr($taxonomy['icon']) . ' cmpd_dashicons"></span>' . esc_html($taxonomy['name']) . '</li>';

            foreach ($taxonomy['terms'] as $term) {
                if (!empty($term)) {
                    $output .= '<li><a href="'.esc_attr($productPageLink).esc_attr($taxonomy['slug']).'='.esc_attr($term->slug).'" title="' . esc_attr($term->name) . '">' . esc_attr($term->name) . '</a></li>';
                }
            }
            $output .= '</ul>';
        }
        return apply_filters( 'cmpd_output_given_terms', $output, $atts );
    }

    public static function outputProductPitch($atts) {
        $output = '';
        $post = get_post();
        $tag = !empty($atts['tag']) ? $atts['tag'] : 'div';
        $class = !empty($atts['class']) ? $atts['class'] : 'cmpd-product-pitch-label';

        if (empty($post)) {
            return;
        }

        $product_pitch = CMPD_Labels::getLocalized('product_pitch');
        $meta = CMProductDirectory::meta($post->ID, 'cmpd_product_pitch');

        if (!empty($meta)) {
            $output .= '<' . esc_attr($tag) . ' class="' . esc_attr($class) . '">' . CMProductDirectory::__($product_pitch) . ' ' . $meta . '</' . esc_attr($tag) . '>';
        }
        return apply_filters( 'cmpd_output_product_pitch', $output, $atts );
    }

    public static function outputYearFounded($atts) {
        $output = '';
        $display = CMPD_Settings::getOption(CMPD_Settings::OPTION_DISPLAY_YEAR_FOUNDED);
        if ($display) {
            $post = get_post();
            $tag = !empty($atts['tag']) ? $atts['tag'] : 'span';
            $class = !empty($atts['class']) ? $atts['class'] : 'cmpd-year-founded-label';

            if (empty($post)) {
                return;
            }
            $year_founded = CMPD_Labels::getLocalized('year_founded');
            $meta = CMProductDirectory::meta($post->ID, 'cmpd_year_founded');

            if (!empty($meta) && $meta != 'Not indicated') {
                $output .= '<li><span class="dashicons dashicons-calendar-alt cmpd_dashicons"></span><' . esc_attr($tag) . ' class="' . esc_attr($class) . '">' . CMProductDirectory::__($year_founded) . ' ' . esc_html($meta) . '</' . esc_attr($tag) . '></li>';
            }
        }
        return apply_filters( 'cmpd_output_year_founded', $output, $atts );
    }

    public static function outputLocation($atts) {
        $output = '';
        $post = get_post();
        $label = CMPD_Labels::getLocalized('address');

        $address = array();
        $address[] = CMProductDirectory::meta($post->ID, 'cmpd_address', '');
        $address[] = CMProductDirectory::meta($post->ID, 'cmpd_cityTown', '');
        $address[] = CMProductDirectory::meta($post->ID, 'cmpd_stateCounty', '');
        $address[] = CMProductDirectory::meta($post->ID, 'cmpd_postalcode', '');
        $address[] = CMProductDirectory::meta($post->ID, 'cmpd_region', '');
        $address[] = CMProductDirectory::meta($post->ID, 'cmpd_country', '');

        $display_this = CMProductDirectory::meta($post->ID, 'cmpd_add_address_field');
        $display_global = CMPD_Settings::getOption(CMPD_Settings::OPTION_PRODUCT_DEFAULT_ADDRESS);

        if ($display_this && $display_global) {
            if (!empty($address)) {
                $output .= '<li><ul class="cmpd-box-taxonomy"><span class="dashicons dashicons-admin-home cmpd_dashicons"></span>' . esc_html($label) . '</li>';
                foreach ($address as $addr) {
                    $output .=!empty($addr) ? '<li>' . esc_html($addr) . '</li>' : '';
                }
                $output .= '</ul></li>';
            }
        }
        return apply_filters( 'cmpd_output_location', $output, $atts );
    }

    public static function outputLocationShortcode($atts) {
        $post = get_post();
        if (empty($post)) {
            return;
        }

        $address = CMProductDirectory::meta($post->ID, 'cmpd_add_address_field');
        if (empty($address)) {
            return;
        }

        $output = '<ul class="list-unstyled">';

        $address = CMProductDirectory::meta($post->ID, 'cmpd_address');
        $output .=empty($address) ? '' : '<li>' . esc_html($address) . '</li>';
        $cityTown = CMProductDirectory::meta($post->ID, 'cmpd_cityTown');
        $output .= empty($cityTown) ? '' : '<li>' . esc_html($cityTown) . '</li>';
        $country = CMProductDirectory::meta($post->ID, 'cmpd_country');
        $output .= empty($country) ? '' : '<li>' . esc_html($country) . '</li>';
        $output .= '</ul>';

        return apply_filters( 'cmpd_output_location_shortcode', $output, $atts );
    }

    public static function buildAddress() {
        $post = get_post();
        $location = '';

        $virtual_address = CMProductDirectory::meta($post->ID, 'cmpd_virtual_address');
        if ($virtual_address) {
            return $location;
        }

        $address = CMProductDirectory::meta($post->ID, 'cmpd_address');
        $address = empty($address) ? '' : ' ' . esc_html($address);
        $cityTown = CMProductDirectory::meta($post->ID, 'cmpd_cityTown');
        $cityTown = empty($cityTown) ? '' : ' ' . esc_html($cityTown);
        $stateCounty = CMProductDirectory::meta($post->ID, 'cmpd_stateCounty');
        $stateCounty = empty($stateCounty) ? '' : ' ,' . esc_html($stateCounty);
        $postalcode = CMProductDirectory::meta($post->ID, 'cmpd_postalcode');
        $postalcode = empty($postalcode) ? '' : ' ' . esc_html($postalcode);
        $region = CMProductDirectory::meta($post->ID, 'cmpd_region');
        $region = empty($region) ? '' : ' ' . esc_html($region);
        $country = CMProductDirectory::meta($post->ID, 'cmpd_country');
        $country = empty($country) ? '' : ' ' . esc_html($country);

        $location = $address . $cityTown . $stateCounty . $postalcode . $region . $country;
        return $location;
    }

    public static function buildSmallAddress() {
        $post = get_post();
        $location = '';
        $address = CMProductDirectory::meta($post->ID, 'cmpd_address');
        $address = empty($address) ? '' : ' ' . esc_html($address);
        $cityTown = CMProductDirectory::meta($post->ID, 'cmpd_cityTown');
        $cityTown = empty($cityTown) ? '' : ' ' . esc_html($cityTown);
        $postalcode = CMProductDirectory::meta($post->ID, 'cmpd_postalcode');
        $postalcode = empty($postalcode) ? '' : ' ' . esc_html($postalcode);
        $country = CMProductDirectory::meta($post->ID, 'cmpd_country');
        $country = empty($country) ? '' : ' ' . esc_html($country);
        $location = $address . $cityTown . $postalcode . $country;
        return $location;
    }

    public static function outputWebUrl($atts) {
        $output = '';
        $post = get_post();

        if (empty($post)) {
            return;
        }
        $web_url = CMPD_Labels::getLocalized('web_url');
        $meta = CMProductDirectory::meta($post->ID, 'cmpd_web_url');
        if (!empty($meta)) {
            $output .= '<li><span class="dashicons dashicons-admin-site cmpd_dashicons"></span><a class="cmpd-info-box-link" href="' . esc_attr($meta) . '" target="_blank" rel="nofollow"><i class="fa fa-sbusinessap"></i>' . CMProductDirectory::__($web_url) . '</a></li>';
        }
        return apply_filters( 'cmpd_output_web_url', $output, $atts );
    }

    public static function outputEmail($atts) {
        $output = '';
        $post = get_post();

        if (empty($post)) {
            return;
        }

        $emailLabel = CMPD_Labels::getLocalized('bemail');
        $emailValue = CMProductDirectory::meta($post->ID, 'cmpd_bemail');
        if (!empty($emailValue)) {
            if (strpos($emailValue, '@') !== false) {
                $mailto = 'mailto:';
                $showEmail = CMPD_Settings::getOption(CMPD_Settings::OPTION_PRODUCT_PAGE_SHOW_EMAIL);
                $displayEmail = !empty($showEmail) ? ' ' . $emailValue : '';
            } else {
                $displayEmail = '';
                $mailto = '';
            }

            $output .= '<li><span class="dashicons dashicons-email-alt cmpd_dashicons"></span><a class="cmpd-info-box-link" href="' . esc_attr($mailto . $emailValue) . '" target="_blank" rel="nofollow"><i class="fa fa-sbusinessap"></i>' . esc_html(CMProductDirectory::__($emailLabel) . $displayEmail) . '</a></li>';
        }
        return apply_filters( 'cmpd_output_email', $output, $atts );
    }

    public static function outputFacebook($atts) {
        $output = '';
        $post = get_post();

        if (empty($post)) {
            return;
        }

        $facebook_name = CMPD_Labels::getLocalized('facebook_name');
        $meta = CMProductDirectory::meta($post->ID, 'cmpd_facebook_name');
        if (!empty($meta)) {
            $output .= '<li><span class="dashicons dashicons-facebook cmpd_dashicons"></span><a class="cmpd-info-box-link" href="' . esc_attr($meta) . '" target="_blank" rel="nofollow"><i class="fa fa-sbusinessap"></i>' . esc_html(CMProductDirectory::__($facebook_name)) . '</a></li>';
        }
        return apply_filters( 'cmpd_output_facebook', $output, $atts );
    }

    public static function outputTwitter($atts) {
        $output = '';
        $post = get_post();

        $display = CMPD_Settings::getOption(CMPD_Settings::OPTION_DISPLAY_TWITTER);
        if ($display) {
            require_once(CMPD_PLUGIN_DIR . '/shared/TwitterAPIExchange.php');
            if (empty($post)) {
                return;
            }
            $twitter_name = CMPD_Labels::getLocalized('twitter_name');
            $meta = CMProductDirectory::meta($post->ID, 'cmpd_twitter_name');

            if (!empty($meta)) {
                $tcount = '';
                $tw_fallow = CMPD_Settings::getOption(CMPD_Settings::OPTION_PRODUCT_TWITTER_FALLOWERS);

                if (!empty($tw_fallow) && filter_var($meta, FILTER_VALIDATE_URL)) {
                    try {
                        $tmp_array = explode('/', $meta);
                        $user = array_pop($tmp_array);
                        $tcount = cmpd_twitter_count($user);
                        if ($tcount) {
                            $tcount = ' (' . $tcount . ')';
                        }
                    } catch (Exception $e) {
                        // code...
                    }
                }

                $output .= '<li><span class="dashicons dashicons-twitter cmpd_dashicons"></span><a class="cmpd-info-box-link" href="' . esc_attr($meta) . '" target="_blank" rel="nofollow">' . esc_html(CMProductDirectory::__($twitter_name)) . $tcount . '</a></li>';
            }
        }
        return apply_filters( 'cmpd_output_twitter', $output, $atts );
    }

    public static function outputAlexa($atts) {
        $output = '';
        $post = get_post();
        if (empty($post)) {
            return;
        }
        $tcount = '';
        $alexaName = CMPD_Labels::getLocalized('alexa_name');
        $showAlexa = CMPD_Settings::getOption(CMPD_Settings::OPTION_PRODUCT_ALEXA_RANK);
        $url = CMProductDirectory::meta($post->ID, 'cmpd_web_url');
        if (!empty($showAlexa) && filter_var($url, FILTER_VALIDATE_URL)) {
            try {
                $url = str_replace(array('http://', 'https://'), array('', ''), $url);
                $source = file_get_contents('http://data.alexa.com/data?cli=10&dat=snbamz&url=' . $url);

				$matches = array();
                // Alexa Rank
                preg_match('/\<popularity url\="(.*?)" text\="([0-9]+)" source\="panel"\/\>/si', $source, $matches);
                $tcount = !empty($matches[2]) ? $matches[2] : 0;
                $alexaUrl = 'http://www.alexa.com/siteinfo/' . rawurlencode($url);
                $output .= '<li><span class="dashicons dashicons-admin-site cmpd_dashicons"></span><a class="cmpd-info-box-link" href="' . esc_attr($alexaUrl) . '" target="_blank" rel="nofollow"><i class="fa fa-sbusinessap"></i>' . esc_html(CMProductDirectory::__($alexaName)) . $tcount . '</a></li>';
            } catch (Exception $e) {
                // code...
            }
        }
        return apply_filters( 'cmpd_output_alexa', $output, $atts );
    }

    public static function outputGooglePlus($atts) {
        $output = '';
        $post = get_post();

        if (empty($post)) {
            return;
        }
        $google = CMPD_Labels::getLocalized('google');
        $meta = CMProductDirectory::meta($post->ID, 'cmpd_google');
        if (!empty($meta)) {
            $output .= '<li><span class="dashicons dashicons-googleplus cmpd_dashicons"></span><a class="cmpd-info-box-link" href="' . esc_attr($meta) . '" target="_blank" rel="nofollow"><i class="fa fa-sbusinessap"></i>' . esc_html(CMProductDirectory::__($google)) . '</a></li>';
        }
        return apply_filters( 'cmpd_output_google_plus', $output, $atts );
    }

    public static function outputLinkedIn($atts) {
        $output = '';
        $post = get_post();

        if (empty($post)) {
            return;
        }
        $linkedin = CMPD_Labels::getLocalized('linkedin');
        $meta = CMProductDirectory::meta($post->ID, 'cmpd_linkedin');
        if (!empty($meta)) {
            $output .= '<li><span class="dashicons dashicons-id cmpd_dashicons"></span><a class="cmpd-info-box-link" href="' . esc_attr($meta) . '" target="_blank" rel="nofollow"><i class="fa fa-sbusinessap"></i>' . esc_html(CMProductDirectory::__($linkedin)) . '</a></li>';
        }
        return apply_filters( 'cmpd_output_linkedin', $output, $atts );
    }

    public static function outputRSS($atts = array()) {
        $output = '';
        $post = get_post();

        if (empty($post)) {
            return;
        }
        $rss = CMPD_Labels::getLocalized('rss');
        $meta = CMProductDirectory::meta($post->ID, 'cmpd_rss_name');
        if (!empty($meta)) {
            $output .= '<li><span class="dashicons dashicons-rss cmpd_dashicons"></span><a class="cmpd-info-box-link" href="' . esc_attr($meta) . '" target="_blank" rel="nofollow"><i class="fa fa-sbusinessap"></i>' . esc_html(CMProductDirectory::__($rss)) . '</a></li>';
        }
        return apply_filters( 'cmpd_output_rss', $output, $atts );
    }

    public static function outputAddLinks($atts = array()) {
        $output = '';
        $post = get_post();
        $add_links = CMPD_Settings::getOption(CMPD_Settings::OPTION_ADD_LINKS);

        if (empty($add_links)) {
            return;
        }

        if (empty($post)) {
            return;
        }

        // icons
        $additionalLink[1]['icon'] = CMPD_Settings::getOption(CMPD_Settings::OPTION_ADD_LINKS_ICO1);
        $additionalLink[2]['icon'] = CMPD_Settings::getOption(CMPD_Settings::OPTION_ADD_LINKS_ICO2);
        $additionalLink[3]['icon'] = CMPD_Settings::getOption(CMPD_Settings::OPTION_ADD_LINKS_ICO3);
        $additionalLink[4]['icon'] = CMPD_Settings::getOption(CMPD_Settings::OPTION_ADD_LINKS_ICO4);

        // links
        $additionalLink[1]['link'] = CMProductDirectory::meta($post->ID, 'cmpd_add_link1');
        $additionalLink[2]['link'] = CMProductDirectory::meta($post->ID, 'cmpd_add_link2');
        $additionalLink[3]['link'] = CMProductDirectory::meta($post->ID, 'cmpd_add_link3');
        $additionalLink[4]['link'] = CMProductDirectory::meta($post->ID, 'cmpd_add_link4');

        // label
        $add_link1 = CMPD_Settings::getOption(CMPD_Settings::OPTION_ADD_LINKS_LABEL1);
        $add_link1 = empty($add_link1) ? '' : $add_link1;
        $additionalLink[1]['label'] = __($add_link1, CMPD_SLUG_NAME);
        $add_link2 = CMPD_Settings::getOption(CMPD_Settings::OPTION_ADD_LINKS_LABEL2);
        $add_link2 = empty($add_link2) ? '' : $add_link2;
        $additionalLink[2]['label'] = __($add_link2, CMPD_SLUG_NAME);
        $add_link3 = CMPD_Settings::getOption(CMPD_Settings::OPTION_ADD_LINKS_LABEL3);
        $add_link3 = empty($add_link3) ? '' : $add_link3;
        $additionalLink[3]['label'] = __($add_link3, CMPD_SLUG_NAME);
        $add_link4 = CMPD_Settings::getOption(CMPD_Settings::OPTION_ADD_LINKS_LABEL4);
        $add_link4 = empty($add_link4) ? '' : $add_link4;
        $additionalLink[4]['label'] = __($add_link4, CMPD_SLUG_NAME);


        // if any link is enabled
        if (!empty($add_link1) || !empty($add_link2) || !empty($add_link3) || !empty($add_link4)) {
            // $output .= '<ul class="list-unstyled cmpd-additionallinks">';
            foreach ($additionalLink as $link) {
                if (!empty($link['label']) && !empty($link['link'])) {
                    $icon = !empty($link['icon']) ? '<img class="cmpd_add_link_ico" src="' . esc_attr($link['icon']) . '" />' : '<span class="dashicons dashicons-admin-links"></span> ';
                    $output .= '<li>' . $icon . '<a href="' . esc_attr($link['link']) . '" class="cmpd-info-box-link" target="_blank" rel="nofollow">' . esc_html($link['label']) . '</a></li>';
                }
            }
        }

        return apply_filters( 'cmpd_output_add_links', $output, $atts );
    }

    public static function outputAddFields($atts = array()) {
        $atts = shortcode_atts(array('position' => NULL), $atts);
        $output = '';
        $label = CMPD_Settings::getOption(CMPD_Settings::OPTION_ADD_FIELDS);

        if (empty($label)) {
            return;
        }
        if (empty($atts['position']) || !in_array($atts['position'], array('info_box', 'below_content'))) {
            return;
        }

        $post = get_post();
        if (empty($post)) {
            return;
        }

        $fieldsToOutput = array();
        $not_empty = 0;
        for ($index = 1; $index < 5; $index++) {
            $label = CMPD_Settings::getOption(CMPD_Settings::OPTION_ADD_FIELDS_LABEL_BASE . $index);
            if (!empty($label)) {
                $position = CMPD_Settings::getOption(CMPD_Settings::OPTION_ADD_FIELDS_POS_BASE . $index);
                if (!empty($position) && $position == $atts['position']) {
                    $metakey = 'cmpd_add_field' . $index;
                    $value = CMProductDirectory::meta($post->ID, $metakey);
                    $icon = CMPD_Settings::getOption(CMPD_Settings::OPTION_ADD_FIELDS_ICO_BASE . $index);

                    $fieldsToOutput[] = array(
                        'label' => $label,
                        'value' => $value,
                        'icon' => $icon,
                    );

                    if (!empty($value)) {
                        $not_empty++;
                    }
                }
            }
        }

        if ($not_empty > 0) {
            $output .= '<ul class="list-unstyled">';
            foreach ($fieldsToOutput as $value) {
                if (!empty($value['value'])) {
                    $additionalClass = 'cmpd_' . sanitize_title($value['label']) . '_field';
                    $output .= '<li class="cmpd_add_field_container ' . esc_attr($additionalClass) . '">';
                    if (!empty($value['icon'])) {
                        $output .= '<img class="cmpd_add_link_ico" src="' . esc_attr($value['icon']) . '" >';
                    }
                    $output .= '<i class="fa fa-sbusinessap"></i><b>' . esc_html($value['label']) . '</b>';
                    $output .= '<div class="cmpd_add_field_content">';
                    $output .= esc_html($value['value']);
                    $output .= '</div>';
                    $output .= '</li>';
                }
            }
            $output .= '</ul>';
        }

        return apply_filters( 'cmpd_output_add_fields', $output, $atts );
    }

    public static function outputPhone($atts) {
        $output = '';
        $post = get_post();

        if (empty($post)) {
            return;
        }
        $phone = CMPD_Labels::getLocalized('phone');
        $meta = CMProductDirectory::meta($post->ID, 'cmpd_phone');
        if (!empty($meta)) {
            $output .= '<li><span class="dashicons dashicons-phone cmpd_dashicons"></span><i class="fa fa-sbusinessap"></i><div class="cmpd-info-box-phone" >' . esc_html(CMProductDirectory::__($phone) . ' ' . $meta) . '<div></li>';
        }
        return apply_filters( 'cmpd_output_phone', $output, $atts );
    }

    public static function outputGoogleMap($atts) {
        global $post;
        $output = '';

        $virtual_address = CMProductDirectory::meta($post->ID, 'cmpd_virtual_address');

        $post = get_post();
        $tag = !empty($atts['tag']) ? $atts['tag'] : 'div';
        $class = !empty($atts['class']) ? $atts['class'] : 'cmpd-add-google-map-label';
        $meta = CMProductDirectory::meta($post->ID, 'cmpd_add_google_map');
        $title = $post->post_title;
        $location = self::buildSmallAddress();

        $map_ad = '';
        $outputAds = CMPD_Settings::getOption(CMPD_Settings::OPTION_PRODUCT_ADVERT_DISPLAY);
        if ($outputAds) {
            $map_ad = CMPD_Settings::getOption(CMPD_Settings::OPTION_PRODUCT_ADVERRT2);
            $map_ad = stripslashes($map_ad);
            $map_ad = do_shortcode($map_ad);
        }

        $display_this = $meta;
        $display_global = CMPD_Settings::getOption(CMPD_Settings::OPTION_PRODUCT_DEFAULT_MAP);

        if ($display_this && $display_global) {
            // No map
            if (empty($post) || empty($location) || $meta == 0 || $virtual_address) {
                if (empty($map_ad)) {
                    return;
                }
            } else {
                // Show map
                $translation_array = array(
                    'address' => $location,
                    'title' => $title
                );

                wp_enqueue_script('cmpd-functions');
                wp_localize_script('cmpd-functions', 'cmpd_map_settings', $translation_array);
                $output .= '<div class="product-widget cmpd_google_map" id="cmpd-map-canvas"></div>';
            }
        }

        if (!empty($map_ad)) {
            $output.= '<div class="cmbbd_uner_map">' . $map_ad . '</div>';
        }
        return apply_filters( 'cmpd_output_googla_map', $output, $atts );
    }

    public static function outputPostTitle($atts = array()) {
        $output = '';
        $post = get_post();
        $tag = !empty($atts['tag']) ? $atts['tag'] : 'div';
        $class = !empty($atts['class']) ? $atts['class'] : 'cmpd-title';
        $product_name = CMPD_Labels::getLocalized('product_name');
        if (!empty($post)) {
            $output = '<' . esc_attr($tag) . ' ' . ($class ? 'class="' . esc_attr($class) . '"' : '') . '>' . esc_html(CMProductDirectory::__($product_name) . ' ' . $post->post_title) . '</' . esc_attr($tag) . '>';
            if (!empty($atts['add_link'])) {
                $permalink = get_permalink($post->ID);
                $output = '<a href="' . esc_attr($permalink) . '" alt="' . esc_attr($post->post_title) . '" title="' . esc_attr($post->post_title) . '" target="_blank">' . $output . '</a>';
            }
        }
        return apply_filters( 'cmpd_output_post_title', $output, $atts );
    }

    public static function outputCompanyName($atts) {
        $output = '';
        $post = get_post();
        if (empty($post)) {
            return;
        }
        $meta = CMPD_Labels::getLocalized('company_name');
        $company_name = CMProductDirectory::meta($post->ID, 'cmpd_company_name');
        $isAssigned = get_post_meta( $post->ID, 'cmpd_assign_business', true );
        $isImported = get_post_meta( $post->ID, 'cmpd_imported_from', true );

        if (!empty($company_name)) {
            $company_name = $isAssigned ? '<a href="'.get_post_permalink( $isAssigned ).'">'.$company_name.'</a>' : $company_name ;
            $company_name = $isImported ? '<a href="'.get_post_permalink( $isImported ).'">'.$company_name.'</a>' : $company_name ;
            $output .= '<li><span class="dashicons dashicons-nametag cmpd_dashicons"></span>' . esc_html($meta) . ' ' . $company_name . '</li>';
        }
        return apply_filters( 'cmpd_output_company_name', $output, $atts );
    }

    public static function output_product_cost($atts) {
        $output = '';
        $post = get_post();
        if (empty($post)) {
            return;
        }
        $meta = CMPD_Labels::getLocalized('product_cost');
        $product_cost = CMProductDirectory::meta($post->ID, 'cmpd_product_cost');
        if (!empty($product_cost)) {
            $output .= '<li><span class="dashicons dashicons-cart cmpd_dashicons"></span>' . esc_html($meta) . ': <b>' . esc_html($product_cost) . '</b></li>';
        }
        return apply_filters( 'cmpd_output_product_cost', $output, $atts );
    }

    public static function output_purchase_link($atts) {
        $output = '';
        $post = get_post();
        if (empty($post)) {
            return;
        }
        $meta = CMProductDirectory::meta($post->ID, 'cmpd_purchase_link');
        $key = wp_create_nonce( 'key' . $post->ID );
        if (!empty($meta)) {
            $output .= '<li><a class="cmpd_purchase_link" data-cmpdid="' . $post->ID . '" data-cmpdkey="' . $key . '" href="' . esc_attr($meta) . '" target="_blank" rel="nofollow"><span class="dashicons dashicons-cart cmpd_dashicons"></span>'.esc_html(CMPD_Labels::getLocalized('purchase_link')).'</a></li>';
        }
        return apply_filters( 'cmpd_output_purchase_link', $output, $atts );
    }

    public static function output_demo_link($atts) {
        $output = '';
        $post = get_post();

        if (empty($post)) {
            return;
        }
        $demo_link = CMPD_Labels::getLocalized('demo_link');
        $meta = CMProductDirectory::meta($post->ID, 'cmpd_demo_link');
        if (!empty($meta)) {
            $output .= '<li><span class="dashicons dashicons-visibility cmpd_dashicons"></span><a class="cmpd-info-box-link" href="' . esc_attr($meta) . '" target="_blank" rel="nofollow"><i class="fa fa-sbusinessap"></i>' . CMProductDirectory::__($demo_link) . '</a></li>';
        }
        return apply_filters( 'cmpd_output_demo_link', $output, $atts );
    }

    public static function output_product_page($atts) {
        $output = '';
        $post = get_post();

        if (empty($post)) {
            return;
        }
        $product_page = CMPD_Labels::getLocalized('product_page');
        $meta = CMProductDirectory::meta($post->ID, 'cmpd_product_page');
        if (!empty($meta)) {
            $output .= '<li><span class="dashicons dashicons-admin-site cmpd_dashicons"></span><a class="cmpd-info-box-link" href="' . esc_attr($meta) . '" target="_blank" rel="nofollow"><i class="fa fa-sbusinessap"></i>' . CMProductDirectory::__($product_page) . '</a></li>';
        }
        return apply_filters( 'cmpd_output_product_page', $output, $atts );
    }

    public static function output_product_gallery($atts) {
        $output = '';
        $post = get_post();
        if (empty($post)) {
            return;
        }

        $attachment_ids = CMProductDirectory::meta($post->ID, 'cmpd_product_gallery');

        if (!empty($attachment_ids)) {
            $attachment_ids = explode(',', $attachment_ids);
            $output .= '<div class="cmpd_lightbox_gallery_container">';
            foreach ($attachment_ids as $item) {
                $output .= '<a href="' . wp_get_attachment_url($item, 'large') . '" class="cmpd_lightbox_gallery nofancybox">' . wp_get_attachment_image($item, 'thumbnail') . '</a>';
            }
            $output .= '</div>';
        }
        return apply_filters( 'cmpd_output_product_gallery', $output, $atts );
    }

    public static function output_product_video($atts) {
        $output = '';
        $post = get_post();
        if (empty($post)) {
            return;
        }
        $display = CMPD_Settings::getOption(CMPD_Settings::OPTION_ACTIVATE_VIDEO_FIELD);
        if ($display) {
            $video = CMProductDirectory::meta($post->ID, 'cmpd_product_video');
            if (!empty($video)) {
                $output .= '<div class="cmpd_video">';
                if (strpos($video, 'youtube')) {
                    $output .= '<iframe width="100%" height="auto" src="' . esc_attr($video) . '" frameborder="0" allowfullscreen></iframe>';
                } elseif (strpos($video, 'vimeo')) {
                    $output .= '<iframe src="' . esc_attr($video) . '" width="100%" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>';
                }
                $output .= '</div>';
            }
        }
        return apply_filters( 'cmpd_output_product_video', $output, $atts );
    }

    public static function outputPostContent($atts) {
        $output = '';
        $post = get_post();
        $tag = !empty($atts['tag']) ? $atts['tag'] : 'div';
        $class = !empty($atts['class']) ? $atts['class'] : 'cmpd-description';

        if (!empty($post->post_content)) {
            $output = '<' . esc_attr($tag) . ' ' . ($class ? 'class="' . esc_attr($class) . '"' : '') . '>' . do_shortcode(wpautop($post->post_content)) . '</' . esc_attr($tag) . '>';
        }

        return apply_filters( 'cmpd_output_post_content', $output, $atts );
    }

    public static function outputFeaturedImage($atts) {
        $output = '';
        $post = get_post();
        $tag = !empty($atts['tag']) ? $atts['tag'] : 'div';
        $class = !empty($atts['class']) ? $atts['class'] : 'cmpd-image';

        if (!empty($post)) {
            $output = '<' . esc_attr($tag) . ' ' . ($class ? 'class="' . esc_attr($class) . '"' : '') . '>' . CMProductDirectoryFrontend::outputImage($post, array()) . '</' . esc_attr($tag) . '>';
        }
        return apply_filters( 'cmpd_output_featured_image', $output, $atts );
    }

    public static function outputBackLink($atts = array()) {
        $showBackLink = CMPD_Settings::getOption(CMPD_Settings::OPTION_PRODUCT_PAGE_SHOW_BACKLINK);
        $output = '';
        if ($showBackLink) {
            $shortcodePageId = get_option(CMProductDirectory::SHORTCODE_PAGE_OPTION);
            $shortcodePageLink = get_page_link($shortcodePageId);
            if (!empty($shortcodePageId) && !empty($shortcodePageLink)) {
                $output .= '<a class="cmpd-backlink-wrapper" href="' . esc_attr($shortcodePageLink) . '">&laquo;&nbsp;' . CMPD_Labels::getLabel('product_page_backlink_label') . '</a>';
            }
        }
        return apply_filters( 'cmpd_output_back_to_index_link', $output, $atts );
    }

    public static function outputGallery($atts = array()) {
        include_once CMPD_PLUGIN_DIR . '/backend/cm-product-directory-backend.php';
        $post = get_post();

        $images = CMProductDirectoryProductPage::getProductGallery($post->ID);
        $output = '<div id="product_images_container"><ul class="product_images">';
        if (!empty($images)) {
            foreach ($images as $image) {
                if (!empty($image['cmpd_image'][0])) {
                    $output .= '<li>';
                    $output .= '<a href="' . esc_attr($image['cmpd_image'][0]) . '" class="thickbox" rel="gallery"><img src="' . esc_attr($image['thumb'][0]) . '" /></a>';
                    $output .= '</li>';
                }
            }
        }
        $output .= '</ul></div>';
        return apply_filters( 'cmpd_output_gallery', $output, $atts );
    }

    public static function outputLogo($atts) {
        $output = '';
        $post = get_post();
        $display = CMPD_Settings::getOption(CMPD_Settings::OPTION_DISPLAY_LOGO);
        if ($display) {
            $output .= '<div class="cmpd_logo_container">';
            $thumbnail_id = CMProductDirectory::meta($post->ID, 'cmpd_product_gallery_id');
            if (!empty($thumbnail_id)) {
                $output .= wp_get_attachment_image($thumbnail_id, 'cmpd_image_big');
            } else {
                $output .= '<img width="500" src="' . CMPD_PLUGIN_URL . 'frontend/assets/img/default-product-500-500.png" class="attachment-cmpd_image size-cmpd_image" alt="' . esc_attr($post->post_title) . '" sizes="(max-width: 500px) 100vw, 500px" />';
            }
            $output .= '</div>';
            return apply_filters( 'cmpd_output_logo', $output, $atts );
        }
    }

    public static function outputGallerySlider($atts) {
        include_once CMPD_PLUGIN_DIR . '/backend/cm-product-directory-backend.php';
        $post = get_post();
        $output = '';
        $output_slider = '';

        $displayLogo = CMPD_Settings::getOption(CMPD_Settings::OPTION_DISPLAY_LOGO);
        if ($displayLogo) {
            $images = CMProductDirectoryProductPage::getProductGallery($post->ID);

            if (!empty($images)) {
                $output_slider = '';
                foreach ($images as $image) {
                    if (!empty($image['cmpd_image'][0])) {
                        $output_slider .= '<div class="cmpd_product_image"> <img class="img-responsive" src="' . esc_attr($image['cmpd_image'][0]) . '" /></div>';
                    }
                }
            } else {
                $default_image = CMPD_Settings::getOption(CMPD_Settings::OPTION_PRODUCT_DEFAULT_IMAGE);
                $default_image = empty($default_image) ? CMPD_PLUGIN_URL . 'frontend/assets/img/default-product-500-500.png' : $default_image;
                $output_slider .= '<img class="img-responsive" src="' . esc_attr($default_image) . '" />';
            }

            if (!empty($atts['add_link'])) {
                $permalink = get_permalink($post->ID);
                $output = '<a href="' . esc_attr($permalink) . '" alt="' . esc_attr($post->post_title) . '" title="' . esc_attr($post->post_title) . '" target="_blank">' . $output_slider . '</a>';
            } else {
                $output = $output_slider;
            }
        }
        return apply_filters( 'cmpd_output_gallery_slider', $output, $atts );
    }

    public static function outputRelatedProduct($atts = array()) {
        $output = '';
        $outputAds = CMPD_Settings::getOption(CMPD_Settings::OPTION_PRODUCT_ADVERT_DISPLAY);
        if ($outputAds) {
            $logo_ad_top = CMPD_Settings::getOption(CMPD_Settings::OPTION_PRODUCT_ADVERRT3);
            $logo_ad_top = stripslashes($logo_ad_top);
            $logo_ad_top = do_shortcode($logo_ad_top);

            if (!empty($logo_ad_top)) {
                $output.= '<div class="cmpd_over_related" >' . $logo_ad_top . '</div>';
            }
        }

        $showRelated = CMPD_Settings::getOption(CMPD_Settings::OPTION_RELATEDPRODUCT_SHOWBUTTON);
        if (!empty($showRelated)) {
            $product = CMProductDirectoryProductPage::getRelatedProduct();
            if (!empty($product)) {
                $page_template = CMPD_Settings::getOption( CMPD_Settings::OPTION_PRODUCT_PAGE_TEMPLATE );
                $product_page_you_may_also_like = CMPD_Labels::getLabel('product_page_you_may_also_like');
                $output .= '<div class="cmpd_related_products">';
                $default_image = CMPD_Settings::getOption(CMPD_Settings::OPTION_PRODUCT_DEFAULT_IMAGE);
                $default_image = empty($default_image) ? CMPD_PLUGIN_URL . 'frontend/assets/img/default-product-500-500.png' : $default_image;
                if ( $page_template == 'cm_new' ) {
                    $output .= '<h3 class="related_product" >' . CMProductDirectory::__($product_page_you_may_also_like) . '</h3>';
                    $output .= '<div class="cmpd_related_products_list">';
                } else {
                    $output .= '<h3 class="related_product" ><strong>' . CMProductDirectory::__($product_page_you_may_also_like) . '</strong></h3>';
                }
                foreach ($product as $product) {
                    if (!empty($product['images'])) {
                        $img = $product['images'][0]['thumb'][0];
                    } else {
                        $img = $default_image;
                    }
                    $pitch = empty($product['pitch']) ? ' ' : $product['pitch'];
                    if ( $page_template == 'cm_new' ) {
                        $output .= '<div><div class="product-related">' .
                            (!empty($img) ? '<a href="' . esc_attr(get_permalink($product['id'])) . '"><img class="cmpd_related_product_image" title="' . esc_attr($pitch) . '" alt="' . esc_attr($product['name']) . '" src="' . esc_attr($img) . '"></a>' : '') .
                            '<h4 class="connected-title text-center"><a href="' . esc_attr(get_permalink($product['id'])) . '">' . esc_html($product['name']) . '</a></h4>' .
                            '</div></div>';
                    } else {
                    $output .= '<article class="product-related" >
                <a href="' . esc_attr(get_permalink($product['id'])) . '">' .
                            (!empty($img) ? '<img class="cmpd_related_product_image" title="' . esc_attr($pitch) . '" alt="' . esc_attr($product['name']) . '" src="' . esc_attr($img) . '">' : '') .
                            '<h4 class="connected-title text-center">' .
                            esc_html($product['name']) .
                            '</h4>' .
                            '</a>' .
                            '</article>';
                    }
                }
                if ( $page_template == 'cm_new' ) {
                    $output .= '</div>';
                }
            }
        }

        if ($outputAds) {
            $logo_ad_bottom = CMPD_Settings::getOption(CMPD_Settings::OPTION_PRODUCT_ADVERRT1);
            $logo_ad_bottom = stripslashes($logo_ad_bottom);
            $logo_ad_bottom = do_shortcode($logo_ad_bottom);

            if (!empty($logo_ad_bottom)) {
                $output.= '<div class="cmpd_under_related" >' . $logo_ad_bottom . '</div>';
            }
        }
        $output .= '</div>';
        return apply_filters( 'cmpd_output_related_product', $output, $atts );
    }

    public static function outputAdditions($atts = array()) {
        $output = '';
        $post = get_post();
        if (!empty($post)) {
            $output = apply_filters('cmpd_additions', $output, $post->ID);
        }
        return apply_filters( 'cmpd_output_additions', $output, $atts );
    }

    public static function output_dates($atts = array()) {
        $dates = '';
        $output = '';
        $display_create = get_option('cmpd_product_page_publish_date');
        $display_update = get_option('cmpd_product_page_update_date');

        if ($display_create) {
            $label = CMPD_Labels::getLabel('product_publish_date');
            $date = get_the_time() . ', ' . get_the_date();
            $dates .= '<li><b>' . esc_html($label) . '</b> ' . esc_html($date) . '</li>';
        }

        if ($display_update) {
            $label = CMPD_Labels::getLabel('product_update_date');
            $date = get_the_modified_time() . ', ' . get_the_modified_date();
            $dates .= '<li><b>' . esc_html($label) . '</b> ' . esc_html($date) . '</li>';
        }

        if (!empty($dates)) {
            $output = '<ul class="list-unstyled" style="margin-top:1em;">' . $dates . '</ul>';
        }

        return apply_filters( 'cmpd_output_display_dates', $output, $atts );
    }
}
