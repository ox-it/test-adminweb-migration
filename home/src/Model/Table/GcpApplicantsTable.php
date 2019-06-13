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
  public static $nl = "\n";

  public static function organisationsOptions() {
    return [ 'U'=>'University of Oxford', 'R'=>'Oxford University Hospitals NHS Trust', 'O'=>'Other' ];
  }

	private static function keyValueOptions($values) {
    $result = [];
    foreach ($values as $val) $result[$val] = $val;
    return $result;
  }


	public static function defaultConnectionName() {
		return 'gcp';
	}

	public function initialize(array $config)
	{
	  $db_config = $config['connection']->config();
	  $prefix = empty($db_config['prefix']) ? '' : $db_config['prefix'];
	  $table = $prefix . 'applicant';
		$this->addBehavior('Timestamp');
		$this->setTable($table);
		$this->setPrimaryKey('applicantID');
	}

	public function accept($ids=[]) {
	  $file = $this->getDownloadFile();
	  if (empty($file)) return 'Unable to create output file';
	  foreach ($ids as $id) {
	    $applicant = $this->getByID($id);
	    if ($applicant) {
	      $applicant->download_date = date("d/m/Y", time());
	      $applicant->download_time = date("H:i", time());
	      $applicant->download_stamp = time();
        $applicant->username = $this->createUsername($applicant);

        $record = $applicant->username . ',';
        $record .= $this->createPassword() . ',';
        $record .= $applicant->forename . ',';
        $record .= $applicant->surname . ',';
        $record .= $applicant->email . ',0,0' . self::$nl;

        $file->append($record);

        $this->save($applicant);
	    }
	  }
	  $file->close();
	  return false;
	}

	private function createPassword($sample='qwertyuiopasdfghjklzxcvbnmQWERTYUIOPASDFGHJKLZXCVBNM1234567890', $length=8) {
  	$newString = str_shuffle(str_repeat($sample, $length));
    return substr($newString, rand(0,strlen($newString)-$length), $length);
	}

	private function getDownloadFile() {
  	$dir = new Folder(TMP . 'gcp', true);
		$txtFilename = strtolower('gcp/' . date('Y_m_d') . '.txt');
		$txtFile = new File(TMP . $txtFilename);
		if (!$txtFile->exists()) {
		  $ok = $txtFile->create();
		  if (!$ok) return false;
		  $txtFile->write('username,password,firstname,lastname,email,maildisplay,autosubscribe' . self::$nl);
		}
		return $txtFile;
	}

	private function createUsername($applicant) {
	  $patterns = array('/\s+/','/-/');
    $replacements = array('','');
    $surname_fragment = substr(preg_replace($patterns,$replacements,$applicant['surname']),0,7);
    $first_initial = substr(preg_replace($patterns,$replacements,$applicant['forename']),0,1);
    $unique = true;
    $suffix = 0;
    $rootname = strtolower($surname_fragment.$first_initial);
    do {
      $username = $rootname . ($suffix==0 ? '' : $suffix);
      $duplicate = $this->getByUsername($username);
      if (!empty($duplicate->username) && $duplicate->username==$username) {
        $suffix++;
        $unique = false;
      } else {
        $unique = true;
      }
    } while (!$unique);
    return $username;
	}

	public function reject($ids=[]) {
	  foreach ($ids as $id) {
	    $applicant = $this->getByID($id);
	    if ($applicant) {
        $applicant->download_date = "Rejected";
        $this->save($applicant);
	    }
	  }
	}

	public function getByID($applicantID = null) {
		$query = $this->find('all') ->where(['applicantID'=>$applicantID]);
    $applicant = $query->first();
    if (!empty($applicant)) {
			$applicant->name = (!empty($applicant->title)?$applicant->title.' ':'') . (!empty($applicant->forename)?$applicant->forename.' ':'') . (!empty($applicant->surname)?$applicant->surname:'');
			$orgs = self::organisationsOptions();
			$applicant->organisation = !empty($orgs[$applicant->employer]) ? $orgs[$applicant->employer] : '';
    }
		return $applicant;
	}

	public function getByUsername($username = null) {
		$query = $this->find('all') ->where(['username'=>$username]);
    $applicant = $query->first();
    if (!empty($applicant)) {
			$applicant->name = (!empty($applicant->title)?$applicant->title.' ':'') . (!empty($applicant->forename)?$applicant->forename.' ':'') . (!empty($applicant->surname)?$applicant->surname:'');
			$orgs = self::organisationsOptions();
			$applicant->organisation = !empty($orgs[$applicant->employer]) ? $orgs[$applicant->employer] : '';
    }
		return $applicant;
	}

	public function getAvailable() {
		$query = $this->find('all') ->where([ 'download_date IS'=>null ]) ->order([ 'made_stamp' => 'ASC' ]);
    $applicants = $query->all();
		return $applicants;
	}

	public function getAccepted($search='') {
	  $where = [ 'download_date IS NOT'=>NULL, 'download_date IS NOT'=>'Rejected' ];
	  if (!empty($search)) $where['surname LIKE'] = $search . '%';
		$query = $this->find('all') ->where($where) ->order([ 'made_stamp' => 'DESC' ]) ->limit(100);
    $applicants = $query->all();
		return $applicants;
	}

	public function getRejected($search='') {
	  $where = [ 'download_date IS'=>'Rejected' ];
	  if (!empty($search)) $where['surname LIKE'] = $search . '%';
		$query = $this->find('all') ->where($where) ->order([ 'made_stamp' => 'DESC' ]) ->limit(100);
    $applicants = $query->all();
		return $applicants;
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

}