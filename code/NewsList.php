<?php
class NewsList extends DataObjectDecorator {
	function extraStatics() {
		return array(
			'db' => array(
				'NewsListHeadline' => 'Varchar',
				'NewsListLength' => 'Int',
				'NewsListNoNewsMessage' => 'Varchar',
				'ShowNewsList' => 'Boolean'
			),
			'many_many' => array(
				'NewsSections' => 'NewsSection'
			),
			'defaults' => array(
				'NewsListHeadline' => 'Latest news',
				'NewsListLength' => 5,
				'NewsListNoNewsMessage' => 'There are currently no news',
				'ShowNewsList' => 1
			)
		);
	}
	function updateCMSFields(&$fields){
		$fields->addFieldsToTab( 'Root.Content.News', array(
			new CheckboxField('ShowNewsList','Show news list'),
			new TextField('NewsListHeadline', 'Headline (e.g. Latest news)'),
			new TextField('NewsListLength', 'Number of news to list'),
			new TextField('NewsListNoNewsMessage', 'Message to show when there are no news')
		));
		$newSections = DataObject::get('NewsSection');
		if($newSections->exists() && $newSections->Length > 0) {
			$fields->addFieldToTab(
				'Root.Content.News',
				new CheckboxSetfield(
					'NewsSections',
					'Exclude the following news sections',
					$newSections->toDropdownMap('ID','Title')
				)
			);
		}
		return $fields;
	}
	public function News() {
		$where = '(FromDate IS NULL OR FromDate <= NOW()) AND (ToDate IS NULL OR ToDate >= NOW())';
		$newsSections = $this->owner->NewsSections();
		if($newsSections->Count()) {
			$where .= ' AND ParentID NOT IN ('.implode(',',$newsSections->column('ID')).')';
		}
		$data = DataObject::get('NewsPage', $where, '', '', $this->owner->NewsListLength);
 		return $data;
	}
}