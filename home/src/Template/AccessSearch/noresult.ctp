<!-- File: src/Template/AccessSearch/noresult.ctp -->

<div class="row">

	<div class="waf-include">

		<h3>Search Results</h3>

		<p class="search_results no_results">
		  There are no matching results for your search criteria.
		  <a href="http://www.admin.ox.ac.uk/access/atoz">Click here</a>
		  to see our A to Z list of buildings and departments.
		</p>

    <p>&nbsp;</p>
    <p>
      <?= $this->Html->link('Return to Search', ['action' => 'index'], ['class'=>'button']) ?>
    </p>

	</div>
</div>