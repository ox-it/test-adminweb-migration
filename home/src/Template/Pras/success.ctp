<!-- File: src/Template/Pras/success.ctp -->

<?php // echo '<div class="row"><div class="description">' . print_r($form,true) . '</div></div>';  ?>

<div class="row">
	<div class="waf-include">

		<h3>Success</h3>
		<p>
      PRAS data entered successfully.
		</p>
		<p>
			An email containing your request was sent to the Organisation Structure administrator.
		</p>

    <p>&nbsp;</p>
    <p>
      <?= $waf->postButtonToReferer($this, 'Start Again') ?>
    </p>

	</div>
</div>