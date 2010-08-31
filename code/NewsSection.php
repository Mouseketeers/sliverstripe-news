<?php
class NewsSection extends Section {
	static $db = array();
	static $has_one = array();
	//static $allowed_children = array("NewsPage");
 	static $default_child = "NewsPage";
}
class NewsSection_Controller extends Section_Controller {
	public function News($num='',$parent='') {
		$where = '(FromDate IS NULL OR FromDate <= NOW()) AND (ToDate IS NULL OR ToDate >= NOW())';
		if ($parent) $where .= ' AND ParentID = '.$parent;
 		return DataObject::get('NewsPage', $where, 'FromDate DESC', '', $num); 
	}
}
?>