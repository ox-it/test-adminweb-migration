<!-- File: src/Template/Orientation/index.ctp -->

<div class="row">
  <?php //echo '<textarea rows="10" style="line-height:1.1em">' . print_r($departments, true) . '</textarea>'; ?>
	<h3>
		Orientation Programme
	</h3>
	<p class="notes"><strong>Note:</strong> REG CODE and 'Meet & Greet' option is set in src/Controller/OrientationController.php</p>

<div class="waf-include">

    <!-- Form --><?php // Create form with validation set in FinanceTravelApplicantsTable::validationRegister() ?>
		<?= $this->Form->create($applicant, [ 'type'=>'file', 'context'=>[ 'validator'=>'register' ], 'novalidate' => true ]) ?>

			<?= $this->Form->control('registration', [ 'label'=>'Registration Code' ]) ?>
			<?= $this->Form->control('firstname', [ 'label'=>'First Name' ]) ?>
			<?= $this->Form->control('surname', [ 'label'=>'Family Name' ]) ?>
			<?= $this->Form->control('DOB', [ 'label'=>'Date of Birth', 'templates'=>$waf->template_wrappers('dob',$applicant->dateformat_notes()) ]) ?>
			<?= $this->Form->control('collcode', [ 'type'=>'select', 'options'=>$colleges, 'empty'=>'-- Select a College --', 'label'=>'College at Oxford' ]) ?>
			<?= $this->Form->control('natcode', [ 'type'=>'select', 'options'=>$nationalities, 'empty'=>'-- Select Your Nationality --', 'label'=>'Nationality' ]) ?>
			<?= $this->Form->control('domcode', [ 'type'=>'select', 'options'=>$countries, 'empty'=>'-- Select Your Country --', 'label'=>'Country of Ordinary Residence' ]) ?>
			<?= $this->Form->control('language', [ 'label'=>'First Language' ]) ?>
			<?= $this->Form->control('deptcode', [ 'type'=>'select', 'options'=>$departments, 'empty'=>'-- Select Your Department --', 'label'=>'Department or Faculty' ]) ?>
			<?= $this->Form->control('course_type', [ 'type'=>'radio', 'label'=>'Course Type', 'options'=>$applicant->coursetypeOptions(), 'templates'=>$waf->template_wrappers('course_type',$applicant->spacer()), 'default'=>'P' ]) ?>
			<?= $this->Form->control('degree', [ 'type'=>'select', 'options'=>$applicant->all_degrees(), 'empty'=>'-- Select the Degree --', 'label'=>'Degree' ]) ?>
			<?= $this->Form->control('subject', [ 'label'=>'Subject' ]) ?>
			<?= $this->Form->control('email', [ 'label'=>'Your Email Address' ]) ?>

      <?php
        if ($meet_and_greet) :
          // NOTE: MEET & GREET is set in src/Controller/OrientationController.php
      ?>

  			<hr class="line">

				<h2>Meet and Greet Service at Heathrow Airport</h2>

				<p>
					Representatives of Oxford University will be available to meet students who
					arrive at the <u>Central Bus Station in Heathrow airport</u> from Saturday 28th September
					to Sunday 6th October 2013 between the hours of 8.00 and 20.00. If you would like
					a Representative to meet you, please enter your arrival details below:
				</p>

				<?= $this->Form->control('meet', [ 'type'=>'radio', 'label'=>'Would you like a Representative to meet you?', 'options'=>$applicant->yesnoOptions(), 'templates'=>$waf->template_wrappers('meet',$applicant->spacer()) ]) ?>
				<div id="meet-info">
					<?= $this->Form->control('arrival_date', [ 'label'=>'Arrival Date', 'templates'=>$waf->template_wrappers('arrival_date',$applicant->dateformat_notes(),['required']) ]) ?>
					<?= $this->Form->control('arrival_time', [ 'label'=>'Arrival Time', 'templates'=>$waf->template_wrappers('arrival_hr',$applicant->timeformat_notes(),['required']) ]) ?>
					<?= $this->Form->control('flight_num', [ 'label'=>'Flight Number', 'templates'=>$waf->template_wrappers('flight_num','',['required']) ]) ?>
					<?= $this->Form->control('flight_from', [ 'label'=>'Arriving From', 'templates'=>$waf->template_wrappers('flight_from','',['required']) ]) ?>
				</div>

  			<hr class="line">

      <?php
        endif;
      ?>


      <p>&nbsp;</p>
			<!-- Submit -->
			<?php
					echo $this->Form->button(__('Submit Request'));
					echo $this->Form->button('Clear Form', [ 'type'=>'reset' ]);
			?>

		<?php
				echo $this->Form->end();
		?>

</div>
<div id="optional"></div>

</div>