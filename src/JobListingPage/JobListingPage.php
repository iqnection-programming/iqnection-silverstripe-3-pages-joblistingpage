<?php

namespace IQnection\JobListingPage;

use SilverStripe\Forms;
use UndefinedOffset\SortableGridField\Forms\GridFieldSortableRows;
use IQnection\FormPage\FormPage;

class JobListingPage extends FormPage
{
	private static $table_name = 'JobListingPage';
	private static $singular_name = 'Job Listing Page';
	private static $plural_name = 'Job Listing Pages';
	
	private static $db = [];
	
	private static $has_many = [
		"JobListingPageSubmissions" => Model\JobListingPageSubmission::class,
		"JobCategories" => Model\JobCategory::class,
		"JobPositions" => Model\JobPosition::class
	];
	
	private static $defaults = [
		'SendToAll' => true
	];
	
	public function getCMSFields()
	{
		$fields = parent::getCMSFields();
		$fields->removeByName('JobCategories');
		$fields->removeByName('JobPositions');
		$fields->addFieldToTab('Root.Categories', Forms\GridField\GridField::create(
			'JobCategories',
			'Job Categories',
			$this->JobCategories(),
			Forms\GridField\GridFieldConfig_RecordEditor::create()
				->addComponent( new GridFieldSortableRows('SortOrder') )
		));
		
		$fields->addFieldToTab('Root.Positions', Forms\GridField\GridField::create(
			'JobPositions',
			'Position',
			$this->JobPositions(),
			Forms\GridField\GridFieldConfig_RecordEditor::create()
				->addComponent( new GridFieldSortableRows('SortOrder') )
		));
		$this->extend('updateCMSFields',$fields);
		return $fields;
	}	
	
}

