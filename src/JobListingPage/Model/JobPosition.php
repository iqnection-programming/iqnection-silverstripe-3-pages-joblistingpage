<?php

namespace IQnection\JobListingPage\Model;

use IQnection\JobListingPage;
use SilverStripe\ORM;
use SilverStripe\Forms;

class JobPosition extends ORM\DataObject
{
	private static $table_name = 'JobPosition';
	private static $singular_name = 'Job Position';
	private static $plural_name = 'Job Positions';
	
	private static $db = [
		"SortOrder" => "Int", 
		"Title" => "Varchar(255)", 
		"Location" => "Varchar(255)",
		"Description" => "HTMLText"
	];
	
	private static $has_one = [
		"JobListingPage" => JobListingPage::class,
		"JobCategory" => JobCategory::class
	];
	
	private static $summary_fields = [
		"Title" => "Job Title",
		"JobCategory.Title" => "Category",
		"Location" => "Location"
	];
	
	private static $default_sort = 'SortOrder ASC';
	
	public function getCMSFields()
	{
		$fields = parent::getCMSFields();
		
		$fields->removeByName('FileTracking');
		$fields->removeByName('LinkTracking');
		$fields->removeByName('SortOrder');
		$fields->removeByName('JobListingPageID');
		$fields->insertBefore('Description', $fields->dataFieldByName('JobCategoryID'));
		
		$this->extend('updateCMSFields',$fields);
		return $fields;
	}
	
	public function canCreate($member = null, $context = [])	{ return true; }
	public function canDelete($member = null, $context = [])	{ return true; }
	public function canEdit($member = null, $context = []) 		{ return true; }
	public function canView($member = null, $context = [])		{ return true; }
	
	public function onBeforeWrite()
	{
		parent::onBeforeWrite();
		if ( (!$this->JobListingPage()->Exists()) && ($Page = $this->JobCategory()->JobListingPage()->Exists()) )
		{
			$this->JobListingPageID = $Page->ID;
		}
	}
	
	public function Link()
	{
		return $this->JobListingPage()->Link("details/".$this->ID);
	}
	
	public function ApplyLink()
	{
		return $this->JobListingPage()->Link('apply/'.$this->ID);
	}
}

