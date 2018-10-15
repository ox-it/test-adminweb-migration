<!-- File: src/Template/SafetyCourses/index.ctp -->

<div class="row">
	<div class="waf-include">

        <h4>Welcome to the Safety Office training webpages.</h4>

        <p>Information on each of the courses on offer may be obtained by clicking
        the appropriate subject link. To reserve a place on one of the courses, applicants
        will need their Oxford single sign-on account (Webauth login and password)
        before following the relevant booking link for the course of interest. All
        individuals with a University card are eligible for an Oxford single sign-on
        account, and further information about the University's web authentication system,
        Webauth, is available from Computing Services via their helpdesk or
        <a href="http://www.oucs.ox.ac.uk/internal/sld/webauth.xml">their website</a>.

        <p>If, having booked a place, you find you are unable to attend your requested
        course, please fill in the
        <?= $this->Html->link('cancellation form', ['action' => 'cancel']) ?>
        so that your place can be offered to another trainee. All courses are offered
        free of charge to University staff and students. However, departments will be
        charged a &pound;30 penalty fee if booked trainees fail to turn up on the day,
        or in the event of late cancellations. Trainees must sign the attendance register
        circulated at each course. Failure to do so may be interpreted as a failure to
        attend and the penalty fee will be levied.</p>

        <p>For further information about the safety courses on offer please contact the
        <a href="mailto:webmaster&#64;safety.ox.ac.uk">Safety Office</a>. The University
        provides extensive opportunities for training and development. Further details of
        other providers and the types of courses available can be found in the relevant section of the
        <a href="http://www.ox.ac.uk/sg/working_at_oxford/training_development">Staff Gateway</a>.</p>

        <h4>Current Courses</h4>

        <?php if (!empty($courses) && count($courses)>0) { ?>

					<ul>
					<?php foreach ($courses as $course): ?>
							<li>
									<?= $this->Html->link($course->course, ['controller' => 'Safety', '?' => [ 'course' => $course->courseID ] ]) ?>
									<?php // print_r($course); ?>
							</li>
					<?php endforeach; ?>
					</ul>

        <?php } else { ?>

          <p><em>No courses found</em></p>

        <?php } ?>

	</div>
</div>
