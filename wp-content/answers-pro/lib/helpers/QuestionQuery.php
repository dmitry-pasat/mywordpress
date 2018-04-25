<?php

class CMA_QuestionQuery {
	
	protected $wp_query;
	protected $resultIds = array();
	
	protected $limit = -1;
	protected $categories = array();
	protected $tags = array();
	protected $author = null;
	protected $contributor = null;
	protected $answered = null;
	protected $resolved = null;
	protected $order = 'post_date';
	protected $sort = 'DESC';
	protected $search = '';
	protected $status = 'publish';
	protected $page = 1;
	protected $myQuestions = false;
	
	protected $customWhereCallback;
	
	
	
	function exec() {
		
		$questionsArgs = array(
			'post_type' => CMA_Thread::POST_TYPE,
			'post_status' => $this->status,
			'posts_per_page' => $this->limit,
			'paged' => $this->page,
			'fields' => 'ids',
			'tag' => $this->tags,
			'search' => $this->search,
			'widget' => true,
		);
		
		// Show resolved or not resolved
		if (!is_null($this->resolved)) {
			$questionsArgs['meta_query'] = array(array(
				'key' => CMA_Thread::$_meta['resolved'],
				'value' => intval($this->resolved),
			));
		}
		
		// Show only my questions
		if ($this->myQuestions) {
			$questionsArgs['user_questions'] = 1;
		}
		
		// Author filter
		if ($this->author) {
			if (!is_numeric($this->author)) {
				if ($user = get_user_by('slug', $this->author)) {
					$this->author = $user->ID;
				} else {
					$this->author = null;
				}
			}
			$questionsArgs['author'] = $this->author;
		}
		
		// Contributor filter
		if(!empty($this->contributor) AND !is_numeric($this->contributor)) {
			if ($user = get_user_by('slug', $this->contributor)) {
				$this->contributor = $user->ID;
			} else {
				$this->contributor = null;
			}
		}
		
		$currentCategoryId = null;
		$category = null;
		if(!empty($this->categories)) {
			$categories = array_filter($this->categories);
			$categoriesSlugs = array();
			foreach ($categories as $i => $cat) {
				if (!is_scalar($cat)) continue;
				if (preg_match('/^[0-9]+$/', $cat)) {
					$category = get_term($cat, CMA_Category::TAXONOMY);
					$categoriesSlugs[] = $category->slug;
					$catId = $cat;
				}
				else if ($category = get_term_by('slug', trim($cat), CMA_Category::TAXONOMY)) {
					$catId = $category->term_id;
					$categoriesSlugs[] = $category->slug;
				} else {
					$catId = false;
				}
				if ($catId) {
					$currentCategoryId = $catId;
					if (empty($questionsArgs['tax_query'][0])) {
						$questionsArgs['tax_query'][0] = array(
							'taxonomy' => CMA_Category::TAXONOMY,
							'field' => 'term_id',
							'terms' => array($catId),
						);
					} else {
						$questionsArgs['tax_query'][0]['terms'][] = $catId;
					}
				}
			}
			$this->categories = $categoriesSlugs;
// 			$atts['cat'] = implode(',', $categoriesSlugs);
		}
		
		$that = $this;
		$this->customWhereCallback = function($val) use ($that) {
			global $wpdb;
			if (!is_null($that->answered)) {
				$val .= CMA_AnswerController::registerCommentsFiltering($val, ($that->answered ? 'ans' : 'unans'));
			}
			if (!empty($that->contributor)) {
				$val .= $wpdb->prepare(" AND (post_author = %d OR ID IN (
					SELECT wc.comment_post_ID FROM $wpdb->comments wc
					WHERE wc.user_id = %d
					AND wc.comment_approved = 1
				))", $that->contributor, $that->contributor);
			}
			$val .= " AND $wpdb->posts.ID IS NOT NULL";
			return $val;
		};
		
		$questionsArgs = apply_filters('cma_questions_query_args', $questionsArgs, $this);
        add_filter('posts_where_request', $this->customWhereCallback);
		add_filter('posts_where_request', array('CMA_AnswerController', 'categoryAccessFilter'));
        $this->wp_query = CMA_Thread::customOrder(new WP_Query(), $this->sort);
		foreach ($questionsArgs as $key => $val) {
			$this->wp_query->set($key, $val);
		}
		
		$this->fetchIds();
		
// 		var_dump($this->resultIds);
		
		return $this;
		
	}
	
	
	
	protected function fetchIds() {
		$this->resultIds = $this->wp_query->get_posts();
		remove_filter('posts_where_request', $this->customWhereCallback);
		remove_filter('posts_where_request', array('CMA_AnswerController', 'categoryAccessFilter'));
		return $this->resultIds;
	}
	
	
	function getIds() {
		return $this->resultIds; 
	}
	
	
	function getQuestions() {
		return array_map(array('CMA_Thread', 'getInstance'), $this->getIds());
	}
	
	
	
	function setLimit($limit) {
		$this->limit = $limit;
		return $this;
	}
	
	
	function setAuthor($author) {
		$this->author = $author;
		return $this;
	}
	
	
	function setContributor($contributor) {
		$this->contributor = $contributor;
		return $this;
	}
	
	
	function setCategories(array $categories) {
		$this->categories = $categories;
		return $this;
	}
	
	
	function setTags(array $tags) {
		$this->tags = $tags;
		return $this;
	}
	
	
	function setAnswered($answered) {
		$this->answered = $answered;
		return $this;
	}
	
	
	function setResolved($resolved) {
		$this->resolved = $resolved;
		return $this;
	}
	
	
	function setSort($sort) {
		$this->sort = $sort;
		return $this;
	}
	
	
	function setOrder($order) {
		$this->order = $order;
		return $this;
	}
	
	
	function setSearch($search) {
		$this->search = $search;
		return $this;
	}
	
	
	function setStatus($status) {
		$this->status = $status;
		return $this;
	}
	
	
	function setPage($page) {
		$this->page = $page;
		return $this;
	}
	
	
	function myQuestions($val) {
		$this->myQuestions = $val;
		return $this;
	}
	
	
	function getWpQuery() {
		return $this->wp_query;
	}
	
	
}