<!-- File: src/Template/SystemsAvailability/cols.ctp -->

<div class="row">

  <h3><?= $view->name ?></h3>
  <?php //echo '<textarea>' . print_r($view, true) . '</textarea>'; ?>

  <div class="waf-include">

    <?php if (!empty($systems) && count($systems)>0) { ?>

      <table class="waf-systems-availability view-<?= $view->id ?> cols">
        <thead>
          <tr>
            <?php foreach ($systems as $system): ?>
            <th class="<?= str_replace(' ','-',strtolower($system->name)) ?>">
              <?php if (!empty($system->url)) echo '<a href="'.$system->url.'">'; ?>
              <?= $system->name ?>
              <?php if (!empty($system->url)) echo '</a>'; ?>
            </th>
            <?php endforeach; ?>
          </tr>
        </thead>

        <tbody>
          <tr>
            <?php foreach ($systems as $system): ?>
            <td class="<?= $system->level ?> system-<?= $system->id ?>">
              <strong><?= $system->levelName ?></strong>
              <div class="indicators">
                <span class="indicator indicator-red"></span>
                <span class="indicator indicator-amber"></span>
                <span class="indicator indicator-green"></span>
              </div>
            </td>
            <?php endforeach; ?>
          </tr>
          <tr>
            <?php foreach ($systems as $system): ?>
            <td class="status system-<?= $system->id ?>">
              <?= $system->text ?>
            </td>
            <?php endforeach; ?>
          </tr>
          <tr>
            <?php foreach ($systems as $system): ?>
            <td class="details system-<?= $system->id ?>">
              <?= $system->details ?>
            </td>
            <?php endforeach; ?>
          </tr>
          <tr>
            <?php foreach ($systems as $system): ?>
            <td class="updated system-<?= $system->id ?>">
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
