<?
	class JobCategory extends DataObject
	{
		private static $db = array(
			"SortOrder" => "Int",  
			"Title" => "Varchar(255)", 
		);
		
		private static $has_one = array(
			"JobListingPage" => "JobListingPage"
		); 		
		
		private static $summary_fields = array(
			'Title' => 'Title'
		);
		
        public function getCMSFields()
        {
			$fields = new FieldList();

			$fields->push( new TextField("Title", "Title:") );
			
			return $fields;
        }
		
		public function canCreate($member = null) { return true; }
		public function canDelete($member = null) { return true; }
		public function canEdit($member = null)   { return true; }
		public function canView($member = null)   { return true; }
	}
	
	class Position extends DataObject
	{
		private static $db = array(
			"SortOrder" => "Int", 
			"Title" => "Varchar(255)", 
			"Location" => "Varchar(255)",
			"Content" => "HTMLText"
		);
		
		private static $has_one = array(
			"JobListingPage" => "JobListingPage",
			"JobCategory" => "JobCategory"
		); 
		
		private static $summary_fields = array(
			"Title" => "Job Title",
			"CategoryName" => "Category",
			"Location" => "Location"
		);
		
        public function getCMSFields()
        {
			$fields = new FieldList();

			$fields->push( new TextField("Title", "Job Title:") );
			if ($this->JobListingPageID)
			{
				$fields->push( new DropdownField("JobCategoryID", "Category:", $this->GetJobCategories()) );
			}
			else
			{
				$fields->push( new ReadonlyField('JobCategoryID', 'Category:','You must save before you can select a category') );
			}
			$fields->push( new TextField("Location", "Location:") );
			$fields->push( new HTMLEditorField("Content", "Content/Description:") );

			return $fields;
        }
		
		public function GetJobCategories()
		{
			$cats = array("" => "");

			if ($this->JobListingPageID > 0)
			{
				foreach($this->JobListingPage()->JobCategories() as $cat)
				{
					$cats[$cat->ID] = $cat->Title;
				}
			}
			return $cats;
		}
		
		public function CategoryName()
		{
			if ($this->JobCategoryID > 0)
			{
				return $this->JobCategory()->Title;
			}
			else
			{
				return "(none)";
			}
		}
		
		public function canCreate($member = null) { return true; }
		public function canDelete($member = null) { return true; }
		public function canEdit($member = null)   { return true; }
		public function canView($member = null)   { return true; }
		
		public function Link()
		{
			return $this->JobListingPage()->Link("details/".$this->ID);
		}
		
		public function ApplyLink()
		{
			return $this->JobListingPage()->Link('apply/'.$this->ID);
		}
	}
	
	class JobListingPageSubmission extends FormPageSubmission 
	{
		
        private static $db = array(
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
        );
		
		private static $has_one = array(
			'CoverLetter' => 'File',
			'Resume' => 'File'
		);
		
		private static $summary_fields = array(
			"Created" => "Date",
			"JobTitle" => 'Job Title',
			'JobLocation' => 'Job Location',
			"FirstName" => "First Name",
			"LastName" => "Last Name",
			'Phone' => 'Phone',
			"Email" => "Email Address",
		);
		
		private static $default_sort = "Created DESC";
				
		public function canCreate($member = null) { return false; }
		public function canDelete($member = null) { return true; }
		public function canEdit($member = null)   { return false; }
		public function canView($member = null)   { return true; }
		
    }
	
	class JobListingPage extends FormPage
	{
		static $db = array(
		);
		
		static $has_many = array(
			"JobCategories" => "JobCategory",
			"Positions" => "Position"
		);
		
		public function getCMSFields()
		{
			$fields = parent::getCMSFields();
			
			$fields->addFieldToTab('Root.Content.Categories', new GridField(
				'JobCategories',
				'Job Categories',
				$this->JobCategories(),
				GridFieldConfig_RecordEditor::create()->addComponent(
					new GridFieldSortableRows('SortOrder')	,
					'GridFieldButtonRow'
				)
			));
			
			$fields->addFieldToTab('Root.Content.Jobs', new GridField(
				'Positions',
				'Position',
				$this->Positions(),
				GridFieldConfig_RecordEditor::create()->addComponent(
					new GridFieldSortableRows('SortOrder')	,
					'GridFieldButtonRow'
				)
			));
			
			return $fields;
		}	
		
		public function CategoriesForDropdown()
		{
			$cats = "<option value='0'></option>";

			if ($this->ID > 0)
			{
				foreach ($this->JobCategories() as $cat)
				{
					$cats .= "<option value='".$cat->ID."'>".htmlspecialchars($cat->Title)."</option>";
				}
			}
			return $cats;
		}		
	}
	
	class JobListingPage_Controller extends FormPage_Controller
	{
		static $allowed_actions = array(
			'details',
			'apply'
		);
		
		public function init()
		{
			parent::init();
		}
		
		function PageJS()
		{
			return array_merge(
				parent::PageJS(),
				array(
					"iq-joblistingpage/javascript/jquery.tablesorter.min.js"
				)
			);
		}
		
		public function FormConfig()
		{
			return array(
				"useNospam" => true,
				"sendToAll" => true,
				"trackFormSubmit" => array(
					"category" => "Form Submissions", 
					"action" => "submit", 
					"label" => "Submit Job Form",
					"value" => 1
				)
			);
		}
		
		public function FormFields()
		{
			return array(
				"JobTitle" => array(
					"FieldType" => "HiddenField",
					"Label" => "Job Title",
					"Value" => $this->findJobby()->Title,
				),
				"JobLocation" => array(
					"FieldType" => "HiddenField",
					"Label" => "Job Location",
					"Value" => $this->findJobby()->Location,
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
			);
		}
		
		public function details()
		{
			if($job = $this->findJobby())
			{
				return $this->Customise(array(
					"Jobby" => $job
				));
			}
			else
			{
				Director::redirectBack();	
			}
		}
		
		public function apply()
		{
			if($job = $this->findJobby())
			{
				return $this->Customise(array(
					"Jobby" => $job
				));
			}
			else
			{
				Director::redirectBack();	
			}
		}
		
		public function findJobby()
		{
			$job = false;
			$id = $this->request->param('ID');
			if($id)$job = DataObject::get_one('Position','JobListingPageID='.$this->ID.' AND ID='.$id);
			return $job;
		}
		
	}
?>