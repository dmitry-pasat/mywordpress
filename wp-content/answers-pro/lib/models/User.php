<?php

class CMA_User extends WP_User {
	
	
	static function getInstance($userId) {
		return static::get_user_by('id', $userId);
	}
	
	
	static function get_user_by( $field, $value ) {
		$userdata = static::get_data_by( $field, $value );
	
		if ( !$userdata ) return false;

		$user = new static;
		$user->init( $userdata );

		return $user;
	}
	
	
	public function init( $data, $blog_id = '' ) {
		parent::init($data, $blog_id);
		$this->link = static::createAuthorLink($this, true);
		$this->richLink = static::createAuthorLink($this, false);
	}
	
	
	static function createAuthorLink($user, $simple = false) {
		if (empty($user)) return null;
		if (CMA_Settings::getOption(CMA_Settings::OPTION_AUTHOR_LINK_ENABLED)) {
			$url = CMA_BaseController::getContributorUrl($user);
			if( !empty($url) ) $authorLink = sprintf('<a href="%s" class="cma-user-profile-link">%s</a>', esc_attr($url), esc_html($user->display_name));
		}
		if (empty($authorLink)) {
			$authorLink = '<span class="cma-author">' . esc_html($user->display_name) .'</span>';
		}
		if (!$simple) {
			if (static::canSendPrivateQuestion($user->ID)) {
				$authorLink .= ' ' . static::createPrivateQuestionIcon($user->ID);
			}
		}
		return $authorLink;
	}
	
	
	public static function createPrivateQuestionIcon($userId) {
		return sprintf('<a href="#" class="cma-private-question-icon" title="%s" data-user-id="%d"></a>',
				esc_attr(CMA_Labels::getLocalized('send_private_question')),
				intval($userId)
				);
	}
	
	
	public static function canSendPrivateQuestion($targetUserId) {
		$userId = get_current_user_id();
		return (CMA_Settings::getOption(CMA_Settings::OPTION_PRIVATE_QUESTIONS_ENABLED) AND $userId AND $userId != $targetUserId);
	}
	
	
	function getAvatarHtml() {
		$html = null;
		$enabled = CMA_Settings::getOption(CMA_Settings::OPTION_SHOW_GRAVATARS);
		if ($enabled) {
			$html = get_avatar($this->ID, 32);
		}
		
		return apply_filters('cma_user_avatar', $html, $this, $enabled);
		
	}
	
	
}