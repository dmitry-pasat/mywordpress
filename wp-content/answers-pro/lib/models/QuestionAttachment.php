<?php

class CMA_QuestionAttachment extends CMA_Attachment {
	
	
	
	public static function selectForQuestion(CMA_Thread $thread) {
		$ids = $thread->getAttachmentsIds();
		if (!empty($ids)) {
			return parent::select($thread->getId(), $ids);
		} else {
			return array();
		}
	}
	
	
	
}