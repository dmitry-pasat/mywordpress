<?php

class CMA_TopContributorsWidget extends WP_Widget {
	
	const DEFAULT_TITLE = 'Top contributors';
	const DEFAULT_LIMIT = 10;
	
	const DISPLAY_NUMBER_ANSWERS = 'answers';
	const DISPLAY_NUMBER_QUESTIONS = 'questions';
	const DISPLAY_NUMBER_VOTES = 'votes';
	const DISPLAY_NUMBER_RATING = 'rating';
	const DISPLAY_NONE = 'none';
	
	const CACHE_TRANSIENT_PREFIX = 'cma_topconwidget_';
	const CACHE_TIME = 3600;
	

    public function __construct() {
        $widget_ops = array('classname' => 'CMA_TopContributorsWidget', 'description' => 'Show CM Top contributors');
        parent::__construct('CMA_TopContributorsWidget', 'CM Top contributors', $widget_ops);
    }

    public static function getInstance() {
        return register_widget(get_class());
    }

    /**
     * Widget options form
     * @param WP_Widget $instance 
     */
    public function form($instance) {
        if (isset($instance['title'])) {
            $title = $instance['title'];
        } else {
            $title = __(self::DEFAULT_TITLE, 'cm-answers-pro');
        }
        
        $displayNumber = (isset($instance['displayNumber']) ? $instance['displayNumber'] : self::DISPLAY_NUMBER_ANSWERS);
        $limit = isset($instance['limit'])?$instance['limit']:self::DEFAULT_LIMIT;
        $hideAnonymousUser = (!empty($instance['hideAnonymousUser'])) ? 1 : 0;
        
        ?>
        <p>
            <label for="<?php echo esc_attr($this->get_field_name('title')); ?>"><?php _e('Title:'); ?></label> 
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>" name="<?php echo esc_attr($this->get_field_name('title')); ?>" type="text" value="<?php echo esc_attr($title); ?>" />
        </p>
        <p>
            <label for="<?php echo esc_attr($this->get_field_name('limit')); ?>"><?php _e('Count:'); ?></label> 
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id('limit')); ?>" name="<?php echo esc_attr($this->get_field_name('limit')); ?>" type="text" value="<?php echo esc_attr($limit); ?>" />
        </p>
        <p><label for="<?php echo esc_attr($this->get_field_id('displayNumber')); ?>">Display Number of: <select class="widefat" id="<?php echo esc_attr($this->get_field_id('displayNumber')); ?>" name="<?php echo esc_attr($this->get_field_name('displayNumber')); ?>">
        	<option value="<?php echo self::DISPLAY_NONE ?>"<?php selected(self::DISPLAY_NONE, $displayNumber); ?>>don't display</option>
        	<option value="<?php echo self::DISPLAY_NUMBER_ANSWERS ?>"<?php selected(self::DISPLAY_NUMBER_ANSWERS, $displayNumber); ?>>answers</option>
			<option value="<?php echo self::DISPLAY_NUMBER_QUESTIONS ?>"<?php selected(self::DISPLAY_NUMBER_QUESTIONS, $displayNumber); ?>>questions</option>
			<option value="<?php echo self::DISPLAY_NUMBER_RATING ?>"<?php selected(self::DISPLAY_NUMBER_RATING, $displayNumber); ?>>rating</option>
		</select></p>
		<p><label><input type="checkbox" value="1" name="<?php echo esc_attr($this->get_field_name('hideAnonymousUser')); ?>" <?php checked($hideAnonymousUser);?> /> Don't show the anonymous posting user</label>
 
 <?php
    }

    /**
     * Update widget options
     * @param WP_Widget $new_instance
     * @param WP_Widget $old_instance
     * @return WP_Widget 
     */
    public function update($new_instance, $old_instance) {
        $instance = array();
        $instance['title'] = (!empty($new_instance['title']) ) ? strip_tags($new_instance['title']) : '';
        $instance['limit'] = (!empty($new_instance['limit']) ) ? strip_tags($new_instance['limit']) : self::DEFAULT_LIMIT;
        $instance['displayNumber'] = (!empty($new_instance['displayNumber']) ) ? strip_tags($new_instance['displayNumber']) : self::DISPLAY_NUMBER_ANSWERS;
        $instance['hideAnonymousUser'] = (!empty($new_instance['hideAnonymousUser']) ) ? 1 : 0;

        return $instance;
    }

    /**
     * Render widget
     * 
     * @param array $args
     * @param WP_Widget $instance 
     */
    public function widget($args, $instance) {
        
        extract($args, EXTR_SKIP);
        
        if (empty($instance['title'])) $instance['title'] = CMA::__(self::DEFAULT_TITLE);
        if (empty($instance['limit'])) $instance['limit'] = self::DEFAULT_LIMIT;

        $title = apply_filters('widget_title', $instance['title']);
        $limit = $instance['limit'];
        $displayNumber = (isset($instance['displayNumber']) ? $instance['displayNumber'] : self::DISPLAY_NUMBER_ANSWERS);
        $hideAnonymousUser = (!empty($instance['hideAnonymousUser'])) ? 1 : 0;

        echo $before_widget;
        if (!empty($title))
            echo $before_title . $title . $after_title;

        ?>
        
        <div class="cma-tags-container"><?php
            
        	$contributors = $this->getContributors($displayNumber, $limit);
        	$anonymousUserId = apply_filters('cma_anonymous_user_id', 0);
                      
            foreach ($contributors as $c) {
					if ($hideAnonymousUser AND $anonymousUserId == $c->user_id) continue;
                    echo '<div>';
                    if (empty($c->user_id)) {
						echo $c->display_name;
					} else {
						printf('<a href="%s">%s</a>',
							esc_attr(CMA_BaseController::getContributorUrl($c->user_id)),
							esc_html($c->display_name)
						);
                    }
					if ($displayNumber != self::DISPLAY_NONE) {
						printf(' <span>%d %s</span>', intval($c->cnt), strtolower(CMA_Labels::getLocalized($displayNumber)));
					}
                    echo '</div>';
            }

        ?></div>
        <?php
        echo $after_widget;
    }
    
    
    protected function getContributors($displayNumber, $limit) {
		global $wpdb;
		
		$transientName = static::CACHE_TRANSIENT_PREFIX . md5(serialize(array($displayNumber, $limit)));
		$result = get_transient($transientName);
		if (!empty($result)) return $result;

		switch ($displayNumber) {

			case self::DISPLAY_NUMBER_ANSWERS:
				
				$result = $wpdb->get_results($wpdb->prepare("SELECT wu.ID AS user_id, wu.user_nicename,
					IFNULL( wu.display_name, wc.comment_author ) AS display_name,
					count( wc.comment_ID ) AS cnt
					FROM $wpdb->users wu
					LEFT JOIN $wpdb->comments wc ON wu.ID = wc.user_id
					WHERE wc.comment_type = %s
					AND wc.comment_approved = 1
					GROUP BY wu.ID
					ORDER BY cnt DESC
					LIMIT %d", CMA_Answer::COMMENT_TYPE, $limit));
				break;
				
			case self::DISPLAY_NUMBER_QUESTIONS:
				
				$result = $wpdb->get_results($wpdb->prepare("SELECT wu.ID AS user_id, wu.user_nicename,
					wu.display_name,
					count( wp.ID ) AS cnt
					FROM $wpdb->users wu
					LEFT JOIN $wpdb->posts wp ON wu.ID = wp.post_author
					WHERE wp.post_type = %s
					AND wp.post_status = 'publish'
					GROUP BY wu.ID
					ORDER BY cnt DESC
					LIMIT %d", CMA_Thread::POST_TYPE, $limit));
				break;
				
			case self::DISPLAY_NUMBER_RATING:
				
// 				$sql = $wpdb->prepare("SELECT wu.ID AS user_id, wu.user_nicename, wu.display_name,
//         			IFNULL(wcs.ans_sum,0) + IFNULL(wps.post_sum,0) as cnt
// 					FROM $wpdb->users wu
// 					LEFT JOIN (SELECT wc.user_id, SUM(wcm.meta_value) AS ans_sum FROM $wpdb->comments wc JOIN $wpdb->commentmeta wcm ON wcm.comment_id = wc.comment_id WHERE wc.comment_type = %s AND wc.comment_approved = 1 AND wcm.meta_key = %s) wcs ON (wcs.user_id = wu.ID)
// 					LEFT JOIN (SELECT wp.post_author, SUM(wpm.meta_value) AS post_sum FROM $wpdb->posts wp JOIN $wpdb->postmeta wpm ON wpm.post_id = wp.ID WHERE wp.post_type = %s AND wp.post_status = 'publish' AND wpm.meta_key = %s) wps ON (wps.post_author = wu.ID)
// 					ORDER BY cnt DESC
// 					LIMIT %d",
// 					CMA_Answer::COMMENT_TYPE,
// 					CMA_Answer::META_RATING,
// 					CMA_Thread::POST_TYPE,
// 					CMA_Thread::$_meta['rating'],
// 					$limit
// 				);
				
// 				var_dump($sql);exit;
				
				$sql = $wpdb->prepare("SELECT wu.ID AS user_id, wu.user_nicename,
					wu.display_name,
					IFNULL(SUM(IFNULL(wpm.meta_value,0)),0) + IFNULL(SUM(IFNULL(wcm.meta_value,0)),0) AS cnt
					FROM $wpdb->users wu
					LEFT JOIN $wpdb->comments wc ON wu.ID = wc.user_id
					LEFT JOIN $wpdb->commentmeta wcm ON wcm.comment_id = wc.comment_ID AND wcm.meta_key = %s
					LEFT JOIN $wpdb->posts wp ON wu.ID = wp.post_author
					LEFT JOIN $wpdb->postmeta wpm ON wpm.post_id = wp.ID AND wpm.meta_key = %s
					WHERE wc.comment_type = %s
					AND wc.comment_approved = 1
					AND wp.post_type = %s
					AND wp.post_status = %s
					GROUP BY wu.ID
					ORDER BY cnt DESC
					LIMIT %d",
					CMA_Answer::META_RATING,
					CMA_Thread::$_meta['rating'],
					CMA_Answer::COMMENT_TYPE,
					CMA_Thread::POST_TYPE,
					'publish',
					$limit
				);
				$result = $wpdb->get_results($sql);
				break;
				
			default:
				
				$result = $wpdb->get_results($wpdb->prepare("SELECT wu.ID AS user_id, wu.user_nicename,
					wu.display_name
					FROM $wpdb->users wu
					ORDER BY display_name ASC
					LIMIT %d", $limit));
				
		}
		
		set_transient($transientName, $result, static::CACHE_TIME);
		
		return $result;
								
	}

    static public function get_terms_by_post_type($taxonomies, $post_types) {
        global $wpdb;
        $query = $wpdb->prepare("SELECT t.*, COUNT(*) as cnt from $wpdb->terms AS t INNER JOIN $wpdb->term_taxonomy AS tt ON t.term_id = tt.term_id INNER JOIN $wpdb->term_relationships AS r ON r.term_taxonomy_id = tt.term_taxonomy_id INNER JOIN $wpdb->posts AS p ON p.ID = r.object_id WHERE p.post_type IN('" . join("', '", $post_types) . "') AND tt.taxonomy IN('" . join("', '", $taxonomies) . "') GROUP BY t.term_id ORDER BY cnt DESC");
        $results = $wpdb->get_results($query);
        return $results;
    }

    
	static function register() {
		register_widget(__CLASS__);
	}

}


add_action('widgets_init', array('CMA_TopContributorsWidget', 'register'));
