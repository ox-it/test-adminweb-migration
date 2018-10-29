<?php
// src/Model/Table/SafetyApplicantsTable.php
namespace App\Model\Table;

use Cake\ORM\Table;
use Cake\I18n\Time;
use Cake\I18n\Date;
use Cake\Validation\Validator;

class SafetyApplicantsTable extends Table
{

		public static function defaultConnectionName() {
			return 'safety-test';
		}

    public function initialize(array $config)
    {
        $this->addBehavior('Timestamp');
        $this->setTable('safety_applicant');
        $this->setPrimaryKey('applicantID');
    }

    public function getByID($applicantID = null) {
      $applicant = $this->get($applicantID);
      return $applicant;
    }

    public function validationRegister() {
      $validator = new Validator();

  		$validator ->notEmpty(['jobtitle','phone','email','managersurname','managerfirstname']);
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
				$entity->webdate = date('d/m/Y');
				$entity->webdatesort = date('Y/m/d');
				$entity->webtime = date('H:i');
			}
		}

}