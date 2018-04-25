<?php

class CMA_QuestionController extends CMA_BaseController {

	const ACTION_STAGE_CHANGE = 'cma-stage-change';
	
	const PARAM_STAGE = 'question_stage';
	
	
	public static function initialize() {
		
		if (!CMA::isLicenseOk()) return;
		
		add_action('cma_index_question_form', array(__CLASS__, 'indexQuestionForm'), 1000, 3);
		add_filter('template_include', array(__CLASS__, 'overrideTemplate'), PHP_INT_MAX);
		
		if (CMA_Settings::getOption(CMA_Settings::OPTION_QUESTION_STAGES_ENABLE)) {
			add_action('CMA_thread_before', array(__CLASS__, 'showQuestionStage'), 10, 2);
			add_filter('cma_display_question_title', array(__CLASS__, 'getDisplayQuestionTitleWithStage'), 10, 2);
			add_filter('cma_get_question_title', array(__CLASS__, 'getQuestionTitleWithStage'), 10, 3);
			add_action('wp_ajax_cma_question_stage_change', array(__CLASS__, 'ajax_cma_question_stage_change'));
			add_action('pre_get_posts', array(__CLASS__, 'registerStageFilter'), 9999, 1);
			add_action('cma_nav_bar_top', array(__CLASS__, 'displayStageNavBarFilter'));
			if (CMA_Settings::getOption(CMA_Settings::OPTION_QUESTION_LAST_STAGE_DISABLE_ANSWERS)) {
				add_filter('cma_can_post_answers_final', array(__CLASS__, 'canPostAnswersForQuestionStage'), 10, 3);
			}
			if (CMA_Settings::getOption(CMA_Settings::OPTION_QUESTION_LAST_STAGE_DISABLE_COMMENTS)) {
				add_filter('cma_can_post_answers_final', array(__CLASS__, 'canPostAnswersForQuestionStage'), 10, 3);
				add_filter('cma_can_post_comments_final', array(__CLASS__, 'canPostCommentsForQuestionStage'), 10, 3);
			}
		}
			
// 		add_filter('wp_title', function($title) { return 'aaaaaaa';}, PHP_INT_MAX, 1);
// 		add_filter('the_content', array(__CLASS__, 'the_content'), PHP_INT_MAX);
		
	}
	
	
	static function overrideTemplate($template) {
		if (get_query_var('CMA-question-add')) {
			$tempalte = self::prepareSinglePage(
				$title = CMA_Labels::getLocalized('ask_a_question'),
				$content = '',
				$newQuery = true
			);
		}
		
		return $template;
		
	}
	
	
	static function addHeader() {
		
		if (!CMA_Thread::canPostQuestions()) {
			self::addMessage(self::MESSAGE_ERROR, CMA_Labels::getLocalized('msg_cannot_post_question'));
// 			wp_redirect(CMA::getReferer());
// 			exit;
		}
		
		self::loadScripts();
		
	}
	
	
	static function addAction() {
		$content = '';
		if (CMA_Thread::canPostQuestions()) {
			$content = CMA_QuestionFormShortcode::shortcode(array(
				'cat' => CMA_BaseController::_getParam('category')
			));
		}
		else if (!is_user_logged_in()) {
			$content = self::_loadView('answer/widget/login');
		}
		return compact('content');
	}
	
	
	static function testHeader() {
		
	}
	
	
	static function testAction() {
		return array();
	}
	
	
	static function indexQuestionForm($catId, $place, $displayOptions = array()) {
		if (CMA_Settings::getOption(CMA_Settings::OPTION_QUESTION_FORM_BUTTON)) {
			$url = home_url('question/add/');
			if (!empty($displayOptions['formtags'])) {
				$url = add_query_arg('formtags', urlencode($displayOptions['formtags']), $url);
			}
			echo CMA_BaseController::_loadView('answer/widget/question-form-button', compact('url', 'displayOptions'));
		} else {
			$redirectAfterPost = '_thread';
			echo CMA_BaseController::_loadView('answer/widget/question-form', compact('catId', 'displayOptions', 'redirectAfterPost'));
		}
	}
	
	
	static function showQuestionStage($thread, $displayOptions) {
		$currentStage = $thread->getStage();
		if (CMA_Thread::canSetStage()) {
			$stages = CMA_Thread::getPossibleStages();
			$ajaxurl = admin_url('admin-ajax.php');
			$nonce = wp_create_nonce(static::ACTION_STAGE_CHANGE);
			$id = $thread->getId();
			echo static::_loadView('answer/meta/question-stage-select', compact('stages', 'currentStage', 'thread', 'ajaxurl', 'nonce', 'id'));
		} else {
			echo static::_loadView('answer/meta/question-stage', compact('currentStage', 'thread'));
		}
	}
	
	
	static function getDisplayQuestionTitleWithStage($title, $thread) {
		$title = '<span class="cma-question-title-before-stage">' . $title . '<span>';
		$title .= '<span class="cma-question-stage">['. $thread->getStage() .']</span>';
		return $title;
	}
	
	
	static function getQuestionTitleWithStage($title, $thread, $withPrefix) {
		if ($withPrefix) {
			$title .= ' ['. $thread->getStage() .'] ';
		}
		return $title;
	}
	
	
	static function ajax_cma_question_stage_change() {
		$response = array('success' => 0, 'msg' => 'An error occurred.');
		$nonce = filter_input(INPUT_POST, 'nonce');
		if (wp_verify_nonce($nonce, static::ACTION_STAGE_CHANGE) AND CMA_Thread::canSetStage()) {
			$id = filter_input(INPUT_POST, 'id');
			if ($id AND $thread = CMA_Thread::getInstance($id)) {
				$stage = filter_input(INPUT_POST, 'stage');
				$stages = CMA_Thread::getPossibleStages();
				if (in_array($stage, $stages)) {
					$thread->setStage($stage);
					$response = array('success' => 1, 'msg' => 'Stage has been changed.');
				} else {
					$response['msg'] = 'Invalid stage.';
				}
			} else {
				$response['msg'] = 'Unknown thread.';
			}
		}
		header('content-type: application/json');
		echo json_encode($response);
		exit;
	}
	
	
	static function registerStageFilter($query) {
		if( !is_admin() AND $query->is_main_query() AND isset($query->query_vars['post_type']) && $query->query_vars['post_type'] == CMA_Thread::POST_TYPE ) {
			
			$stage = filter_input(INPUT_GET, static::PARAM_STAGE);
			$stages = CMA_Thread::getPossibleStages();
			if (strlen($stage) == 0 OR !in_array($stage, $stages)) return;
			
			$metaQuery = $query->get('meta_query');
			if (!is_array($metaQuery)) $metaQuery = array();
			$addQuery = array(
				'key' => CMA_Thread::$_meta['stage'],
				'value' => $stage,
			);
			if ($stage == CMA_Thread::getDefaultStage()) {
				$addQuery = array(
					'relation' => 'OR',
					$addQuery,
					array(
						'key' => CMA_Thread::$_meta['stage'],
						'compare' => 'NOT EXISTS',
					)
				);
			}
			$metaQuery[] = $addQuery;
			$query->set('meta_query', $metaQuery);
			
		}
	}
	
	
	static function displayStageNavBarFilter() {
		$currentStage = filter_input(INPUT_GET, static::PARAM_STAGE);
		$stages = CMA_Thread::getPossibleStages();
		$fieldName = static::PARAM_STAGE;
		echo static::_loadView('answer/meta/question-stage-nav-bar', compact('currentStage', 'stages', 'fieldName'));
	}
	
	
	static function canPostAnswersForQuestionStage($result, $userId, $thread) {
		if (is_null($userId)) $userId = get_current_user_id();
		if (user_can($userId, 'manage_options')) return $result;
		if ($thread->getStage() == CMA_Thread::getLastStage()) {
			$result = false;
		}
		return $result;
	}
	
	
	static function canPostCommentsForQuestionStage($result, $userId, $obj) {
		if (is_null($userId)) $userId = get_current_user_id();
		if (user_can($userId, 'manage_options')) return $result;
		$thread = null;
		if ($obj instanceof CMA_Thread) {
			$thread = $obj;
		}
		else if ($obj instanceof CMA_Answer) {
			$thread = $obj->getThread();
		}
		if ($thread AND $thread->getStage() == CMA_Thread::getLastStage()) {
			$result = false;
		}
		return $result;
	}
	
	
}
