<?php
	class CMPDSingleRandomProduct extends WP_Widget
	{
		protected static $filePath		 = '';
		protected static $cssPath		 = '';
		public static $lastQueryDetails	 = array();
		public static $calledClassName;

		public static function init()
		{
			if ( empty( self::$calledClassName ) )
			{
				self::$calledClassName = __CLASS__;
			}
		
			self::$filePath	 = plugin_dir_url( __FILE__ );
			self::$cssPath	 = self::$filePath . '../assets/css/';
		}

		/**
		 * Create widget
		 */
		public function __construct()
		{
			$widget_ops = array(
				'classname' => 'CMPDSingleRandomProduct',
				'description' => 'Show single random CM Product Directory item'
				);
			
				parent::__construct( 'cmpd_singlerandomproduct', 'CM Product Directory - Random Product', $widget_ops );
		}

		/**
		 * Widget options form
		 * @param WP_Widget $instance
		 */
		public function form( $instance )
		{
			$instance = wp_parse_args( (array) $instance, array( 'title' => '', 'amount' => 3, 'show_category' => FALSE ) );
			ob_start();
			?>
			<p>
				<label for="<?php echo esc_attr($this->get_field_id( 'title' )); ?>">Title:
					<input class="widefat" id="<?php echo esc_attr($this->get_field_id( 'title' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'title' )); ?>" type="text" value="<?php echo esc_attr( $instance[ 'title' ] ); ?>" />
				</label>
			</p>
			<p>
				<label for="<?php echo esc_attr($this->get_field_id( 'amount' )); ?>">Number of items:
					<input class="widefat" id="<?php echo esc_attr($this->get_field_id( 'amount' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'amount' )); ?>" type="text" value="<?php echo esc_attr( $instance[ 'amount' ] ); ?>" />
				</label>
			</p>
			<p>
				<label for="<?php echo esc_attr($this->get_field_id( 'show_category' )); ?>">Show category?
					<input class="widefat" name="<?php echo esc_attr($this->get_field_name( 'show_category' )); ?>" type="hidden" value="0" />
					<input class="widefat" id="<?php echo esc_attr($this->get_field_id( 'show_category' )); ?>" name="<?php echo esc_attr($this->get_field_name( 'show_category' )); ?>" type="checkbox" value="1" <?php checked( '1', esc_attr( $instance[ 'show_category' ] ) ); ?> />
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
		public function update( $new_instance, $old_instance )
		{
			$instance					 = $old_instance;
			$instance[ 'title' ]		 = $new_instance[ 'title' ];
			$instance[ 'amount' ]		 = $new_instance[ 'amount' ];
			$instance[ 'show_category' ] = $new_instance[ 'show_category' ];
			return $instance;
		}

		/**
		 * Render widget
		 *
		 * @param array $args
		 * @param WP_Widget $instance
		 */
		public function widget( $args, $instance )
		{
			if ( CMProductDirectory::$isLicenseOK )
			{
				extract( $args, EXTR_SKIP );

				$title			 = empty( $instance[ 'title' ] ) ? ' ' : apply_filters( 'widget_title', $instance[ 'title' ] );
				$words			 = (!empty( $instance[ 'words' ] ) && is_numeric( $instance[ 'words' ] )) ? $instance[ 'words' ] : 20;
				$amount			 = (!empty( $instance[ 'amount' ] ) && is_numeric( $instance[ 'amount' ] )) ? $instance[ 'amount' ] : 3;
				$show_category	 = (!empty( $instance[ 'show_category' ] )) ? $instance[ 'show_category' ] : FALSE;

				if ( $amount < 1 )
				{
					$amount = 1;
				}

				$mainPageId = get_option( 'cmtt_productID' );

				$queryArgs	 = array(
					'post_type'		 => CMProductDirectoryShared::POST_TYPE,
					'post_status'	 => 'publish',
					'posts_per_page' => $amount,
					'orderby'		 => 'rand',
					'cache_results'	 => false
				);

				$query		 = new WP_Query( $queryArgs );
				$terms		 = $query->get_posts();

				static $include_styles = true;

				ob_start();
				echo $before_widget;
				if ( !empty( $title ) )
					echo $before_title . $title . $after_title;

				if ( empty( $terms ) )
				{
					echo '<p class="error">' . CMProductDirectory::__( 'No products found.' ) . '</p>';
				}
				else
				{
					if ( $include_styles )
					{
						?>
						<style>
							.cmpd_widget_product{
								clear: both;
								margin-bottom: 5px;
								display: flex;
							}
							.cmpd_widget_product_image{
								border: 0px solid #EEE !important;
								box-shadow: none !important;
								margin: 2px 10px 2px 0;
								padding: 3px !important;
								display: inline-block;
							}

							.cmpd_widget_product_title {
								background: none !important;
								clear: none;
								margin-bottom: 0 !important;
								margin-top: 0 !important;
								font-weight: 400;
								font-size: 12px !important;
								line-height: 1.5em;
								display: inline-block;
							}
						</style>
						<?php
					}

					$shortcodePageId = get_option(CMProductDirectory::SHORTCODE_PAGE_OPTION);
					$shortcodePageLink = get_page_link($shortcodePageId);

					foreach ( $terms as $term )
					{
						$productItemImage = '';

						$images = CMProductDirectoryProductPage::getProductGallery( $term->ID );
						if ( !empty( $images ) )
						{
							$image = reset( $images );
							if ( !empty( $image[ 'thumb' ][ 0 ] ) )
							{
								$productItemImage = $image[ 'thumb' ][ 0 ];
							}
						}

						$category = '';
						if ( !empty( $show_category ) )
						{
							$categoriesArr	 = array();
							$tax_terms		 = wp_get_post_terms( $term->ID, CMProductDirectoryShared::POST_TYPE_TAXONOMY, array( 'hide_empty' => false ) );
							foreach ( $tax_terms as $tax_term )
							{
								$categoriesArr[] = $tax_term->name;
							}
							$category = implode( ',', $categoriesArr );
						}
						?>

						<?php $product_thumbnail = !empty( $productItemImage ) ? esc_attr( $productItemImage ) : CMPD_PLUGIN_URL.'frontend/assets/img/default-product-100-100.png' ; ?>

						<div class="cmpd_widget_product">
							<div class="cmpd_widget_product_image">
								<a class="cmpd_widget_product_link" href="<?php echo get_permalink( $term->ID ); ?>">
									<img width="60" height="60" src="<?php echo esc_attr($product_thumbnail); ?>" alt="<?php echo esc_attr($term->post_title); ?>" title="<?php echo esc_attr($term->post_title); ?>" />
								</a>
							</div>

							<div class="cmpd_widget_product_title">
								<a class="cmpd_widget_product_link" href="<?php echo get_permalink( $term->ID ); ?>">
									<b><?php echo esc_html($term->post_title); ?></b>
								</a>

								<?php if ( !empty( $show_category ) )
								{
									?>
									<div class="cmpd_widget_product_category">
									<?php foreach ( $tax_terms as $tax_term )
									{
										$tax_link = esc_url( add_query_arg( array( 'cmcats' => $tax_term->slug ), $shortcodePageLink ) );
										?>
										<a href="<?php echo $tax_link; ?>" class="cm-productLink" title="<?php echo esc_attr($term->name); ?>"><?php echo esc_html($tax_term->name); ?></a>
									<?php } ?>
									</div>
								<?php } ?>
							</div>

							<div class="clearfix"></div>
						</div>
						<?php
					}
				}
				echo $after_widget;
				ob_end_flush();
			}
		}
	}