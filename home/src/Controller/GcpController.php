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
	  if (!$this->check_ip()) return $this->render('noaccess');

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

  private function check_ip()
  {
    $ip = $_SERVER['REMOTE_ADDR'];

    // List of IPs that can access admin pages
    if ($ip=='169.254.214.100') return true;
    if ($ip=='192.168.1.64') return true;

    $this->Flash->error('Bad IP: ' . $ip);
    return false;
  }

  /* Do not allow direct access - use render instead
	public function success($applicantID)
	{
		$this->loadModel('GcpApplicants');
		$this->set('applicant', $this->GcpApplicants->getByID($applicantID));
	}
	//*/

}