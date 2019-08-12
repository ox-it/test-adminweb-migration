<!-- File: src/Template/Harassment/report.ctp -->

<div class="row">

	<h3>Harassment Survey</h3>
    
	<div class="waf-include">
      <p><?php echo $user['name']; ?></p>
      <p>Please complete this form once for each person seeking advice.</p>
      <p class="small_text">(This anonymous information is requested solely for the purpose of monitoring the University's arrangements for dealing with harassment and will be treated as strictly confidential)</p>
    
	  <?php 
	   // Form uses validation set in HarassmentSurveys::validationReport()
	   // Options arrays are defined in the src/Model/Entity/HarassmentSurvey
	  ?>
	<!-- Form -->
    
    <?= $this->Form->create($survey, [ 'type'=>'file', 'context'=>[ 'validator'=>'report' ], 'novalidate'=>true ]) ?>
 
    <?= $this->Form->control('action', [ 'type'=>'hidden', 'value'=>'report' ]) ?>
    <?= $this->Form->control('submitted', [ 'type'=>'hidden', 'value'=>1 ]) ?>
    <?= $this->Form->control('0nilreturn', [ 'type'=>'hidden', 'value'=>0 ]) ?>
    
	<?php echo $this->Form->input('1_date_of_first_meeting', ['required' => true, 'maxYear' => date("Y"), 'type' => 'date','div' => false, 'label' => false, 'wrapInput' => false, 'label' => '1. Date of the first meeting with the person you are supporting:']); ?>
	<!-- <label class="gapabove"></strong></label> -->
	<?= $this->Form->label('2_supporting', 'Are you supporting: ') ?>
	<?= $this->Form->radio('2_supporting', [
	  
	    ['text' => 'The complainant', 'value' => '0'], 
	    ['text' => 'The alleged Harasser', 'value' => '1'],
	    ['text' => 'Other', 'value' => '2']
		
	  
			],['value' => '0']); ?>          
		  
   <?= $this->Form->control('2_other', ['type'=>'text', 'label'=>'Please specify:', 'disabled' => true]); ?>
   	
   <?= $this->Form->control('3_complainant_department', ['type'=>'select', 'options'=>$departments, 'empty'=>'-- Please Select --', 'label'=>'3. If known, please confirm the complainant(s) department, faculty or college:']); ?>
         
   <label class="gapabove">4. Is the complainant:</strong></label>
   <table>
     <tbody>
       <tr><td></td><th scope="col">Male</th><th scope="col">Female</th><th scope="col">Other</th><th scope="col">Unknown</th></tr>
       <?= $survey::maleFemaleOtherUnknownTextNums($this, '4_university_staff_male', '4_university_staff_female', '4_university_staff_other', '4_university_staff_unknown','University staff') ?>
       <?= $survey::maleFemaleOtherUnknownTextNums($this, '4_college_staff_male', '4_college_staff_female', '4_college_staff_other', '4_college_staff_unknown','College staff') ?>
       <?= $survey::maleFemaleOtherUnknownTextNums($this, '4_undergraduate_student_male', '4_undergraduate_student_female', '4_undergraduate_student_other', '4_undergraduate_student_unknown','Undergraduate Student') ?>
       <?= $survey::maleFemaleOtherUnknownTextNums($this, '4_graduate_student_male', '4_graduate_student_female', '4_graduate_student_other', '4_graduate_student_unknown','Graduate Student') ?>
       <?= $survey::maleFemaleOtherUnknownTextNums($this, '4_unknown_male', '4_unknown_female', '4_unknown_other', '4_unknown_unknown','Unknown') ?>
       <?= $survey::maleFemaleOtherUnknownTextNums($this, '4_other_male', '4_other_female', '4_other_other', '4_other_unknown','Other') ?>
     </tbody>
   </table>           
   
   <!-- Nature of behaviour (tick boxes allowing multiple choices) -->	
   <label class="gapabove">5. Nature of behaviour / incident described (tick more than one if necessary):</span></label>
   <?= $this->Form->control('5_offensive', ['type'=>'checkbox', 'label'=>'Offensive comments or body language, including insults, jokes or gestures (written, face-to-face or through a third party)']); ?>
   <?= $this->Form->control('5_bullying', ['type'=>'checkbox', 'label'=>'Bullying']); ?>
   <?= $this->Form->control('5_isolation', ['type'=>'checkbox', 'label'=>'Isolation from work or study']); ?>
   <?= $this->Form->control('5_hostility', ['type'=>'checkbox', 'label'=>'Hostility, verbal or physical threats']); ?>
   <?= $this->Form->control('5_malicious', ['type'=>'checkbox', 'label'=>'Malicious rumours']); ?>
   <?= $this->Form->control('5_embarrassing', ['type'=>'checkbox', 'label'=>'Embarrassing or patronising behaviour or comments, humiliating and/or demeaning criticism']); ?>
   <?= $this->Form->control('5_physical', ['type'=>'checkbox', 'label'=>'Physical abuse / assault']); ?>
   <?= $this->Form->control('5_sexual_harassment', ['type'=>'checkbox', 'label'=>'Sexual harassment']); ?>
   <?= $this->Form->control('5_sexual_assult', ['type'=>'checkbox', 'label'=>'Sexual assault / rape']); ?>
   <?= $this->Form->control('5_stalking', ['type'=>'checkbox', 'label'=>'Stalking']); ?>
   <?= $this->Form->control('5_other', ['type'=>'text', 'label'=>'Other (Please specify)']); ?>
   
         
   <label class="gapabove">6. Did the behaviour explicitly, or in the eyes of the complainant, relate to:</label>
   <?= $this->Form->control('6_age', ['type'=>'checkbox', 'label'=>'Age']); ?>
   <?= $this->Form->control('6_disability', ['type'=>'checkbox', 'label'=>'Disability']); ?>
   <?= $this->Form->control('6_gender', ['type'=>'checkbox', 'label'=>'Gender']); ?>
   <?= $this->Form->control('6_pregnancy', ['type'=>'checkbox', 'label'=>'Pregnancy / maternity']); ?>
   <?= $this->Form->control('6_race', ['type'=>'checkbox', 'label'=>'Race']); ?>
   <?= $this->Form->control('6_religion', ['type'=>'checkbox', 'label'=>'Religion or belief']); ?>
   <?= $this->Form->control('6_sexuality', ['type'=>'checkbox', 'label'=>'Sexual Orientation']); ?>
   <?= $this->Form->control('6_transgender', ['type'=>'checkbox', 'label'=>'Transgender']); ?>
   <?= $this->Form->control('6_other', ['type'=>'text', 'label'=>'Other']); ?>
         
            
   <?= $this->Form->control('7_accused_dept', ['type'=>'select', 'options'=>$departments, 'empty'=>'-- Please Select --', 'label'=>'7. If known, please confirm the department, faculty or college that the person(s) complained about belongs to:']); ?>
            
   <!-- People complained about (number of male, female, unknown & other enquirers in each category) -->
  <label class="gapabove">8. Was the person(s) complained about:</label>
  <table>
    <tbody>
      <tr><td></td><th scope="col">Male</th><th scope="col">Female</th><th scope="col">Other</th><th scope="col">Unknown</th></tr>
      <?= $survey::maleFemaleOtherUnknownTextNums($this, '8_university_staff_male', '8_university_staff_female', '8_university_staff_other', '8_university_staff_unknown','University staff') ?>
      <?= $survey::maleFemaleOtherUnknownTextNums($this, '8_college_staff_male', '8_college_staff_female', '8_college_staff_other', '8_college_staff_unknown','College staff') ?>
      <?= $survey::maleFemaleOtherUnknownTextNums($this, '8_undergraduate_student_male', '8_undergraduate_student_female', '8_undergraduate_student_other', '8_undergraduate_student_unknown','Undergraduate Student') ?>
      <?= $survey::maleFemaleOtherUnknownTextNums($this, '8_graduate_student_male', '8_graduate_student_female', '8_graduate_student_other', '8_graduate_student_unknown','Graduate Student') ?>
      <?= $survey::maleFemaleOtherUnknownTextNums($this, '8_unknown_male', '8_unknown_female', '8_unknown_other', '8_unknown_unknown','Unknown') ?>
      <?= $survey::maleFemaleOtherUnknownTextNums($this, '8_other_male', '8_other_female', '8_other_other', '8_other_unknown','Other') ?>
    </tbody>
  </table>        

  <label class="gapabove">9. Do you know what steps the person you are supporting intends to take next (tick more than one if necessary):</label>
  <?= $this->Form->control('9_no_further_action', ['type'=>'checkbox', 'label'=>'No further action at this time']); ?>
  <?= $this->Form->control('9_pursue_training', ['type'=>'checkbox', 'label'=>'Pursue training, coaching, mentoring opportunities']); ?>
  <?= $this->Form->control('9_contact_agencies', ['type'=>'checkbox', 'label'=>'Contacting internal or external agencies or support services']); ?>
  <?= $this->Form->control('9_tell_person', ['type'=>'checkbox', 'label'=>'Tell the person that they are unhappy with their behaviour']); ?>
  <?= $this->Form->control('9_seek_help', ['type'=>'checkbox', 'label'=>'Seek help from their department / college to facilitate an informal resolution (including mediation)']); ?>
  <?= $this->Form->control('9_formal_complaint', ['type'=>'checkbox', 'label'=>'Submit a formal complaint']); ?>
  <?= $this->Form->control('9_other', ['type'=>'text', 'label'=>'Other']); ?> 
            
  <label class="gapabove">10. Has the person you have been supporting also been in touch with:</label>
  <?= $this->Form->control('10_harassment_line', ['type'=>'checkbox', 'label'=>'Harassment Line']); ?>
  <?= $this->Form->control('10_welfare_and_support', ['type'=>'checkbox', 'label'=>'Student Welfare and Support Services']); ?>
  <?= $this->Form->control('10_proctors_office', ['type'=>'checkbox', 'label'=>'The Proctors Office']); ?>
  <?= $this->Form->control('10_local_central_hr', ['type'=>'checkbox', 'label'=>'Local or Central HR']); ?>
	
  <!-- Submit -->
    
  <?= $this->Form->button(__('Submit Request')) ?>
  <?= $this->Form->button('Clear Form', [ 'type'=>'reset' ]) ?>
  <?php echo $this->Form->end(); ?>

	</div>
</div>