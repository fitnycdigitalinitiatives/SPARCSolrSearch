<?php

/**
 * @package     omeka
 * @subpackage  solr-search
 * @copyright   2012 Rector and Board of Visitors, University of Virginia
 * @license     http://www.apache.org/licenses/LICENSE-2.0.html
 */

?>


<?php echo head(array('title' => __('Solr Search')));?>

<div class="row results">
	<div class="col-xs-9">
		<?php $query = array_key_exists('q', $_GET) ? $_GET['q'] : ''; ?>
		<?php if (preg_match('/^#[a-f0-9]{6}$/i', $query)): ?>
			<?php
			$color_name = color_name($query);
			$swatch_html = '<div id="swatch" data-toggle="tooltip" title="Color name: '. $color_name . '"><div style="background-color:' . html_escape($query) . ';"></div></div>';
			?>
			<h4>Showing <?php echo $results->response->numFound; ?> results for <?php echo $swatch_html; ?></h4>
		<?php else: ?>
			<h4>Showing <?php echo $results->response->numFound; ?> results for <em><?php echo $query; ?></em></h4>
		<?php endif; ?>
	</div>
</div>

<div class="row">
	<div id="solr-results" class="col-lg-8 col-md-8 col-sm-6">
		<!-- Results Grid -->
		<div class="row" id="grid">

			<?php foreach ($results->response->docs as $doc): ?>

			<!-- Document. -->
			<div class="result col-lg-3 col-md-3 col-sm-6 col-xs-6 item-thumb">

				<!-- Record URL. -->
				<?php $url = SolrSearch_Helpers_View::getDocumentUrl($doc); ?>

				<!-- Title. -->
				<a href="<?php echo $url; ?>" class="thumbnail">
					<?php $record = get_db()->getTable($doc->model)->find($doc->modelid); ?>
					<?php $recordType = $doc->resulttype; ?>
					<?php if ($recordType == 'Exhibit Page'): ?>
						<?php $exhibit = $record->getExhibit(); ?>
						<?php $recordImage = record_image($exhibit, 'square_thumbnail', array('class' => 'img-responsive')); ?>
					<?php else: ?>
						<?php $recordImage = mdid_thumbnail_tag($record, 'img-responsive'); ?>
					<?php endif; ?>
					<?php echo $recordImage; ?>
					<!-- Result type. -->
					<?php if ($recordType == 'Item'): ?>
						<span class="badge result-type"><?php echo metadata($record, 'item_type_name'); ?></span>
					<?php else: ?>
						<span class="badge result-type"><?php echo $recordType; ?></span>
					<?php endif; ?>
					<div class="caption">
						<h5>
						<?php
							$title = is_array($doc->title) ? $doc->title[0] : $doc->title;
							if (empty($title)) {
								$title = '<i>' . __('Untitled') . '</i>';
							}
							echo $title;
						?>
						</h5>
					</div>
				</a>
			</div>

			<?php endforeach; ?>
		</div>
	</div>
	<!-- Facets. -->
	<div class="col-lg-4 col-md-4 col-sm-6">
		<div id="solr-facets">
			<div class="panel panel-default">
				<div class="panel-heading">
					<strong><?php echo __('Limit your search'); ?></strong>
				</div>
			</div>
			<!-- Applied facets. -->
			<?php if (SolrSearch_Helpers_Facet::parseFacets()): ?>
				<div id="solr-applied-facets" class="panel panel-default">
					<div class="panel-heading">
						<strong>Current Filters</strong>
					</div>
					<div class="list-group">
						<!-- Get the applied facets. -->
						<?php foreach (SolrSearch_Helpers_Facet::parseFacets() as $f): ?>
							<!-- Remove link. -->
							<?php $url = SolrSearch_Helpers_Facet::removeFacet($f[0], $f[1]); ?>
							<a class="list-group-item" href="<?php echo $url; ?>">
							<!-- Facet label. -->
							<?php $label = SolrSearch_Helpers_Facet::keyToLabel($f[0]); ?>
							<span class="applied-facet-value"><?php echo $f[1]; ?> </span>
							<button type="button" class="close" aria-label="Close"><span aria-hidden="true">&times;</span></button>
							</a>
						<?php endforeach; ?>
					</div>
				</div>
			<?php endif; ?>

			<?php $collapse_count = 1; ?>
			<?php foreach ($results->facet_counts->facet_fields as $name => $facets): ?>
				<!-- Does the facet have any hits? -->
				<?php if (count(get_object_vars($facets))): ?>
					<div class="panel panel-default">
						<!-- Facet label. -->
						<?php $label = SolrSearch_Helpers_Facet::keyToLabel($name); ?>
						<div class="panel-heading">
							<strong><?php echo $label; ?></strong>
						</div>
						<div class="list-group">
							<!-- Facets. -->

							<?php $display_facets = array_slice(get_object_vars($facets), 0, 5); ?>
							<?php foreach ($display_facets as $value => $count): ?>
								<!-- Facet URL. -->
								<?php $url = SolrSearch_Helpers_Facet::addFacet($name, $value); ?>
								<!-- Facet link. -->
								<a href="<?php echo $url; ?>" class="list-group-item facet-value">
									<?php echo $value; ?><span class=" badge facet-count"><?php echo $count; ?></span>
								</a>
							<?php endforeach; ?>
							<?php if ((count(get_object_vars($facets))) > 5 ): ?>
								<?php $hidden_facets = array_slice(get_object_vars($facets), 5); ?>
								<div id="collapse<?php echo $collapse_count; ?>" class="panel-collapse collapse">
								<?php foreach ($hidden_facets as $value => $count): ?>
									<!-- Facet URL. -->
									<?php $url = SolrSearch_Helpers_Facet::addFacet($name, $value); ?>
									<!-- Facet link. -->
									<a href="<?php echo $url; ?>" class="list-group-item facet-value">
										<?php echo $value; ?><span class=" badge facet-count"><?php echo $count; ?></span>
									</a>
								<?php endforeach; ?>
								</div>
								<a class="list-group-item more" role="button" data-toggle="collapse" href="#collapse<?php echo $collapse_count++; ?>">More...</a>
							<?php endif; ?>
						</div>
					</div>
				<?php endif; ?>
			<?php endforeach; ?>
		</div>
	</div>
</div>

<?php echo pagination_links(); ?>
<?php echo foot();
