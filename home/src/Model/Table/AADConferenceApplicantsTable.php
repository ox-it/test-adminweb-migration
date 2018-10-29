<?php
// src/Model/Table/AADConferenceApplicantsTable.php
namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\I18n\Time;
use Cake\I18n\Date;
use Cake\Validation\Validator;

class AADConferenceApplicantsTable extends Table
{

	public static function defaultConnectionName() {
		return 'aad_conference-test';
	}

	public function initialize(array $config)
	{
		$this->addBehavior('Timestamp');
		$this->setTable('aad_conference_applicant');
		$this->setPrimaryKey('applicantID');
	}

	public function getByOxfordID()
	{
    $oxfordID = !empty($_SERVER['HTTP_WAF_WEBAUTH']) ? $_SERVER['HTTP_WAF_WEBAUTH'] : 'notgiven';
    $query = $this->find('all') ->where(['AADConferenceApplicants.oxfordID'=>$oxfordID]) ->order(['timestamp'=>'DESC']);
    $applicant = $query->first();
    return $applicant;
	}

    public function getByID($applicantID = null)
    {
      $applicant = $this->get($applicantID);
      return $applicant;
    }

    public function validationRegister()
    {
      $validator = new Validator();

      $require = ['title','forname','surname','jobtitle','phone','email','email2'];
  		foreach($require as $r) $validator ->notEmpty($r);

      $validator ->lengthBetween('phone', [5, 16], 'Please enter a valid phone number');

  		$validator ->add('email', 'validFormat', [ 'rule'=>'email', 'message' => 'Please enter a valid email' ]);
  		$validator ->add('manageremail', 'validFormat', [ 'rule'=>'email', 'message' => 'Please enter a valid email' ]);

      return $validator;
    }

    public function validationCancel() {
      $validator = new Validator();
      $validator ->requirePresence('email') ->notEmpty('email', 'Please enter a valid email address');
      $validator ->requirePresence('courseID') ->notEmpty('courseID', 'Please select a course event');
      return $validator;
    }

    public function beforeSave($event, $entity, $options)
		{
			if ($entity->isNew()) {
				$entity->oxfordID = !empty($_SERVER['HTTP_WAF_WEBAUTH']) ? $_SERVER['HTTP_WAF_WEBAUTH'] : 'notgiven';
				$entity->timestamp = time();
				$entity->webdate = date('d/m/Y');
				$entity->webdatesort = date('Y/m/d');
				$entity->webtime = date('H:i');
			}
		}

}