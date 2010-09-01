<?php
class NewsSection extends Page {
	static $db = array();
	static $has_one = array();
	//static $allowed_children = array("NewsPage");
 	static $default_child = "NewsPage";
}
class NewsSection_Controller extends Page_Controller {
	public function News($num=10,$parent='') {
		$where = '(FromDate IS NULL OR FromDate <= NOW()) AND (ToDate IS NULL OR ToDate >= NOW())';
		if ($parent) $where .= ' AND ParentID = '.$parent;
 		return DataObject::get('NewsPage', $where, 'FromDate DESC', '', $num);
	}
	public function OtherNews($num=10,$parent='') {
		$where = '`NewsPage`.`ID` <> '.$this->ID .' AND (FromDate IS NULL OR FromDate <= NOW()) AND (ToDate IS NULL OR ToDate >= NOW())';
		if ($parent) $where .= ' AND ParentID = '.$parent;
 		return DataObject::get('NewsPage', $where, 'FromDate DESC', '', $num);
	}
}
?>