<!-- File: src/Template/Harassment/confirm.ctp -->

<div class="row">
	<div class="waf-include">

		<h3>
		  Harassment Statement
		</h3>

		<?php
		  if (!empty($survey)) :
		    $userid = $survey->personID;
		    $acyear = $survey->year;
		?>

      <p><strong>
        You have already entered a
        <?php if ($survey->{'0nilreturn'} == 0) : ?>
          case report
        <?php else : ?>
          'no reports' statement
        <?php endif; ?>
        for the academic year <?= $survey->year . '/' . substr($survey->year+1,-2) ?>.
      <strong></p>

    <?php
      else :
		    $userid = $report->personID;
        $acyear = $report->year;
    ?>

      <p><strong>
        Thank you. You have confirmed that there are no reports to submit for the year
        <?= $report->year . '/' . substr($report->year+1,-2) ?>.
      <strong></p>

    <?php
      endif;
    ?>

    <?php
		  if (count($surveys)>1 && $user->userID==$userid) :
		?>
      <p>&nbsp;</p>

		  <h4>Statements Summary</h4>
		  <table>
		    <thead>
		      <tr>
		        <th>Academic Year</th><th>Reports information</td>
		      </tr>
		    </thead>
		    <tbody>
		      <?php
		        foreach ($surveys as $s) {
		      ?>
		        <tr<?= ($acyear == $s->year) ? ' class="highlight"' : '' ?>>
		          <td><?= $s->year . '/' . substr($s->year+1,-2) ?></td><td><?= ($s->{'0nilreturn'}==1) ? 'No reports' : $this->Html->link('Report filed', ['action' => 'view', $s->surveyID]) ?></td>
		        </tr>
		      <?php
		        }
		      ?>
		    </tbody>
		  </table>
    <?php
      endif;
    ?>


    <p>&nbsp;</p>
    <p>
      <?= $waf->postButtonToReferer($this, 'Return to Harassement Start Page') ?>
    </p>

	</div>
</div>