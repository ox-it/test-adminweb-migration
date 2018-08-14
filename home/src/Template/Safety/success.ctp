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

		<p>
		  <span class="label"><strong>Job Title:</strong></span>
		  <span class="value"><?= $applicant->jobtitle; ?></span>
    </p>

		<p>
		  <span class="label"><strong>Telephone:</strong></span>
		  <span class="value"><?= $applicant->phone; ?></span>
    </p>

		<p>
		  <span class="label"><strong>University Email:</strong></span>
		  <span class="value"><?= $applicant->email; ?></span>
    </p>

		<p>
		  <span class="label"><strong>Department/Faculty:</strong></span>
    	<?php if (!empty($applicant->deptcode)) : ?>
				 <span class="value"><?= $department->deptalpha; ?></span>
			<?php else : ?>
				 <span class="value"><?= $applicant->depttext; ?></span>
			<?php endif; ?>
    </p>

		<p>
		  <span class="label"><strong>College:</strong></span>
    	<?php if (!empty($applicant->collcode)) : ?>
				 <span class="value"><?= $college->college; ?></span>
			<?php else : ?>
				 <span class="value">&nbsp;</span>
			<?php endif; ?>
    </p>

		<h4>
		  Your Manager or Supervisor
		</h4>

		<p>
		  <span class="label"><strong>Surname:</strong></span>
		  <span class="value"><?= $applicant->managersurname; ?></span>
    </p>

		<p>
		  <span class="label"><strong>First Name:</strong></span>
		  <span class="value"><?= $applicant->managerfirstname; ?></span>
    </p>

		<p>
		  <span class="label"><strong>Telephone:</strong></span>
		  <span class="value"><?= $applicant->managerphone; ?></span>
    </p>

		<p>
		  <span class="label"><strong>Email:</strong></span>
		  <span class="value"><?= $applicant->manageremail; ?></span>
    </p>

    <p>&nbsp;</p>
    <p>
      <?= $this->Html->link('Return to Course List', ['action' => 'index'], ['class'=>'button']) ?>
    </p>

	</div>
</div>