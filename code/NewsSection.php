<?php
class NewsSection extends Page {
	public static $db = array(
		'Pagination' => 'Boolean',
		'NumPages' => 'Int',
		'ExcludeOutdatedNews' => 'Boolean'
	);
	static $defaults = array(
		'SortOrder' => 'FromDate',
		'ExcludeOutdatedNews' => '0'
	);
	static $has_one = array();
 	static $default_child = "NewsPage";
 	static $icon  = 'news/images/news_section';
 	
	function getCMSFields() {
		$fields = parent::getCMSFields();
		$fields->addFieldToTab(
			$tab = 'Root.Content.Main',
			new NumericField(
				$db_name = 'NumPages',
				$cms_label = _t('NewsSection.MAX_PAGES_TO_LIST','Max pages to list (set to 0 to list all pages)')
			),
			$place_before = 'Content'
		);
		$fields->addFieldToTab(
			$tab = 'Root.Content.Main',
			new CheckboxField(
				$db_name = 'ExcludeOutdatedNews',
				$cms_label = _t('NewsSection.EXCLUDE_OUTDATED','Exclude outdated news from the list')
			),
			$place_before = 'Content'
		);
		return $fields;
	}
}
class NewsSection_Controller extends Page_Controller {
	//gets current news other than the 
	public function OtherNews($limit='') {
		$filter = '`NewsPage`.`ID` <> '.$this->ID .' AND (FromDate IS NULL OR FromDate <= NOW()) AND (ToDate IS NULL OR ToDate >= NOW())'; 
		//if ($parent) $where .= ' AND ParentID = '.$parent;
 		return DataObject::get('NewsPage', $filter, 'FromDate DESC', '', $limit);
	}
	public function ContentList() {
		$limit = '';
		if($this->NumPages) {
			if(!isset($_GET['start']) || !is_numeric($_GET['start']) || (int)$_GET['start'] < 1) $_GET['start'] = 0;
			$limit_start = (int)$_GET['start'];
			$limit = $limit_start.','.$this->NumPages;
		}
		$filter = 'ParentID = '. $this->ID;
		if ($this->ExcludeOutdatedNews) $filter .= ' AND (FromDate IS NULL OR FromDate <= NOW()) AND (ToDate IS NULL OR ToDate >= NOW())';
		$data = DataObject::get('NewsPage', $filter, $this->SortOrder,'',$limit);
		return $data;
	}
}
?>