<?php
/*\
 * Called from src/Controller/GraduateAccomodationController.php
 * Receives $data, $waf, $css
 */
?>

<p>Please find attached the XML file of the request submission.</p>

<?php if (!empty($data['comments'])) : ?>

  <p>Below are the extra comments provided by the user.</p>
  <blockquote><p><em><?= str_replace("\n","<br>\n",$data['comments']) ?></em></p></blockquote>

<?php endif; ?>

<?php if (!empty($data['expecting']) ) : ?>

  <p><strong>The applicant<?= ($data['single']?'':'s') ?> <?= ($data['single']?'is':'are') ?> also expecting a child.</strong></p>

<?php endif; ?>


<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
