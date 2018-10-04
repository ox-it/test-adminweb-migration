<!-- File: src/Template/GraduateAccommodation/success.ctp -->

<?php // echo '<div class="row"><div class="description">' . print_r($form,true) . '</div></div>';  ?>

<div class="row">
	<div class="waf-include">

		<h3>Success</h3>
		<p>
			Thank you for your application to graduate accommodation.  You will now be registered
			onto our waiting list, and we will be in touch if we are able to make an offer of accommodation.
		</p>
		<p>
			For those applying for accommodation starting before August 2018, please note that
			our current tenants have signed fixed-term agreements until 31 July 2018,
			and so it will rely on people requesting to leave early for accommodation to
			become available.  We will be in touch if anything comes up.
		</p>
		<p>
			For those applying for accommodation starting in Michaelmas 2018, the allocation
			process will begin in the middle of April. We will aim to keep you regularly
			updated of your position on the waiting list from April onwards.
		</p>
		<p>
			If you have any questions, please do get in touch using our general inbox address:
			<a href="mailto:graduate.accommodation@admin.ox.ac.uk">graduate.accommodation@admin.ox.ac.uk</a>.
		</p>

    <p>&nbsp;</p>
    <p>
      <?= $waf->postButtonToReferer($this, 'Return to Application Form') ?>
    </p>

	</div>
</div>