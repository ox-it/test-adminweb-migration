<?php
/**
 * Called from src/Controller/UASEventsController.php
 * Receives $person, $booked, $waf, $css
 */
?>

<p>
  Dear <?= $person->title ?> <?= $person->forename ?> <?= $person->surname ?>,
</p>

<p>
  Your event registration has been recorded.
  You are now confirmed to attend the following UAS event(s):
</p>

<ul>
  <li><?= implode("</li>\n  <li>", $booked) ?></li>
</ul>

<p>
  To cancel a booking, please email the UAS Communications team at
  <a href="mailto:uas.communications@admin.ox.ac.uk">uas.communications@admin.ox.ac.uk</a>.
</p>

<p>
  Visit the UAS website
  (<a href="http://www.admin.ox.ac.uk/uas/events/">http://www.admin.ox.ac.uk/uas/events/</a>)
  to register for new events as they become available.
</p>

<p>Kind Regards,</p>

<p>
  <strong>UAS Communications</strong>,<br>
  University of Oxford,<br>
  <br>
  75-81 High Street,<br>
  Oxford<br>
  OX1 4BG
</p>

<p>
  Tel: +44 (0)1865 (2)84847<br>
  Email: <a href="mailto:uas.communications@admin.ox.ac.uk">uas.communications@admin.ox.ac.uk</a><br>
  Web: <a href="http://www.admin.ox.ac.uk">www.admin.ox.ac.uk</a><br>
  Twitter: <a href="https://twitter.com/OxfordUASComms">@OxfordUASComms</a>
</p>

<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>

