<!-- File: src/Template/UASEvents/index.ctp -->

<div class="row">

	<h3>
		Events Booking Form
	</h3>

	<p>To register for UAS events, please complete the following form.</p>
	<p>
	  <strong>Please note:</strong> This event booking form is linked to your Single Sign-On, therefore only book a place for yourself and not on behalf of someone else.
		If you wish to register on behalf of someone else, contact <a href="mailto:uas.communications@admin.ox.ac.uk">uas.communications@admin.ox.ac.uk</a>.
	</p>
	<div class="waf-include">

    <!-- Form -->
		<?php echo $this->Form->create($person, [ 'context' => ['validator' => 'register'], 'novalidate' => true ]); ?>

		<?php if (count($events) > 0) : ?>

			<h4>
				Your Details
			</h4>

			<?php
					echo $this->Form->control('title', ['label' => 'Title']);
					echo $this->Form->control('forename', ['label' => 'First name']);
					echo $this->Form->control('surname', ['label' => 'Surname']);
					echo $this->Form->control('jobtitle', ['label' => 'Job title']);
					echo $this->Form->control('phone', ['label' => 'Telephone']);
					echo $this->Form->control('email', ['label' => 'Email']);
					echo $this->Form->control('email2', ['label' => 'Confirm email', 'default'=>$person->email]);
					echo $this->Form->control('deptcode', ['type' => 'select', 'options' => $departments, 'empty' => '-- Please select if appropriate --', 'label' => 'Department/Faculty']);
					echo $this->Form->control('depttext', ['label' => 'Department/Faculty Details', 'templates' => $waf->template_wrappers('depttext')]);
					echo $this->Form->control('collcode', ['type' => 'select', 'options' => $colleges, 'empty' => '-- Please select if appropriate --', 'label' => 'College']);
			?>

			<hr class="line">

			<!-- Available Events -->

			<h4>
				Events
			</h4>
			<p>Please tick the box next to the event(s) that you wish to book a place on:</p>

			<?php
			  foreach ($events as $event) {
			    // Check booking status
			    $booking_status = '';
			    $booking_negate = '';
			    $fully_booked = strtolower($event->fullybooked)=='y';
			    foreach ($bookings as $booking) {
			      if ($booking->eventID == $event->eventID) {
			        $booking_status = $booking->bookstatus;
			        $booking_negate = 'C';
			      }
			    }
			    $class = ($fully_booked) ? 'event full' : 'event';
			    echo '<div class="' . $class . '">' . "\n";
			      $display = $event->display;
			      if ($fully_booked) $display = '<strike>' . $display . '</strike> &nbsp; [FULLY BOOKED]';
			      $options = ['type' => 'checkbox', 'value' => 'B', 'hiddenField' => $booking_negate, 'label' => ['text' => $display, 'escape' => false]];
			      if ($fully_booked) $options['disabled'] = true;
			      if ($booking_status == 'B') $options['checked'] = true;
			      $this->Form->unlockField('event_' . $event->eventID);
						echo $this->Form->control('event_' . $event->eventID, $options,['val'=>$booking_status]);
			    echo '</div>' . "\n";
				}
				echo '<hr class="line">';

				//echo '<textarea rows="12" style="line-height: 1.1em;font-size:0.7em">' . print_r($bookings, true) . '</textarea>';
			?>

			<p>
				If you wish to cancel a booking, or be added to the waiting list for an event
				that is fully booked, please email the UAS Communications team at
				<a href="mailto:uas.communications@admin.ox.ac.uk">uas.communications@admin.ox.ac.uk</a>.
			</p>

			<!-- Submit -->
			<?php
					echo $this->Form->button(__('Confirm'));
					echo $this->Form->button('Clear', ['type'=>'reset']);
			?>

		<?php else : ?>
		  <p>There are no events available for booking.</p>
		  <p>
		    If you were expecting to book an event, please call the UAS Communications team on 284847 or email us at
				<a href="mailto:uas.communications@admin.ox.ac.uk">uas.communications@admin.ox.ac.uk</a>.
      </p>
		<?php endif; ?>

		<?php
				echo $this->Form->end();
		?>

	</div>
</div>