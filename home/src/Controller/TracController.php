<?php
// src/Controller/TracController.php

namespace App\Controller;

use Cake\Datasource\ConnectionManager;
use Cake\Filesystem\File;
use Cake\Mailer\Email;


class TracController extends AppController
{

  public static function defaultConnectionName() {
      return 'trac';
  }

  public function index()
  {
    $survey = $this->getLatestSurveyOrInvalidate();
    if ($survey) {
      if ($this->request->is(['post', 'put'])) {
        $survey = $this->TracSurveys->patchEntity($survey, $this->request->getData(), ['validate'=>$survey->group_colour]);
        if ($this->TracSurveys->save($survey)) {
          $this->Flash->success(__('Saved.'));
          $this->set('survey', $survey);
          $this->render('success'); return;
        } else {
          $this->Flash->error(__('Sorry. Your survey contains errors.'));
        }
      }
      $this->set('survey', $survey);

      // Render based on group colour
      if ($survey->group_colour=='blue') $this->render('blue');
      if ($survey->group_colour=='green') $this->render('green');
    }
  }

  private function getLatestSurveyOrInvalidate()
  {
    // DONE: Remove the development OSS value
    // if (empty($_SERVER['HTTP_WAF_WEBAUTH'])) $_SERVER['HTTP_WAF_WEBAUTH'] = 'orie1954';
    // 'sloblock' - non existant
    // 'phpc0364' - green - expired
    // 'orie1954' - green
    // 'sjoh0487' - blue
    // 'bras2682' - blue - expired - empty
    // 'corp0382' - blue - expired

    if (empty($_SERVER['HTTP_WAF_WEBAUTH'])) {
      // TODO: Force Oxford SSO Login
    }

    $this->loadModel('TracSurveys');
    $survey = $this->TracSurveys->getByOxfordID();
    if (empty($survey)) {
      $this->render('nouser');
      return null;
    }

    $this->set('survey', $survey);
    $survey->is_ready = (time() > $this->Waf->date_to_stamp($survey->group_week));
    $survey->is_still_collecting = (time() < $this->Waf->date_to_stamp($survey->group_finish_date, 'end'));
    //$this->Flash->success('SURVEY: '.print_r($survey,true));
    //$this->Flash->success('SURVEY: '.json_encode($survey));

    if (!$survey->is_ready || !$survey->is_still_collecting) {
      $this->render('notcollecting');
      return null;
    }

    $survey->old_date = $this->Waf->date_to_stamp($survey->date_submitted);
    return $survey;
  }

}