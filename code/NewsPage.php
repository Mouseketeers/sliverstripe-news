<?php
class NewsPage extends Page {
	static $db = array(
		'FromDate' => 'Date',
		'ToDate' => 'Date'
	);
	/*static $has_one = array (
		'NewsImage' => 'Image'
	);*/
	static $default_parent = 'NewsSection';
	static $allowed_children = 'none';
	static $can_be_root = false;
	static $default_sort = 'FromDate DESC';
	static $defaults = array('ShowInMenus' => false);
	
	function getCMSFields() {
		$fields = parent::getCMSFields();
		$fields->addFieldToTab('Root.Content.Main',new CalendarDateField('FromDate','From'),'Content');
		$fields->addFieldToTab('Root.Content.Main',new CalendarDateField('ToDate','To'),'Content');
		//$fields->addFieldToTab('Root.Content.Main', new ImageField('NewsImage', 'News Image','Content'));
		$fields->removeFieldFromTab("Root.Content.Main","MenuTitle");
		return $fields;
	}
}
class NewsPage_Controller extends Page_Controller {
	public function OtherNews($num=10) {
		return DataObject::get('NewsPage', '`NewsPage`.`ID` <> '.$this->ID.' AND (FromDate IS NULL OR FromDate <= NOW()) AND (ToDate IS NULL OR ToDate >= NOW())', 'FromDate DESC', '', $num);
	}

}
?>