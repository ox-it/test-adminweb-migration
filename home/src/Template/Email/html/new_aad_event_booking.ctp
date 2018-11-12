<?php
/**
 * Called from src/Controller/AADEventsController.php
 * Receives $person, $booked, $waf, $css
 */
?>

<p>
  Dear <?= $person->title ?> <?= $person->forename ?> <?= $person->surname ?>,
</p>

<p>
  Your event registration has been recorded.
  You are now confirmed to attend the following AAD events:
</p>

<ul>
  <li><?= implode("</li>\n  <li>", $booked) ?></li>
</ul>

<p>
  To cancel a booking, please call the AAD Communications team on 284847 or email us at
  <a href="mailto:AcademicAdmin.Comms@admin.ox.ac.uk">AcademicAdmin.Comms@admin.ox.ac.uk</a>.
</p>

<p>
  You may log back in to the AAD events registration form via the AAD Staff Events page
  (<a href="http://www.admin.ox.ac.uk/aad/communications/events/">http://www.admin.ox.ac.uk/aad/communications/events/</a>)
  to register for new events as they become available.
</p>

<p>Kind Regards,</p>

<p>
  <strong>Academic Administration Division Communications</strong>,<br>
  University of Oxford,<br>
  Examination Schools,<br>
  75-81 High Street,<br>
  Oxford<br>
  OX1 4BG
</p>

<p>
  Tel: 01865 (2)84847<br>
  Email: <a href="mailto:AcademicAdmin.Comms@admin.ox.ac.uk">AcademicAdmin.Comms@admin.ox.ac.uk</a><br>
  Web: <a href="http://www.admin.ox.ac.uk/aad">www.admin.ox.ac.uk/aad</a>
</p>

<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>

