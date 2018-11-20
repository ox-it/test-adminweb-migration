<!-- File: src/Template/SafetyCourses/view.ctp -->

	<div class="row">
		<div class="description">
			<?php // print_r($events);  ?>
		</div>
	</div>

<div class="row">
	<div class="waf-include">

		<h3>
		  Thank you!
		</h3>

    <!-- Initial instructions -->
    <p>
    	<?php if ($applicant->statuscode=='A') : ?>
				 Thank you for applying
			<?php else : ?>
				 Thank you for registering for the waiting list
			<?php endif; ?>
			for the <strong><?= $course->course; ?></strong>
			<?php if (!empty($course->category) && $course->category==1) : ?>
				  course, on <strong><?= date('l jS F', $event->startstamp) ?></strong>.
			<?php else : ?>
    			course.
			<?php endif; ?>
    </p>
    <p>Please print this page as a record of your application.</p>
    <p>&nbsp;</p>
    <p>The following information has been recorded:</p>

		<h4>
		  Your Details
		</h4>

		<?php
			echo $waf->postValueWithLabel($applicant->jobtitle, 'Job Title');
			echo $waf->postValueWithLabel($applicant->phone, 'Telephone');
			echo $waf->postValueWithLabel($applicant->email, 'University Email');
			if ($applicant->deptcode!='00') {
			  echo $waf->postValueWithLabel($applicant->deptcode, 'Department/Faculty', $departments);
			} else {
			  echo $waf->postValueWithLabel($applicant->depttext, 'Department/Faculty');
			}
			echo $waf->postValueWithLabel($applicant->collcode, 'College', $colleges);
    ?>

		<h4>
		  Your Manager or Supervisor
		</h4>

		<?php
			echo $waf->postValueWithLabel($applicant->managersurname, 'Surname');
			echo $waf->postValueWithLabel($applicant->managerfirstname, 'First Name');
			echo $waf->postValueWithLabel($applicant->managerphone, 'Telephone');
			echo $waf->postValueWithLabel($applicant->manageremail, 'Email');
			echo $waf->postValueWithLabel($applicant->collcode, 'College', $colleges);
    ?>

    <p>&nbsp;</p>
    <p>
      <?= $waf->postButtonToReferer($this, 'Return to Course List', true) ?>
    </p>

	</div>
</div>