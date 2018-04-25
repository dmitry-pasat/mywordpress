<?php
class CMProductDirectoryCommunityProductNotification
{
	const CMPDC_MYPRODUCT_NOTIFICATION_CONTENT_TYPE = 'text/html';
	const CMPDC_MYPRODUCT_NOTIFICATION_SUBJECT = ' ';
	
	private $_emails;
	private $_contentData;
	private $_content;
	private $_notificationSubject;
	
	public function __construct()
	{
		$this->addContentTypeFilter();
	}
	
	public function setEmail($email)
	{
		$this->_emails[] = $email;
	}
	
	private function addContentTypeFilter()
	{
		add_filter( 'wp_mail_content_type', array(__CLASS__, 'setContentType') );
	}
	
	public static function setContentType()
	{
		return self::CMPDC_MYPRODUCT_NOTIFICATION_CONTENT_TYPE;
	}
	
	public function setContentData($data)
	{
		$this->_contentData = $data;
	}
	
	public function send()
	{
		if ($this->_emails)
		{
			foreach($this->_emails as $email)
			{
				wp_mail($email, (!empty($this->_notificationSubject)?$this->_notificationSubject:self::CMPDC_MYPRODUCT_NOTIFICATION_SUBJECT), vsprintf($this->getContent(), $this->_contentData));
			}
		}
	}
	
	public function setContent($content)
	{
		$this->_content = $content;
	}
	
	private function getContent()
	{
		return $this->_content;
	}
	
	public function setNotificationSubject($subject)
	{
		$this->_notificationSubject = $subject;
	}
	
	public function resetSettings()
	{
		
	}	
}