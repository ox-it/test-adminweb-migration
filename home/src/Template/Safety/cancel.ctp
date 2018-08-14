<!-- File: src/Template/SafetyCourses/book.ctp -->

<?php
      $options = [];
      foreach ($events as $event) {
        //print_r($event);
        $course = $event->safety_course;
        $value  = $course->course . ' (' . date('jS F', $event->startstamp) . ')';
        $options[$event->eventID] = $value;
      }
?>

	<div class="row">
		<div class="description">
			<?php //print_r($departments);  ?>
		</div>
	</div>

<div class="row">
	<div class="waf-include">

		<h3>
		  Cancellation Form
		</h3>

    <!-- Initial instructions -->
    <p>
			To cancel an existing booking, please fill in the information below:
    </p>

    <!-- Form -->
		<?php
				echo $this->Form->create($applicant, [
          'context' => ['validator' => 'cancel']
        ]);
		?>

		<?php
				echo $this->Form->control('email', ['label' => 'University Email', 'class' => 'with-notes']);
				echo $this->Form->input('eventID', ['type' => 'select', 'options' => $options, 'empty' => '-- Please Select --', 'label' => 'Course']);
				echo $this->Form->button(__('Cancel Booking'));
				echo $this->Form->end();
		?>

	</div>
</div>