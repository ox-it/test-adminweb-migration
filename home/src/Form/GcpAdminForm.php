<?php
// src/Form/GcpAdminForm.php

namespace App\Form;

use Cake\Form\Form;
use Cake\Form\Schema;
use Cake\Validation\Validator;
use Cake\Filesystem\Folder;
use Cake\Filesystem\File;

class GcpAdminForm extends Form
{

	public function validationAdmin() {
		$validator = new Validator();
		$validator ->notEmpty('sloblock');
		return $validator;
	}

	protected function _execute(array $data)
  {
     // Check action
     $data['action'] = '';
     if (isset($data['accept'])) $data['action'] = 'accept';
     if (isset($data['reject'])) $data['action'] = 'reject';

     // Gather IDs
     $data['ids'] = [];
     for ($i=0;$i<$data['row_tot'];$i++) {
       if (!empty($data['app'.$i])) {
         $id = $data['app'.$i];
         if (!empty($data['selector'.$id]) && $data['selector'.$id]=='1') $data['ids'][] = $id;
       }
     }

     return $data;
  }

}