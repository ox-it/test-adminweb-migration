<!-- File: src/Template/Trac/notcollecting.ctp -->

<div class="row">

  <h3>Academic Activity Survey</h3>

	<div class="waf-include">

      <p><strong>You are not currently under collection.</strong></p>

      <?php if ($survey->is_still_collecting) : ?>
        <p>Please try again after <?= $survey->group_week ?></p>
      <?php else : ?>
        <?php if (empty($survey->submitted_stamp)) : ?>
          <p>There was no data submitted previously.</p>
        <?php else : ?>
          <p>Your last collection was submitted on <?= date('jS F Y', $survey->submitted_stamp) ?></p>
          <p>See below for the data submitted in the previous collection.</p>

					<hr class="line" />
					<?= $waf->postValueWithLabel($survey->title, 'Title') ?>
					<?= $waf->postValueWithLabel($survey->initials, 'Initials') ?>
					<?= $waf->postValueWithLabel(ucwords($survey->surname), 'Surname') ?>
					<?= $waf->postValueWithLabel($survey->payroll, 'Employee/Payroll Number') ?>
					<?= $waf->postValueWithLabel($survey->department, 'Department/Faculty') ?>

					<hr class="line" />


        <?php endif; ?>
      <?php endif; ?>

			<p>For further assistance please contact the administration team at <a href="mailto:aas@admin.ox.ac.uk">aas@admin.ox.ac.uk</a>.</p>

	</div>
</div>