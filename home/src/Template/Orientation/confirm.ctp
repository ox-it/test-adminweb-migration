<!-- File: src/Template/Orientation/confirm.ctp -->

<div class="row">
  <?php //echo '<textarea rows="10" style="line-height:1.1em">' . print_r($applicant, true) . '</textarea>'; ?>
<div class="waf-include">

		<h3>
		  Confirmation
		</h3>

    <!-- Initial instructions -->
    <?php
      switch($applicant->orient_course) {
        case 'S':
          echo '<p>You are registered for the graduate Orientation programme taking place on Thursday, 27 September.</p>';
          break;
        case 'P':
          echo '<p>You are registered for the graduate Orientation programme taking place on Friday, 28 September.</p>';
          break;
        case 'U':
          echo '<p>You are registered for the undergraduate and visiting student Orientation programme taking place on Monday, 1 October.</p>';
          break;
      }
    ?>
    <p>
      A timetable booklet will be available from the Oxford Students website
      three weeks before the programme starts, and you will also be sent an email
      reminder one week before the programme starts.
    </p>
    <?php
      if ($applicant->arrive_ts) {
        echo '<p>A representative of the University will meet you at the Central
        Bus Station in Heathrow Airport on '.date('l j F' ,$applicant->arrive_ts)
        .' (arriving on flight '.$applicant->flight_num.' from '.$applicant->flight_from.').</p>' . "\n";
      }
    ?>

    <p>&nbsp;</p>
    <p>
      <?= $waf->postButtonToReferer($this, 'Return to Orientation Form') ?>
    </p>

</div>
<div id="optional"></div>

</div>