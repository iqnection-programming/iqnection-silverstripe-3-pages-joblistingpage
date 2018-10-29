<?php

namespace IQnection\JobListingPage\Model;

use IQnection\JobListingPage;
use UndefinedOffset\SortableGridField\Forms\GridFieldSortableRows;
use SilverStripe\ORM;
use SilverStripe\Forms;

class JobCategory extends ORM\DataObject
{
	private static $table_name = 'JobCategory';
	private static $singular_name = 'Job Category';
	private static $plural_name = 'Job Categories';
	
	private static $db = [
		"SortOrder" => "Int",  
		"Title" => "Varchar(255)", 
	];
	
	private static $has_one = [
		"JobListingPage" => JobListingPage::class
	];
	
	private static $has_many = [
		'JobPositions' => JobPosition::class
	];
	
	private static $summary_fields = [
		'Title' => 'Title'
	];
	
	private static $default_sort = 'SortOrder ASC';
	
	public function getCMSFields()
	{
		$fields = parent::getCMSFields();
		$fields->removeByName('FileTracking');
		$fields->removeByName('LinkTracking');
		$fields->removeByName('SortOrder');
		$fields->removeByName('JobPositions');
		if ($this->Exists())
		{
			$fields->addFieldToTab('Root.Positions', Forms\GridField\GridField::create(
				'JobPositions',
				'Positions',
				$this->JobPositions(),
				Forms\GridField\GridFieldConfig_RecordEditor::create()
					->addComponent( new GridFieldSortableRows('SortOrder') )
			));
		}
		
		$this->extend('updateCMSFields',$fields);
		
		return $fields;
	}
	
	public function canCreate($member = null, $context = [])	{ return true; }
	public function canDelete($member = null, $context = [])	{ return true; }
	public function canEdit($member = null, $context = []) 		{ return true; }
	public function canView($member = null, $context = [])		{ return true; }
}





