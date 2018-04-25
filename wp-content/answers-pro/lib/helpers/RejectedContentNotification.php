<?php

class CMA_RejectedContentNotification {
	
	static protected $supportedTypesMap = array(
		CMA_Thread::POST_TYPE => 'question',
		CMA_Answer::COMMENT_TYPE => 'answer',
		CMA_Comment::COMMENT_TYPE => 'comment',
	);
	
	static function plugins_loaded() {
		if (CMA_Settings::getOption(CMA_Settings::OPTION_NOTIF_CONTENT_REJECTED_ENABLE)) {
			add_action(  'transition_post_status',  array(__CLASS__, 'transition_post_status'), 10, 3 );
			add_action('trashed_comment', array(__CLASS__, 'comment_rejected'), 10, 1 );
			add_action('spammed_comment', array(__CLASS__, 'comment_rejected'), 10, 1 );
		}
	}
	
	
	static function transition_post_status( $new_status, $old_status, $post ) {
		if ( $post->post_type == CMA_Thread::POST_TYPE AND $new_status != $old_status AND $old_status == 'pending'
				AND ($new_status == 'trash' OR $new_status == 'spam')) {
			
			if ($thread = CMA_Thread::getInstance($post->ID)) {
				static::sendNotification(CMA_Thread::POST_TYPE, $post->ID, $thread->getAuthorEmail(),
						$thread->getTitle(false), $thread->getContent(), $thread->getCreationDate());
			}
					
		}
	}
	
	
	static function comment_rejected($commentId) {
		$comment = get_comment($commentId);
		if ( in_array($comment->comment_type, array_keys(static::$supportedTypesMap))) {
			
			if (CMA_Answer::COMMENT_TYPE == $comment->comment_type) {
				if ($obj= CMA_Answer::getById($comment->comment_ID)) {
					$authorEmail = $obj->getAuthorEmail();
					if ($thread = $obj->getThread()) {
						$questionTitle = $thread->getTitle(false);
					}
				}
			}
			else if (CMA_Comment::COMMENT_TYPE == $comment->comment_type) {
				if ($obj = CMA_Comment::getById($comment->comment_ID)) {
					$authorEmail = $obj->getAuthorEmail();
					if ($thread = $obj->getThread()) {
						$questionTitle = $thread->getTitle(false);
					}
				}
			}
			
			if (!empty($authorEmail) AND !empty($questionTitle)) {
				static::sendNotification($comment->comment_type, $comment->comment_ID, $authorEmail,
						$questionTitle, $comment->comment_content, $comment->comment_date);
			}
			
		}
	}
	
	
	static function sendNotification($type, $contentId, $email, $questionTitle, $content, $datePosted) {
		
		$subject = CMA_Settings::getOption(CMA_Settings::OPTION_NOTIF_CONTENT_REJECTED_SUBJECT);
		$template = CMA_Settings::getOption(CMA_Settings::OPTION_NOTIF_CONTENT_REJECTED_TEMPLATE);
		
		$fragment = substr(strip_tags($content), 0, 100) . (strlen(strip_tags($content)) > 100 ? '...' : '');
		$vars = array(
			'[blogname]' => get_bloginfo('blogname'),
			'[type]' => (isset(static::$supportedTypesMap[$type]) ? static::$supportedTypesMap[$type] : $type),
			'[question_title]' => $questionTitle,
			'[content]' => strip_tags($content),
			'[fragment]' => $fragment,
			'[date]' => $datePosted,
		);
		
		return CMA_Email::send($email, $subject, $template, $vars);
		
	}
	
	
	
}