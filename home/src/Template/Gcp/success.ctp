<!-- File: src/Template/Harassment/success.ctp -->

<div class="row">
	<div class="waf-include">

		<h3>
		  Harassment Statement - Submission Success
		</h3>

		<?php
		  if (!empty($survey)) :
		?>

    <p> Thank you for filling out the report.</p>
    <p> The following information has been recorded:</p>

    <h4><?= h($user->name) ?> - <?= h($survey->harassment_department->deptalpha) ?></h4>
    <?= $waf::postValueWithLabel(
      ($survey->{'1adeptadviser'}=='Y'?'Harassment Adviser':'') .
      ($survey->{'1edeptadmin'}=='Y'?'Departmental Administrator / Personnel officer':''), 'Your Capacity') ?>
    <?= $waf::postValueWithLabel($survey->inqdept->deptalpha, 'Inquirer\'s Dept/College') ?>

    <!-- Inquirers (question 2.1) -->
    <h4>Inquirers:</h4>
    <?= $waf::postValueWithLabelIfNotZero($survey->{'21aacm'}, 'Male academic staff') ?>
    <?= $waf::postValueWithLabelIfNotZero($survey->{'21bacf'}, 'Female academic staff') ?>
    <?= $waf::postValueWithLabelIfNotZero($survey->{'21cacrelm'}, 'Male academic-related staff') ?>
    <?= $waf::postValueWithLabelIfNotZero($survey->{'21dacrelf'}, 'Female academic-related staff') ?>
    <?= $waf::postValueWithLabelIfNotZero($survey->{'21enonacm'}, 'Male non-academic staff') ?>
    <?= $waf::postValueWithLabelIfNotZero($survey->{'21fnonacf'}, 'Female non-academic staff') ?>
    <?= $waf::postValueWithLabelIfNotZero($survey->{'21gugm'}, 'Male undergraduate students') ?>
    <?= $waf::postValueWithLabelIfNotZero($survey->{'21hugf'}, 'Female undergraduate students') ?>
    <?= $waf::postValueWithLabelIfNotZero($survey->{'21ipgm'}, 'Male graduate students') ?>
    <?= $waf::postValueWithLabelIfNotZero($survey->{'21jpgf'}, 'Female graduate students') ?>
    <?= $waf::postValueWithLabelIfNotZero($survey->{'21kotherm'}, 'Male '.$survey->{'21klotherdetails'} ) ?>
    <?= $waf::postValueWithLabelIfNotZero($survey->{'21lotherf'}, 'Female '.$survey->{'21klotherdetails'} ) ?>

    <!-- Nature of inquiry (question 2.2) -->
    <h4>Nature of inquiry:</h4>
    <?= $waf::postObjectFieldsAsList($survey, [
      '22aadvicegeninfo' => 'General information',
      '22badviceharassment' => 'Advice re: harassment experienced',
      '22cadvicecomplaint' => 'Advice re: complaint or possible complaint against inquirers',
      '22dadviceadvisor' => 'Another adviser seeking advice',
      '22fadviceother' => $survey->{'22fadviceotherdetails'}
    ]) ?>

		<!-- Nature of behaviour (question 3) -->
		<h4>Nature of behaviour:</h4>
    <?= $waf::postObjectFieldsAsList($survey, [
      '3averbalabuse' => 'Verbal abuse, offensive remarks or threats',
      '3bwrittenabuse' => 'Written abuse, offensive remarks or threats',
      '3cimages' => 'Offensive electronic images',
      '3dbullying' => 'Bullying',
      '3eassault' => 'Physical abuse/assault',
      '3fadvances' => 'Unwelcome sexual advances',
      '3gsexualassault' => 'Sexual assault/rape',
      '3iinappropriate' => 'Allegation of inappropriate behaviour',
      '3hother' => $survey->{'3hotherdetails'}
    ]) ?>

		<!-- Behaviour relating to (question 4) -->
		<h4>Behaviour related to:</h4>
    <?= $waf::postObjectFieldsAsList($survey, [
      '4arace' => 'Race',
      '4bgender' => 'Gender',
      '4csexualorientation' => 'Sexual Orientation',
      '4hgenderreassignment' => 'Gender Reassignment',
      '4dreligion' => 'Religion',
      '4edisability' => 'Disability',
      '4fage' => 'Age',
      '4gother' => $survey->{'4gotherdetails'}
    ]) ?>

		<!-- People complained about (question 5) -->
		<h4>Person(s) complained about:</h4>
    <?= $waf::postValueWithLabelIfNotZero($survey->{'5aaboutacm'}, 'Male academic staff') ?>
    <?= $waf::postValueWithLabelIfNotZero($survey->{'5baboutacf'}, 'Female academic staff') ?>
    <?= $waf::postValueWithLabelIfNotZero($survey->{'5caboutacrelm'}, 'Male academic-related staff') ?>
    <?= $waf::postValueWithLabelIfNotZero($survey->{'5daboutacrelf'}, 'Female academic-related staff') ?>
    <?= $waf::postValueWithLabelIfNotZero($survey->{'5eaboutnonacm'}, 'Male non-academic staff') ?>
    <?= $waf::postValueWithLabelIfNotZero($survey->{'5faboutnonacf'}, 'Female non-academic staff') ?>
    <?= $waf::postValueWithLabelIfNotZero($survey->{'5gaboutugm'}, 'Male undergraduate students') ?>
    <?= $waf::postValueWithLabelIfNotZero($survey->{'5haboutugf'}, 'Female undergraduate students') ?>
    <?= $waf::postValueWithLabelIfNotZero($survey->{'5iaboutpgm'}, 'Male graduate students') ?>
    <?= $waf::postValueWithLabelIfNotZero($survey->{'5jaboutpgf'}, 'Female graduate students') ?>
    <?= $waf::postValueWithLabelIfNotZero($survey->{'5kaboutotherm'}, 'Male '.$survey->{'5klaboutotherdetails'} ) ?>
    <?= $waf::postValueWithLabelIfNotZero($survey->{'5laboutotherf'}, 'Female '.$survey->{'5klaboutotherdetails'} ) ?>

    <!-- Same College/department? -->
    <p class="display-p">
    <?= $survey->{'52samedept'}==1?'The person(s) complained about are in the <em>same department</em>, faculty or college as the complainant':'' ?>
    <?= $survey->{'52samedeptno'}==1?'The person(s) complained about are <em>not</em> in the same department, faculty or college as the complainant':'' ?>
    <?= $survey->{'52samedeptunknown'}==1?'It is not known whether the person(s) complained about are in the same department, faculty or college as the complainant':'' ?>
    </p>

    <?php if ( !empty($survey->{'61formalto'}) ) : ?>
      <!-- Formal complaint details (question 6) -->
      <h4>Formal complaint details</h4>
      <?= $waf::postValueWithLabel($survey->{'61formalto'}, 'Formal complaint made to') ?>
      <?= ($survey->{'62agrievance'}==1) ? $waf::postValueWithLabel( ($survey->{'62aupheld'}==1?'Upheld':'') . ($survey->{'62anotupheld'}==1?'Not upheld':''), 'Grievance procedure') : '' ?>
      <?= ($survey->{'62bdisciplinary'}==1) ? $waf::postValueWithLabel( $survey->{'62bdisciplinaryaction'} , 'Disciplinary procedure') : '' ?>
      <?= ($survey->{'62cformalother'}==1) ? $waf::postValueWithLabel( $survey->{'62cformalotherdetails'} , 'Other disciplinary procedure') : '' ?>
  	<?php endif; // !empty($survey->{'61formalto'}) ?>

    <?php if ( !empty($survey->{'71informalto'}) ) : ?>
      <!-- Informal complaint details (question 7) -->
      <h4>Informal complaint details</h4>
      <?= $waf::postValueWithLabel($survey->{'71informalto'}, 'Formal complaint made to') ?>
      <p class="display-p">Action(s) taken:</p>
      <?= $waf::postObjectFieldsAsList($survey, [
        '72aadvice' => 'Advice given to complainant',
        '72binvestigation' => 'Gender',
        '72clowkey' => 'Sexual Orientation',
        '72dwarning' => 'Gender Reassignment',
        '72eother' => $survey->{'72fotherdetails'}
      ]) ?>
      <p class="display-p">
      <?= $survey->{'73yessatisfaction'}==1?'<green>&#10003;</green> The matter was resolved to the satisfaction of the complainant':'' ?>
      <?= $survey->{'73nosatisfaction'}==1?'<red>&#10007;</red> The matter was <em>not</em> resolved to the satisfaction of the complainant':'' ?>
      <?= $survey->{'73notknown'}==1?'<blue>?</blue> It is unknown whether the matter was resolved to the satisfaction of the complainant':'' ?>
      </p>
  	<?php endif; // !empty($survey->{'71informalto'}) ?>

    <?php if ( $survey->{'81aapproachsubject'} + $survey->{'81bapproachthird'} + $survey->{'81cotheraction'} > 0 ) : ?>
      <!-- Other action taken (question 8) -->
      <h4>Other action taken by complainant</h4>
      <?= $waf::postObjectFieldsAsList($survey, [
        '81aapproachsubject' => 'Approach by complainant to subject of complaint',
        '81bapproachthird' => 'Approach by complainant to a third party: &nbsp; ' . '<span class="display-notes">' . $survey->{'81bapproachthirddetails'} . '</span>',
        '81cotheraction' => 'Other action by complainant: &nbsp; ' . '<span class="display-notes">' . $survey->{'81cotheractiondetails'} . '</span>'
      ]) ?>
    <?php if ( $survey->{'82agenadvice'} + $survey->{'82badviceformal'} + $survey->{'82creferred'} > 0 ) : ?>
  	<?php endif; ?>
      <h4>Other action requested by complainant:</h4>
      <?= $waf::postObjectFieldsAsList($survey, [
        '82agenadvice' => 'General advice and information requested',
        '82badviceformal' => 'Advice on bringing formal complaint requested',
        '82creferred' => 'Complaint referred elsewhere: &nbsp; ' . '<span class="display-notes">' . $survey->{'82creferreddetails'} . '</span>'
      ]) ?>
  	<?php endif; ?>

  	<h3>Conclusion</h3>
    <?= $waf::postValueWithLabel($survey->compyear . (!empty($survey->compmonth)?' (' . $waf::monthFromNumber($survey->compmonth) . ')':''), 'Case closed') ?>
    <?php if ( $survey->{'9yessatisfiedeo'} + $survey->{'9notsatisfiedeo'} > 0 ) : ?>
    <p class="display-p">
      <?= $survey->{'9yessatisfiedeo'}==1 ? '<green>&#10003;</green> You were satisfied with the assistance received from the Equal Opportunities Office' : '' ?>
      <?= $survey->{'9notsatisfiedeo'}==1 ? '<red>&#10007;</red> You were <em>not</em> satisfied with the assistance received from the Equal Opportunities Office' : '' ?>
    </p>
  	<?php endif; ?>

    <?php if ( !empty($survey->{'9aeocomments'}) ) : ?>
      <h4>Final Comments</h4>
      <p class="display-p display-notes">
        <?= $survey->{'9aeocomments'} ?>
      </p>
  	<?php endif; ?>

		<?php
		  else :
		?>

      <p>Sorry. We could not find that report</p>
      <p>Please <a href="mailto:eoweb&#64admin.ox.ac.uk">contact the administrators</a>.</p>

    <?php
      endif;
    ?>


    <p>&nbsp;</p>
    <p>
      <?= $this->Html->link('Return to Harassement Start Page', ['action' => 'index'], ['class'=>'button']) ?>
    </p>

	</div>
</div>