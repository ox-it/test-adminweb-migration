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
    $applicant->name = (!empty($applicant->title)?$applicant->title.' ':'') . (!empty($applicant->forename)?$applicant->forename.' ':'') . (!empty($applicant->surname)?$applicant->surname:'');
    $orgs = self::organisationsOptions();
    $applicant->organisation = !empty($orgs[$applicant->employer]) ? $orgs[$applicant->employer] : '';
		return $applicant;
	}

	public function validationRegister($validator) {
    $validator ->notEmpty(['surname','forename','title','employer','position','email','phone','role']);
		$validator ->add('email', 'validFormat', [ 'rule'=>'email', 'message' => 'Please enter a valid email' ]);
    foreach(['study','investigator', 'REC','project'] as $target) {
		  $validator->notEmpty($target, null, function ($context) { return (!empty($context['data']['employer']) && $context['data']['employer']=='O'); });
		}
		return $validator;
	}

	public function beforeSave($event, $entity, $options) {
		if ($entity->isNew()) {
			$entity->made_stamp = time();
		}
	}

	protected function prepareEmailFields($entity)
	{

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