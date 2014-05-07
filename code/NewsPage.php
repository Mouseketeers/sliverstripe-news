<?php
class NewsPage extends Page {
	static $db = array(
		'FromDate' => 'Date',
		'ToDate' => 'Date',
		'Abstract' => 'Text'
	);
	static $has_one = array(
		'Image' => 'Image',
		'NewsDocument' => 'File'
	);
	static $icon  = 'news/images/news';
	static $default_parent = 'NewsSection';
	static $allowed_children = 'none';
	static $can_be_root = false;
	static $default_sort = 'FromDate DESC, Sort DESC';
	static $defaults = array(
		'ShowInMenus' => false,
		'FromDate' => 'now'
	);
	static $international_date_formats = array(
		'da_DK' => '%e. %B %Y',
		'se_SE' => '%e. %B %Y',
		'de_DE' => '%e. %B %Y',
		'default' => '%e %B %Y'
	);
	static $file_upload_folder = 'News';
	function getCMSFields() {
		$from_date_field = new DateField('FromDate', _t('NewsPage.FROM','From'));
		$from_date_field->setConfig('showcalendar',true);
		
		$to_date_field = new DateField('ToDate', _t('NewsPage.TO','To'));
		$to_date_field->setConfig('showcalendar',true);

		$document_upload_field = new FileUploadField('NewsDocument', 'News Document');
		$document_upload_field->setUploadFolder(self::$file_upload_folder);
		
		$fields = parent::getCMSFields();
		
		$fields->addFieldToTab('Root.Content.Main',new TextareaField('Abstract','Abstract'),'Content');
		$fields->addFieldToTab(
			$tab = 'Root.Content.Main',
			$from_date_field,
			$place_before = 'Content'
		);
		$fields->addFieldToTab(
			$tab = 'Root.Content.Main',
			$to_date_field,
			$place_before = 'Content'
		);
		$fields->addFieldToTab(
			$tab = 'Root.Content.Main',
			$document_upload_field
		);
		return $fields;
	}
	public function DateAndTitle() {
		return $this->FromDate . ' - ' . $this->Title;
	}
	public function SetFileUploadFolder($folder_name) {
		self::$file_upload_folder = $folder_name;
	}
	public function InternationalDate($DateDBName = 'FromDate') {
		$date_obj = $this->dbObject($DateDBName);
		if($date_obj->value) {
			$date_formats = self::$international_date_formats;
			$locale = i18n::get_locale();
			$date_format = isset($date_formats[$locale]) ? $date_formats[$locale] : $date_formats['default'];
			return $date_obj->FormatI18N($date_format);
		};
	}
	public function getRestfulSearchContext() {
		if (!class_exists('DateFilter')) return $this->getDefaultSearchContext();
		return new SearchContext(
			$this->class,
			null,
			array(
				'FromDate' => new DateFilter('FromDate'),
				'ToDate' => new DateFilter('ToDate')
			)
		);
	}
}
class NewsPage_Controller extends Page_Controller {
	public function OtherNews($limit='') {
		$filter = '`NewsPage`.`ID` <> '.$this->ID
			.' AND ParentID = '.$this->ParentID
			.' AND (FromDate IS NULL OR FromDate <= NOW()) AND (ToDate IS NULL OR ToDate >= NOW())';
		return DataObject::get('NewsPage', $filter, '', '', $limit);
	}
}
?>