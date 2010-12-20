<?php
class NewsPage extends Page {
	static $db = array(
		'FromDate' => 'Date',
		'ToDate' => 'Date'
	);
	static $icon  = 'news/images/news';
	static $default_parent = 'NewsSection';
	static $allowed_children = 'none';
	static $can_be_root = false;
	static $default_sort = 'Sort DESC';
	static $defaults = array(
		'ShowInMenus' => false,
		'FromDate' => 'now'
	);
	function getCMSFields() {
		$fields = parent::getCMSFields();
		$fields->addFieldToTab(
			$tab = 'Root.Content.Main',
			new CalendarDateField(
				$db_name = 'FromDate',
				$cms_label = _t('NewsPage.FROM','From')),
			$place_before = 'Content'
		);
		$fields->addFieldToTab(
			$tab = 'Root.Content.Main',
			new CalendarDateField(
				$db_name = 'ToDate',
				$cms_label = _t('NewsPage.TO','To')),
			$place_before = 'Content'
		);
		return $fields;
	}
}
class NewsPage_Controller extends Page_Controller {
	public function OtherNews($limit='') {
		$filter = '`NewsPage`.`ID` <> '.$this->ID
			.' AND ParentID = '.$this->ParentID
			.' AND (FromDate IS NULL OR FromDate <= NOW()) AND (ToDate IS NULL OR ToDate >= NOW())';
		$sortorder = 'FromDate DESC';
		return DataObject::get('NewsPage', $filter, $sortorder, '', $limit);
	}
}
?>