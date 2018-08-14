<!-- File: src/Template/SafetyCourses/book.ctp -->

	<div class="row">
		<div class="description">
			<?php //print_r($departments);  ?>
		</div>
	</div>

<div class="row">
	<div class="waf-include">

		<h3>
		  Course Booking Form
		</h3>

    <!-- Initial instructions -->
    <p>
			<strong>Please Note:</strong> You can only use this form to book a place for yourself.
			Please <strong>do not</strong> book on behalf of someone else.
    </p>
    <p>
			<?php if ($event->waiting) : ?>
				 To add yourself to the waiting list for the
			<?php else : ?>
				 To book a place on the
			<?php endif; ?>
			<strong><?= $course->course; ?></strong> course,
			<?php if (!empty($course->category) && $course->category==1) : ?>
				 on <strong><?= date('l jS F', $event->startstamp) ?></strong>,
			<?php endif; ?>
      please provide the following information:
    </p>

    <!-- Form -->
		<?php
				echo $this->Form->create($applicant, [
          'context' => ['validator' => 'register']
        ]);
		?>

		<h4>
		  Your Details
		</h4>

		<?php
				echo $this->Form->control('jobtitle', ['label' => 'Job Title']);
				echo $this->Form->control('phone', ['label' => 'Telephone']);
				echo $this->Form->control('email', ['label' => 'University Email', 'class' => 'with-notes', 'notes' => 'Please use the same email for all communications with the Safety Office)']);
				echo '<p class="notes">Please use the same email for all communications with the Safety Office</p>';
				echo $this->Form->input('deptcode', ['type' => 'select', 'options' => $departments, 'empty' => '-- Please Select --', 'label' => 'Department/Faculty']);
				echo $this->Form->control('depttext', ['label' => 'Department/Faculty']);
				echo $this->Form->input('collcode', ['type' => 'select', 'options' => $colleges, 'empty' => '-- Please Select --', 'label' => 'College']);
		?>

		<h4>
		  Your Manager or Supervisor
		</h4>
		<?php
				echo $this->Form->control('managersurname', ['label' => 'Surname']);
				echo $this->Form->control('managerfirstname', ['label' => 'First Name']);
				echo $this->Form->control('managerphone', ['label' => 'Telephone']);
				echo $this->Form->control('manageremail', ['label' => 'Email']);
				echo $this->Form->button(__('Submit Application'));
				echo $this->Form->button('Clear', ['type'=>'reset']);
				echo $this->Form->end();
		?>

	</div>
</div>