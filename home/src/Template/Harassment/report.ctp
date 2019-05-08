<!-- File: src/Template/Harassment/report.ctp -->

<div class="row">

	<h3>
		Harassment Survey
	</h3>

	<div class="waf-include">

    <!-- Information -->
	  <p>Please complete this form once for each person seeking advice.</p>
    <p class="small_text">
      (This anonymous information is requested solely for the purpose of monitoring the
      University's arrangements for dealing with harassment and will be treated as
      strictly confidential)
    </p>

    <?php
      // Form uses validation set in HarassmentSurveys::validationReport()
      // Options arrays are defined in the src/Model/Entity/HarassmentSurvey
    ?>
    <!-- Form -->
		<?= $this->Form->create($survey, [ 'type'=>'file', 'context'=>[ 'validator'=>'report' ], 'novalidate'=>true ]) ?>

      <?= $this->Form->control('action', [ 'type'=>'hidden', 'value'=>'report' ]) ?>
      <?= $this->Form->control('submitted', [ 'type'=>'hidden', 'value'=>1 ]) ?>
      <?= $this->Form->control('0nilreturn', [ 'type'=>'hidden', 'value'=>0 ]) ?>

			<!-- The capacity the user was acting in -->
  		<?= $this->Form->control('official_role', ['type'=>'radio', 'options'=>$survey::roleOptions(), 'label'=>'1.1 Please select your role in this case'], [ 'label'=>false ]); ?>

      <!-- Department code for the inquirer -->
  		<?= $this->Form->control('12inqdeptcode', ['type'=>'select', 'options'=>$departments, 'empty'=>'-- Please Select --', 'label'=>'1.2 Please select the department, faculty or college the inquirer was from']); ?>

      <!-- Inquirer details (number of male and female enquirers in each category) -->
      <label class="gapabove">2.1 Inquirers</strong> <span class="small_text">(please enter a number or leave blank for zero)</label>
      <div class="inline_wrapper"><p><strong>Male &nbsp;</strong></p><p><strong>Female</strong></p></div>
			<?= $survey::maleFemaleTextNums($this, '21aacm', '21bacf', 'Academic staff') ?>
			<?= $survey::maleFemaleTextNums($this, '21cacrelm', '21dacrelf', 'Academic-related staff') ?>
			<?= $survey::maleFemaleTextNums($this, '21enonacm', '21fnonacf', 'Support staff') ?>
			<?= $survey::maleFemaleTextNums($this, '21gugm', '21hugf', 'Undergraduate student') ?>
			<?= $survey::maleFemaleTextNums($this, '21ipgm', '21jpgf', 'Graduate student') ?>
			<?= $survey::maleFemaleTextNums($this, '21kotherm', '21lotherf', 'Other:' . $this->Form->control('21klotherdetails', $survey::textNum(13,40,255)) ) ?>

      <!-- Nature of inquiry (tick boxes allowing multiple choices) -->
      <label class="gapabove">2.2 Nature of inquiry <span class="small_text">(select any that apply)</span></label>
      <?= $this->Form->control('22aadvicegeninfo', ['type'=>'checkbox', 'label'=>'General information']); ?>
      <?= $this->Form->control('22badviceharassment', ['type'=>'checkbox', 'label'=>'Advice re: harassment experienced']); ?>
      <?= $this->Form->control('22cadvicecomplaint', ['type'=>'checkbox', 'label'=>'Advice re: complaint or possible complaint against inquirers']); ?>
      <?= $this->Form->control('22dadviceadvisor', ['type'=>'checkbox', 'label'=>'Another adviser seeking advice']); ?>
      <?= $this->Form->control('22fadviceother', ['type'=>'checkbox', 'label'=>'Other']); ?>
      <div id="22f-wrapper">
				<?= $this->Form->control('22fadviceotherdetails', ['type'=>'text', 'label'=>'Other - Please specify', 'size'=>40, 'maxlength'=>255 ]); ?>
      </div>

      <!-- Nature of behaviour (tick boxes allowing multiple choices) -->
      <label class="gapabove">3. Nature of behaviour <span class="small_text">(select any that apply)</span></label>
      <?= $this->Form->control('3averbalabuse', ['type'=>'checkbox', 'label'=>'Verbal abuse, offensive remarks or threats']); ?>
      <?= $this->Form->control('3bwrittenabuse', ['type'=>'checkbox', 'label'=>'Written abuse, offensive remarks or threats']); ?>
      <?= $this->Form->control('3cimages', ['type'=>'checkbox', 'label'=>'Offensive electronic images (e.g. downloads from websites)']); ?>
      <?= $this->Form->control('3dbullying', ['type'=>'checkbox', 'label'=>'Bullying']); ?>
      <?= $this->Form->control('3eassault', ['type'=>'checkbox', 'label'=>'Physical abuse/assault']); ?>
      <?= $this->Form->control('3fadvances', ['type'=>'checkbox', 'label'=>'Unwelcome sexual advances']); ?>
      <?= $this->Form->control('3gsexualassault', ['type'=>'checkbox', 'label'=>'Sexual assault/rape']); ?>
      <?= $this->Form->control('3iinappropriate', ['type'=>'checkbox', 'label'=>'Allegation of inappropriate behaviour']); ?>
      <?= $this->Form->control('3hother', ['type'=>'checkbox', 'label'=>'Other']); ?>
      <div id="3ho-wrapper">
				<?= $this->Form->control('3hotherdetails', ['type'=>'text', 'label'=>'Other - Please specify', 'size'=>40, 'maxlength'=>255 ]); ?>
      </div>

      <!-- Behaviour relating to: (tick boxes allowing multiple choices) -->
      <label class="gapabove">4. Did behaviour explicitly, or in the eyes of the inquirer, relate to <span class="small_text">(select any that apply)</span></label>
      <?= $this->Form->control('4arace', ['type'=>'checkbox', 'label'=>'Race']); ?>
      <?= $this->Form->control('4bgender', ['type'=>'checkbox', 'label'=>'Gender']); ?>
      <?= $this->Form->control('4csexualorientation', ['type'=>'checkbox', 'label'=>'Sexual Orientation']); ?>
      <?= $this->Form->control('4hgenderreassignment', ['type'=>'checkbox', 'label'=>'Gender Reassignment']); ?>
      <?= $this->Form->control('4dreligion', ['type'=>'checkbox', 'label'=>'Religion']); ?>
      <?= $this->Form->control('4edisability', ['type'=>'checkbox', 'label'=>'Disability']); ?>
      <?= $this->Form->control('4fage', ['type'=>'checkbox', 'label'=>'Age']); ?>
      <?= $this->Form->control('4gother', ['type'=>'checkbox', 'label'=>'Other']); ?>
      <div id="4go-wrapper">
				<?= $this->Form->control('4gotherdetails', ['type'=>'text', 'label'=>'Other - Please specify', 'size'=>40, 'maxlength'=>255 ]); ?>
      </div>

      <!-- People complained about (number of male and female enquirers in each category) -->
      <label class="gapabove">5. Person(s) complained about (if any) <span class="small_text">(please enter a number or leave blank for zero)</span></label>
      <div class="inline_wrapper"><p><strong>Male &nbsp;</strong></p><p><strong>Female</strong></p></div>
			<?= $survey::maleFemaleTextNums($this, '5aaboutacm', '5baboutacf', 'Academic staff') ?>
			<?= $survey::maleFemaleTextNums($this, '5caboutacrelm', '5daboutacrelf', 'Academic-related staff') ?>
			<?= $survey::maleFemaleTextNums($this, '5eaboutnonacm', '5faboutnonacf', 'Support staff') ?>
			<?= $survey::maleFemaleTextNums($this, '5gaboutugm', '5haboutugf', 'Undergraduate student') ?>
			<?= $survey::maleFemaleTextNums($this, '5iaboutpgm', '5jaboutpgf', 'Undergraduate student') ?>
			<?= $survey::maleFemaleTextNums($this, '5kaboutotherm', '5laboutotherf', 'Other:' . $this->Form->control('5klaboutotherdetails', $survey::textNum(13,40,255)) ) ?>

      <!-- Same College/department? (radio buttons for yes, no and unknown) -->
      <div class="gapabove">
  		  <?= $this->Form->control('same_dept', ['type'=>'radio', 'options'=>$survey::yesNoUnknownOptions('52y','52n','52u'), 'label'=>'5.2 Are the person(s) complained about in the same department, faculty or college as the complainant?'], [ 'label'=>false ]); ?>
  		</div>

  		<!-- Instructions for question 6 -->
      <h4>
        If a FORMAL complaint was made, please complete question 6. IF NOT, Please go on to question 7.
      </h4>
      <!-- Formal complaint details -->
      <?= $this->Form->control('61formalto', ['type'=>'text', 'label'=>'6. Who was the formal complaint made to?', 'maxlength'=>255 ]); ?>

      <!-- 6.2a includes a subsidiary set of radio buttons -->
      <label class="gapabove">6.2 What action was taken (if known)?</label>
      <?= $this->Form->control('62agrievance', ['type'=>'checkbox', 'label'=>'Grievance procedure']); ?>
      <div id="62-wrapper" class="indent">
  		  <?= $this->Form->control('grievance', ['type'=>'radio', 'options'=>$survey::grievanceOptions(), 'label'=>false ]); ?>
  		</div>

      <!-- 6.2b with a text box on the following line -->
      <?= $this->Form->control('62bdisciplinary', ['type'=>'checkbox', 'label'=>'Disciplinary procedure']); ?>
      <div id="62bo-wrapper">
        <?= $this->Form->control('62bdisciplinaryaction', ['type'=>'text', 'label'=>'Please specify action taken if known', 'maxlength'=>255, 'class'=>'with-notes' ]); ?>
  		</div>

      <!-- 6.2c with a text box on the following line -->
      <?= $this->Form->control('62cformalother', ['type'=>'checkbox', 'label'=>'Other']); ?>
      <div id="62co-wrapper">
        <?= $this->Form->control('62cformalotherdetails', ['type'=>'text', 'label'=>'Please specify', 'maxlength'=>255 ]); ?>
  		</div>

			<!-- Instructions for question 7 -->
      <h4>
        If an INFORMAL complaint was made, please complete question 7.  IF NOT, Please go on to question 8.
      </h4>
			<!-- Informal complaint details -->
			<?= $this->Form->control('71informalto', ['type'=>'text', 'label'=>'7. Who was the informal complaint made to?', 'maxlength'=>255 ]); ?>

      <!-- 7.2 Informal complaints: (tick boxes allowing multiple choices) -->
      <label class="gapabove">7.2 What action was taken (if known)?</label>
      <?= $this->Form->control('72aadvice', ['type'=>'checkbox', 'label'=>'Advice given to complainant']); ?>
      <?= $this->Form->control('72binvestigation', ['type'=>'checkbox', 'label'=>'Investigation']); ?>
      <?= $this->Form->control('72clowkey', ['type'=>'checkbox', 'label'=>'Low key resolution']); ?>
      <?= $this->Form->control('72dwarning', ['type'=>'checkbox', 'label'=>'Informal warning']); ?>
      <?= $this->Form->control('72eother', ['type'=>'checkbox', 'label'=>'Other']); ?>
      <div id="72eo-wrapper">
				<?= $this->Form->control('72fotherdetails', ['type'=>'text', 'label'=>'Other - Please specify', 'size'=>40, 'maxlength'=>255 ]); ?>
      </div>

      <!-- 7.3 Was the complainant satisfied? (radio buttons for yes, no and unknown) -->
      <div class="gapabove">
  		  <?= $this->Form->control('matter_resolved', ['type'=>'radio', 'options'=>$survey::yesNoUnknownOptions('73y','73n','73u'), 'label'=>'7.3 Was the matter resolved to the satisfaction of the complainant?'], [ 'label'=>false ]); ?>
  		</div>

      <!-- 8 Other action taken: (tick boxes allowing multiple choices) -->
      <label class="gapabove">8. Other action taken by complainant (<em>indicate one or more as appropriate</em>)</label>
      <?= $this->Form->control('81aapproachsubject', ['type'=>'checkbox', 'label'=>'Approach by complainant to subject of complaint']); ?>
      <?= $this->Form->control('81bapproachthird', ['type'=>'checkbox', 'label'=>'Approach by complainant to a third party']); ?>
      <div id="81bo-wrapper">
				<?= $this->Form->control('81bapproachthirddetails', ['type'=>'text', 'label'=>'Please specify', 'size'=>40, 'maxlength'=>255, 'class'=>'with-notes' ]); ?>
      </div>
      <?= $this->Form->control('81cotheraction', ['type'=>'checkbox', 'label'=>'Other action by complainant']); ?>
      <div id="81co-wrapper">
				<?= $this->Form->control('81cotheractiondetails', ['type'=>'text', 'label'=>'Please specify', 'size'=>40, 'maxlength'=>255, 'class'=>'with-notes' ]); ?>
      </div>

      <!-- 8.2 Other action requested: (tick boxes allowing multiple choices) -->
      <label class="gapabove">8.2 Other action requested by complainant (<em>indicate one or more as appropriate</em>)</label>
      <?= $this->Form->control('82agenadvice', ['type'=>'checkbox', 'label'=>'General advice and information requested']); ?>
      <?= $this->Form->control('82badviceformal', ['type'=>'checkbox', 'label'=>'Advice on bringing formal complaint requested']); ?>
      <?= $this->Form->control('82creferred', ['type'=>'checkbox', 'label'=>'Complaint referred elsewhere']); ?>
      <div id="82co-wrapper">
				<?= $this->Form->control('82creferreddetails', ['type'=>'text', 'label'=>'Please specify', 'size'=>40, 'maxlength'=>255, 'class'=>'with-notes' ]); ?>
      </div>

      <!-- 9. Conclusion -->
      <label class="gapabove">9. If known, when was the case concluded?</label>
      <!-- Date concluded -->
      <div class="inline_wrapper">
				<?= $this->Form->control('compmonth', ['type' => 'select', 'options' => $survey::monthOptions(), 'empty' => '-- Please Select --', 'label' => 'Month']); ?>
				<?= $this->Form->control('compyear', ['type' => 'select', 'options' => $survey::yearOptions(), 'empty' => '-- Please Select --', 'label' => 'Year']); ?>
    	</div>

      <!-- Were you satisfied? (radio buttons for yes or no) -->
      <div class="gapabove">
  		  <?= $this->Form->control('eoo_satisfaction', ['type'=>'radio', 'options'=>$survey::yesNoOptions('91y','91n'), 'label'=>'Were you, the adviser, satisfied with any assistance sought from the Equal Opportunites Office?'], [ 'label'=>false ]); ?>
  		</div>

      <div class="gapabove">
  		  <?= $this->Form->control('9aeocomments', ['type'=>'text', 'label'=>'Final Comments', 'size'=>80, 'maxlength'=>255 ]); ?>
  		</div>

			<!-- Submit -->
      <p>&nbsp;</p>
			<?= $this->Form->button(__('Submit Request')) ?>
			<?= $this->Form->button('Clear Form', [ 'type'=>'reset' ]) ?>

		<?php
				echo $this->Form->end();
		?>

	</div>
</div>