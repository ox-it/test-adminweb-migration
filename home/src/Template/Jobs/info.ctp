<!-- File: src/Template/Jobs/info.ctp -->

<?php

  $pager = '';
  if (!empty($feed['pager'])) {
    $page = $feed['pager']['page'];
    $pages = $feed['pager']['pages'];
    $pager .= "\n";
    $pager .= '    <div class="jobs-pager">'."\n";
    $pager .= '    <ul class="pagination">'."\n";
    if ($pages>1) $pager .= '<li class="pager-first'.($page==0?' disabled':'').'"><a title="Go to first page" href="?page=0">first</a></li>';
    if ($pages>1) $pager .= '<li class="prev'.($page==0?' disabled':'').'"><a title="Go to previous page" href="?page='.($page-1).'">previous</a></li>';
    for ($p=0; $p<$pages; $p++) {
      $pager .= '    <li class="link page_'.$p.($p==$page?' active current':'').'">'."\n";
      $pager .= ($p==$page) ? '<span>' : '      <a title="Go to page '.($p+1).'" href="?page='.$p.'">';
      $pager .= ($p+1);
      $pager .= (($p==$page) ? '</span>' : '</a>') ."\n";
      $pager .= '    </li>'."\n";
    }
    if ($pages>1) $pager .= '<li class="next'.($page==($pages-1)?' disabled':'').'"><a title="Go to next page" href="?page='.($page+1).'">next</a></li>';
    if ($pages>1) $pager .= '<li class="pager-last'.($page==($pages-1)?' disabled':'').'"><a title="Go to last page" href="?page='.($pages-1).'">last</a></li>';
    $pager .= '    </ul>'."\n";
    $pager .= '    </div>'."\n".'    <hr>'."\n"."\n";
  }

?>

<div class="row">

	<?php //print '<textarea rows="5" style="line-height:1.2em;font-size:11px">' . print_r($feed,true) . '</textarea>'; ?>

	<div class="waf-include">

	  <div id="job-vacancies-app">
    <hr>
    <?= $pager ?>
    <?php foreach ($feed['currentVacancies']['vacancy'] as $vacancy) { ?>

      <?php $grade = explode(':', $vacancy['gradeAndSalaryText']); ?>

			<h2 style="margin: 1em 0 0 3px; ">
			<?= $vacancy['shortDescription'] ?>
			</h2>
			<table class="table"><tbody>
				<tr><td colspan="4" style="width: 100%;" class="orgGroupLocationText"><strong>
				<?= $vacancy['orgGroupLocationText'] ?>
				</strong></td></tr>
				<tr>
					<td style="width: 20%;">Vacancy type: </td>
					<td colspan="3" class="competitionType">
					<?= $vacancy['competitionType']['description'] ?>
					</td>
				</tr>
				<tr>
					<td class="gradeAndSalaryText">
					<?= count($grade)>1 ? $grade[0] : 'Pay' ?>:</td>
					<td colspan="3" class="gradeAndSalaryText"><?= count($grade)==1 ? $grade[0] : $grade[1] ?>
					</td>
				</tr>
				<tr>
					<td>Vacancy ID :</td>
					<td style="width: 30%;" class="recruitmentId">
					<?= $vacancy['recruitmentId'] ?>
					</td>
					<td style="width: 20%;" class="job-closing">Closing Date :</td>
					<td style="width: 30%;" class="recruitmentClosesDate">
					<?= $vacancy['recruitmentClosesDate'] ?>
					</td>
				</tr>
				<tr>
					<td style="width: 20%;">
						Contact Name:
					</td>
					<td style="width: 30%;">
						<?= $vacancy['contactPersonText'] ?>
					</td>
					<td style="width: 20%;">
						Contact Email:
					</td>
					<td style="width: 30%;">
					  <?php if (!empty($vacancy['contactEmailText'])) : ?>
						<a href="mailto:<?= $vacancy['contactEmailText'] ?>"><?= $vacancy['contactEmailText'] ?></a>
						<?php endif; ?>
					</td>
				</tr>
				<tr>
					<td colspan="4" style="width: 100%;" class="jobDescription">
					  <?= $vacancy['jobDescription'] ?>
					</td>
				</tr>
			</tbody></table>
			<hr>

    <?php } ?>
		<?= $pager ?>

		<?php //print '<textarea rows="5" style="line-height:1.2em;font-size:11px">' . print_r($file,true) . '</textarea>'; ?>

	  </div>
	</div>
</div>
