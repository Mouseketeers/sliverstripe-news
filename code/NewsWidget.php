<?php
class NewsWidget extends Widget {
	static $db = array(
		'WidgetTitle' => 'Varchar',
		'NumberToShow' => 'Int',
		'NoNewsMessage' => 'Varchar'
	);
	static $defaults = array(
		'WidgetTitle' => 'Latest news',
		'NumberToShow' => 5,
		'NoNewsMessage' => 'There are currently no news'
	);
	static $title = 'Latest News';
	static $cmsTitle = 'Latest News';
	static $description = 'This widget displays latest news. The news module is required to make use of this widget';
	function getCMSFields() {
		return new FieldSet(
			new TextField('WidgetTitle', 'Widget title'),
			new TextField('NumberToShow', 'Number of news to list'),
			new TextField('NoNewsMessage', 'Message to show when there is no news')
		);
	}
	function News($num='',$parentID=''){
		$num = $num ? $num : $this->NumberToShow;
		$data = DataObject::get('NewsPage', 'FromDate IS NULL OR FromDate <= NOW()', '', '', $num);
 		return $data;
	}
	function Title() {
		return $this->WidgetTitle;
	}
	function NoNewsMessage() {
		return $this->NoNewsMessage;
	}
}

?>