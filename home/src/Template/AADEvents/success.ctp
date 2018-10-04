<!-- File: src/Template/AADEvents/index.ctp -->
    <?php
      $b = [];
      $c = [];
      foreach ($bookings as $booking) {
        if ($booking->bookstatus == 'B') $b[] = $booking;
        if ($booking->bookstatus == 'C') $c[] = $booking;
      }
    ?>

<div class="row">

	<h3>
		Events Booking Form Success
	</h3>

	<?php
		if (!empty($person->mismatch)) {
		  echo '<p><em>ID mismatch</em></p>';
		  echo $waf->postLinkToReferer($this, 'Return to booking form');

		  return;
		}
	?>

	<div class="waf-include">

    <p>Thank you for registering, the following details have been recorded. Booking
    details have been emailed to you at the email address you provided.</p>
    <p>You can amend your details on the <?= $waf->postLinkToReferer($this, 'booking form') ?>
    until the time of the event.</p>

    <h4>Personal Details</h4>
    <p>
      <strong>Name:</strong> <?= $person->forename . ' ' . $person->surname; ?><br>
      <strong>Job Title:</strong> <?= $person->jobtitle; ?><br>
      <strong>Phone:</strong> <?= $person->phone; ?><br>
      <strong>Email:</strong> <?= $person->email; ?><br>
    <?php if (!empty($person->department)) : ?>
      <strong>Department:</strong> <?= $person->department; ?><br>
    <?php
      endif;
      if (!empty($person->college)) :
    ?>
      <strong>College:</strong> <?= $person->college; ?><br>
    <?php endif; ?>
    </p>

		<?php
			// echo '<textarea rows="12" style="line-height: 1.1em;font-size:0.7em">' . print_r($person, true) . '</textarea>';
		?>

    <?php
      if (count($b)>0) :
    ?>
      <h4>Bookings</h4>
      <p>You have booked the following events:</p>
      <ul>
			<?php
				foreach ($b as $booking) {
				  $display = '<strong>' . $booking->a_a_d_events_event->eventname . '</strong> (<em>' . date("d F Y", $booking->a_a_d_events_event->startstamp) . ', ' . $booking->a_a_d_events_event->starttime . '</em>; &nbsp; ' . $booking->a_a_d_events_event->a_a_d_events_location->location . ')';
          echo '<li>' . $display . '</li>';
				}
			?>
			</ul>
    <?php
      endif;
    ?>

    <?php
      if (count($c)>0) :
    ?>
      <h4>Cancellations</h4>
      <p>You have cancelled the following events:</p>
      <ul>
			<?php
				foreach ($c as $booking) {
				  $display = '<strong>' . $booking->a_a_d_events_event->eventname . '</strong> (<em>' . date("d F Y", $booking->a_a_d_events_event->startstamp) . ', ' . $booking->a_a_d_events_event->starttime . '</em>; &nbsp; ' . $booking->a_a_d_events_event->a_a_d_events_location->location . ')';
          echo '<li>' . $display . '</li>';
				}
			?>
			</ul>
    <?php
      endif;
    ?>

    <?php
      if (count($bookings)==0) :
    ?>
      <h4>No Bookings</h4>
      <p>You have no bookings or cancellations at the moment.</p>
    <?php
      endif;
    ?>

		<?php
			// echo '<textarea rows="12" style="line-height: 1.1em;font-size:0.7em">' . print_r($bookings, true) . '</textarea>';
		?>

	</div>
</div>