<!-- File: src/Template/Gcp/success.ctp -->

<div class="row">
	<div class="waf-include">

		<h3>
		  GCP Online Registration - Success
		</h3>

		<?php
		  if (!empty($applicant)) :
		?>

    <p> Thank you for filling out the report.</p>
    <p> The following information has been recorded:</p>

    <?= $waf::postValueWithLabel($applicant->{'name'}, 'Name') ?>
    <?= $waf::postValueWithLabel($applicant->{'position'}, 'Position') ?>
    <?= $waf::postValueWithLabel($applicant->{'organisation'}, 'Employing Organisation') ?>
    <?= $waf::postValueWithLabel($applicant->{'email'}, 'Email') ?>
    <?= $waf::postValueWithLabel($applicant->{'phone'}, 'Telephone') ?>

    <?= $waf::postValueWithLabel($applicant->{'role'}, 'Research Role') ?>
    <?php if ( !empty($applicant->{'additional'}) ) : ?>
        <?= $waf::postValueWithLabel($applicant->{'additional'}, 'Additional Comments') ?>
  	<?php endif; ?>

    <?php if ( !empty($applicant->{'study'}) ) : ?>
      <h5>Project Details</h5>
      <?= $waf::postValueWithLabel($applicant->{'study'}, 'Name of Study') ?>
      <?= $waf::postValueWithLabel($applicant->{'investigator'}, 'Chief Investigator') ?>
      <?= $waf::postValueWithLabel($applicant->{'REC'}, 'REC Reference') ?>
      <?= $waf::postValueWithLabel($applicant->{'project'}, 'Project ID') ?>
  	<?php endif; ?>

		<?php
		  else :
		?>

      <p>Sorry. We could not find that registration</p>
      <p>Please <a href="mailto:researchsupport&#64admin.ox.ac.uk">contact the administrators</a>.</p>

    <?php
      endif;
    ?>


    <p>&nbsp;</p>
    <p>
      <?= $this->Html->link('Return to GCP Online Page', $this->request->referer(), ['class'=>'button']) ?>
    </p>

	</div>
</div>