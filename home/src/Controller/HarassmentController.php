<?php
// src/Controller/HarassmentController.php

namespace App\Controller;

use Cake\Datasource\ConnectionManager;
use Cake\Filesystem\File;
use Cake\Mailer\Email;


class HarassmentController extends AppController
{

	public static function defaultConnectionName() {
		return 'harassment';
	}

	public function index()
	{
		// Respond to GET parameters
  		$action = $this->request->getData('action');
		$userID = $this->request->getData('personID');
		$deptcode = $this->request->getData('deptcode');
		$acyear = $this->request->getData('acyear');
  	
  		if (!empty($action) && in_array($action,['report','noreport'])) {
  	  		return $this->$action($userID,$deptcode,$acyear);
    	}
    	elseif (!empty($action) && in_array($action,['admin'])) {//$this->Flash->success('USER: ' . print_r($user,true));
            return $this->$action($userID);
        }
        elseif (!empty($action) && in_array($action,['user_admin'])) {
          return $this->$action($userID);
        }
        elseif (!empty($action) && in_array($action,['save_user'])) {
            $data  = $this->request->getData();
            return $this->$action($data);
        }
        elseif (!empty($action) && in_array($action,['delete_user'])) {
            $data  = $this->request->getData();
            return $this->$action($data);
		}
		elseif (!empty($action) && in_array($action, ['download_report'])) {
            return $this->$action();
        }
        elseif(!empty($action) && in_array($action, ['edit_user'])) {
            $user_id = $this->request->getData('user_id');
            return $this->$action($user_id);
        }
        elseif(!empty($action) && in_array($action, ['add_user'])) {
            return $this->$action();
		}
		elseif (!empty($action) && in_array($action,['department_admin'])) {
            return $this->$action($userID);
		}
        elseif (!empty($action) && in_array($action,['save_department'])) {
            $data  = $this->request->getData();
            return $this->$action($data);
        }
        elseif (!empty($action) && in_array($action,['delete_department'])) {
            $data  = $this->request->getData();
            return $this->$action($data);
        }
        elseif(!empty($action) && in_array($action, ['edit_department'])) {
            $dept_code = $this->request->getData('dept_code');
            return $this->$action($dept_code);
        }
        elseif(!empty($action) && in_array($action, ['add_department'])) {
            return $this->$action();
        }
        elseif(!empty($action) && in_array($action, ['download_report'])) {
            return $this->$action();
        }

  		// Otherwise continue
		$user = $this->getOxfordUserAndValidate();
		$user['is_admin'] = $this->check_secure();
		if ($this->request->is(['post','put'])) {
			$user = $this->HarassmentUsers->patchEntity($user, $this->request->getData());
			$this->Flash->success('USER: ' . print_r($user,true));
            
            if (!empty($user->action)) {
                //return $this->redirect([ '?' => [ 'a'=>($user->action == 'report'?'report':'noreport'), 'u'=>$user->userID, 'd'=>$user->deptcode, 'y'=>$user->acyear ] ]);
                $action = $user->action;
       	        if (!empty($action) && in_array($action,['report','noreport'])) {
					return $this->$action($user->userID, $user->deptcode, $user->acyear);
				}
                /*
                if ($user->action == 'report') {
                    return $this->redirect([ 'action' => 'report', $user->userID, $user->deptcode, $user->acyear ]);
                } else {
                     return $this->redirect([ 'action' => 'noreport', $user->userID, $user->deptcode, $user->acyear ]);
                }
                //*/
            }
		}
	}

    public function add_user()
    {
        if (!$this->check_secure()) return $this->render('noaccess');
        $this->loadModel('HarassmentUsers');
        $this->loadModel('HarassmentDepartments');

        $departments = $this->HarassmentDepartments->getSelectOptions();
        $this->set('departments', $departments);
        $this->render('edit_user');
    }

    public function delete_user($user_data)
    {
        if (!$this->check_secure()) return $this->render('noaccess');
        $this->loadModel('HarassmentUsers');
        $this->loadModel('HarassmentDepartments');
        $this->loadModel('HarassmentUsersDepartments');

        $user = $this->HarassmentUsers->find('all', array('conditions'=>array('userID='.$user_data['user_id'])))->contain(['HarassmentDepartments'])->first();
        $user_dept_id =($user['harassment_departments'][0]['_joinData']['user_deptID']);

        if ($this->HarassmentUsers->delete($user)) {

        }

        $users = $this->HarassmentUsers->find('all')->contain(['HarassmentDepartments']);
        $departments = $this->HarassmentDepartments->getSelectOptions();
        $this->set('users', $users);
        $this->set('departments', $departments);
        $this->render('admin_users');
    }

    public function edit_user($user_id)
    {
        if (!$this->check_secure()) return $this->render('noaccess');
        $this->loadModel('HarassmentDepartments');
        $this->loadModel('HarassmentUsers');
        $user = $this->HarassmentUsers->find('all', array('conditions'=>array('userID='.$user_id)))->contain(['HarassmentDepartments'])->first();

        $departments = $this->HarassmentDepartments->getSelectOptions();
        $this->set('user', $user);
        $this->set('departments', $departments);
        $this->render('edit_user');
    }

    public function save_user($new_data)
	{
        $this->loadModel('HarassmentDepartments');
        $this->loadModel('HarassmentUsers');
        $this->loadModel('HarassmentUsersDepartments');

        if (isset($new_data['user_id']) && $new_data['user_id']) {
            $user = $this->HarassmentUsers->find('all', array('conditions'=>array('userID='.$new_data['user_id'])))->contain(['HarassmentDepartments'])->first();
            $user->name = $new_data['name'];
            $user->oxfordID = $new_data['SSO'];
            $user_dept_id = $user['harassment_departments'][0]['_joinData']['user_deptID'];
        }
        else {
            $user = $this->HarassmentUsers->newEntity();
            $user->name = $new_data['name'];
            $user->oxfordID = $new_data['SSO'];
        }

        if($this->HarassmentUsers->save($user)) {
            if(isset($user_dept_id)) {
                $user_dept = $this->HarassmentUsersDepartments->get($user_dept_id);
                $user_dept->deptcode = $new_data['department'];
            }
            else {
                $user_dept = $this->HarassmentUsersDepartments->newEntity();
                $user_dept->userID = $user['userID'];
                $user_dept->deptcode = $new_data['department'];
            }

            $this->HarassmentUsersDepartments->save($user_dept);
        }

        $users = $this->HarassmentUsers->find('all')->contain(['HarassmentDepartments']);
        $departments = $this->HarassmentDepartments->getSelectOptions();
        $this->set('users', $users);
        $this->set('departments', $departments);
        $this->render('admin_users');
    }

    public function user_admin($userID)
    {
        if (!$this->check_secure()) return $this->render('noaccess');

        $this->loadModel('HarassmentUsers');
        $this->loadModel('HarassmentDepartments');
        $users = $this->HarassmentUsers->find('all')->contain(['HarassmentDepartments']);
        $departments = $this->HarassmentDepartments->getSelectOptions();
        $this->set('users', $users);
        $this->set('departments', $departments);
        $this->render('admin_users');
    }

    public function department_admin($userID)
    {
        if (!$this->check_secure()) return $this->render('noaccess');

        $this->loadModel('HarassmentDepartments');
        $departments = $this->HarassmentDepartments->find('all');
        $this->set('departments', $departments);
        $this->render('admin_departments');
    }

    public function edit_department($deptcode)
    {
        if (!$this->check_secure()) return $this->render('noaccess');
        $this->loadModel('HarassmentDepartments');
        $department = $this->HarassmentDepartments->find('all', array('conditions'=>array('deptcode="'.$deptcode.'"')))->first();
        $this->set('department', $department);
        $this->render('edit_department');
    }

    public function add_department()
    {
        if (!$this->check_secure()) return $this->render('noaccess');
        $this->render('edit_department');
    }

    public function save_department($new_data)
    {
        $this->loadModel('HarassmentDepartments');

        if (isset($new_data['deptcode_original']) && $new_data['deptcode_original']) {
            $department = $this->HarassmentDepartments->find('all', array('conditions'=>array('deptcode="'.$new_data['deptcode_original'].'"')))->first();
            $department->deptcode = $new_data['deptcode'];
            $department->deptalpha = $new_data['deptalpha'];
        }
        else {

        }
 
        if($this->HarassmentDepartments->save($department)) {

        }

        $departments = $this->HarassmentDepartments->find('all');
        $this->set('departments', $departments);
        $this->render('admin_departments');
    }

    public function delete_department($dept_data)
    {
        if (!$this->check_secure()) return $this->render('noaccess');
        $this->loadModel('HarassmentDepartments');

        $department = $this->HarassmentDepartments->find('all', array('conditions'=>array('deptcode="'.$dept_data['deptcode_original'].'"')))->first();

        if ($this->HarassmentDepartments->delete($department)) {

        }

        $departments = $this->HarassmentDepartments->find('all');
        $this->set('departments', $departments);
        $this->render('admin_departments');
    }

    public function admin($userID)
	            {
			                    if (!$this->check_secure()) return $this->render('noaccess');
					                    $user = $this->getOxfordUserAndValidate();

					                    $this->render('admin');

							            }

	public function report($userID, $deptcode, $acyear)
	{
	    $submitted = $this->request->getData('submitted');
		//$this->Flash->success('REPORT :: USER:' . $userID . ' DEPTCODE:'.$deptcode . ' ACYEAR:'.$acyear  . ' SUMITTED:'.$submitted );

		$user = $this->getOxfordUserAndValidate();
		$this->loadModel('HarassmentSurveys');
		$survey = $this->HarassmentSurveys->newEntity(['personID'=>$userID, 'deptcode'=>$deptcode, 'year'=>$acyear]);

		$this->loadModel('HarassmentDepartments');
		$departments = $this->HarassmentDepartments->getSelectOptions();
		$this->set('departments', $departments);

		if ($this->request->is(['post', 'put']) && $submitted) {
			$survey = $this->HarassmentSurveys->patchEntity($survey, $this->request->getData(), ['validate'=>'report']);
			if ($this->HarassmentSurveys->save($survey)) {
				$this->Flash->success(__('Saved.'));
				//$this->Flash->success('SURVEY: ' . print_r($survey,true));
				//$this->Flash->success('USER: ' . print_r($user,true));
				//return $this->redirect(['action' => 'success', $survey->surveyID]);
    		$this->set('user', $user);
    		$this->set('survey', $survey);
				return $this->render('success');
			} else {
			  $this->Flash->error(__('Sorry. Your survey contains errors. Please check all the fields for errors/omissions.'));
			}
		}
		$this->set('survey', $survey);
		$this->render('report');
	}

	public function noreport($userID, $deptcode, $acyear)
	{
		//$this->Flash->success('NOREPORT :: USER:' . $userID . ' DEPTCODE:'.$deptcode . ' ACYEAR:'.$acyear );
		$user = $this->getOxfordUserAndValidate();
		$this->loadModel('HarassmentSurveys');
		$survey = $this->HarassmentSurveys->getByDeptAndYear($deptcode, $acyear);
		//$this->Flash->success('SURVEY: '.json_encode($survey));
		$this->set('survey', $survey);
		//$surveys = $this->HarassmentSurveys->getByDept($deptcode);
		//$this->Flash->success('SURVEYS: '.json_encode($surveys));
		$this->set('surveys', []);
		if (empty($survey)) {
		  $nilreport = $this->HarassmentSurveys->newEntity([
		    'personID' => $userID,
		    'deptcode' => $deptcode,
		    'year' => $acyear,
		    '0nilreturn' => 1
		  ]);
		  $this->HarassmentSurveys->save($nilreport);
  		$this->set('report', $nilreport);
		}
		$this->render('noreport');
	}

  /*
	public function success($surveyID)
	{
		$user = $this->getOxfordUserAndValidate();
		$this->loadModel('HarassmentSurveys');

		$survey = $this->HarassmentSurveys->getByID($surveyID);
		if (empty($user) || empty($survey->personID) || $survey->personID!=$user->userID) {
		  $this->render('nouser');
		  return null;
		}

    $this->loadModel('HarassmentDepartments');
    $survey->inqdept = $this->HarassmentDepartments->getByCode($survey->{'12inqdeptcode'});

		//$this->Flash->success('SURVEY: '.json_encode($survey));
		$this->set('survey', $survey);
		$this->set('waf', $this->Waf);
	}
	//*/

	private function getOxfordUserAndValidate()
	{
	  // Removed the development OSS value
		// if (empty($_SERVER['HTTP_WAF_WEBAUTH'])) $_SERVER['HTTP_WAF_WEBAUTH'] = 'clme1428';
		// 'sloblock' - non existant
		// 'alls0027' - inactive
		// 'bioc0236' - single dept
		// 'ashgjp'   - multiple depts
    //$this->Flash->success('USER: '.getenv('HTTP_WAF_WEBAUTH'));

		if (empty($_SERVER['HTTP_WAF_WEBAUTH'])) {
		  // TODO: Force Oxford SSO Login
		}

	  $this->loadModel('HarassmentUsers');
		$user = $this->HarassmentUsers->getByOxfordID();
    //$this->Flash->success('USER: '.json_encode($user));
		if (empty($user) || !empty($user->inactive)) {
		  $this->render('nouser');
		  return null;
		}
		$this->set('user', $user);
		return $user;
	}

	private function emailConfirmation($applicant)
	{
	  $message  = "<p>Dear ".$applicant->title." ".$applicant->forename." ".$applicant->surname.",</p>\n";
		// Send the email
		$email = new Email('default');
  	    $email->from(['AcademicAdmin.Comms@admin.ox.ac.uk' => 'Academic Administration Division Communications']);
		//$email->to($person->email);
		// TODO: Remove test email
		$email->to(['samuel.press@it.ox.ac.uk'=>'Sam Press']);
		$email->subject('AAD Event Registration');
		$email->emailFormat('html');
		$email->send($message);
	}

    private function check_secure()
    {
        $this->loadModel('HarassmentUsers');
        $user = $this->HarassmentUsers->getByOxfordID();
	
	if ($user->admin == 1) {
            return true;
        } else {
            return false;
        }

       return false;
    }

}
