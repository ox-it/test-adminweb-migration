<!-- File: src/Template/Harassment/nouser.ctp -->

<div class="row">
	<div class="waf-include">

    <?php
      if (!isset($user)) :
    ?>

  		<h3>Unknown User<?= empty($_SERVER['HTTP_WAF_WEBAUTH']) ?  '' : ' : ' . $_SERVER['HTTP_WAF_WEBAUTH'] ?></h3>
      <p><strong>You are not currently registered to use the Harassment Advisor Survey system.</strong></p>
      <p>
        If you need access to this system, please
    <?php
      elseif (!empty($user->inactive)) :
    ?>

  		<h3>Unauthorised</h3>
      <p>
        <strong>Your access to the Harassment Advisor Survey system has expired,
        or you have tried to access a resource outside the range of your valid permissions.</strong>
      </p>
      <p>
        If you still need to enter reports, please
    <?php
      endif;
    ?>
        <a href="mailto:eoweb&#64admin.ox.ac.uk">contact the administrators</a>.
      </p>

	</div>
</div>