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

    <?php
			echo $waf->postValueWithLabel($applicant->email, 'University Email');
			echo $waf->postValueWithLabel($course->course, 'Course');
			echo $waf->postValueWithLabel(date('l jS F', $event->startstamp), 'Event Date');
    ?>

    <p>&nbsp;</p>
    <p>
      <?= $waf->postButtonToReferer($this, $text='Return to Course List', true) ?>
    </p>

	</div>
</div>