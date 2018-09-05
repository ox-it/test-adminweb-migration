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

	<?= $this->Html->script($this->name . '/script.js') ?>

	<div class="waf-include">

    <?php //echo '<textarea rows="10" style="line-height:1.1em">' . print_r($userdepts, true) . '</textarea>'; ?>

    <!-- Form -->
		<?= $this->Form->create($applicant, [ 'novalidate' => true ]) ?>

			<?= $this->Form->control('surname', [ 'label'=>'Surname' ]) ?>
			<?= $this->Form->control('forename', [ 'label'=>'First Name' ]) ?>
			<?= $this->Form->control('title', [ 'label'=>'Title' ]) ?>
			<?= $this->Form->control('employer', [ 'type'=>'select', 'options'=>$organisations, 'empty'=>'-- Please select --', 'label'=>'Employing Organisation' ] ) ?>
			<?= $this->Form->control('otheremp', [ 'label'=>'Please specify' ]) ?>
			<?= $this->Form->control('position', [ 'label'=>'Position' ]) ?>
			<?= $this->Form->control('email', [ 'label'=>'Email' ]) ?>
			<?= $this->Form->control('phone', [ 'label'=>'Telephone' ]) ?>

			<!-- Submit -->
			<?php
					echo $this->Form->button(__('Submit Request'));
					echo $this->Form->button('Clear From', [ 'type'=>'reset' ]);
			?>

		<?php
				echo $this->Form->end();
		?>

	</div>
</div>