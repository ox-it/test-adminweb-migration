<!-- File: srv/Template/Gcp/index.ctp -->
<?php

  $pager = '';
  if (!empty($passedPager)) {
    $page = $passedPager['page'];
    $pages = $passedPager['pages'];
    $pager .= "\n";
    $pager .= '    <div class="downloads-pager">'."\n";
    $pager .= '    <ul class="pagination">'."\n";
    if ($pages>1) $pager .= '<li class="pager-first'.($page==0?' disabled':'').'"><a title="Go to first page" href="?downloads=0">first</a></li>';
    if ($pages>1) $pager .= '<li class="prev'.($page==0?' disabled':'').'"><a title="Go to previous page" href="?downloads='.($page-1).'">previous</a></li>';
    for ($p=0; $p<$pages; $p++) {
      $pager .= '    <li class="link page_'.$p.($p==$page?' active current':'').'">'."\n";
      $pager .= ($p==$page) ? '<span>' : '      <a title="Go to page '.($p+1).'" href="?downloads='.$p.'">';
      $pager .= ($p+1);
      $pager .= (($p==$page) ? '</span>' : '</a>') ."\n";
      $pager .= '    </li>'."\n";
    }
    if ($pages>1) $pager .= '<li class="next'.($page==($pages-1)?' disabled':'').'"><a title="Go to next page" href="?downloads='.($page+1).'">next</a></li>';
    if ($pages>1) $pager .= '<li class="pager-last'.($page==($pages-1)?' disabled':'').'"><a title="Go to last page" href="?downloads='.($pages-1).'">last</a></li>';
    $pager .= '    </ul>'."\n";
    $pager .= '    </div>'."\n".'    <hr>'."\n"."\n";
  }

?>
<div class="row">

    <h3>
        GCP Online Application Admin
    </h3>
    <div class="waf-include">
	<hr>
	<?= $pager ?>
        <ul>
            <?php if ($files) { ?>
	        <?php foreach ($files as $i=>$file) { ?>
                    <p><a href="?download=<?= $file ?>"><?= $file ?></a></p>
	        <?php } ?>
            <?php } ?>
        </ul>
	<?= $pager ?>
    </div>
</div>
