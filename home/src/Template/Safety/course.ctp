<!-- File: src/Template/SafetyCourses/view.ctp -->

<div class="row">
	<div class="waf-include">

		<?php
	    if (empty($course)) {
        echo '<h3>Sorry</h3><p>No matching course found</p>';
        return;
	    }
	  ?>


		<h3>
		  <?= h($course->course) ?>
		</h3>

    <?php if (!empty($course->availability)) : ?>
		<h4>Who should attend</h4>
		<?= $course->availability ?>
		<hr />
		<?php endif; ?>


    <?php if (!empty($course->description)) : ?>
		<h4>Description</h4>
		<!-- WAF.SafetyCourses.description -->
		<?= $course->description ?>
		<hr />
		<?php endif; ?>

		<!-- Dates and Booking section -->
    <?php if ($course->category == 3 || $course->category == 4) : // No fixed dates ?>
       <h4>When will the next course run?</h4>
    <?php else : ?>
      <h4>Dates</h4>

			<?php $event_count = $events->count(); ?>
			<?php if (!empty($events) && $event_count>0 ) { ?>

				<?php //print "Found " . $event_count . " event" . ($event_count==1?"":"s"); ?>
				<?php //print_r($events); ?>

				<ul>
				<?php foreach ($events as $event): ?>
					<li>
  					<span class="waf-date">
							<!-- WAF.SafetyEvents.datestart -->
							<?= $event->datestart ?>
						</span>

            <span class="waf-time">
							<!-- WAF.SafetyEvents.timestart -->
							<?= $event->timestart ?>
							-
							<!-- WAF.SafetyEvents.timeend -->
							<?= $event->timeend ?>
						</span>

            <span class="waf-location">
							<!-- WAF.SafetyEvents.location -->
							<?= $event->location ?>
						</span>

						<?php //print_r($event); ?>

						<?php if ($course->category == 1) : // Add booking ?>

              <p>
								<?php if ($event->eventstatuscode == 'N') : ?>
									Places can be booked from <?= date('jS F', $event->openstamp); ?>
								<?php elseif ($event->eventstatuscode == 'O') : ?>
									<?= $this->Html->link('Book a place', ['controller' => 'Safety', '?' => [ 'book' => $event->eventID ] ]) ?>
								<?php elseif ($event->eventstatuscode == 'F') : ?>
									<?php if (count($events)==1) : ?>
										This course is now fully booked but you can still
										<?= $this->Html->link('Join the waiting list', ['Controller' => 'Events', 'action' => 'book', $event->eventID]) ?>
										for any cancellations
									<?php else : ?>
										This course is now fully booked)
									<?php endif; ?>
								<?php else : ?>
									Booking for this course has now closed
								<?php endif; ?>
              </p>

            <?php endif; ?>

					</li>
				<?php endforeach; ?>
				</ul>

			<?php } else { ?>

				<p><em>There are currently no scheduled dates for this course.</em></p>

				<?php if (($course->category == 1 || $course->category == 2) && !empty($course->dateinfo)) : ?>
        <p>
					<!-- WAF.SafetyCourses.dateinfo -->
					<?= $course->dateinfo ?>
        </p>
        <?php endif; ?>

			<?php } ?>
		<?php endif; ?>

		<!-- Booking section -->
    <?php if (!($course->category == 1 || ($course->category == 2 && count($events)))) : ?>
		  <p>
  			<!-- WAF.SafetyCourses.bookinginfo -->
				<?= $course->bookinginfo ?>

				<?php if ($course->category == 4) : ?>
				  <!-- ?= $this->Html->link($course->course, ['action' => 'view', $course->courseID]) ? -->
				  <!-- a href="'.$CONTAINER_ROOT.'/forms/booking/?evID='.$ev_rec['eventID'].'">add your name to the list</a -->
        <?php endif; ?>

      </p>
    <?php endif; ?>

		<?php if (!empty($course->contactemail)) : ?>
		<hr />

		<h4>Contact Information</h4>
  		<p>For further information contact
				<!-- WAF.SafetyCourses.contactemail -->
				<a href="mailto:<?= $course->contactemail ?>">
				<?php if (!empty($course->contact)): ?>
  				<!-- WAF.SafetyCourses.contact -->
					<?= $course->contact ?>
				<?php else: ?>
					<?= $course->contactemail ?>
				<?php endif; ?>
				</a>
		  </p>
		<?php else: ?>
			<?php if (!empty($course->contact)): ?>
				<h4>Contact Information</h4>
  		  <p>For further information contact
					<!-- WAF.SafetyCourses.contact -->
					<?= $course->contact ?>
				</p>
			<?php endif; ?>
		<?php endif; ?>

	</div>
</div>