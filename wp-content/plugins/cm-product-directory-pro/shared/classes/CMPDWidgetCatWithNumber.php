<?php

class CMPDWidgetCatWithNumber extends WP_Widget
{
    protected static $filePath = '';
    protected static $cssPath = '';
    public static $lastQueryDetails = array();
    public static $calledClassName;

    public static function init()
    {
        if( empty(self::$calledClassName) )
        {
            self::$calledClassName = __CLASS__;
        }
        self::$filePath = plugin_dir_url(__FILE__);
        self::$cssPath = self::$filePath . '../assets/css/';
    }

    /**
     * Create widget
     */
    public function __construct()
    {
        $widget_ops = array('classname' => 'CMPDWidgetCatWithNumber', 'description' => 'Show each Product Directory Category with number of terms');
        parent::__construct('cmpd_widgetcatwithnumber', 'CM Product Directory - Categories', $widget_ops);
    }

    /**
     * Widget options form
     * @param WP_Widget $instance
     */
    public function form($instance)
    {
        $instance = wp_parse_args((array) $instance, array('title' => '', 'chars' => 20, 'glink' => '', 'showLink' => 'yes', 'show_number' => false ));
        $title = $instance['title'];
        $chars = $instance['chars'];
        $glink = $instance['glink'];
        $showLink = $instance['showLink'];
        ob_start();
        ?>
        <p><label for="<?php echo esc_attr($this->get_field_id('title')); ?>">Title:
            <input class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>" name="<?php echo esc_attr($this->get_field_name('title')); ?>" type="text" value="<?php echo esc_attr($title); ?>" /></label></p>

        <p>
			<label for="<?php echo esc_attr($this->get_field_id( 'show_number' )); ?>">Show items number?
				<input class="widefat" name="<?php echo esc_attr($this->get_field_name( 'show_number' )); ?>" type="hidden" value="0" />
				<input class="widefat" id="<?php echo esc_attr($this->get_field_id( 'show_number' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'show_number' )); ?>" type="checkbox" value="1" <?php checked( '1', esc_attr( $instance[ 'show_number' ] ) ); ?> />
			</label>
		</p>
        <?php
        ob_end_flush();
    }

    /**
     * Update widget options
     * @param WP_Widget $new_instance
     * @param WP_Widget $old_instance
     * @return WP_Widget
     */
    public function update($new_instance, $old_instance)
    {
        $instance 					 = $old_instance;
        $instance['title']			 = $new_instance['title'];
        $instance[ 'show_number' ] = $new_instance[ 'show_number' ];
        return $instance;
    }

    /**
     * Render widget
     *
     * @param array $args
     * @param WP_Widget $instance
     */
    public function widget($args, $instance)
    {
        extract($args, EXTR_SKIP);
        $taxonomy 		= CMProductDirectoryShared::POST_TYPE_TAXONOMY;
        $tax_terms 		= get_terms($taxonomy, array('hide_empty' => false));
        $title 			= empty($instance['title']) ? ' ' : apply_filters('widget_title', $instance['title']);
        $show_number	= !empty( $instance[ 'show_number' ] ) ? $instance[ 'show_number' ] : FALSE;

        ob_start();
        echo $before_widget;
        if( !empty($title) )
        {
            echo $before_title . $title . $after_title;
        }

        self::draw($tax_terms,$show_number);

        echo $after_widget;
        ob_end_flush();
    }

    protected static function draw(&$data,$show_number, $id = 0)
    {
    	echo '<ul>';
        foreach($data as $key => $tax_term)
        {
            if( $tax_term->parent == $id )
            {
                $shortcodePageId = get_option(CMProductDirectory::SHORTCODE_PAGE_OPTION);
                $shortcodePageLink = get_page_link($shortcodePageId);
                $tax_count = $show_number ? ' ('.$tax_term->count.')' : '' ;

                $href = esc_url(add_query_arg(array('cmcats' => $tax_term->slug), $shortcodePageLink));
                $title = $tax_term->name;
                echo '<li>' . '<a href="' . $href . '" class="cm-productLink" title="' . esc_attr($title) . '" ' . '>' . esc_html($tax_term->name . $tax_count) .'</a>';
                $child = $tax_term->term_id;
                unset($data[$key]);
                self::draw($data,$show_number, $child);
                echo '</li>';
            }
        }
        echo '</ul>';
    }
}
