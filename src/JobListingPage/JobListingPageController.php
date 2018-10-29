<?php

namespace IQnection\JobListingPage;

use IQnection\FormPage\FormPageController;

class JobListingPageController extends FormPageController
{
	private static $allowed_actions = [
		'details',
		'apply'
	];
	
	public function PageJS()
	{
		return [
			"javascript/jquery.tablesorter.min.js"
		];
	}
	
	public function FormConfig()
	{
		$config = [
			"useNospam" => true
		];
		$this->extend('updateFormConfig', $config);
		return $config;
	}
	
	public function FormFields()
	{
		$fields = array(
			"JobTitle" => array(
				"FieldType" => "HiddenField",
				"Label" => "Job Title",
				"Value" => $this->CurrentJob()->Title,
			),
			"JobLocation" => array(
				"FieldType" => "HiddenField",
				"Label" => "Job Location",
				"Value" => $this->CurrentJob()->Location,
			),
			"FirstName" => array(
				"FieldType" => "TextField",
				"Label" => "First Name",
				"Required" => true,
			),
			"LastName" => array(
				"FieldType" => "TextField",
				"Label" => "Last Name",
				"Required" => true,
			),
			"Address" => array(
				"FieldType" => "TextField",
				"Label" => "Address",
			),
			"Address2" => array(
				"FieldType" => "TextField",
				"Label" => "",
			),
			"City" => array(
				"FieldType" => "TextField",
				"Label" => "City",
			),
			"State" => array(
				"FieldType" => "DropdownField",
				"Label" => "State",
				"Value" => "GetStates",
				"Default" => "PA"
			),
			"ZipCode" => array(
				"FieldType" => "TextField",
				"Label" => "Zip Code",
			),
			"Phone" => array(
				"FieldType" => "TextField",
				"Label" => "Phone Number",
			),
			"Email" => array(
				"FieldType" => "EmailField",
				"Label" => "Email Address",
				"Required" => true,
			),
			"CoverLetter" => array(
				"FieldType" => "FileField",
				"Label" => "Cover Letter",
				"Required" => false
			),
			"Resume" => array(
				"FieldType" => "FileField",
				"Label" => "Resume",
				"Required" => true,
				"message" => "Please upload your resume."
			),
			"Comments" => array(
				"FieldType" => "TextareaField",
				"Label" => "Comments",
			),
			"Recipient" => $this->RecipientFieldConfig()
		);
		
		$this->extend('updateFormFields',$fields);
		return $fields;
	}
	
	public function CurrentJob()
	{
		return $this->JobPositions()->byID($this->request->param('ID'));
	}
	
	public function details()
	{
		if (!$this->CurrentJob()) 
		{
			return $this->redirectBack();
		}
		return $this;
	}
	
	public function apply()
	{
		if (!$this->CurrentJob()) 
		{
			return $this->redirectBack();
		}
		return $this;
	}
}

