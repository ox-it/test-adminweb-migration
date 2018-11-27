<!-- File: src/Template/Gcp/index.ctp -->

<div class="row">

	<h3>
		GCP Online Application
	</h3>

	<p>
	  To be eligible for registration on this course, you should be employed either by
	  Oxford University or the Oxford University Hospitals NHS Trust, or be working on
	  clinical research either sponsored or hosted by one of these organisations.
	</p>
  <p>
    Please complete the form below to register. Once eligibility has been established,
    we will issue a username and password for access to the course.
  </p>

	<div class="waf-include">

    <?php //echo '<textarea rows="10" style="line-height:1.1em">' . print_r($userdepts, true) . '</textarea>'; ?>

    <!-- Form -->
		<?= $this->Form->create($applicant, [ 'context'=>[ 'validator'=>'register' ], 'novalidate' => true ]) ?>

			<?= $this->Form->control('surname', [ 'label'=>'Surname' ]) ?>
			<?= $this->Form->control('forename', [ 'label'=>'First Name' ]) ?>
			<?= $this->Form->control('title', [ 'label'=>'Title' ]) ?>
			<?= $this->Form->control('employer', [ 'type'=>'select', 'options'=>$organisations, 'empty'=>'-- Please select --', 'label'=>'Employing Organisation' ] ) ?>
			<?php // $this->Form->control('otheremp', [ 'label'=>'Please specify' ]) ?>
			<?= $this->Form->control('position', [ 'label'=>'Position' ]) ?>
			<?= $this->Form->control('email', [ 'type'=>'text', 'label'=>'Email' ]) ?>
			<?= $this->Form->control('phone', [ 'type'=>'text', 'label'=>'Telephone' ]) ?>
			<?= $this->Form->control('role', ['type'=>'textarea', 'label' => 'Give a brief description of your role in research', 'rows' => 3]); ?>
			<?= $this->Form->control('additional', ['type'=>'textarea', 'label' => 'Please provide any relevant, additional information which you think may be useful to help us determine your eligibility', 'rows' => 3]); ?>

			<!-- External Applicants -->
      <div id="waf-gcp-external">
        <p>
          If you have not provided an Oxford University or Oxford University Hospitals
          NHS Trust email address, please provide the following information for one
          Oxford University or Oxford University Hospitals NHS Trust clinical research
          project you are working on so that we can confirm your eligibility.
        </p>
  			<?= $this->Form->control('study', [ 'label'=>'Name of Study' ]) ?>
	  		<?= $this->Form->control('investigator', [ 'label'=>'Chief Investigator' ]) ?>
		  	<?= $this->Form->control('REC', [ 'label'=>'REC Reference' ]) ?>
			  <?= $this->Form->control('project', [ 'label'=>'Project ID' ]) ?>
      </div>

			<!-- Submit -->
			<?php
					echo $this->Form->button('Register');
					echo $this->Form->button('Clear Form', [ 'type'=>'reset' ]);
			?>

		<?php
				echo $this->Form->end();
		?>

	</div>
</div>