<!-- File: src/Template/SafetyCourses/view.ctp -->

	<div class="row">
		<div class="description">
			<?php // print_r($events);  ?>
		</div>
	</div>

<div class="row">
	<div class="waf-include">

		<h3>
		  Cancellation Confirmed
		</h3>

    <!-- Initial instructions -->
    <p>
    	Thank you for informing us that you will not be attending the
			<strong><?= $course->course; ?></strong>
			<?php if (!empty($course->category) && $course->category==1) : ?>
				  course, on <strong><?= date('l jS F', $event->startstamp) ?></strong>.
			<?php else : ?>
    			course.
			<?php endif; ?>
    </p>
    <p>Please print this page as a record of your cancellation.</p>
    <p>&nbsp;</p>
    <p>The following information has been recorded:</p>

		<p>
		  <span class="label"><strong>University Email:</strong></span>
		  <span class="value"><?= $applicant->email; ?></span>
    </p>

		<p>
		  <span class="label"><strong>Course:</strong></span>
		  <span class="value"><?= $course->course; ?></span>
    </p>

		<p>
		  <span class="label"><strong>Event Date:</strong></span>
		  <span class="value"><?= date('l jS F', $event->startstamp) ?></span>
    </p>

    <p>&nbsp;</p>
    <p>
      <?= $this->Html->link('Return to Course List', ['action' => 'index'], ['class'=>'button']) ?>
    </p>

	</div>
</div>