<?php
	class CMProductDirectoryPROStarRating
	{
		protected static $instance	 	= NULL;
		const CMSR_SHORTCODE_TAG 		= 'cmpd-star-rating'; // shortcode name
		const CMSR_COOKIE_TAG			= 'cm-rating-'; // cookie name (+ post id)
		const CMSR_RATING_META_TAG		= 'cmpd_rating'; // post meta rating key
		const POST_TYPE					= 'cm-Product'; // display rating for this post-types
		const NUMERICAL					= 'cmpd_star_rating_numerical'; // option, bool. Display numerical note if true

		const DISPLAY_COUNT				= 'cmpd_star_rating_display_count';

		static public function getInstance()
		{
			if( empty( self::$instance ) )
			{
				self::$instance = new CMProductDirectoryPROStarRating();
			}
			else
			{
				return self::$instance;
			}
		}

		public function __construct()
		{
			self::registerShortCode();
			add_action( 'wp_loaded', array( __CLASS__, 'ratePost' ) );
			add_action( 'init', array( __CLASS__, 'setCookie' ) );
			add_filter( 'the_content', array( __CLASS__, 'insertStarRating' ) );
		}

		public static function registerShortCode()
		{
			add_shortcode( self::CMSR_SHORTCODE_TAG, array( __CLASS__, 'getRatingData' ) );
		}

		public static function outputRating( $data )
		{
			$star_type 	= self::get_stars_array( $data['rating'] );
			$styles 	= self::getRatingStyles();

			$content = '<ul class="cm-rating"><li class="cm-rating-item"><b>Rating:</b></li>';
			for($i=0; $i<=4; $i++ )
			{
				$content .= self::outputStar( $star_type, $i, $data );
			}
			$content .= $data[ 'show_average' ] != false ? '<li class="cm-rating-item"><b>'.round( $data[ 'rating' ], 1 ).'</b></li>' : '' ;
			$content .= $data[ 'show_count' ]	!= false ? '<li class="cm-rating-item"><b>('.$data[ 'show_count' ].')</b></li>' : '' ;

			$content .= '</ul>';

			return $content.$styles;
		}

		public static function get_stars_array( $rating )
		{
			if ( $rating == 0 )
			{
				$array = array( 'empty', 'empty', 'empty', 'empty', 'empty' );
			}
			else
			{
				$rating = explode( '.', $rating );

				$full = $rating[0];
				$half = isset( $rating[1] ) && $rating >= 5 ? 1 : 0 ;
				$empty = !$half ? 5 - $full : 5 - $full - $half ;
				while( $full > 0 )
				{
					$array[] = 'full';
					$full--;
				}

				if ( $half )
				{
					$array[] = 'half';
				}

				while( $empty > 0 )
				{
					$array[] = 'empty';
					$empty--;
				}
			}
			return $array;
		}

		public static function outputStar( $star_type, $i, $data )
		{
			$current = $star_type[$i];
			$n = $i+1;
			$link_a = $data['allowed'] ? '<a href="?rate='.$n.'&id='.$data['post_id'].'&type='.self::POST_TYPE.'">' : '' ;
			$link_b = $data['allowed'] ? '</a>' : '' ;

			$star = '<li class="cm-rating-item">'.$link_a.'<img src="'.plugin_dir_url( __FILE__ ).'star-rating-assets/img/'.$current.'-star.png" />'.$link_b.'</li>';
			return $star;
		}

		public static function ratePost()
		{
			if ( isset( $_GET[ 'rate' ] ) && isset( $_GET[ 'id' ] ) && isset( $_GET[ 'type' ] ) )
			{
				$new_rate 	= $_GET['rate'];
				$post_id 	= $_GET[ 'id' ];
				$type 		= $_GET[ 'type' ];

				$rating = self::getRating( $post_id );
				$status = self::isAllowToRate( $rating );

				if ( $type === self::POST_TYPE )
				{
					if ( $status ) // check if user is allowed to rate
					{
						if ( $new_rate >= 1 && $new_rate <= 5 )
						{
							array_push( $rating['rates'], $new_rate );

							$rating = self::blockUser( $rating );

							$rating['post_id'] = $post_id;

							update_post_meta( $post_id, self::CMSR_RATING_META_TAG, $rating );

						} // new rate in range
					} // user is allowed
				} // check post-type
			} // get is set
		}

		/**
		 * Check if user is allowed to rate
		 * If logged in user rated already return false
		 * If Cookie exist return false
		 * In other case return true
		 */
		public static function isAllowToRate( $rating )
		{
			if ( is_user_logged_in() ) // user logged in
			{
				// get user id
				$user_id = get_current_user_id();

				if ( !empty( $rating['users'] ) ) // users list not empty
				{
					if ( in_array( $user_id, $rating['users'] ) )
					{
						$status = 0;
					}
					else
					{
						$status = 1;
					}
				}
				else
				{
					$status = 1;
				}
			}
			else // user not logged in
			{
				if ( isset( $_COOKIE[ self::CMSR_COOKIE_TAG.self::POST_TYPE.'-'.$rating['post_id'] ]) )
				{
					$status = 0;
				}
				else
				{
					$status = 1;
				}
			}
			return $status;
		}


		public static function setCookie()
		{
			if ( isset( $_GET[ 'id' ] ) && isset( $_GET[ 'rate' ] ) && isset( $_GET[ 'type' ] ) )
			{
				$type = $_GET[ 'type' ];
				
				if ( $type === self::POST_TYPE )
				{
					$id = $_GET[ 'id' ];
					setcookie( self::CMSR_COOKIE_TAG.$type.'-'.$id, true, time()+2678400 ); // 2678400 = month
				}
			}			
		}


		/**
		 * If user is logged in, then push his ID to array
		 */
		public static function blockUser( $rating )
		{
			// add logged in user id to array
			$user_id = is_user_logged_in() ? get_current_user_id() : false ;
			if ( $user_id )
			{
				if ( !in_array( $user_id, $rating[ 'users' ] ) )
				{
					array_push( $rating[ 'users' ], $user_id );
				}
			}

			return $rating;
		}


		/**
		 * Prepare all datas needed to rate a post
		 */
		public static function getRatingData( $atts )
		{
			global $post;
			$atts = shortcode_atts( array(
				'show_average' => 0
				), $atts
			);

			$rating = self::getRating( get_the_ID() );
			$status = self::isAllowToRate( $rating );

			// prepare array to display rating
			if ( !empty( $rating[ 'rates' ] ) )
			{
				$sum = array_sum( $rating[ 'rates' ] );
				$av_rate = round ( $sum / sizeof( $rating[ 'rates' ] ), 2 );
			}
			else
			{
				$av_rate = 0;
			}

			$show_average = get_option( self::NUMERICAL );
			$show_count   	= get_option( self::DISPLAY_COUNT );
			$show_count 	= false != $show_count ? sizeof( $rating[ 'rates' ] ) : '' ;

			$data = array(
				'allowed'		=> $status,
				'rating'		=> $av_rate,
				'show_average' 	=> $show_average,
				'show_count'	=> $show_count,
				'post_id'		=> $post->ID,
			);

			$content = self::outputRating( $data );

			return $content;
		}

		/*
		 * get rating for current post
		 */
		public static function getRating( $id )
		{
			$rating = get_post_meta( $id, self::CMSR_RATING_META_TAG, true );
			if ( false == $rating )
			{
				$rating = array( 'rates' => array(), 'users' => array(), 'post_id' => $id );
				update_post_meta( $id, self::CMSR_RATING_META_TAG, $rating );
			}

			return $rating;
		}

		/*
		 * insert rating shortcode to glossary post if option set
		 */
		public static function insertStarRating( $content )
		{
			// show/hide rating function
			$is_rating_enabled = get_option( 'cmpd_star_rating' );

			if ( is_singular( self::POST_TYPE ) && false != $is_rating_enabled )
			{
				$content .= '['.self::CMSR_SHORTCODE_TAG.' show_average=1]';
				return $content;
			}
			else
			{
				return $content;
			}
		}

		public static function getRatingStyles()
		{
			$styles = '<style>
				.cm-rating 			{ margin: 0.5em 0; padding: 0 !important; display: block; }
				.cm-rating-item 	{ display: inline; list-style-type: none; margin: auto 0.1em; padding: 0; }
				.cm-rating-item img { padding: 0.75em 0; vertical-align: middle; }				
			</style>';

			return $styles;
		}
	}