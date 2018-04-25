<?php

$cminds_plugin_config = array(
    'plugin-is-pro'            => TRUE,
    'plugin-has-addons'        => TRUE,
    'plugin-addons'            => array(
        array( 'title' => 'Product Directory Community', 'description' => 'Let WordPress users add, manage and claim their listing in the product directory.', 'link' => 'https://www.cminds.com/wordpress-plugins-library/product-directory-community-submissions-plugin-for-wordpress-by-creativeminds/', 'link_buy' => 'https://www.cminds.com/checkout/?edd_action=add_to_cart&download_id=99033&wp_referrer=https://www.cminds.com/checkout/&edd_options[price_id]=1' ),
        array( 'title' => 'Product Directory Payments', 'description' => 'Support charging payment for publishing a new product directory listing or renewing an existing one.', 'link' => 'https://www.cminds.com/wordpress-plugins-library/product-directory-plugin-for-wordpress-by-creativeminds/', 'link_buy' => 'https://www.cminds.com/checkout/?edd_action=add_to_cart&download_id=105711&wp_referrer=https://www.cminds.com/checkout/&edd_options[price_id]=1' ),
    ),
    'plugin-is-addon'          => FALSE,
    'plugin-shortcodes'        => '<article class="cm-shortcode-desc">
    <header>
        <h4>[cmpd_single_product]</h4>
        <span>Single product shortcode</span>
    </header>
    <div class="cm-shortcode-desc-inner">
        <h5>Parameters:</h5>
        <ul>
            <li><strong>slug</strong> - The slug of the product</li>
        </ul>
        <h5>Example</h5>
        <p><kbd>[cmpd_single_product slug="product-slug"]</kbd></p>
        <p>The shortcode shows the single product based on the slug passed as a parameter.</p>
    </div>
</article>

<article class="cm-shortcode-desc">
    <header>
        <h4>[cmpd_product]</h4>
        <span>Product Directory Shortcode</span>
    </header>
    <div class="cm-shortcode-desc-inner">
        <h5>Parameters:</h5>
        <ul>
            <li><strong>view</strong> - the id of the view from the following: <code>tiles, list, directory</code>(defaults to: <code>tiles</code>)</li>
            <li><strong>hidesearch</strong> - whether to show the search field. Value should be 1 or 0</li>
            <li><strong>hidecategories</strong> - whether to show the categories filter. Value should be 1 or 0.</li>
            <li><strong>hidecustomtaxonomies</strong> - whether to show the Custom Taxonomy filter. Value should be 1 or 0.</li>
            <li><strong>hidetags</strong> - whether to show the tags filter. Value should be 1 or 0.</li>
            <li><strong>hidesearchby</strong> - whether to show the Search by City/ZIP/State field. Value should be 1 or 0.</li>
            <li><strong>row_product</strong> - number of the product in the row (<code>tiles</code> view only).</li>
            <li><strong>page_product</strong> - number of the product on one page.</li>
            <li><strong>cats</strong> - the slug of the catagory from which the product should be displayed.</li>
            <li><strong>customtax</strong> - the slug of the Custom Taxonomy from which the product should be displayed.</li>
            <li><strong>tags</strong> -the name of the tag the product displayed should have.
            <li><strong>only_relevant</strong> - use 1 if you like only to display the categories associated with productes in the directory. Value should be 1 or 0.</li>
            <li><strong>product_ids</strong> - the IDs of the product you only want to show in directory. Value should be an ID, or comma separated IDs.</li>
            <li><strong>exclude_ids</strong> - the IDs of the product you want to exclude from displaying in directory. Value should be an ID, or comma separated IDs.</li>
        </ul>
        <h5>Example</h5>
        <p><kbd>[cmpd_product showfilter="1" row_product="3" cats="1" only_relevant="0" tags="tagname" product_ids="1,3,5" exclude_ids="2,4" ]</kbd></p>
        <p>Shows the Product Directory index. Used without parameters it will display the main index without filtering based on the Settings. Passing arguments allow to deeply customise
        what is displayed</p>
    </div>
</article>

<article class="cm-shortcode-desc">
    <header>
        <span>Product Page shortcodes</span>
    </header>
    <div class="cm-shortcode-desc-inner">
        <h5>Shortcodes:</h5>
        <ul>
            <li><strong>[cmpd_categories]</strong> - displays the categories and tags box.</li>
            <li><strong>[cmpd_post_title]</strong> - displays post title</li>
            <li><strong>[cmpd_post_content]</strong> - displays post content.</li>
            <li><strong>[cmpd_featured_image]</strong> - display featured image.</li>
            <li><strong>[cmpd_back_to_index_link]</strong> - displays back link.</li>
        </ul>
        <h5>Usage:</h5>
        <p>These shortcodes can only be used on the Product Page theme.</p>
    </div>
</article>',
    'plugin-version'           => '1.1.11',
    'plugin-abbrev'            => 'cmpd',
    'plugin-short-slug'        => 'product-directory',
    'plugin-settings-url'      => admin_url( 'edit.php?post_type=cm-product&page=cm-product-directory-settings' ),
    'plugin-parent-short-slug' => '',
    'plugin-file'              => CMPD_PLUGIN_FILE,
    'plugin-dir-path'          => plugin_dir_path( CMPD_PLUGIN_FILE ),
    'plugin-dir-url'           => plugin_dir_url( CMPD_PLUGIN_FILE ),
    'plugin-basename'          => plugin_basename( CMPD_PLUGIN_FILE ),
    'plugin-icon'              => '',
    'plugin-name'              => CMPD_NAME,
    'plugin-license-name'      => CMPD_NAME,
    'plugin-slug'              => '',
    'plugin-menu-item'         => 'edit.php?post_type=' . CMProductDirectoryShared::POST_TYPE,
    'plugin-textdomain'        => CMPD_SLUG_NAME,
    'plugin-userguide-key'     => '684-cm-product-directory-cmpd',
    'plugin-store-url'         => 'https://www.cminds.com/wordpress-plugins-library/product-directory-plugin-for-wordpress-by-creativeminds/',
    'plugin-review-url'        => '',
    'plugin-changelog-url'     => CMPD_RELEASE_NOTES,
    'plugin-licensing-aliases' => array(),
);
