<!-- File: src/Template/SystemsAvailability/cols.ctp -->

<div class="row">

  <h3><?= $view->name ?></h3>

  <div class="waf-include">

    <?php if (!empty($systems) && count($systems)>0) { ?>

      <table class="waf-systems-availability cols">
        <thead>
          <tr>
            <?php foreach ($systems as $system): ?>
            <th>
              <?php if (!empty($system->url)) echo '<a href="'.$system->url.'">'; ?>
              <?= $system->name ?>
              <?php if (!empty($system->url)) echo '</a>'; ?>
            </th>
            <?php endforeach; ?>
          </tr>
        </thead>

        <tbody>
          <tr class="even">
            <?php foreach ($systems as $system): ?>
            <td class="<?= $system->level ?>">
              <strong><?= $system->levelName ?></strong>
              <div class="indicators">
                <span class="indicator indicator-red"></span>
                <span class="indicator indicator-amber"></span>
                <span class="indicator indicator-green"></span>
              </div>
            </td>
            <?php endforeach; ?>
          </tr>
          <tr class="odd">
            <?php foreach ($systems as $system): ?>
            <td class="status">
              <?= $system->text ?>
            </td>
            <?php endforeach; ?>
          </tr>
          <tr class="even">
            <?php foreach ($systems as $system): ?>
            <td class="details">
              <?= $system->details ?>
            </td>
            <?php endforeach; ?>
          </tr>
          <tr class="odd">
            <?php foreach ($systems as $system): ?>
            <td class="updated">
              <?= date('j M Y, H:i', $system->time) ?>
            </td>
            <?php endforeach; ?>
          </tr>
        </tbody>
      </table>

      <?php //echo '<textarea>' . print_r($systems, true) . '</textarea>'; ?>

    <?php } else { ?>

      <p><em>No systems found</em></p>

    <?php } ?>

  </div>
</div>
