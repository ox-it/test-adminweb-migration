<?php
// src/Controller/GcpController.php

namespace App\Controller;

use App\Form\GcpAdminForm;

use Cake\Datasource\ConnectionManager;

class GcpController extends AppController
{

	public function index()
	{
		$this->loadModel('GcpApplicants');
		$this->set('organisations', $this->GcpApplicants->organisationsOptions());
		$applicant = $this->GcpApplicants->newEntity();
		if ($this->request->is(['post', 'put'])) {
			$applicant = $this->GcpApplicants->patchEntity($applicant, $this->request->getData(), ['validate'=>'register']);
			if ($this->GcpApplicants->save($applicant)) {
				$this->Flash->success(__('Saved.'));
				$this->set('applicant', $applicant);
				$this->render('success');
				return;
			}
			$this->Flash->error(__('Sorry. Your application contains errors.'));
		}
		$this->set('applicant', $applicant);
	}

  // Administrative functionality - keep behind security!
	public function admin()
	{
	  // Admin IP security
	  if (!$this->check_secure()) return $this->render('noaccess');

	  // Respond to GET parameters
  	$accepted = $this->request->getQuery('accepted');
  	if (isset($accepted)) return $this->accepted($accepted);
  	$rejects = $this->request->getQuery('rejects');
  	if (isset($rejects)) return $this->rejects($rejects);

	  $admin = new GcpAdminForm();
  	$this->set('admin', $admin);

		$this->loadModel('GcpApplicants');
		$applicants = $this->GcpApplicants->getAvailable();
		$this->set('applicants', $applicants);

		if ($this->request->is(['post', 'put'])) {
  		$result = $admin->execute($this->request->getData());
			if ($result) {

  		  // Make at least one applicant has been accepted
  		  if (count($result['ids'])<1) return $this->Flash->error('Please select one or more applicants first!');

  		  // Accept
  		  if ($result['action']==="accept") return $this->accept($result['ids']);

  		  // Reject
  		  if ($result['action']==="reject") return $this->reject($result['ids']);

			} else {
  		  //$this->Flash->error('ADMIN:' . print_r($result,true));
				$this->Flash->error('There was a problem. Please check the form.');
			}
		}
	}

	private function accept($ids) {
    $error = $this->GcpApplicants->accept($ids);
    if ($error) 	$this->Flash->error($error);
	  else 					$this->Flash->success('Accepted ' . count($ids) . ' applicant' . (count($ids)>1 ? 's' : ''));
		$this->set('applicants', $this->GcpApplicants->getAvailable());
	}

	private function reject($ids) {
	  $this->Flash->success('Rejected ' . count($ids) . ' applicant' . (count($ids)>1 ? 's' : ''));
    $this->GcpApplicants->reject($ids);
		$this->set('applicants', $this->GcpApplicants->getAvailable());
	}

  // Administrative functionality - keep behind security!
	private function accepted($search='')
	{
	  $admin = new GcpAdminForm();
  	$this->set('admin', $admin);

		$this->loadModel('GcpApplicants');
		$applicants = $this->GcpApplicants->getAccepted($search);
		$this->set('applicants', $applicants);

		if ($this->request->is(['post', 'put'])) {
  		$result = $admin->execute($this->request->getData());
			if ($result) {

  		  if (count($result['ids'])<1) {
  		    $this->Flash->error('Please select one or more applicants first!');
        } else {
    		  if ($result['action']==="reject") $this->reject($result['ids']);
    		}

			} else {
  		  //$this->Flash->error('ADMIN:' . print_r($result,true));
				$this->Flash->error('There was a problem. Please check the form.');
			}
		}

		$this->render('accepted');
	}

  // Administrative functionality - keep behind security!
	private function rejects($search='')
	{
	  $admin = new GcpAdminForm();
  	$this->set('admin', $admin);

		$this->loadModel('GcpApplicants');
		$applicants = $this->GcpApplicants->getRejected($search);
		$this->set('applicants', $applicants);

		if ($this->request->is(['post', 'put'])) {
  		$result = $admin->execute($this->request->getData());
			if ($result) {

  		  if (count($result['ids'])<1) {
  		    $this->Flash->error('Please select one or more applicants first!');
        } else {
    		  if ($result['action']==="accept") $this->accept($result['ids']);
    		}

			} else {
  		  //$this->Flash->error('ADMIN:' . print_r($result,true));
				$this->Flash->error('There was a problem. Please check the form.');
			}
		}

		$this->render('rejects');
	}

  private function check_secure()
  {
    $ip = $_SERVER['REMOTE_ADDR'];

    // List of Test IPs that can access admin pages
    if (!empty($_SERVER['SERVER_NAME'])) {
		  if ($_SERVER['SERVER_NAME']=='almac.local') {
        if (substr($ip,0,10)=='192.168.1.') return true;
      }
		  if ($_SERVER['SERVER_NAME']=='waf-td.nsms.ox.ac.uk') {
				if (substr($ip,0,10)=='192.168.1.') return true;
				if (substr($ip,0, 7)=='129.67.') return true;
				// Finlay's PC
				if ($ip=='163.1.124.150') return true;
      }
    }
      
    $authorised_on_live = [
        # Research Support staff
        'admn2434', # Karl Shepherd
        'admn4354', # Mark Crossley
        'immd0345', # Ronja Bahadori
        'phpc0487', # Karen Melham
        # IT Services
        'pubh0164', # Finlay Birnie
        'clme1428' # Sam Press
    ];

    if (empty($_SERVER['HTTP_WAF_WEBAUTH'])) {
		  return false;
		} else {
		  $sso = $_SERVER['HTTP_WAF_WEBAUTH'];
		  if (in_array($sso, $authorised_on_live)) return true;
		}

    //$this->Flash->error('Bad Access: ' . $ip);
    return false;
  }

}
