<!-- File: src/Template/AADConference/index.ctp -->

<div class="row">

	<h3>
		UAS Conference Series 2013/14 - Registration Form
	</h3>

	<div class="waf-include">

	  <?php echo $this->Html->script('AADConference/script.js'); ?>

    <!-- Initial instructions -->
    <?php
      if (!$applicant->newUser)
					echo('<p>To alter your details for '.$conference->conference_name.', taking place on '.$conference->conference_datestring.' at '.$conference->conference_locale.', please amend the information below and click "Update Registration".</p>');
			else
					echo('<p>To register for sessions at '.$conference->conference_name.', taking place on '.$conference->conference_datestring.' at '.$conference->conference_locale.', please fill in the form below with your details and select the breakout sessions you wish to attend.</p>');
    ?>

    <!-- Form -->
		<?php echo $this->Form->create($applicant, [ 'context' => ['validator' => 'register'] ]); ?>

		<h4>
		  Your Details
		</h4>

    <?php
				echo $this->Form->control('title', ['label' => 'Title']);
				echo $this->Form->control('forename', ['label' => 'First name']);
				echo $this->Form->control('surname', ['label' => 'Surname']);
				echo $this->Form->control('jobtitle', ['label' => 'Job title']);
				echo $this->Form->control('phone', ['label' => 'Telephone']);
				echo $this->Form->control('email', ['label' => 'Email']);
				echo $this->Form->control('email2', ['label' => 'Confirm email']);
				echo $this->Form->input('collcode', ['type' => 'select', 'options' => $colleges, 'empty' => '-- Please select if appropriate --', 'label' => 'College']);
				echo $this->Form->input('deptcode', ['type' => 'select', 'options' => $departments, 'empty' => '-- Please select if appropriate --', 'label' => 'Department/Faculty']);
				// TODO: Add not listed option.
				//echo $this->Form->control('depttext', ['label' => 'Department/Faculty']);
    ?>

    <hr class="line">

    <?php
			if (!$applicant->newUser) :
				echo '<p>If you no longer wish to attend this Conference, you can cancel your registration. Please note, if you select to de-register you will lose your reserved place on sessions when this form is submitted with the checkbox selected.<p>';
				echo $this->Form->input('deregistered', ['type' => 'checkbox', 'label' => 'De-register?']);
				// TODO: Make sure this value is properly initialised
				echo '<hr class="line">';
			endif;
    ?>

    <!-- Registration -->
    <?php
      if (!empty($conference->registration_text)) {
        echo '<p><strong>' . $conference->registration_text . '</strong>&nbsp;&nbsp;(' . $conference->registration_start .', ' . $conference->registration_location . ')</p>';
				echo '<hr class="line">';
      }
    ?>

    <!-- Lunch -->
    <?php
      if (!empty($conference->lunch_text)) {
        echo '<p><strong>' . $conference->lunch_text . '</strong>&nbsp;&nbsp;(' . $conference->lunch_start .' - ' . $conference->lunch_end . ') *</p>';
        if (!empty($conference->lunch_note)) {
          echo '<p><strong>*</strong>&nbsp;&nbsp;' . $conference->lunch_note . '</p>';
        }
        if (substr(strtolower($conference->lunch),0,1) == 'y') {
          // Attendance (Yes or No)
          echo $this->Form->input('lunch', ['type' => 'select', 'options' => $conference->lunchOptions, 'empty' => '-- Please select an option --', 'label' => $conference->lunch_question, 'id'=>'lunchSelect']);
          // TODO: Initialise the display/hiding of dietary info
          echo $this->Form->control('dietary', ['type'=>'textarea', 'label' => 'Please specify any dietary restrictions or allergies', 'rows' => 2 , 'id'=>'lunchDietary']);
        }
				echo '<hr class="line">';
      }
    ?>

    <!-- Plenary -->
    <?php
      if (!empty($conference->plenary_text)) {
        echo '<p><strong>' . $conference->plenary_text . '</strong>&nbsp;&nbsp;(' . $conference->plenary_start .' - ' . $conference->plenary_end . ') *</p>';
        if (!empty($conference->lunch_note)) {
          echo '<p><strong>*</strong>&nbsp;&nbsp;' . $conference->lunch_note . '</p>';
        }
        if (substr(strtolower($conference->plenary),0,1)) {
          $plenaryResponse = (!empty($applicant->plenary)) ? $applicant->plenary : 'n';
          $disabled = ($conference->plenaryIsFull && $plenaryResponse=='n') ? ' disabled' : '';
					$message = ($conference->plenaryIsFull && $plenaryResponse=='n') ? 'This session is now fully booked. However, please do come to the North School at 9am where the opening welcome will be live-streamed - booking is not required.' : $conference->plenary_question;
          $selected = ($conference->plenaryIsFull) ? $plenaryResponse : $applicant->plenary;
          // Attendance (Yes or No)
          echo $this->Form->input('lunch', ['type' => 'select', 'options' => $plenaryOptions, 'empty' => '-- Please select an option --', 'label' => $message, 'id'=>'plenarySelect']);
				  if (!$disabled) {
				    if ($conference->plenaryIsFull) echo '<p>This session is now fully booked.</p>';
				  }
				  echo $this->Form->control('plenary', ['type' => 'hidden', 'value' => $plenaryResponse]);
        }
				echo '<hr class="line">';
      }
    ?>

    <!-- Sessions -->
    <?php
      if (!empty($sessions)) {
        //print_r($sessions);
				echo '<hr class="line">';
      }
    ?>

    <!-- Tea Breaks -->
    <?php
      if (!empty($conference->teabreak1)) {
        echo '<p><strong>' . $conference->teabreak1 . '</strong>&nbsp;&nbsp;(' . $conference->teabreak1_start .' - ' . $conference->teabreak1_end . ') <em>' . $conference->teabreak1_location . '</em></p>';
				echo '<hr class="line">';
      }
      if (!empty($conference->teabreak2)) {
        echo '<p><strong>' . $conference->teabreak2 . '</strong>&nbsp;&nbsp;(' . $conference->teabreak2_start .' - ' . $conference->teabreak2_end . ') <em>' . $conference->teabreak2_location . '</em></p>';
				echo '<hr class="line">';
      }
    ?>

    <!-- Speaker -->
    <?php
      if (!empty($conference->speakerquestion_text)) {
        echo '<p><strong>' . $conference->speakerquestion_text . '</strong>&nbsp;&nbsp;(' . $conference->speakerquestion_start .' - ' . $conference->speakerquestion_end . ')</p>';
        if (substr(strtolower($conference->speakerquestion),0,1) == 'y' && !$conference->speakersQuestionIsFull) {
          echo $this->Form->input('speakersquestion', ['type' => 'select', 'options' => $conference->speakersQuestionsOptions, 'empty' => '-- Please select an option --', 'label' => $conference->speakerquestion_question, 'id'=>'speakerQuestionSelect']);
          if (substr(strtolower($conference->advancedquestion),0,1) == 'y') {
            echo $this->Form->control('question', ['type'=>'textarea', 'label' => $conference->advancedquestion_text, 'rows' => 2, 'id'=>'advancedQuestion']);
          }
        }
				echo '<hr class="line">';
      }
    ?>

    <!-- Reception -->
    <?php
      if (!empty($conference->reception_text)) {
        echo '<p><strong>' . $conference->reception_text . '</strong>&nbsp;&nbsp;(' . $conference->reception_start . (!empty($conference->reception_end) ? ' - ' . $conference->reception_end : '') . ')</p>';
				echo '<hr class="line">';
      }
    ?>

    <!-- Bike Doctor -->
    <?php
      if (substr(strtolower($conference->bikerepair),0,1) == 'y' && !$conference->bikeRepairIsFull) {
        echo '<p><strong>' . $conference->bikerepair_text . '</strong>&nbsp;&nbsp;(' . $conference->bikerepair_start . (!empty($conference->bikerepair_end) ? ' - ' . $conference->bikerepair_end : '') . ')</p>';
        echo $this->Form->input('bikerepair', ['type' => 'select', 'options' => $conference->bikeRepairOptions, 'empty' => '-- Please select an option --', 'label' => 'Do you wish to use the repair service?', 'id'=>'speakerQuestionSelect']);
				echo '<hr class="line">';
      }
    ?>

    <!-- Accessibility -->
    <h4>
		  Venue Accessibility
		</h4>
		<?php
			echo $this->Form->input('accessibility', ['type' => 'checkbox', 'value' => 'y', 'hiddenField' => 'n', 'label' => 'Do you have any specific access requirements that you would like to make us aware of?']);
			echo $this->Form->control('accessibility_desc', ['type'=>'textarea', 'label' => 'If yes, please specify your requirements', 'rows' => 4, 'id'=>'accessibilityDetails']);
			echo '<hr class="line">';
		?>

    <!-- Submit -->
		<?php
				echo $this->Form->button(__('Register'));
				echo $this->Form->button('Clear', ['type'=>'reset']);
				echo $this->Form->end();
		?>

	</div>
</div>