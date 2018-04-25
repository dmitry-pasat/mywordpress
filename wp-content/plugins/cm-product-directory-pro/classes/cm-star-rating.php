<?php
if ( !class_exists('CMStarRating')){
    class CMStarRating{

        protected static $instance = NULL;
        protected $config          = NULL;
        protected $class_tag       = 'cm_star_rating';

        public function __construct($config) {

            $this->config = $config;
            $this->registerShortCode();
            add_action('wp_loaded', array($this, 'ratePost'));
            add_action('init', array($this, 'setCookie'));
            add_filter('the_content', array($this, 'insertStarRating'));
            add_action('wp_enqueue_scripts', array($this, 'register_plugin_styles'));
            add_action('admin_enqueue_scripts', array($this, 'register_plugin_dashboard_styles'));

            add_filter($this->config['filters_avaliable_shortcodes'], array($this, 'avaliable_shortcodes'));

            add_filter($this->config['filters_settings'], array($this, 'addSettings'));
            add_filter($this->config['filters_category'], array($this, 'addCategory'));
            add_filter($this->config['filters_settings_subcategory'], array($this, 'addSubcategory'));

            // Metabox to manage rating on each Post editor page
            add_action( 'add_meta_boxes', array($this, 'add_manage_ratings_metabox'), 10, 1 );

            // Ajax Delete
            add_action('wp_ajax_ajaxDeleteRate', array($this, 'ajaxDeleteRate'));

            // Ajax Add
            add_action('wp_ajax_ajaxAddRate', array( $this, 'ajaxAddRate' ));

            // Save post
            add_action( 'save_post', array($this, 'save_post_ratings' ));
        }

        public function ajaxDeleteRate(){
            $post_id = $_POST['post_id'];
            $rate_id = $_POST['rate_id'];

            $ratings = $this->getRatings($post_id);
            unset($ratings[$rate_id]);
            update_post_meta( $post_id, $this->class_tag, $ratings );
            $this->manage_ratings_table($ratings, $post_id);
            die();
        }

        public function ajaxAddRate(){
            $post_id  = $_POST['post_id'];
            $new_rate = $_POST['new_rate'];
            $ratings = $this->getRatings($post_id);

            if ( $new_rate >= 1 && $new_rate <= 5 ){
                $user_ip = $_POST['user_ip'];
                $user_id = !empty($_POST['user_id']) && is_numeric($_POST['user_id']) ? $_POST['user_id'] : '' ;

                $ratings[] = array(
                    'rate' => $new_rate,
                    'id'   => $user_id,
                    'ip'   => $user_ip,
                    'date' => date('H:i:s d-m-Y')
                );
                update_post_meta( $post_id, $this->class_tag, $ratings );
            }

            $this->manage_ratings_table($ratings, $post_id);
            die();
        }

        public function addCategory($tabs){
            $tabs['cm-star-rating'] = 'CM Star Rating Settings';
            return $tabs;
        }

        public function addSubcategory($tabs){
            $tabs['cm-star-rating']['section'] = 'Section 1';
            return $tabs;
        }

        // Settings
        public function addSettings($settings)
        {
            $settings[$this->config['prefix'].'_rating_enabled'] = array(
                'type'        => 'bool',
                'default'     => false,
                'category'    => 'cm-star-rating',
                'subcategory' => 'section',
                'title'       => 'Enable Star Rating System',
                'desc'        => 'Select this option if you want to use the Star Rating System.',
            );
            $settings[$this->config['prefix'].'_rating_display_numerical'] = array(
                'type'        => 'bool',
                'default'     => false,
                'category'    => 'cm-star-rating',
                'subcategory' => 'section',
                'title'       => 'Display numerical rate',
                'desc'        => 'Select this option if you want to display numerical average rate near rating.',
            );
            $settings[$this->config['prefix'].'_rating_display_count']  = array(
                'type'        => 'bool',
                'default'     => false,
                'category'    => 'cm-star-rating',
                'subcategory' => 'section',
                'title'       => 'Display number of rates',
                'desc'        => 'Set this option if you want to display the number of rates for the post.',
            );
            $settings[$this->config['prefix'].'_rating_display_on_top'] = array(
                'type'        => 'bool',
                'default'     => false,
                'category'    => 'cm-star-rating',
                'subcategory' => 'section',
                'title'       => 'Display star rating on top of sidebar',
                'desc'        => 'Set this option if you want to display star rating on the top part of the sidebar. Otherwise star rating wil be displayed on the bottom.',
            );
            $settings[$this->config['prefix'].'_blocked_ip'] = array(
                'type'        => 'textarea',
                'default'     => '',
                'category'    => 'cm-star-rating',
                'subcategory' => 'section',
                'title'       => 'Block IP',
                'desc'        => 'Write IPs to block users. User ";" as separator, e.g. 100.200.300; 100.200.301',
            );
            return $settings;
        }

        public function register_plugin_styles() {
            wp_register_style($this->class_tag, plugin_dir_url( __FILE__ ) . 'assets/css/cm-star-rating.css');
             wp_enqueue_style($this->class_tag);
        }

        public function register_plugin_dashboard_styles() {
            wp_register_style($this->class_tag, plugin_dir_url( __FILE__ ) . 'assets/css/cm-star-rating-dashboard.css');
             wp_enqueue_style($this->class_tag);

            wp_enqueue_script( 'cm-star-rating-js', plugin_dir_url(__FILE__).'assets/js/cm-star-rating-js.js');

            // AJAX
            $data[ 'ajaxurl' ] = admin_url( 'admin-ajax.php' );
            wp_localize_script( 'cm-star-rating-js', 'cmsr_data', $data );
        }

        public function avaliable_shortcodes($output) {
            $output .= '<br /><li><b>CM Star Rating Shortcode attributes:</b> <span class="cm_shortcode_quote">['.$this->class_tag.']</span>
            <ul>
                <li>* <em>ratingfor</em> - whether to show rating for specific post (post ID)</li>
                <li>* <em>disablerating</em> - whether to disable rating ("1" to disable)</li>
                <li>* <em>hideaverage</em> - whether to hide average rate ("1" to disable)</li>
                <li>* <em>hidecount</em> - whether to hide ratings count ("1" to disable</li>
            </ul></li>';
            return $output;
        }

        public function registerShortCode() {
            add_shortcode($this->config['prefix'].'_'.$this->class_tag, array($this, 'display_rating'));
        }

        public function get_stars_array($rating) {
            if ($rating == 0) {
                $array = array('empty', 'empty', 'empty', 'empty', 'empty');
            } else {
                $rating = explode('.', $rating);

                $full = $rating[0];
                $half = isset($rating[1]) && $rating >= 5 ? 1 : 0;
                $empty = !$half ? 5 - $full : 5 - $full - $half;
                while ($full > 0) {
                    $array[] = 'filled';
                    $full--;
                }

                if ($half) {
                    $array[] = 'half';
                }

                while ($empty > 0) {
                    $array[] = 'empty';
                    $empty--;
                }
            }
            return $array;
        }

        public function outputStar($star_type, $i, $data) {
            $current = $star_type[$i];
            $n = $i + 1;

            $link_a = $data['allowed'] ? '<a href="'.get_post_permalink($data['post_id']).'?rate=' . $n . '&id=' . $data['post_id'] . '&type=' . $this->config['post_type'] . '">' : '';
            $link_b = $data['allowed'] ? '</a>' : '';

            $star = '<li class="cm-rating-item">' . $link_a . '<span class="dashicons dashicons-star-' . esc_attr($current) . '"></span>' . $link_b . '</li>';
            return $star;
        }

        /**
         * Add Metabox to manage ratings for each post on edit page
         */
        public function add_manage_ratings_metabox()
        {
            add_meta_box( 'manage-ratings-metabox', 'Manage Post Ratings', array($this,'manage_ratings_metabox') );
        }

        /**
         * Display metabox with ratings to manage
         */
        public function manage_ratings_metabox()
        {
            global $post;
            $ratings = $this->getRatings($post->ID);
            $this->manage_ratings_table($ratings, $post->ID);
        }

        public function manage_ratings_table($ratings, $post_id ){
            echo empty($ratings) ? '<p>No ratings to display.</p>' : '';
            ?>

            <table class="manage_ratings_table">
            <tbody>
            <?php if ( !empty($ratings) ){ ?>
                <tr>
                    <th class="cmsr_10_cell">Rate</th>
                    <th class="cmsr_26_cell">User name</th>
                    <th class="cmsr_26_cell">User IP</th>
                    <th class="cmsr_26_cell">Date</th>
                    <th class="cmsr_10_cell">Actions</th>
                </tr>

                <?php foreach ( $ratings as $key=>$rate ){
                    $user = 'Anonymous';
                    if ( !empty($rate['id']) ){
                        $user_info = get_userdata($rate['id']);
                        if ( $user_info ){
                            $user = '<a href="'.get_edit_user_link( $rate['id'] ).'">'.$user_info->user_login.'</a>';
                        }
                    }
                ?>
                <tr>
                    <td><input type="text" id="" name="cm_star_rating[<?php echo $key; ?>]" value="<?php echo $rate['rate']; ?>" /></td>
                    <td><?php echo $user; ?></td>
                    <td><?php echo $rate['ip']; ?></td>
                    <td><?php echo $rate['date']; ?></td>
                    <td><input type="button" value="Delete" class="cmsr_delete_rate" data-rate_id="<?php echo $key; ?>" data-post_id="<?php echo $post_id; ?>" /></td>
                </tr>
                <?php } ?>
            <?php } // if $ratings not empty ?>
                <tr>
                    <td><input type="number" id="new_rate" name="new_rate" placeholder="Rate: 1-5" /></td>
                    <td><input type="text" id="user_id" name="user_id" placeholder="User ID" /></td>
                    <td><input type="text" id="user_ip" name="user_ip" placeholder="User IP" /></td>
                    <td></td>
                    <td><input type="button" value="Add" class="cmsr_add_rate" data-post_id="<?php echo $post_id; ?>" /></td>
                </tr>
            </tbody>
            </table>
        <?php }

        /**
         * Prepare all datas needed to rate a post
         */
        public function display_rating($atts)
        {
            $content = '';
            global $post_type;
            $is_rating_enabled = $this->is_star_rating_enabled();

            if ( $post_type === $this->config['post_type'] && $is_rating_enabled )
            {
                global $post;

                $rating_for_id = !empty($atts['ratingfor']) ? $atts['ratingfor'] : $post->ID;

                // get ratings
                $ratings = $this->getRatings($rating_for_id);

                // get status
                $status = $this->getUserStatus($ratings, $post->ID, $atts );

                // prepare array to display rating
                $ratings_notes  = array();
                $sum_ratings    = 0;
                $average_rating = 0;
                if ( !empty($ratings) ){
                    foreach ( $ratings as $rate )
                    {
                        array_push($ratings_notes, $rate['rate']);
                    }

                    $sum_rating     = array_sum($ratings_notes);
                    $average_rating = round($sum_rating / sizeof($ratings_notes), 2);
                }

                $show_average = get_option($this->config['prefix'].'_rating_display_numerical');
                $show_count   = get_option($this->config['prefix'].'_rating_display_count');
                $show_count   = false != $show_count ? sizeof($ratings_notes) : '';

                $data = array(
                    'allowed'      => $status,
                    'rating'       => $average_rating,
                    'show_average' => $show_average,
                    'show_count'   => $show_count,
                    'post_id'      => $post->ID,
                );

                $content = $this->outputRating($data, $atts);
            }
            return $content;
        }

        public function outputRating($data, $atts) {

            $hide_average = isset($atts['hideaverage']) ? 1 : 0;
            $hide_count   = isset($atts['hidecount']) ? 1 : 0;

            $star_type = $this->get_stars_array($data['rating']);
            $content   = '<div class="cm_star_rating_container">';
            $content  .= !$hide_average && $data['show_average'] != false ? '<p class="cm_star_rating_average">' . round($data['rating'], 1) . '</p>' : '';
            $content  .= '<ul class="cm_star_rating_stars">';
            for ($i = 0; $i <= 4; $i++) {
                $content .= $this->outputStar($star_type, $i, $data);
            }
            $content .= '</ul>';
            $ratings_string = $data['show_count'] > 1 ? 'Ratings' : 'Rating';
            $content .=!$hide_count && $data['show_count'] != false ? '<p class="cm_star_rating_count">(' . esc_html($data['show_count']) . ' ' . $ratings_string . ')</p>' : '';
            $content .= '</div>';

            return $content;
        }

        public function ratePost() {
            if (isset($_GET['rate']) && isset($_GET['id']) && isset($_GET['type'])) {
                $new_rate = $_GET['rate'];
                $post_id  = $_GET['id'];
                $type     = $_GET['type'];

                // get ratings
                $ratings = $this->getRatings($post_id);

                // get status
                $status = $this->getUserStatus($ratings, $post_id );

                if (($type === $this->config['post_type']) && $status && ($new_rate >= 1 && $new_rate <= 5)) {

                    $ratings[] = array(
                        'rate' => $new_rate,
                        'ip'   => $this->get_user_ip(),
                        'date' => date('H:i:s d-m-Y'),
                        'id'   => is_user_logged_in() ? get_current_user_id() : ''
                    );

                    $this->setCookie();

                    update_post_meta($post_id, $this->class_tag, $ratings);
                }
            } // get is set
        }

        /**
         * Check if user is allowed to rate
         * If logged in user rated already return false
         * If Cookie exist return false
         * In other case return true
         * ratings array | ratings enabled|disabled
         */
        public function getUserStatus($ratings, $post_id, $atts=null)
        {
            // check if ratings not disabled
            if ( $atts !== null ) {
                if ( !empty($atts['disablerating']) && $atts['disablerating'] === 1 ) {
                    $status = 0;
                    return;
                }
            }

            // check blocked ips
                $blocked_ips = get_option($this->config['prefix'].'_blocked_ip');
                $blocked_ips = str_replace(' ', '', $blocked_ips);
                $blocked_ips = explode(';', $blocked_ips);
                $user_ip     = $this->get_user_ip();
                foreach ( $blocked_ips as $ip ){
                    if ( $user_ip === $ip ){
                        $status = 0;
                        return;
                    }
                }

            if ( is_user_logged_in() ) { // check status for logged in user

                // check if user ID is in the array
                $status = $this->find_user_in_ratings_array($ratings, 'id');

            } else { // check status for logged out user

                // check if COOKIE exist
                $cookie_tag    = $this->class_tag.'-'.$this->config['post_type'].'-'.$post_id;
                $cookie_status = isset($_COOKIE[$cookie_tag]) ? 0 : 1 ;



                // check if users IP is in the array
                $ip_status = $this->find_user_in_ratings_array($ratings, 'ip');
                $status = $cookie_status && $ip_status ? 1 : 0;
            }
            return $status;
        }

        /**
         * Search for user IP in ratings array. If sucess status = 1, else = 0
         * @param $ratings - array with ratings
         * @param $type - id|ip to search by keys in $ratings array
         */
        public function find_user_in_ratings_array($ratings, $type) {
            $status = 1;
            $user = $type == 'ip' ? $this->get_user_ip() : get_current_user_id() ;
            foreach( $ratings as $rating ) {
                if ( $rating[$type] == $user ){
                    $status = 0;
                    return $status;
                }
            }
            return $status;
        }

        public function get_user_ip()
        {
            $ip = getenv('HTTP_CLIENT_IP')?:
            getenv('HTTP_X_FORWARDED_FOR')?:
            getenv('HTTP_X_FORWARDED')?:
            getenv('HTTP_FORWARDED_FOR')?:
            getenv('HTTP_FORWARDED')?:
            getenv('REMOTE_ADDR');

            return $ip;
        }

        public function setCookie() {
            if (isset($_GET['id']) && isset($_GET['rate']) && isset($_GET['type'])) {
                $type = $_GET['type'];

                if ($type === $this->config['post_type']) {
                    $id = $_GET['id'];
                    setcookie($this->class_tag .'-'. $type . '-' . $id, true, time() + 2678400); // 2678400 = month
                }
            }
        }

        /**
         * get rating for current post
         * @param $id = post ID
         */
        public function getRatings($id) {
            $ratings = get_post_meta($id, $this->class_tag, true);

            // Import from older version
            $ratings = $this->importOlderArray($ratings);

            if ( !$ratings ) {
                $ratings = array();
                update_post_meta( $id, $this->class_tag, $ratings );
            }

            return $ratings;
        }

        public function importOlderArray($ratings){

            if ( !empty($ratings) ){
                // Check if array needs to be changed
                if ( isset($ratings['rates']) || isset($ratings['users']) ){
                    if ( !empty($ratings['rates'])) {
                        $new_ratings = array();
                        foreach ( $ratings['rates'] as $rate ) {
                            $new_ratings[] = array(
                                'rate' => $rate,
                                'id'    => '',
                                'ip'    => '',
                                'date'  => '',
                            );
                        }
                        $ratings = $new_ratings;
                    } else {
                        $ratings = array();
                    }
                }
            }
            return $ratings;
        }

        /*
         * insert rating shortcode to glossary post if option set
         */
        public function insertStarRating($content) {
            $is_enabled = $this->is_star_rating_enabled();
            if (is_singular($this->config['post_type']) && false != $is_enabled) {
                $content .= '[' . $this->class_tag . ' show_average=1]';
                return $content;
            } else {
                return $content;
            }
        }

        public function is_star_rating_enabled()
        {
            $bool = get_option($this->config['prefix'].'_rating_enabled');
            return $bool;
        }

        /**
         * While updating a post save ratins
         */
        public function save_post_ratings($post_id){
            global $post_type;
            if ( $post_type == $this->config['post_type'] && isset($_POST['cm_star_rating']) ){
                $ratings = $this->getRatings($post_id);
                $new_ratings = $_POST['cm_star_rating'];

                foreach ($new_ratings as $key=>$new_rate){
                    if ( $new_rate >= 1 && $new_rate <= 5){
                        $ratings[$key]['rate'] = $new_rate;
                    }
                }

                update_post_meta( $post_id, 'cm_star_rating', $ratings );
            }
        }
    }
}