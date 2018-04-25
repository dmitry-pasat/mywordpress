<?php

class CMA_MicroPaymentsBadges {
	
	
	static function plugins_loaded() {
		if( CMA_MicroPayments::isMicroPaymentsAvailable() ) {
			add_filter('cma_settings_pages_groups', array(__CLASS__, 'addSettingsSubcategory'), 20);
			if (CMA_MicroPayments::isMicroPaymentsConfigured()) { // Setup frontend hooks
				add_filter('cma_get_author', array(__CLASS__, 'cma_get_author'));
				add_filter('cma_contributor_header', array(__CLASS__, 'cma_contributor_header'), 10, 2);
				add_filter('cma_mp_users_badge', array(__CLASS__, 'cma_mp_users_badge'), 10, 2);
			}
		}
	}
	
	
	static function addSettingsSubcategory($subcategories) {
		$subcategories['micropayments']['badges'] = 'Badges';
		return $subcategories;
	}
	
	
	
	static function settingsList($optionName, $optionConfig) {
		$value = CMA_Settings::getOption($optionName);
		if (!is_array($value)) $value = array();
		
		$itemTemplate = '<div class="cma-mp-badge-item" data-badge="%d">
			<div class="cma-mp-badge-item-header"><span>%d</span> badge %s
				<a href="#" class="cma-mp-badge-remove">[remove]</a>
			</div>
			%s
		</div>';
		$fieldTemplate = '<ul>
			<li>Starting from <input type="number" name="'. $optionName .'[points][]" value="%d" /> points</li>
			<li>Title: <input type="text" name="'. $optionName .'[title][]" value="%s" /></li>
			<li data-field="image">Image: <input type="text" name="'. $optionName .'[image][]" value="%s" />
				<input type="button" class="cma-mp-badge-upload" value="Upload" />
				%s
			</li>
			
		</ul>';
		
		$imageTemplate = '<img src="%s" />';
		
		$out = sprintf($itemTemplate, 0, 0, 'for guests', '');
		
		if (empty($value)) {
			$imageUrl = CMA_URL . '/views/resources/imgs/star.png';
			$image = sprintf($imageTemplate, esc_attr($imageUrl));
			$out .= sprintf($itemTemplate, 1, 1, '', sprintf($fieldTemplate, 0, 'First', $imageUrl, $image));
		}
		
		if (!empty($value['points'])) foreach ($value['points'] as $i => $points) {
			if (!empty($value['image'][$i])) {
				$imageUrl = $value['image'][$i];
				$image = sprintf($imageTemplate, esc_attr($imageUrl));
			} else {
				$imageUrl = $image = '';
			}
			$out .= sprintf($itemTemplate, $i+1, $i+1, '',
				sprintf($fieldTemplate, $points, $value['title'][$i], $imageUrl, $image)
			);
		}
		
		$out .= '<div class="cma-mp-badge-add"><a href="#" class="button">Add new</a></div>';
		
		return '<div class="cma-mp-badges-list">' . $out . '</div>';
	}
	
	
	
	static function getBadgeForUser($userId) {
		$mode = CMA_Settings::getOption(CMA_Settings::OPTION_MP_BADGES_MODE);
		if (CMA_Settings::MP_BADGES_MODE_DISABLED != $mode) {
			$points = CMA_MicroPayments::getUserBallance($userId);
// 			var_dump($points);
			$out = '';
			if (CMA_Settings::MP_BADGES_MODE_ACCUMULATIVE == $mode) {
				$list = static::getBadgesList();
				$out = '';
				$index = 0;
				if ($list AND !empty($list['points'])) foreach ($list['points'] as $i => $badgePoints) {
					$badgePoints = intval($badgePoints);
// 					var_dump($badgePoints);
					if ($badgePoints <= $points) {
						$out .= self::getBadgeImage($i);
						$index = $i;
					}
				}
			} else {
				$index = self::getBadgeIndexForPoints($points);
				$out = self::getBadgeImage($index);
			}
			$title = self::getBadgeTitle($index);
			return sprintf('<span class="cma-mp-user-badge" title="%s">%s</span>', esc_attr($title), $out);
		} else {
			return '';
		}
	}
	
	
	
	static function getBadgeIndexForPoints($points) {
		$list = static::getBadgesList();
		$index = 0;
		if ($list AND !empty($list['points'])) foreach ($list['points'] as $i => $badgePoints) {
			if ($badgePoints <= $points) {
				$index = $i;
			} else {
				return $index;
			}
		}
	}
	
	
	static function getBadgesList() {
		return CMA_Settings::getOption(CMA_Settings::OPTION_MP_BADGES_LIST);
	}
	
	
	static function getBadgeImage($index) {
		$list = static::getBadgesList();
		if (isset($list['image'][$index])) {
			return sprintf('<img src="%s" class="cma-mp-badge" />', esc_attr($list['image'][$index]));
		}
	}
	
	
	static function getBadgeTitle($index) {
		$list = static::getBadgesList();
		if (isset($list['title'][$index])) {
			return $list['title'][$index];
		}
	}
	
	
	static function cma_get_author($user) {
		if ($user AND $user->ID) {
			$anonymousUserId = apply_filters('cma_anonymous_user_id', 0);
			if ($user->ID != $anonymousUserId) {
				$user->richLink .= self::getBadgeForUser($user->ID);
			}
		}
		return $user;
	}
	
	
	static function cma_contributor_header($text, $user) {
		return $text . self::getBadgeForUser($user->ID);
	}
	
	
	static function cma_mp_users_badge($html, $userId) {
		return self::getBadgeForUser($userId);
	}
	
	
}
