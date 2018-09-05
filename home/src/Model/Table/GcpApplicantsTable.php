<?php
// src/Model/Table/GcpApplicantsTable.php
namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\I18n\Time;
use Cake\I18n\Date;
use Cake\Validation\Validator;
use Cake\Filesystem\Folder;
use Cake\Filesystem\File;

class GcpApplicantsTable extends Table
{

  public static $single = 'Single';

  public static function organisationsOptions() {
    return [ 'U'=>'University of Oxford', 'R'=>'Oxford University Hospitals NHS Trust', 'O'=>'Other' ];
  }

	private static function keyValueOptions($values) {
    $result = [];
    foreach ($values as $val) $result[$val] = $val;
    return $result;
  }


	public static function defaultConnectionName() {
		return 'gcp-test';
	}

	public function initialize(array $config)
	{
		$this->addBehavior('Timestamp');
		$this->setTable('gcp_applicant');
		$this->setPrimaryKey('applicantID');
	}

	public function getByID($applicantID = null) {
		$query = $this->find('all') ->where(['applicantID'=>$applicantID]);
    $applicant = $query->first();
		return $applicant;
	}

	public function validationReport($validator) {
    $validator ->notEmpty(['official_role','12inqdeptcode','same_dept','eoo_satisfaction']);

    $validator ->notEmpty('application_type');
		$validator ->notEmpty(['title','surname','firstname','contact_number','preferred_email','nationality','college','degree','subject','term','term_year','acc_prefer_1','acc_prefer_2','tenancy_accept']);

		// Conditional validation
		foreach(['partner_title','partner_lastname','partner_firstname','partner_relationship','partner_nationality','partner_preferred_email','partner_contact_no','partner_college','partner_degree','partner_subject','partner_degree_start'] as $target) {
		  $validator->notEmpty($target, null, function ($context) { return (!empty($context['data']['application_type']) && $context['data']['application_type']==self::$joint); });
		}
		foreach(['spouse_title','spouse_firstname','spouse_lastname','spouse_relationship','spouse_nationality'] as $target) {
		  $validator->notEmpty($target, null, function ($context) { return (!empty($context['data']['application_type']) && $context['data']['application_type']==self::$family); });
		}

    $validator->notEmpty('degree_other', null, function ($context) { return (!empty($context['data']['application_type']) && !empty($context['data']['degree']) && $context['data']['degree']=='Other'); });

		return $validator;
	}

	public function beforeSave($event, $entity, $options) {
		if ($entity->isNew()) {

			$entity->made_stamp = time();

			$entity->download_date = date('d/m/Y');
			$entity->download_time = date('H:i');
			$entity->download_stamp = time();

			// Make CSV
		  //$this->createCSVFile($entity);

			// Send Email
			// $email = $this->prepareEmailFields($entity);
		  //$this->sendEmailConfirmation($entity);

		}
	}

	protected function prepareEmailFields($entity)
	{
		// TODO: Create XML file & send in an email.
		$type = $data['application_type'];
		$isSingle=($data['application_type']==self::$single);
		if ($isSingle){
			$data['email_to'] = [ "singles.accommodation@admin.ox.ac.uk" => 'Singles Accommodation' ];
		} else {
			$data['email_to'] = [ "couples.accommodation@admin.ox.ac.uk" => 'Couples Accommodation' ];
		}
		$data['email_message'] = "<p>Please find attached is the XML file.</p>\n";
    if (!empty($data['comments'])) {
      $data['email_message'] .= "<p>Below are the extra comments provided by the user.</p>\n";
      $data['email_message'] .= '<blockquote><p><em>'.str_replace("\n","<br>\n",$data['comments'])."</em></p></blockquote>\n";
    }
    if (!empty($data['expecting']) ){
				$data['email_message'] .= '<p><strong>The applicant'.($isSingle?'':'s').' '.($isSingle?'is':'are').' also expecting a child.</strong></p>';
		}
		// TODO: Remove test email
		$data['email_to'] = [ "al.pirrie@it.ox.ac.uk" => 'Al Pirrie', 'al@cache.co.uk' => 'Al' ];

		$data['noofchildren'] = (!empty($data['select_child_1'])?1:0) + (!empty($data['select_child_2'])?1:0) + (!empty($data['select_child_3'])?1:0) + (!empty($data['select_child_4'])?1:0) + (!empty($data['select_child_5'])?1:0) + (!empty($data['select_child_6'])?1:0);

		$title = $data['title']!='Other' ? $data['title'] . ' ' : $data['title_other'];
		$data['name']  = $data['firstname'] . ' ' . $data['surname'] . (!empty($data['othernames']) ? ' (nee ' . $data['othernames'] . ')' : '');
		$data['email_subject'] = 'New '.$type.' Application from ' . $data['name'];

		// Make sure all values are present
		$fields = $this->schema()->fields();
		foreach ($fields as $f) if (!isset($data[$f])) $data[$f] = '';

		// Get XML
		$xml = $this->createXMLWithData($data);
		$xmlFilename = strtolower($data['surname'] . '_' . $data['firstname']) . '_' . date('ymdhis') . '.xml';
		$xmlfile = new File(TMP . $xmlFilename, true);
		$xmlfile->write($xml, 'w', true);
		$data['xmlfile'] = TMP . $xmlFilename;

		// Send Email
		$this->sendEmailConfirmation($data);

		return $data;
	}

	function sendEmailConfirmation($data)
	{
		$email = new Email('default');
		$email->to($data['email_to']);
  	$email->from(['graduate.accommodation@admin.ox.ac.uk' => 'Graduate Accommodation Form']);
  	$email->subject($data['email_subject']);
		$email->emailFormat('html');
		$email->attachments($data['xmlfile']);
		$email->send($data['email_message']);
	}

}