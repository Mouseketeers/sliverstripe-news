<?php
class NewsSection extends Page {
	public static $db = array(
		'Pagination' => 'Boolean',
		'NumPages' => 'Int',
		'ExcludeOutdatedNews' => 'Boolean',
		'IncludeNewsInSubsections' => 'Boolean'
	);
	static $defaults = array(
		'ExcludeOutdatedNews' => '0',
		'NumPages' => 10
	);
	static $has_one = array();
 	static $default_child = "NewsPage";
 	static $icon  = 'news/images/news_section';
 	static $num_pages_options = array(
		0 => 'All',
		2 => '2',
		3 => '3',
		4 => '4',
		5 => '5',
		6 => '6',
		7 => '7',
		8 => '8',
		9 => '9',
		10 => '10',
		15 => '15',
		20 => '20',
		50 => '50',
		100 => '100'
	);
	function getCMSFields() {
		$fields = parent::getCMSFields();
		$fields->addFieldToTab(
			$tab = 'Root.Content.Main',
			new DropdownField(
				$db_name = 'NumPages',
				$cms_label = _t('NewsSection.MAX_PAGES_TO_LIST','Max news stories to list per page'),self::$num_pages_options),
			$place_before = 'Content'
		);
		$fields->addFieldToTab(
			$tab = 'Root.Content.Main',
			new CheckboxField(
				$db_name = 'ExcludeOutdatedNews',
				$cms_label = _t('NewsSection.EXCLUDE_OUTDATED','Exclude outdated news')
			),
			$place_before = 'Content'
		);
		$fields->addFieldToTab(
			$tab = 'Root.Content.Main',
			new CheckboxField(
				$db_name = 'IncludeNewsInSubsections',
				$cms_label = _t('NewsSection.INCLUDE_SUBSECTIONS','Include news in subsections')
			),
			$place_before = 'Content'
		);

		return $fields;
	}
}
class NewsSection_Controller extends Page_Controller {
	public function ContentList() {
		if($this->NumPages) {
			if(!isset($_GET['start']) || !is_numeric($_GET['start']) || (int)$_GET['start'] < 1) $_GET['start'] = 0;
			$limit_start = (int)$_GET['start'];
			$limit = $limit_start.','.$this->NumPages;
		}
		else {
			$limit = '';
		}
		if($this->IncludeNewsInSubsections) {
			$decendent_ids = $this->getDescendantIDList();
			$filter = '"NewsPage"."ID" IN ('.implode(',',$decendent_ids).') ';
		}
		else {
			$filter = 'ParentID = '. $this->ID;	
		}
		$filter .= ' AND (FromDate IS NULL OR FromDate <= NOW())';
		if ($this->ExcludeOutdatedNews) $filter .= ' AND (ToDate IS NULL OR ToDate >= NOW())';
		$data = DataObject::get('NewsPage', $filter, 'FromDate DESC','',$limit);
		return $data;
	}
	public function IsFirstPage() {
		return ($this->request->getVar('start') == 0);
	}
	function getAllChildren($objectType = null, $parentObject = null, $dataSet = null) {
      if ($parentObject == null) {
         return null;
      }
      if ($dataSet == null) {
         $dataSet = new DataObjectSet();
      }
      $children = $parentObject->AllChildren();
      if (!empty($children)) {
         $dataSet->merge($children);
         foreach ($children as $child) {
               $dataSet = $this->getAllChildren($objectType, $child, $dataSet);
         }
      }
      if ($objectType) {
         foreach ($dataSet as $object) {
            if ($object->class != $objectType) {
               $dataSet->remove($object);
            }
         }
      }
      return $dataSet;
   }
}
?>