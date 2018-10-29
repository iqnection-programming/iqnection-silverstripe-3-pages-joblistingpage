<?php

namespace IQnection\JobListingPage\Model;

use IQnection\JobListingPage;
use SilverStripe\Assets\File;
use IQnection\FormPage\Model\FormPageSubmission;

class JobListingPageSubmission extends FormPageSubmission
{
	private static $table_name = 'JobListingPageSubmission';
	private static $singular_name = 'Submission';
	private static $plural_name = 'Submissions';
	
	private static $db = [
		'JobTitle' => 'Varchar(255)',
		'JobLocation' => 'Varchar(255)',
		'FirstName' => 'Varchar(255)',
		'LastName' => 'Varchar(255)',
		'Address' => 'Varchar(255)',
		'Address2' => 'Varchar(255)',
		'City' => 'Varchar(255)',
		'State' => 'Varchar(255)',
		'ZipCode' => 'Varchar(255)',
		'Phone' => 'Varchar(255)',
		'Email' => 'Varchar(255)',
		'Comments' => 'Text'
	];
	
	private static $has_one = [
		'CoverLetter' => File::class,
		'Resume' => File::class
	];
	
	private static $summary_fields = [
		"Created.Nice" => "Date",
		"JobTitle" => 'Job Title',
		'JobLocation' => 'Job Location',
		"FirstName" => "First Name",
		"LastName" => "Last Name",
		'Phone' => 'Phone',
		"Email" => "Email Address",
	];
	
	private static $default_sort = "Created DESC";
			
	public function canCreate($member = null, $context = [])	{ return false; }
	public function canDelete($member = null, $context = [])	{ return true; }
	public function canEdit($member = null, $context = []) 		{ return false; }
	public function canView($member = null, $context = [])		{ return true; }
}
