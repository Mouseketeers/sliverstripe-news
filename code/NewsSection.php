<?php
class NewsSection extends Page {
	static $db = array();
	static $has_one = array();
	//static $allowed_children = array("NewsPage");
 	static $default_child = "NewsPage";
 	static $icon  = 'news/images/news-section';
}
class NewsSection_Controller extends Page_Controller {
	public function News($limit=10) {
		$where = 'ParentID = '. $this->ID . ' AND (FromDate IS NULL OR FromDate <= NOW()) AND (ToDate IS NULL OR ToDate >= NOW())';
		$limit = "{$SQL_start},{$limit}";
 		return DataObject::get('NewsPage', $where, 'FromDate DESC', '', $limit);
	}
	public function OtherNews($num=10,$parent='') {
		$where = '`NewsPage`.`ID` <> '.$this->ID .' AND (FromDate IS NULL OR FromDate <= NOW()) AND (ToDate IS NULL OR ToDate >= NOW())';
		if ($parent) $where .= ' AND ParentID = '.$parent;
 		return DataObject::get('NewsPage', $where, 'FromDate DESC', '', $num);
	}
	public function PaginatedChildren($limit=10) {
		if(!isset($_GET['start']) || !is_numeric($_GET['start']) || (int)$_GET['start'] < 1) $_GET['start'] = 0;
		$SQL_start = (int)$_GET['start'];
		//$child_sort = isset($_GET['sort']) ? $_GET['sort'] : self::$default_sort;
		return DataObject::get(
			$callerClass = 'Page',
			$filter = 'ParentID = '. $this->ID,
			$sort = 'FromDate DESC',
			$join = '',
			$limit = $SQL_start .','.$limit
		 );
	}
}

?>