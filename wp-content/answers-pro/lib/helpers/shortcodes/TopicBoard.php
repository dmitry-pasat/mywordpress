<?php

class CMA_TopicBoardShortcode {
	
	
	public static function init() {
		if (!CMA::isLicenseOk()) return;
		add_shortcode('cma-board', array(__CLASS__, 'shortcode'));
	}
	
	
	static function shortcode($atts = array()) {
		
		$atts = shortcode_atts(array(
			'showquestions' => 1,
			'questionslimit' => 0,
		), $atts);
		
		CMA_BaseController::loadScripts();
		
		$categories = CMA_Category::getAll();
		
		if ($atts['showquestions']) {
			if ($atts['questionslimit'] > 0) {
				$questionsByCategory = array();
				foreach ($categories as $category) {
					$query = new CMA_QuestionQuery();
					$query->setLimit($atts['questionslimit'])->setCategories(array($category->getSlug()));
					$questions = $query->exec()->getQuestions();
					$questionsByCategory[intval($category->getId())] = $questions;
					
				}
			} else {
				$query = new CMA_QuestionQuery();
				$questions = $query->exec()->getQuestions();
				$questionsByCategory = array();
				foreach ($questions as $thread) {
					$questionsByCategory[intval($thread->getCategoryId())][$thread->getId()] = $thread;
				}
			}
		} else {
			$questionsByCategory = array();
		}
		
		$displayOptions = CMA_Settings::getDisplayOptionsDefaults();
		
		$result = CMA_BaseController::_loadView('answer/widget/board-categories', compact('categories', 'questionsByCategory', 'atts', 'displayOptions'));
		
		return '<div class="cma-topic-board-shortcode">' . $result .'</div>';
		
	}
	
}

add_action('init', array('CMA_TopicBoardShortcode', 'init'), PHP_INT_MAX);
