<?php

class CMPD_Settings {

    const TYPE_BOOL                        = 'bool';
    const TYPE_INT                         = 'int';
    const TYPE_STRING                      = 'string';
    const TYPE_COLOR                       = 'color';
    const TYPE_TEXTAREA                    = 'textarea';
    const TYPE_RADIO                       = 'radio';
    const TYPE_SELECT                      = 'select';
    const TYPE_MULTISELECT                 = 'multiselect';
    const TYPE_CSV_LINE                    = 'csv_line';
    const TYPE_FILEUPLOAD                  = 'fileupload';
    const TYPE_HIDDEN                      = 'hidden';
    const TYPE_LINK                        = 'link';
    const SETTINGS_PREFIX                  = 'cmpd';
    /*
     * OPTIONS
     */
    const OPTION_ADD_METADESCRIPTION       = 'cmpd_add_metadescription';
    const OPTION_SHOW_COMMENTS             = 'cmpd_show_comments';
    const OPTION_PRODUCT_VIEW              = 'cmpd_product_view';
    const OPTION_PRODUCT_PRODUCT_ON_PAGE   = 'cmpd_product_product_on_page';
    const OPTION_PRODUCT_SHOWSEARCH        = 'cmpd_product_showsearch';
    // const OPTION_PRODUCT_							= 'cmpd_product_showfilter';
    // const OPTION_PRODUCT_SHOWFILTER_TAGS				= 'cmpd_product_showfilter_tags';
    const OPTION_PRODUCT_SHOWDETAILS       = 'cmpd_product_showdetails';
    const OPTION_PRODUCT_SHOWEDITLINK      = 'cmpd_product_showeditlink';
    const OPTION_PRODUCT_PERMALINK         = 'cmpd_product_permalink';
    const OPTION_PRODUCT_STATISTICS_SINGLE = 'cmpd_product_statistics_single';
    const OPTION_PRODUCT_STATISTICS_ALL    = 'cmpd_product_all';
    const OPTION_PRODUCT_STATISTICS_CSV    = 'cmpd_statistic_csv';
    const OPTION_PRODUCT_IMAGE_WARNING     = 'cmpd_product_image_warning';
    const OPTION_PRODUCT_DEFAULT_COUNTRY   = 'cmpd_product_default_country';
    const OPTION_PRODUCT_DEFAULT_YEAR      = 'cmpd_product_default_year';
    const OPTION_PRODUCT_DEFAULT_MAP       = 'cmpd_product_default_map';
    const OPTION_PRODUCT_DEFAULT_ADDRESS   = 'cmpd_product_default_address';
    const OPTION_PRODUCT_DEFAULT_IMAGE     = 'cmpd_product_default_image';
    const OPTION_DISPLAY_TWITTER           = 'cmpd_option_display_twitter';
    const OPTION_PRODUCT_TWITTER_FALLOWERS = 'cmpd_product_twitter_fallowers';
    const OPTION_PRODUCT_ALEXA_RANK        = 'cmpd_product_alexa_rank';
    const GOOGLE_MAP_AUTH_KEY = 'cmpd_google_map_auth_key';
    const OPTION_PRODUCT_ORDERBY            = 'cmpd_product_orderby';
    const OPTION_PRODUCT_ORDER              = 'cmpd_product_order';
    const OPTION_BUTTONS_TARGET_BLANK       = 'cmpd_buttons_target_blank';
    const OPTION_BUTTONS_BUSINES_PITCH_IMG  = 'cmpd_buttons_product_pitch_img';
    const OPTION_PAGINATION_TOP             = 'cmpd_pagination_top';
    const OPTION_PAGINATION_BOTTOM          = 'cmpd_pagination_bottom';
    const OPTION_FOUND_PRODUCT              = 'cmpd_found_product';
    const OPTION_RELATEDPRODUCT_SHOWBUTTON  = 'cmpd_relatedproduct_button_show';
    const OPTION_RELATEDPRODUCT_CAT         = 'cmpd_relatedproduct_cat';
    const OPTION_RELATEDPRODUCT_NUMBER      = 'cmpd_relatedproduct_number';
    const OPTION_CATEGORY_SHOWBUTTON        = 'cmpd_category_button_show';
    const OPTION_TAGS_SHOWBUTTON            = 'cmpd_tags_button_show';
    const OPTION_INFO_WIDGET                = 'cmpd_info_widget';
    const OPTION_ADDRESS_WIDGET             = 'cmpd_address_widget';
    const OPTION_PRODUCT_CONTAINER          = 'cmpd_product_container';
    const OPTION_CATEGORY_SHOW_AS           = 'cmpd_category_show_as';
    const OPTION_POST_PER_PAGE_SHOW         = 'cmpd_post_per_page_show';
    // PRODUCT PAGE
    // PRODUCT PAGE DEFAULTS
    const OPTION_DISPLAY_LOGO               = 'cmpd_option_display_logo';
    const OPTION_DISPLAY_YEAR_FOUNDED       = 'cmpd_option_display_year_founded';
    const OPTION_PRODUCT_TILES_SHOW_CAT     = 'cmpd_product_tiles_show_cat';
    const OPTION_PRODUCT_HEIGHT_LIST        = 'cmpd_product_height_list';
    const OPTION_PRODUCT_SHOW_TAGS          = 'cmpd_product_show_tags';
    //CUSTOM CSS
    const OPTION_CUSTOM_CSS                 = 'cmpd_custom_css';
    // Templates
    const OPTION_PRODUCT_PAGE_TEMPLATE      = 'cmpd_product_page_template';
    const OPTION_PRODUCT_PAGE_PUBLISH_DATE  = 'cmpd_product_page_publish_date';
    const OPTION_PRODUCT_PAGE_UPDATE_DATE   = 'cmpd_product_page_update_date';
    const OPTION_PRODUCT_PAGE_SHOW_BACKLINK = 'cmpd_product_page_show_backlink';
    const OPTION_PRODUCT_PAGE_SHOW_EMAIL    = 'cmpd_product_page_show_email';
    const OPTION_PRODUCT_ADVERRT1           = 'cmpd_product_advert1';
    const OPTION_PRODUCT_ADVERRT2           = 'cmpd_product_advert2';
    const OPTION_PRODUCT_ADVERRT3           = 'cmpd_product_advert3';
    //Additional links
    const OPTION_ADD_LINKS                  = 'cmpd_add_links';
    const OPTION_ADD_LINKS_ICO1             = 'cmpd_add_links_ico1';
    const OPTION_ADD_LINKS_LABEL1           = 'cmpd_add_links_label1';
    const OPTION_ADD_LINKS_ICO2             = 'cmpd_add_links_ico2';
    const OPTION_ADD_LINKS_LABEL2           = 'cmpd_add_links_label2';
    const OPTION_ADD_LINKS_ICO3             = 'cmpd_add_links_ico3';
    const OPTION_ADD_LINKS_LABEL3           = 'cmpd_add_links_label3';
    const OPTION_ADD_LINKS_ICO4             = 'cmpd_add_links_ico4';
    const OPTION_ADD_LINKS_LABEL4           = 'cmpd_add_links_label4';
    //Additional fields
    const OPTION_ADD_FIELDS                 = 'cmpd_add_fields';
    const OPTION_ADD_FIELDS_ICO_BASE        = 'cmpd_add_fields_ico';
    const OPTION_ADD_FIELDS_LABEL_BASE      = 'cmpd_add_fields_label';
    const OPTION_ADD_FIELDS_POS_BASE        = 'cmpd_add_fields_pos';
    const OPTION_ADD_FIELDS_ICO1            = 'cmpd_add_fields_ico1';
    const OPTION_ADD_FIELDS_LABEL1          = 'cmpd_add_fields_label1';
    const OPTION_ADD_FIELDS_POS1            = 'cmpd_add_fields_pos1';
    const OPTION_ADD_FIELDS_ICO2            = 'cmpd_add_fields_ico2';
    const OPTION_ADD_FIELDS_LABEL2          = 'cmpd_add_fields_label2';
    const OPTION_ADD_FIELDS_POS2            = 'cmpd_add_fields_pos2';
    const OPTION_ADD_FIELDS_ICO3            = 'cmpd_add_fields_ico3';
    const OPTION_ADD_FIELDS_LABEL3          = 'cmpd_add_fields_label3';
    const OPTION_ADD_FIELDS_POS3            = 'cmpd_add_fields_pos3';
    const OPTION_ADD_FIELDS_ICO4            = 'cmpd_add_fields_ico4';
    const OPTION_ADD_FIELDS_LABEL4          = 'cmpd_add_fields_label4';
    const OPTION_ADD_FIELDS_POS4            = 'cmpd_add_fields_pos4';
    const TWITTER_CONSUMER_KEY              = 'cmpd_twitter_consumer_key';
    const TWITTER_CONSUMER_SECRET           = 'cmpd_twitter_consumer_secret';
    const TWITTER_OAUTH_ACCESS_TOKEN        = 'cmpd_oauth_access_token';
    const TWITTER_OAUTH_ACCESS_TOKEN_SECRET = 'cmpd_oauth_access_token_secret';
    // button color
    const OPTION_PURCHASE_BUTTON_COLOR        = 'cmpd_purchase_button_color';
    const OPTION_PURCHASE_BUTTON_HOVER_COLOR  = 'cmpd_purchase_button_hover_color';
    const OPTION_PRODUCT_BOX_TEXT_COLOR       = 'cmpd_product_box_text_color';
    const OPTION_PRODUCT_BOX_LINK_COLOR       = 'cmpd_product_box_link_color';
    const OPTION_PRODUCT_BOX_LINK_HOVER_COLOR = 'cmpd_product_box_link_hover_color';
    const OPTION_COMPANY_BOX_TEXT_COLOR       = 'cmpd_company_box_text_color';
    const OPTION_COMPANY_BOX_LINK_COLOR       = 'cmpd_company_box_link_color';
    const OPTION_COMPANY_BOX_LINK_HOVER_COLOR = 'cmpd_company_box_link_hover_color';
    const OPTION_ACTIVATE_VIDEO_FIELD         = 'cmpd_option_activate_video_field';
    const OPTION_PRODUCT_ADVERT_DISPLAY       = 'cmpd_product_advert_display';
    // Views
    // Tiles
    const CMPD_OPTION_APPEARANCE_TILES_COLUMNS      = 'cmpd_option_apperance_tiles_columns';
    const CMPD_OPTION_APPEARANCE_TILES_MARGINS      = 'cmpd_option_apperance_tiles_margins';
    const CMPD_OPTION_APPEARANCE_TILES_SHOW_TITLE   = 'cmpd_option_apperance_tiles_show_title';
    const CMPD_OPTION_APPEARANCE_TILES_IMG_HEIGHT   = 'cmpd_option_apperance_tiles_img_height';
    const CMPD_OPTION_APPEARANCE_TILES_BORDER       = 'cmpd_option_apperance_tiles_border';
    const CMPD_OPTION_APPEARANCE_TILES_SHOW_DETAILS = 'cmpd_option_apperance_tiles_show_details';
    // List
    const CMPD_OPTION_APPEARANCE_LIST_BOTTOMBORDER = 'cmpd_option_appearance_list_bottomborder';
    const CMPD_OPTION_APPEARANCE_LIST_RATING       = 'cmpd_option_appearance_list_rating';
    const CMPD_OPTION_APPEARANCE_LIST_PITCH        = 'cmpd_option_appearance_list_pitch';
    // Directory
    const CMPD_OPTION_APPEARANCE_DIRECTORY_DISPLAY_RATING      = 'cmpd_option_appearance_directory_display_rating';
    const CMPD_OPTION_APPEARANCE_DIRECTORY_DISPLAY_DESCRIPTION = 'cmpd_option_appearance_directory_display_description';
    const CMPD_OPTION_APPEARANCE_DIRECTORY_DISPLAY_CATEGORY    = 'cmpd_option_appearance_directory_display_category';
    // Global
    const OPTION_TAXONOMY_PRICINGMODEL            = 'cmpd_option_taxonomy_pricingmodel';
    const OPTION_TAXONOMY_LANUAGESUPPORT          = 'cmpd_option_taxonomy_languagesupport';
    const OPTION_TAXONOMY_TARGETAUDIENCE          = 'cmpd_option_taxonomy_targetaudience';
    // Product Directory
    const SHORTCODE_ATTR_TAXONOMY_CATEGORY        = 'cmpd_shortcode_attr_taxonomy_category';
    const SHORTCODE_ATTR_TAXONOMY_PRICINGMODEL    = 'cmpd_shortcode_attr_taxonomy_pricingmodel';
    const SHORTCODE_ATTR_TAXONOMY_LANGUAGESUPPORT = 'cmpd_shortcode_attr_taxonomy_languagesupport';
    const SHORTCODE_ATTR_TAXONOMY_TARGETAUDIENCE  = 'cmpd_shortcode_attr_taxonomy_targetaudience';
    const SHORTCODE_ATTR_TAXONOMY_TAG             = 'cmpd_shortcode_attr_taxonomy_tag';
    // Product Page
    const LIST_TAXONOMY_TERMS_CATEGORY            = 'cmpd_list_taxonomy_terms_category';
    const LIST_TAXONOMY_TERMS_PRICINGMODEL        = 'cmpd_list_taxonomy_terms_pricingmodel';
    const LIST_TAXONOMY_TERMS_LANGUAGESUPPORT     = 'cmpd_list_taxonomy_terms_languagesupport';
    const LIST_TAXONOMY_TERMS_TARGETAUDIENCE      = 'cmpd_list_taxonomy_terms_targetaudience';
    const LIST_TAXONOMY_TERMS_TAG                 = 'cmpd_list_taxonomy_terms_tag';
    // Shortcode List Categories
    const SHORTCODE_LIST_CATEGORY_TERMS_CATEGORY        = 'cmpd_shortcode_list_category_terms_category';
    const SHORTCODE_LIST_CATEGORY_TERMS_PRICINGMODEL    = 'cmpd_shortcode_list_category_terms_pricingmodel';
    const SHORTCODE_LIST_CATEGORY_TERMS_LANGUAGESUPPORT = 'cmpd_shortcode_list_category_terms_languagesupport';
    const SHORTCODE_LIST_CATEGORY_TERMS_TARGETAUDIENCE  = 'cmpd_shortcode_list_category_terms_targetaudience';
    const SHORTCODE_LIST_CATEGORY_TERMS_TAG             = 'cmpd_shortcode_list_category_terms_tag';
    const SHORTCODE_LIST_CATEGORY_TERMS_DEFAULT_ICON    = 'cmpd_shortcode_list_category_terms_default_icon';
// Search
    const OPTION_SHOW_WHEN_SEARCH                              = 'cmpd_show_when_search';
    const OPTION_SEARCH_IN_TAGS                                = 'cmpd_search_in_tags';

    /*
     * OPTIONS - END
     */
    const ACCESS_EVERYONE       = 0;
    const ACCESS_USERS          = 1;
    const ACCESS_ROLE           = 2;
    const EDIT_MODE_DISALLOWED  = 0;
    const EDIT_MODE_WITHIN_HOUR = 1;
    const EDIT_MODE_WITHIN_DAY  = 2;
    const EDIT_MODE_ANYTIME     = 3;

    public static $categories    = array(
        'general'       => 'General',
        'product'       => 'Product Page',
        'index'         => 'Product Directory',
        'appearance'    => 'Appearance',
        'api'           => 'API',
        'advertisement' => 'Advertisement',
        'custom_css'    => 'Custom CSS',
        'category_list' => 'Category List',
        'labels'        => 'Labels',
    );
    public static $subcategories = array(
        'general'       => array(
            'general'  => 'General Options',
            'taxonomy' => 'Additional Taxonomy Settings',
        ),
        'api'           => array(
            'twitter' => 'Twitter',
            'alexa'   => 'Alexa',
            'google'  => 'Google',
        ),
        'product'       => array(
            'templates'  => 'Product Page Defaults',
            'taxonomy'   => 'Taxonomy Terms',
            'add_links'  => 'Additional Links for the Product Information',
            'add_fields' => 'Additional Fields for Product Description',
            'related'    => 'Related Products',
            'boxes'      => 'Product Information Sections',
            'colors'     => 'Product Page Colors',
        ),
        'advertisement' => array(
            'advertisement' => 'Advertisement',
        ),
        'index'         => array(
            'shortcode' => 'Product Index Header',
            'filters'   => 'Filters settings',
        ),
        'appearance'    => array(
            'current_view' => 'Current View',
            'image_tiles'  => 'Tiles View Settings',
            'list_view'    => 'List View Settings',
            'product'      => 'Product Directory View Settings',
        ),
        'category_list' => array(
            'category_list' => 'Category List',
        ),
        'custom_css'    => array(
            'custom_css' => 'Custom CSS',
        ),
    );

    public static function getOptionsConfig() {

        return apply_filters( 'cmpd_options_config', array(
            // General
            self::OPTION_PRODUCT_PERMALINK                => array(
                'type'        => self::TYPE_STRING,
                'default'     => 'cm-product',
                'category'    => 'general',
                'subcategory' => 'general',
                'title'       => 'Product permalink',
                'desc'        => 'Change the permalink base (default: https://yoursite.com/cm-product/your-product)',
            ),
            self::OPTION_PRODUCT_STATISTICS_SINGLE        => array(
                'type'        => self::TYPE_BOOL,
                'default'     => TRUE,
                'category'    => 'general',
                'subcategory' => 'general',
                'title'       => 'Enable statistic on detail page',
                'desc'        => 'Show product statistic on detail page.',
            ),
            self::OPTION_PRODUCT_STATISTICS_ALL           => array(
                'type'        => self::TYPE_BOOL,
                'default'     => TRUE,
                'category'    => 'general',
                'subcategory' => 'general',
                'title'       => 'Enable statistic on products page',
                'desc'        => 'Show product statistic on products page.',
            ),
            self::OPTION_PRODUCT_STATISTICS_CSV                        => array(
                'type'        => self::TYPE_LINK,
                'link_text'   => 'Download',
                'category'    => 'general',
                'subcategory' => 'general',
                'title'       => 'Get products statistic',
                'desc'        => 'File in CSV format separated by comma. First column product name, second product page visits, third product clicks.',
            ),
            self::OPTION_PRODUCT_IMAGE_WARNING            => array(
                'type'        => self::TYPE_BOOL,
                'default'     => TRUE,
                'category'    => 'general',
                'subcategory' => 'general',
                'title'       => 'Show a warning for image size',
                'desc'        => 'Show a warning if the size of the image is bigger than 500x500 ?',
            ),
            self::OPTION_PRODUCT_SHOWEDITLINK             => array(
                'type'        => self::TYPE_BOOL,
                'default'     => TRUE,
                'category'    => 'general',
                'subcategory' => 'general',
                'title'       => 'Show admin edit link',
                'desc'        => 'Should the admin/editor edit link be shown near the product name? (for logged in users with "edit_posts" capability only)',
            ),
            self::OPTION_PRODUCT_DEFAULT_COUNTRY          => array(
                'type'        => self::TYPE_SELECT,
                'default'     => 224,
                'category'    => 'product',
                'subcategory' => 'templates',
                'title'       => 'Default country',
                'desc'        => 'Choose the default product company country',
                //'options' => array('top' => 'On Top', 'side' => 'On Side'),
                'options'     => array( "Afghanistan", "Albania", "Algeria", "American Samoa", "Andorra",
                    "Angola", "Anguilla", "Antarctica", "Antigua and Barbuda", "Argentina",
                    "Armenia", "Aruba", "Australia", "Austria", "Azerbaijan",
                    "Bahamas", "Bahrain", "Bangladesh", "Barbados", "Belarus",
                    "Belgium", "Belize", "Benin", "Bermuda", "Bhutan",
                    "Bolivia", "Bosnia and Herzegowina", "Botswana", "Bouvet Island", "Brazil",
                    "British Indian Ocean Territory", "Brunei Darussalam", "Bulgaria", "Burkina Faso", "Burundi",
                    "Cambodia", "Cameroon", "Canada", "Cape Verde", "Cayman Islands",
                    "Central African Republic", "Chad", "Chile", "China", "Christmas Island",
                    "Cocos (Keeling) Islands", "Colombia", "Comoros", "Congo", "Congo, the Democratic Republic of the",
                    "Cook Islands", "Costa Rica", "Cote d'Ivoire", "Croatia (Hrvatska)", "Cuba",
                    "Cyprus", "Czech Republic", "Denmark", "Djibouti", "Dominica",
                    "Dominican Republic", "East Timor", "Ecuador", "Egypt", "El Salvador",
                    "Equatorial Guinea", "Eritrea", "Estonia", "Ethiopia", "Falkland Islands (Malvinas)",
                    "Faroe Islands", "Fiji", "Finland", "France", "France Metropolitan",
                    "French Guiana", "French Polynesia", "French Southern Territories", "Gabon", "Gambia",
                    "Georgia", "Germany", "Ghana", "Gibraltar", "Greece",
                    "Greenland", "Grenada", "Guadeloupe", "Guam", "Guatemala",
                    "Guinea", "Guinea-Bissau", "Guyana", "Haiti", "Heard and Mc Donald Islands",
                    "Holy See (Vatican City State)", "Honduras", "Hong Kong", "Hungary", "Iceland",
                    "India", "Indonesia", "Iran (Islamic Republic of)", "Iraq", "Ireland", "Israel",
                    "Italy", "Jamaica", "Japan", "Jordan", "Kazakhstan",
                    "Kenya", "Kiribati", "Korea, Democratic People's Republic of", "Korea, Republic of", "Kuwait",
                    "Kyrgyzstan", "Lao, People's Democratic Republic", "Latvia", "Lebanon", "Lesotho",
                    "Liberia", "Libyan Arab Jamahiriya", "Liechtenstein", "Lithuania", "Luxembourg",
                    "Macau", "Macedonia, The Former Yugoslav Republic of", "Madagascar", "Malawi", "Malaysia",
                    "Maldives", "Mali", "Malta", "Marshall Islands", "Martinique",
                    "Mauritania", "Mauritius", "Mayotte", "Mexico", "Micronesia, Federated States of",
                    "Moldova, Republic of", "Monaco", "Mongolia", "Montserrat", "Morocco",
                    "Mozambique", "Myanmar", "Namibia", "Nauru", "Nepal",
                    "Netherlands", "Netherlands Antilles", "New Caledonia", "New Zealand", "Nicaragua",
                    "Niger", "Nigeria", "Niue", "Norfolk Island", "Northern Mariana Islands",
                    "Norway", "Oman", "Pakistan", "Palau", "Panama",
                    "Papua New Guinea", "Paraguay", "Peru", "Philippines", "Pitcairn",
                    "Poland", "Portugal", "Puerto Rico", "Qatar", "Reunion",
                    "Romania", "Russian Federation", "Rwanda", "Saint Kitts and Nevis", "Saint Lucia",
                    "Saint Vincent and the Grenadines", "Samoa", "San Marino", "Sao Tome and Principe", "Saudi Arabia", "Senegal",
                    "Seychelles", "Sierra Leone", "Singapore", "Slovakia (Slovak Republic)", "Slovenia",
                    "Solomon Islands", "Somalia", "South Africa", "South Georgia and the South Sandwich Islands", "Spain",
                    "Sri Lanka", "St. Helena", "St. Pierre and Miquelon", "Sudan", "Suriname",
                    "Svalbard and Jan Mayen Islands", "Swaziland", "Sweden", "Switzerland", "Syrian Arab Republic",
                    "Taiwan", "Tajikistan", "Tanzania, United Republic of", "Thailand", "Togo",
                    "Tokelau", "Tonga", "Trinidad and Tobago", "Tunisia", "Turkey",
                    "Turkmenistan", "Turks and Caicos Islands", "Tuvalu", "Uganda", "Ukraine",
                    "United Arab Emirates", "United Kingdom", "United States", "United States Minor Outlying Islands", "Uruguay",
                    "Uzbekistan", "Vanuatu", "Venezuela", "Vietnam", "Virgin Islands (British)",
                    "Virgin Islands (U.S.)", "Wallis and Futuna Islands", "Western Sahara", "Yemen", "Yugoslavia",
                    "Zambia", "Zimbabwe" ),
            ),
            self::OPTION_PRODUCT_DEFAULT_YEAR             => array(
                'type'        => self::TYPE_SELECT,
                'default'     => 65,
                'category'    => 'product',
                'subcategory' => 'templates',
                'title'       => 'Default year founded',
                'desc'        => 'Choose the default year when the prodcut company was established',
                //'options' => array('top' => 'On Top', 'side' => 'On Side'),
                'options'     => array( 'Not indicated', 1950, 1951, 1952, 1953, 1954, 1955, 1956, 1957, 1958, 1959
                    , 1960, 1961, 1962, 1963, 1964, 1965, 1966, 1967, 1968, 1969
                    , 1970, 1971, 1972, 1973, 1974, 1975, 1976, 1977, 1978, 1979
                    , 1980, 1981, 1982, 1983, 1984, 1985, 1986, 1987, 1988, 1989
                    , 1990, 1991, 1992, 1993, 1994, 1995, 1996, 1997, 1998, 1999
                    , 2000, 2001, 2002, 2003, 2004, 2005, 2006, 2007, 2008, 2009
                    , 2010, 2011, 2012, 2013, 2014, 2015, 2016, 2017 ),
            ),
            self::OPTION_PRODUCT_DEFAULT_MAP              => array(
                'type'        => self::TYPE_BOOL,
                'default'     => false,
                'category'    => 'product',
                'subcategory' => 'templates',
                'title'       => 'Show a Google map',
                'desc'        => 'Should a Google map be shown as  default on each product page for the company address.',
            ),
            self::OPTION_PRODUCT_DEFAULT_ADDRESS          => array(
                'type'        => self::TYPE_BOOL,
                'default'     => true,
                'category'    => 'product',
                'subcategory' => 'templates',
                'title'       => 'Show an Business Address',
                'desc'        => 'Should an Business Address be shown as default on each product page.',
            ),
            self::OPTION_PRODUCT_DEFAULT_IMAGE            => array(
                'type'        => self::TYPE_FILEUPLOAD,
                'default'     => '',
                'category'    => 'general',
                'subcategory' => 'general',
                'title'       => 'Choose the default product image',
                'desc'        => 'The default image will be used only when a product doesn\'t have its own image',
            ),
            self::OPTION_ACTIVATE_VIDEO_FIELD             => array(
                'type'        => self::TYPE_BOOL,
                'default'     => true,
                'category'    => 'product',
                'subcategory' => 'boxes',
                'title'       => 'Activate Product Video field',
                'desc'        => 'Check "Yes" if you want to use Product Video Field',
            ),
            // Additional Taxonomy Settings
            self::OPTION_TAXONOMY_PRICINGMODEL            => array(
                'type'        => self::TYPE_BOOL,
                'default'     => true,
                'category'    => 'general',
                'subcategory' => 'taxonomy',
                'title'       => 'Use Pricing Model Taxonomy',
                'desc'        => '',
            ),
            self::OPTION_TAXONOMY_LANUAGESUPPORT          => array(
                'type'        => self::TYPE_BOOL,
                'default'     => true,
                'category'    => 'general',
                'subcategory' => 'taxonomy',
                'title'       => 'Use Language Support Taxonomy',
                'desc'        => '',
            ),
            self::OPTION_TAXONOMY_TARGETAUDIENCE          => array(
                'type'        => self::TYPE_BOOL,
                'default'     => true,
                'category'    => 'general',
                'subcategory' => 'taxonomy',
                'title'       => 'Use Target Audience Taxonomy',
                'desc'        => '',
            ),
            // Product Page
            // Taxonomy
            self::LIST_TAXONOMY_TERMS_CATEGORY            => array(
                'type'        => self::TYPE_BOOL,
                'default'     => true,
                'category'    => 'product',
                'subcategory' => 'taxonomy',
                'title'       => 'Display Category terms list',
                'desc'        => 'Check "yes" if you want to list Category terms on product page',
            ),
            self::LIST_TAXONOMY_TERMS_PRICINGMODEL        => array(
                'type'        => self::TYPE_BOOL,
                'default'     => true,
                'category'    => 'product',
                'subcategory' => 'taxonomy',
                'title'       => 'Display Pricing Model terms list',
                'desc'        => 'Check "yes" if you want to list Pricing Model terms on product page',
            ),
            self::LIST_TAXONOMY_TERMS_LANGUAGESUPPORT     => array(
                'type'        => self::TYPE_BOOL,
                'default'     => true,
                'category'    => 'product',
                'subcategory' => 'taxonomy',
                'title'       => 'Display Language Support terms list',
                'desc'        => 'Check "yes" if you want to list Language Support terms on product page',
            ),
            self::LIST_TAXONOMY_TERMS_TARGETAUDIENCE      => array(
                'type'        => self::TYPE_BOOL,
                'default'     => true,
                'category'    => 'product',
                'subcategory' => 'taxonomy',
                'title'       => 'Display Target Audience terms list',
                'desc'        => 'Check "yes" if you want to list Target Audience terms on product page',
            ),
            self::LIST_TAXONOMY_TERMS_TAG                 => array(
                'type'        => self::TYPE_BOOL,
                'default'     => true,
                'category'    => 'product',
                'subcategory' => 'taxonomy',
                'title'       => 'Display Tag terms list',
                'desc'        => 'Check "yes" if you want to list Tag terms on product page',
            ),
            // Advertisement
            // Advertisement
            self::OPTION_PRODUCT_ADVERT_DISPLAY           => array(
                'type'        => self::TYPE_BOOL,
                'default'     => false,
                'category'    => 'advertisement',
                'subcategory' => 'advertisement',
                'title'       => 'Display the ads',
                'desc'        => 'Turning this OFF will disable all of the ads without needing to remove the scripts.',
            ),
            self::OPTION_PRODUCT_ADVERRT3                 => array(
                'type'        => self::TYPE_TEXTAREA,
                'default'     => '',
                'category'    => 'advertisement',
                'subcategory' => 'advertisement',
                'title'       => 'Ads above related products',
                'desc'        => 'You can add any javascript or HTML code in here (including WordPress shortcodes).',
            ),
            self::OPTION_PRODUCT_ADVERRT1                 => array(
                'type'        => self::TYPE_TEXTAREA,
                'default'     => '',
                'category'    => 'advertisement',
                'subcategory' => 'advertisement',
                'title'       => 'Ads under related products',
                'desc'        => 'You can add any javascript or HTML code in here (including WordPress shortcodes).',
            ),
            self::OPTION_PRODUCT_ADVERRT2                 => array(
                'type'        => self::TYPE_TEXTAREA,
                'default'     => '',
                'category'    => 'advertisement',
                'subcategory' => 'advertisement',
                'title'       => 'Ads under product map',
                'desc'        => 'You can add any javascript or HTML code in here (including WordPress shortcodes).',
            ),
            // Product Directory
            // Product Index Header
            CMProductDirectory::SHORTCODE_PAGE_OPTION     => array(
                'type'        => self::TYPE_STRING,
                'default'     => '',
                'category'    => 'index',
                'subcategory' => 'shortcode',
                'title'       => 'Product Index Page ID',
                'desc'        => 'Select the ID of the page with the [cmpd_product] shortcode. All backlinks will be pointing to that page.',
            ),
            self::OPTION_PRODUCT_VIEW                     => array(
                'type'        => self::TYPE_SELECT,
                'default'     => 'image-tiles',
                'category'    => 'appearance',
                'subcategory' => 'current_view',
                'title'       => 'Default view',
                'desc'        => 'Select the view for the Product Directory',
                'options'     => array(
                    'image-tiles'    => 'Tiles View',
                    'list-view'      => 'List View',
                    'directory-view' => 'Product Directory View',
                    'new-view'       => 'New View',
                ),
            ),
            self::OPTION_PRODUCT_ORDERBY                  => array(
                'type'        => self::TYPE_SELECT,
                'default'     => 'menu_order',
                'category'    => 'index',
                'subcategory' => 'shortcode',
                'title'       => 'Product order by',
                'desc'        => 'Select how the products in the product directory index page should be ordered.',
                'options'     => array( 'menu_order'    => 'Menu Order',
                    'post_title'    => 'Product Name',
                    'post_date'     => 'Date Added',
                    'post_modified' => 'Last Modified Date' )
            ),
            self::OPTION_PRODUCT_ORDER                    => array(
                'type'        => self::TYPE_SELECT,
                'default'     => 'DESC',
                'category'    => 'index',
                'subcategory' => 'shortcode',
                'title'       => 'Order in ascending or descending order',
                'desc'        => 'Select whether the products in the directory index should be ordered in ascending or descending order.',
                'options'     => array( 'DESC' => 'DESC',
                    'ASC'  => 'ASC' ),
            ),
            self::OPTION_PRODUCT_PRODUCT_ON_PAGE          => array(
                'type'        => self::TYPE_STRING,
                'default'     => 15,
                'category'    => 'index',
                'subcategory' => 'shortcode',
                'title'       => 'Number of products on page',
                'desc'        => 'Set the number of items on a single directory page. Use <code>-1</code> to turn off the pagination.',
            ),
            self::OPTION_PAGINATION_TOP                   => array(
                'type'        => self::TYPE_BOOL,
                'default'     => false,
                'category'    => 'index',
                'subcategory' => 'shortcode',
                'title'       => 'Show pagination on top',
                'desc'        => 'Controls whether to show the pagination at the top of the product directory index page.',
            ),
            self::OPTION_PAGINATION_BOTTOM                => array(
                'type'        => self::TYPE_BOOL,
                'default'     => true,
                'category'    => 'index',
                'subcategory' => 'shortcode',
                'title'       => 'Show pagination on bottom',
                'desc'        => 'Controls whether to show the pagination at the bottom of the directory index page.',
            ),
            self::OPTION_FOUND_PRODUCT                    => array(
                'type'        => self::TYPE_BOOL,
                'default'     => true,
                'category'    => 'index',
                'subcategory' => 'shortcode',
                'title'       => 'Show the number of products found',
                'desc'        => 'Controls whether the number of  products found should be displayed.',
            ),
            self::OPTION_POST_PER_PAGE_SHOW               => array(
                'type'        => self::TYPE_BOOL,
                'default'     => FALSE,
                'category'    => 'index',
                'subcategory' => 'shortcode',
                'title'       => 'Show items per page selection',
                'desc'        => 'Should the number of items shown in the product directory index page be editable?'
            ),
            self::OPTION_BUTTONS_TARGET_BLANK             => array(
                'type'        => self::TYPE_BOOL,
                'default'     => FALSE,
                'category'    => 'index',
                'subcategory' => 'shortcode',
                'title'       => 'Open each product page on a new tab',
                'desc'        => 'Should the product page be opened on a new tab? (target="_blank")',
            ),
            self::OPTION_BUTTONS_BUSINES_PITCH_IMG        => array(
                'type'        => self::TYPE_BOOL,
                'default'     => FALSE,
                'category'    => 'index',
                'subcategory' => 'shortcode',
                'title'       => 'Product Pitch as image title',
                'desc'        => 'Should the product pitch be shown as the title of the image? (Product Directory View/Tiles View only!)',
            ),
            // Filters
            self::OPTION_CATEGORY_SHOW_AS                 => array(
                'type'        => self::TYPE_SELECT,
                'default'     => 'tags',
                'category'    => 'index',
                'subcategory' => 'filters',
                'title'       => 'Display categories as',
                'desc'        => 'Select how the categories should be presented.',
                'options'     => array( 'tags' => 'Tags', 'dropdown' => 'Dropdown' )
            ),
            self::OPTION_PRODUCT_SHOWSEARCH               => array(
                'type'        => self::TYPE_BOOL,
                'default'     => TRUE,
                'category'    => 'index',
                'subcategory' => 'filters',
                'title'       => 'Show search field',
                'desc'        => 'Should the product directory be searchable?',
            ),
            self::OPTION_SHOW_WHEN_SEARCH                              => array(
                'type'        => self::TYPE_BOOL,
                'default'     => 0,
                'category'    => 'index',
                'subcategory' => 'filters',
                'title'       => 'Only show items on search?',
                'desc'        => 'Select this option if you want to display the items only after user enters a search term.',
            ),
            self::OPTION_SEARCH_IN_TAGS                                => array(
                'type'        => self::TYPE_BOOL,
                'default'     => FALSE,
                'category'    => 'index',
                'subcategory' => 'filters',
                'title'       => 'Search In Tags',
                'desc'        => 'Should the search also in tags?',
            ),
            self::SHORTCODE_ATTR_TAXONOMY_CATEGORY        => array(
                'type'        => self::TYPE_BOOL,
                'default'     => true,
                'category'    => 'index',
                'subcategory' => 'filters',
                'title'       => 'Display Category filter',
                'desc'        => 'Set default value for "cmpd_product" filter attribute.',
            ),
            self::SHORTCODE_ATTR_TAXONOMY_PRICINGMODEL    => array(
                'type'        => self::TYPE_BOOL,
                'default'     => false,
                'category'    => 'index',
                'subcategory' => 'filters',
                'title'       => 'Display Pricing Model filter',
                'desc'        => 'Set default value for "cmpd_product" filter attribute.',
            ),
            self::SHORTCODE_ATTR_TAXONOMY_LANGUAGESUPPORT => array(
                'type'        => self::TYPE_BOOL,
                'default'     => false,
                'category'    => 'index',
                'subcategory' => 'filters',
                'title'       => 'Display Language Support filter',
                'desc'        => 'Set default value for "cmpd_product" filter attribute.',
            ),
            self::SHORTCODE_ATTR_TAXONOMY_TARGETAUDIENCE  => array(
                'type'        => self::TYPE_BOOL,
                'default'     => true,
                'category'    => 'index',
                'subcategory' => 'filters',
                'title'       => 'Display Target Audience filter',
                'desc'        => 'Set default value for "cmpd_product" filter attribute.',
            ),
            self::SHORTCODE_ATTR_TAXONOMY_TAG             => array(
                'type'        => self::TYPE_BOOL,
                'default'     => true,
                'category'    => 'index',
                'subcategory' => 'filters',
                'title'       => 'Display Tag filter',
                'desc'        => 'Set default value for "cmpd_product" filter attribute.',
            ),
            // APPEARANCE
            // image_tiles
            self::CMPD_OPTION_APPEARANCE_TILES_COLUMNS      => array(
                'type'        => self::TYPE_INT,
                'default'     => 3,
                'category'    => 'appearance',
                'subcategory' => 'image_tiles',
                'title'       => 'Products in a row',
                'desc'        => 'Set the number of products in a row shown in the directory index.',
            ),
            self::CMPD_OPTION_APPEARANCE_TILES_MARGINS      => array(
                'type'        => self::TYPE_STRING,
                'default'     => '1em',
                'category'    => 'appearance',
                'subcategory' => 'image_tiles',
                'title'       => 'Products paddings',
                'desc'        => 'Set padding value. Use px/pt/em/% units (e.g. "0.5em")',
            ),
            self::CMPD_OPTION_APPEARANCE_TILES_IMG_HEIGHT   => array(
                'type'        => self::TYPE_STRING,
                'default'     => 'auto',
                'category'    => 'appearance',
                'subcategory' => 'image_tiles',
                'title'       => 'Image container minimum height',
                'desc'        => 'If you use small images, set minimum height value to display image in the middle of the container. Use px/pt/em/% units (e.g. "220px")',
            ),
            self::CMPD_OPTION_APPEARANCE_TILES_SHOW_TITLE   => array(
                'type'        => self::TYPE_BOOL,
                'default'     => true,
                'category'    => 'appearance',
                'subcategory' => 'image_tiles',
                'title'       => 'Display title',
                'desc'        => 'Set "Yes" if you want to display product title below image',
            ),
            self::CMPD_OPTION_APPEARANCE_TILES_BORDER       => array(
                'type'        => self::TYPE_BOOL,
                'default'     => false,
                'category'    => 'appearance',
                'subcategory' => 'image_tiles',
                'title'       => 'Display border',
                'desc'        => 'Check this option if you want to display border around each prodcut.',
            ),
            self::CMPD_OPTION_APPEARANCE_TILES_SHOW_DETAILS => array(
                'type'        => self::TYPE_BOOL,
                'default'     => false,
                'category'    => 'appearance',
                'subcategory' => 'image_tiles',
                'title'       => 'Show details button',
                'desc'        => 'Should the product box in the directory index include the "Details" button?',
            ),
            // List
            self::CMPD_OPTION_APPEARANCE_LIST_BOTTOMBORDER => array(
                'type'        => self::TYPE_BOOL,
                'default'     => 1,
                'category'    => 'appearance',
                'subcategory' => 'list_view',
                'title'       => 'Display separator line',
                'desc'        => 'Whether you want to display separation line below each product.',
            ),
            self::CMPD_OPTION_APPEARANCE_LIST_RATING       => array(
                'type'        => self::TYPE_BOOL,
                'default'     => 1,
                'category'    => 'appearance',
                'subcategory' => 'list_view',
                'title'       => 'Display rating',
                'desc'        => 'Whether you want to display rating for each product.',
            ),
            self::CMPD_OPTION_APPEARANCE_LIST_PITCH        => array(
                'type'        => self::TYPE_BOOL,
                'default'     => 0,
                'category'    => 'appearance',
                'subcategory' => 'list_view',
                'title'       => 'Display product pitch',
                'desc'        => 'Whether you want to display product pitch next to product title.',
            ),
            // Directory
            self::CMPD_OPTION_APPEARANCE_DIRECTORY_DISPLAY_RATING      => array(
                'type'        => self::TYPE_BOOL,
                'default'     => true,
                'category'    => 'appearance',
                'subcategory' => 'product',
                'title'       => 'Display product rating',
                'desc'        => 'If you want to display each product rating on the side.',
            ),
            self::CMPD_OPTION_APPEARANCE_DIRECTORY_DISPLAY_DESCRIPTION => array(
                'type'        => self::TYPE_BOOL,
                'default'     => true,
                'category'    => 'appearance',
                'subcategory' => 'product',
                'title'       => 'Display product description',
                'desc'        => 'If you want to display each product description below the title.',
            ),
            self::CMPD_OPTION_APPEARANCE_DIRECTORY_DISPLAY_CATEGORY    => array(
                'type'        => self::TYPE_BOOL,
                'default'     => true,
                'category'    => 'appearance',
                'subcategory' => 'product',
                'title'       => 'Display product categories',
                'desc'        => 'If you want to display each product categories below the title.',
            ),
            // Category List
            self::SHORTCODE_LIST_CATEGORY_TERMS_CATEGORY        => array(
                'type'        => self::TYPE_BOOL,
                'default'     => true,
                'category'    => 'category_list',
                'subcategory' => 'category_list',
                'title'       => 'Display Category terms list',
                'desc'        => 'Default value for shortcode "category" attribute',
            ),
            self::SHORTCODE_LIST_CATEGORY_TERMS_PRICINGMODEL    => array(
                'type'        => self::TYPE_BOOL,
                'default'     => true,
                'category'    => 'category_list',
                'subcategory' => 'category_list',
                'title'       => 'Display Pricing Model terms list',
                'desc'        => 'Default value for shortcode "expertise" attribute',
            ),
            self::SHORTCODE_LIST_CATEGORY_TERMS_LANGUAGESUPPORT => array(
                'type'        => self::TYPE_BOOL,
                'default'     => true,
                'category'    => 'category_list',
                'subcategory' => 'category_list',
                'title'       => 'Display Language Support terms list',
                'desc'        => 'Default value for shortcode "service" attribute',
            ),
            self::SHORTCODE_LIST_CATEGORY_TERMS_TARGETAUDIENCE  => array(
                'type'        => self::TYPE_BOOL,
                'default'     => true,
                'category'    => 'category_list',
                'subcategory' => 'category_list',
                'title'       => 'Display Target Audience terms list',
                'desc'        => 'Default value for shortcode "language" attribute',
            ),
            self::SHORTCODE_LIST_CATEGORY_TERMS_TAG             => array(
                'type'        => self::TYPE_BOOL,
                'default'     => true,
                'category'    => 'category_list',
                'subcategory' => 'category_list',
                'title'       => 'Display Tag terms list',
                'desc'        => 'Default value for shortcode "tag" attribute',
            ),
            self::SHORTCODE_LIST_CATEGORY_TERMS_DEFAULT_ICON    => array(
                'type'        => self::TYPE_STRING,
                'default'     => '',
                'category'    => 'category_list',
                'subcategory' => 'category_list',
                'title'       => 'Change default category icon',
                'desc'        => 'Enter image URL ()'
            ),
            // Custom CSS
            // Custom CSS
            self::OPTION_CUSTOM_CSS                 => array(
                'type'        => self::TYPE_TEXTAREA,
                'default'     => '',
                'category'    => 'custom_css',
                'subcategory' => 'custom_css',
                'title'       => 'Custom CSS',
                'desc'        => 'Set the CSS for the CM Product Directory. It will be wrapped with the tags and outputted only with the shortcode.',
            ),
            // Labels
            self::OPTION_DISPLAY_TWITTER            => array(
                'type'        => self::TYPE_BOOL,
                'default'     => false,
                'category'    => 'api',
                'subcategory' => 'twitter',
                'title'       => 'Show Twitter link',
                'desc'        => 'Should the link to Twitter be shown on each product page.',
            ),
            self::OPTION_PRODUCT_TWITTER_FALLOWERS  => array(
                'type'        => self::TYPE_BOOL,
                'default'     => true,
                'category'    => 'api',
                'subcategory' => 'twitter',
                'title'       => 'Show Twitter followers',
                'desc'        => 'Should the number of Twitter followers be shown on each product page.',
            ),
            self::TWITTER_CONSUMER_KEY              => array(
                'type'        => self::TYPE_STRING,
                'default'     => '',
                'category'    => 'api',
                'subcategory' => 'twitter',
                'title'       => 'Twitter Consumer Key',
                'desc'        => 'Put here consumer key (https://apps.twitter.com/)',
            ),
            self::TWITTER_CONSUMER_SECRET           => array(
                'type'        => self::TYPE_STRING,
                'default'     => '',
                'category'    => 'api',
                'subcategory' => 'twitter',
                'title'       => 'Twitter Consumer Secret',
                'desc'        => 'Put here consumer secret key (https://apps.twitter.com/)',
            ),
            self::TWITTER_OAUTH_ACCESS_TOKEN        => array(
                'type'        => self::TYPE_STRING,
                'default'     => '',
                'category'    => 'api',
                'subcategory' => 'twitter',
                'title'       => 'Twitter Access Token',
                'desc'        => 'Put here access token (https://apps.twitter.com/)',
            ),
            self::TWITTER_OAUTH_ACCESS_TOKEN_SECRET => array(
                'type'        => self::TYPE_STRING,
                'default'     => '',
                'category'    => 'api',
                'subcategory' => 'twitter',
                'title'       => 'Twitter Access Token Secret',
                'desc'        => 'Put here access token secret (https://apps.twitter.com/)',
            ),
            self::OPTION_PRODUCT_ALEXA_RANK         => array(
                'type'        => self::TYPE_BOOL,
                'default'     => true,
                'category'    => 'api',
                'subcategory' => 'alexa',
                'title'       => 'Show Alexa rank',
                'desc'        => 'Should the Alexa rank be shown on each product page.',
            ),
            // Google
            self::GOOGLE_MAP_AUTH_KEY => array(
                'type'        => self::TYPE_STRING,
                'default'     => '',
                'category'    => 'api',
                'subcategory' => 'google',
                'title'       => 'Get a Google Key/Authentication',
                'desc'        => 'All Google Maps JavaScript API applications require authentication. Go to <a href="https://developers.google.com/maps/documentation/javascript/get-api-key">Google Developers</a> to get Key',
            ),
            // Templates
            self::OPTION_PRODUCT_PAGE_TEMPLATE        => array(
                'type'        => self::TYPE_SELECT,
                'default'     => 'cm_default',
                'category'    => 'product',
                'subcategory' => 'templates',
                'title'       => 'Default template',
                'desc'        => 'Select the default template for the product page',
                'options'     => CMProductDirectoryShared::scanTemplateDir(),
            ),
            // Product page
            // Product Page Defaults
            self::OPTION_DISPLAY_LOGO                 => array(
                'type'        => self::TYPE_BOOL,
                'default'     => true,
                'category'    => 'product',
                'subcategory' => 'templates',
                'title'       => 'Display product logo',
                'desc'        => 'Display product logo on product page.',
                'options'     => CMProductDirectoryShared::scanTemplateDir(),
            ),
            self::OPTION_DISPLAY_YEAR_FOUNDED         => array(
                'type'        => self::TYPE_BOOL,
                'default'     => false,
                'category'    => 'product',
                'subcategory' => 'templates',
                'title'       => 'Display year founded',
                'desc'        => 'Display business year founded on product page.',
            ),
            self::OPTION_PRODUCT_PAGE_PUBLISH_DATE    => array(
                'type'        => self::TYPE_BOOL,
                'default'     => true,
                'category'    => 'product',
                'subcategory' => 'templates',
                'title'       => 'Display product page publish date',
                'desc'        => 'Shows the date in which the product was created in the product directory'
            ),
            self::OPTION_PRODUCT_PAGE_UPDATE_DATE     => array(
                'type'        => self::TYPE_BOOL,
                'default'     => false,
                'category'    => 'product',
                'subcategory' => 'templates',
                'title'       => 'Display product page update date',
                'desc'        => 'Shows the date in which the product was last updated in the product directory'
            ),
            self::OPTION_ADD_METADESCRIPTION          => array(
                'type'        => self::TYPE_BOOL,
                'default'     => true,
                'category'    => 'product',
                'subcategory' => 'templates',
                'title'       => 'Add Meta description',
                'desc'        => 'If this option is enabled the HTML meta description tag will be added on the product page based on the product pitch.',
            ),
            self::OPTION_SHOW_COMMENTS                => array(
                'type'        => self::TYPE_BOOL,
                'default'     => FALSE,
                'category'    => 'product',
                'subcategory' => 'templates',
                'title'       => 'Show comments',
                'desc'        => 'If this option is enabled the WordPress comments section will be displayed on the product pages.',
            ),
            // Templates
            self::OPTION_PRODUCT_PAGE_SHOW_BACKLINK   => array(
                'type'        => self::TYPE_BOOL,
                'default'     => true,
                'category'    => 'product',
                'subcategory' => 'templates',
                'title'       => 'Show back to directory index link',
                'desc'        => 'Whether to display the back link to the product directory index on the product page.',
            ),
            // Templates
            self::OPTION_PRODUCT_PAGE_SHOW_EMAIL      => array(
                'type'        => self::TYPE_BOOL,
                'default'     => false,
                'category'    => 'product',
                'subcategory' => 'templates',
                'title'       => 'Show company e-mail address',
                'desc'        => 'Whether to show the company e-mail address on the product page.',
            ),
            self::OPTION_INFO_WIDGET                  => array(
                'type'        => self::TYPE_COLOR,
                'default'     => '#2e3641',
                'category'    => 'product',
                'subcategory' => 'colors',
                'title'       => 'Product information box background color',
                'desc'        => 'The background color for the product information on the product page',
            ),
            self::OPTION_ADDRESS_WIDGET               => array(
                'type'        => self::TYPE_COLOR,
                'default'     => '#2e3641',
                'category'    => 'product',
                'subcategory' => 'colors',
                'title'       => 'Company information box background color',
                'desc'        => 'The background color for the company information on the product page',
            ),
            self::OPTION_PRODUCT_CONTAINER            => array(
                'type'        => self::TYPE_COLOR,
                'default'     => '#f5f5f5',
                'category'    => 'product',
                'subcategory' => 'colors',
                'title'       => 'Product page background',
                'desc'        => 'The background color for the product page',
            ),
            self::OPTION_PURCHASE_BUTTON_COLOR        => array(
                'type'        => self::TYPE_COLOR,
                'default'     => '#27ae60',
                'category'    => 'product',
                'subcategory' => 'colors',
                'title'       => 'Purchase product button color',
                'desc'        => 'The background color for the product purchase button',
            ),
            self::OPTION_PURCHASE_BUTTON_HOVER_COLOR  => array(
                'type'        => self::TYPE_COLOR,
                'default'     => '#2ecc71',
                'category'    => 'product',
                'subcategory' => 'colors',
                'title'       => 'Purchase product button color on hover',
                'desc'        => 'The background color for the product purchase button on hover',
            ),
            self::OPTION_PRODUCT_BOX_TEXT_COLOR       => array(
                'type'        => self::TYPE_COLOR,
                'default'     => '#ffffff',
                'category'    => 'product',
                'subcategory' => 'colors',
                'title'       => 'Product box text color',
                'desc'        => 'The text color for product box',
            ),
            self::OPTION_PRODUCT_BOX_LINK_COLOR       => array(
                'type'        => self::TYPE_COLOR,
                'default'     => '#ffffff',
                'category'    => 'product',
                'subcategory' => 'colors',
                'title'       => 'Product box link color',
                'desc'        => 'The link color for product box',
            ),
            self::OPTION_PRODUCT_BOX_LINK_HOVER_COLOR => array(
                'type'        => self::TYPE_COLOR,
                'default'     => '#ffffff',
                'category'    => 'product',
                'subcategory' => 'colors',
                'title'       => 'Product box link color on hover',
                'desc'        => 'The link color (hover) for product box',
            ),
            self::OPTION_COMPANY_BOX_TEXT_COLOR       => array(
                'type'        => self::TYPE_COLOR,
                'default'     => '#ffffff',
                'category'    => 'product',
                'subcategory' => 'colors',
                'title'       => 'Company box text color',
                'desc'        => 'The text color for company box',
            ),
            self::OPTION_COMPANY_BOX_LINK_COLOR       => array(
                'type'        => self::TYPE_COLOR,
                'default'     => '#ffffff',
                'category'    => 'product',
                'subcategory' => 'colors',
                'title'       => 'Company box link color',
                'desc'        => 'The link color for company box',
            ),
            self::OPTION_COMPANY_BOX_LINK_HOVER_COLOR => array(
                'type'        => self::TYPE_COLOR,
                'default'     => '#ffffff',
                'category'    => 'product',
                'subcategory' => 'colors',
                'title'       => 'Company box link color on hover',
                'desc'        => 'The link color (hover) for company box',
            ),
            self::OPTION_RELATEDPRODUCT_SHOWBUTTON    => array(
                'type'        => self::TYPE_BOOL,
                'default'     => true,
                'category'    => 'product',
                'subcategory' => 'related',
                'title'       => 'Show related products',
                'desc'        => 'Controls whether the related products widget should be displayed on the product page.',
            ),
            self::OPTION_RELATEDPRODUCT_CAT           => array(
                'type'        => self::TYPE_BOOL,
                'default'     => true,
                'category'    => 'product',
                'subcategory' => 'related',
                'title'       => 'Related product by category',
                'desc'        => 'If this option is set, related products will have the same category as the displayed product.',
            ),
            self::OPTION_RELATEDPRODUCT_NUMBER        => array(
                'type'        => self::TYPE_INT,
                'default'     => 5,
                'category'    => 'product',
                'subcategory' => 'related',
                'title'       => 'Number of related products',
                'desc'        => 'Choose the number of related products to show.',
            ),
            self::OPTION_ADD_LINKS         => array(
                'type'        => self::TYPE_BOOL,
                'default'     => false,
                'category'    => 'product',
                'subcategory' => 'add_links',
                'title'       => 'Show additional custom links',
                'desc'        => 'Set this option to show additional custom links on product page in product information box.',
            ),
            self::OPTION_ADD_LINKS_LABEL1  => array(
                'type'        => self::TYPE_STRING,
                'default'     => '',
                'category'    => 'product',
                'subcategory' => 'add_links',
                'title'       => 'First custom link label',
                'desc'        => 'This label will be shown on the product page in the product information box',
            ),
            self::OPTION_ADD_LINKS_ICO1    => array(
                'type'        => self::TYPE_FILEUPLOAD,
                'default'     => '',
                'category'    => 'product',
                'subcategory' => 'add_links',
                'title'       => 'First custom link icon',
                'desc'        => 'This icon will be shown on the product page in the product information box',
            ),
            self::OPTION_ADD_LINKS_LABEL2  => array(
                'type'        => self::TYPE_STRING,
                'default'     => '',
                'category'    => 'product',
                'subcategory' => 'add_links',
                'title'       => 'Second custom link label',
                'desc'        => 'This label will be shown on the product page in the product information box',
            ),
            self::OPTION_ADD_LINKS_ICO2    => array(
                'type'        => self::TYPE_FILEUPLOAD,
                'default'     => '',
                'category'    => 'product',
                'subcategory' => 'add_links',
                'title'       => 'Second custom link icon',
                'desc'        => 'This icon will be shown on the product page in the product information box',
            ),
            self::OPTION_ADD_LINKS_LABEL3  => array(
                'type'        => self::TYPE_STRING,
                'default'     => '',
                'category'    => 'product',
                'subcategory' => 'add_links',
                'title'       => 'Third custom link label',
                'desc'        => 'This label will be shown on the product page in the product information box',
            ),
            self::OPTION_ADD_LINKS_ICO3    => array(
                'type'        => self::TYPE_FILEUPLOAD,
                'default'     => '',
                'category'    => 'product',
                'subcategory' => 'add_links',
                'title'       => 'Third custom link icon',
                'desc'        => 'This icon will be shown on the product page in the product information box',
            ),
            self::OPTION_ADD_LINKS_LABEL4  => array(
                'type'        => self::TYPE_STRING,
                'default'     => '',
                'category'    => 'product',
                'subcategory' => 'add_links',
                'title'       => 'Fourth custom link label',
                'desc'        => 'This label will be shown on the product page in the product information box',
            ),
            self::OPTION_ADD_LINKS_ICO4    => array(
                'type'        => self::TYPE_FILEUPLOAD,
                'default'     => '',
                'category'    => 'product',
                'subcategory' => 'add_links',
                'title'       => 'Fourth custom link icon',
                'desc'        => 'This icon will be shown on the product page in the product information box',
            ),
            self::OPTION_ADD_FIELDS        => array(
                'type'        => self::TYPE_BOOL,
                'default'     => false,
                'category'    => 'product',
                'subcategory' => 'add_fields',
                'title'       => 'Show additional custom fields',
                'desc'        => 'Set this option to show additional custom fields on product page in the product company info box.',
            ),
            self::OPTION_ADD_FIELDS_LABEL1 => array(
                'type'        => self::TYPE_STRING,
                'default'     => '',
                'category'    => 'product',
                'subcategory' => 'add_fields',
                'title'       => 'First custom field label',
                'desc'        => 'This label will be shown on the product page in the company info box',
            ),
            self::OPTION_ADD_FIELDS_ICO1   => array(
                'type'        => self::TYPE_FILEUPLOAD,
                'default'     => '',
                'category'    => 'product',
                'subcategory' => 'add_fields',
                'title'       => 'First custom field icon',
                'desc'        => 'This icon will be shown on the product page in the company info box',
            ),
            self::OPTION_ADD_FIELDS_POS1   => array(
                'type'        => self::TYPE_SELECT,
                'default'     => '',
                'category'    => 'product',
                'subcategory' => 'add_fields',
                'title'       => 'First custom field position',
                'desc'        => 'Select the place where this field should be displayed',
                'options'     => array( 'info_box' => CMProductDirectory::__( 'Inside Info Box' ), 'below_content' => CMProductDirectory::__( 'Below Info Box' ) ),
            ),
            self::OPTION_ADD_FIELDS_LABEL2 => array(
                'type'        => self::TYPE_STRING,
                'default'     => '',
                'category'    => 'product',
                'subcategory' => 'add_fields',
                'title'       => 'Second custom field label',
                'desc'        => 'This label will be shown on the product page in the company info box',
            ),
            self::OPTION_ADD_FIELDS_ICO2   => array(
                'type'        => self::TYPE_FILEUPLOAD,
                'default'     => '',
                'category'    => 'product',
                'subcategory' => 'add_fields',
                'title'       => 'Second custom field icon',
                'desc'        => 'This icon will be shown on the product page in the company info box',
            ),
            self::OPTION_ADD_FIELDS_POS2   => array(
                'type'        => self::TYPE_SELECT,
                'default'     => '',
                'category'    => 'product',
                'subcategory' => 'add_fields',
                'title'       => 'Second custom field position',
                'desc'        => 'Select the place where this field should be displayed',
                'options'     => array( 'info_box' => CMProductDirectory::__( 'Inside Info Box' ), 'below_content' => CMProductDirectory::__( 'Below Info Box' ) ),
            ),
            self::OPTION_ADD_FIELDS_LABEL3 => array(
                'type'        => self::TYPE_STRING,
                'default'     => '',
                'category'    => 'product',
                'subcategory' => 'add_fields',
                'title'       => 'Third custom field label',
                'desc'        => 'This label will be shown on the product page in the company info box',
            ),
            self::OPTION_ADD_FIELDS_ICO3   => array(
                'type'        => self::TYPE_FILEUPLOAD,
                'default'     => '',
                'category'    => 'product',
                'subcategory' => 'add_fields',
                'title'       => 'Third custom field icon',
                'desc'        => 'This icon will be shown on the product page in the company info box',
            ),
            self::OPTION_ADD_FIELDS_POS3   => array(
                'type'        => self::TYPE_SELECT,
                'default'     => '',
                'category'    => 'product',
                'subcategory' => 'add_fields',
                'title'       => 'Third custom field position',
                'desc'        => 'Select the place where this field should be displayed',
                'options'     => array( 'info_box' => CMProductDirectory::__( 'side InInfo Box' ), 'below_content' => CMProductDirectory::__( 'Below Info Box' ) ),
            ),
            self::OPTION_ADD_FIELDS_LABEL4 => array(
                'type'        => self::TYPE_STRING,
                'default'     => '',
                'category'    => 'product',
                'subcategory' => 'add_fields',
                'title'       => 'Fourth custom field label',
                'desc'        => 'This label will be shown on the product page in the company info box',
            ),
            self::OPTION_ADD_FIELDS_ICO4   => array(
                'type'        => self::TYPE_FILEUPLOAD,
                'default'     => '',
                'category'    => 'product',
                'subcategory' => 'add_fields',
                'title'       => 'Fourth custom field icon',
                'desc'        => 'This icon will be shown on the product page in the company info box',
            ),
            self::OPTION_ADD_FIELDS_POS4   => array(
                'type'        => self::TYPE_SELECT,
                'default'     => '',
                'category'    => 'product',
                'subcategory' => 'add_fields',
                'title'       => 'Fourth custom field position',
                'desc'        => 'Select the place where this field should be displayed',
                'options'     => array( 'info_box' => CMProductDirectory::__( 'Below Info Box' ), 'below_content' => CMProductDirectory::__( 'Below fo Box' ) ),
            ),
        )
        );
    }

    public static function getOptionsConfigByCategory( $category, $subcategory = null ) {
        $options = self::getOptionsConfig();
        return array_filter( $options, function($val) use ($category, $subcategory) {
            if ( $val[ 'category' ] == $category ) {
                return (is_null( $subcategory ) OR $val[ 'subcategory' ] == $subcategory);
            }
        } );
    }

    public static function getOptionConfig( $name ) {
        $options = self::getOptionsConfig();
        if ( isset( $options[ $name ] ) ) {
            return $options[ $name ];
        }
    }

    public static function setOption( $name, $value ) {
        $options = self::getOptionsConfig();
        $checker = isset( $_POST[ $name ] ) ? (strpos( $name, self::SETTINGS_PREFIX ) === 0) ? 1 : 0 : 0;
        if ( isset( $options[ $name ] ) ) {
            $field = $options[ $name ];
            $old   = get_option( $name );
            if ( is_array( $old ) OR is_object( $old ) OR strlen( (string) $old ) > 0 ) {
                update_option( $name, self::cast( $value, $field[ 'type' ] ) );
            } else {
                $result = update_option( $name, self::cast( $value, $field[ 'type' ] ) );
            }
        }
        if ( empty( $options[ $name ] ) && $checker ) {
            update_option( $name, $value );
        }
    }

    public static function deleteAllOptions() {
        $params  = array();
        $options = self::getOptionsConfig();
        foreach ( $options as $name => $optionConfig ) {
            self::deleteOption( $name );
        }
        return $params;
    }

    public static function deleteOption( $name ) {
        $options = self::getOptionsConfig();
        if ( isset( $options[ $name ] ) ) {
            delete_option( $name );
        }
    }

    public static function getOption( $name ) {
        $options = self::getOptionsConfig();
        if ( isset( $options[ $name ] ) ) {
            $field        = $options[ $name ];
            $defaultValue = (isset( $field[ 'default' ] ) ? $field[ 'default' ] : null);
            return self::cast( get_option( $name, $defaultValue ), $field[ 'type' ] );
        }
    }

    public static function getCategories() {
        $categories = array();
        $options    = self::getOptionsConfig();
        foreach ( $options as $option ) {
            $categories[] = $option[ 'category' ];
        }
        return $categories;
    }

    public static function getSubcategories( $category ) {
        $subcategories = array();
        $options       = self::getOptionsConfig();
        foreach ( $options as $option ) {
            if ( $option[ 'category' ] == $category ) {
                $subcategories[] = $option[ 'subcategory' ];
            }
        }
        return $subcategories;
    }

    protected static function boolval( $val ) {
        return (boolean) $val;
    }

    protected static function arrayval( $val ) {
        if ( is_array( $val ) )
            return $val;
        else if ( is_object( $val ) )
            return (array) $val;
        else
            return array();
    }

    protected static function cast( $val, $type ) {
        if ( $type == self::TYPE_BOOL ) {
            return (intval( $val ) ? 1 : 0);
        } else {
            $castFunction = $type . 'val';
            if ( function_exists( $castFunction ) ) {
                return call_user_func( $castFunction, $val );
            } else if ( method_exists( __CLASS__, $castFunction ) ) {
                return call_user_func( array( __CLASS__, $castFunction ), $val );
            } else {
                return $val;
            }
        }
    }

    protected static function csv_lineval( $value ) {
        if ( !is_array( $value ) )
            $value = explode( ',', $value );
        return $value;
    }

    public static function processPostRequest() {
        $params = array();
        foreach ( $_POST as $name => $optionConfig ) {
            $params[ $name ] = $_POST[ $name ];
            if ( CMPD_Settings::OPTION_PRODUCT_PERMALINK == $name ) {
                $shortcodePageSlug = null;
                $shortcodePageId   = get_option( CMProductDirectory::SHORTCODE_PAGE_OPTION );
                $post              = get_post( $shortcodePageId );
                if ( !empty( $post ) ) {
                    $shortcodePageSlug = $post->post_name;
                }
                if ( !empty( $shortcodePageSlug ) && $params[ $name ] == $shortcodePageSlug && '/' !== substr( $params[ $name ], 0, 1 ) ) {
                    $params[ $name ] = '/' . $params[ $name ]; //add the slash at the beginning to solve problems with mod_rewrite rules
                }
            }
            self::setOption( $name, $params[ $name ] );
        }

        return $params;
    }

    public static function userId( $userId = null ) {
        if ( empty( $userId ) )
            $userId = get_current_user_id();
        return $userId;
    }

    public static function isLoggedIn( $userId = null ) {
        $userId = self::userId( $userId );
        return !empty( $userId );
    }

    public static function getRolesOptions() {
        global $wp_roles;
        $result = array();
        if ( !empty( $wp_roles ) AND is_array( $wp_roles->roles ) )
            foreach ( $wp_roles->roles as $name => $role ) {
                $result[ $name ] = $role[ 'name' ];
            }
        return $result;
    }

    public static function canReportSpam( $userId = null ) {
        return (self::getOption( self::OPTION_SPAM_REPORTING_ENABLED ) AND ( self::getOption( self::OPTION_SPAM_REPORTING_GUESTS ) OR self::isLoggedIn( $userId )));
    }

    public static function getPagesOptions() {
        $pages  = get_pages( array( 'number' => 100 ) );
        $result = array( null => '--' );
        foreach ( $pages as $page ) {
            $result[ $page->ID ] = $page->post_title;
        }
        return $result;
    }

    public static function areAttachmentsAllowed() {
        $ext = self::getOption( self::OPTION_ATTACHMENTS_FILE_EXTENSIONS );
        return (!empty( $ext ) AND ( self::getOption( self::OPTION_ATTACHMENTS_ANSWERS_ALLOW ) OR self::getOption( self::OPTION_ATTACHMENTS_QUESTIONS_ALLOW )));
    }

    public static function getLoginPageURL( $returnURL = null ) {
        if ( empty( $returnURL ) ) {
            $returnURL = get_permalink();
        }
        if ( $customURL = CMPD_Settings::getOption( CMPD_Settings::OPTION_LOGIN_PAGE_LINK_URL ) ) {
            return esc_url( add_query_arg( array( 'redirect_to' => urlencode( $returnURL ) ), $customURL ) );
        } else {
            return wp_login_url( $returnURL );
        }
    }

}
