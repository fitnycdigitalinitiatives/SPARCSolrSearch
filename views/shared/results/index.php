<?php

/**
 * @package     omeka
 * @subpackage  solr-search
 * @copyright   2012 Rector and Board of Visitors, University of Virginia
 * @license     http://www.apache.org/licenses/LICENSE-2.0.html
 */

?>



<?php if ($results->response->numFound == 0): ?>
	<?php echo head(array('title' => __('Search Results'), 'bodyclass' => 'search error'));?>
	<!-- No Results -->
	<div class="row results">
	  <div class="col-xs-6">
	    <?php $query = array_key_exists('q', $_GET) ? $_GET['q'] : ''; ?>
	    <?php $query = trim($query, '()'); ?>
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
		<div class="col-sm-4 col-xs-6">
			<h1>No Results...</h1>
			<p class="lead">This is disappointing, but it doesn't look like we have any items to match your search at this time. Please try searching again with a different keyword.</p>
		</div>
	</div>
<?php else: ?>
	<?php echo head(array('title' => __('Search Results'), 'bodyclass' => 'search'));?>
	<!-- Has Results -->
	<div class="row results">
		<div class="col-xs-8">
			<?php $query = array_key_exists('q', $_GET) ? $_GET['q'] : ''; ?>
			<?php if (strlen($query) > 0): ?>
				<?php $query = trim($query, '()'); ?>
				<?php if (preg_match('/^#[a-f0-9]{6}$/i', $query)): ?>
					<?php
					$color_name = color_name($query);
					$swatch_html = '<div id="swatch" data-toggle="tooltip" title="Color name: '. $color_name . '"><div style="background-color:' . html_escape($query) . ';"></div></div>';
					?>
					<h4>Showing <?php echo $results->response->numFound; ?> results for <?php echo $swatch_html; ?>
						<!-- Applied facets. -->
						<?php if (SolrSearch_Helpers_Facet::parseFacets()): ?>
						  <!-- Get the applied facets. -->
						  <?php foreach (SolrSearch_Helpers_Facet::parseFacets() as $f): ?>
						    <!-- Remove link. -->
						    <?php $url = SolrSearch_Helpers_Facet::removeFacet($f[0], $f[1]); ?>
						    <br><small><em><a class="facet-kill" href="<?php echo $url; ?>"><span class="glyphicon glyphicon-remove-circle" aria-hidden="true"></span>&nbsp;
						    <!-- Facet label. -->
						    <?php $label = SolrSearch_Helpers_Facet::keyToLabel($f[0]); ?>
						    <?php if (($label == 'Facet Color') OR ($label == 'Primary Color')): ?>
						      <?php
						      $applied_facet_color_name = color_name($f[1]);
						      $applied_facet_swatch_html = '<div id="swatch" data-toggle="tooltip" title="Color name: '. $applied_facet_color_name . '"><div style="background-color:' . html_escape($f[1]) . ';"></div></div>';
						      ?>
						      <?php echo $applied_facet_swatch_html; ?>
						    <?php else: ?>
						      <span class="applied-facet-value"><?php echo $f[1]; ?></span>
						    <?php endif; ?>
						    </a></em></small>
						  <?php endforeach; ?>
						<?php endif; ?>
					</h4>
				<?php else: ?>
					<h4>Showing <?php echo $results->response->numFound; ?> results for <em><?php echo $query; ?></em>
						<!-- Applied facets. -->
						<?php if (SolrSearch_Helpers_Facet::parseFacets()): ?>
						  <!-- Get the applied facets. -->
						  <?php foreach (SolrSearch_Helpers_Facet::parseFacets() as $f): ?>
						    <!-- Remove link. -->
						    <?php $url = SolrSearch_Helpers_Facet::removeFacet($f[0], $f[1]); ?>
						    <br><small><em><a class="facet-kill" href="<?php echo $url; ?>"><span class="glyphicon glyphicon-remove-circle" aria-hidden="true"></span>&nbsp;
						    <!-- Facet label. -->
						    <?php $label = SolrSearch_Helpers_Facet::keyToLabel($f[0]); ?>
						    <?php if (($label == 'Facet Color') OR ($label == 'Primary Color')): ?>
						      <?php
						      $applied_facet_color_name = color_name($f[1]);
						      $applied_facet_swatch_html = '<div id="swatch" data-toggle="tooltip" title="Color name: '. $applied_facet_color_name . '"><div style="background-color:' . html_escape($f[1]) . ';"></div></div>';
						      ?>
						      <?php echo $applied_facet_swatch_html; ?>
						    <?php else: ?>
						      <span class="applied-facet-value"><?php echo $f[1]; ?></span>
						    <?php endif; ?>
						    </a></em></small>
						  <?php endforeach; ?>
						<?php endif; ?>
					</h4>
				<?php endif; ?>
			<?php else: ?>
				<?php if (($results->response->numFound) > 1): ?>
					<h4>Showing <?php echo $results->response->numFound; ?> results
						<!-- Applied facets. -->
						<?php if (SolrSearch_Helpers_Facet::parseFacets()): ?>
						  <!-- Get the applied facets. -->
						  <?php foreach (SolrSearch_Helpers_Facet::parseFacets() as $f): ?>
						    <!-- Remove link. -->
						    <?php $url = SolrSearch_Helpers_Facet::removeFacet($f[0], $f[1]); ?>
						    <br><small><em><a class="facet-kill" href="<?php echo $url; ?>"><span class="glyphicon glyphicon-remove-circle" aria-hidden="true"></span>&nbsp;
						    <!-- Facet label. -->
						    <?php $label = SolrSearch_Helpers_Facet::keyToLabel($f[0]); ?>
						    <?php if (($label == 'Facet Color') OR ($label == 'Primary Color')): ?>
						      <?php
						      $applied_facet_color_name = color_name($f[1]);
						      $applied_facet_swatch_html = '<div id="swatch" data-toggle="tooltip" title="Color name: '. $applied_facet_color_name . '"><div style="background-color:' . html_escape($f[1]) . ';"></div></div>';
						      ?>
						      <?php echo $applied_facet_swatch_html; ?>
						    <?php else: ?>
						      <span class="applied-facet-value"><?php echo $f[1]; ?></span>
						    <?php endif; ?>
						    </a></em></small>
						  <?php endforeach; ?>
						<?php endif; ?>
					</h4>
				<?php else: ?>
					<h4>Showing <?php echo $results->response->numFound; ?> result
						<!-- Applied facets. -->
						<?php if (SolrSearch_Helpers_Facet::parseFacets()): ?>
						  <!-- Get the applied facets. -->
						  <?php foreach (SolrSearch_Helpers_Facet::parseFacets() as $f): ?>
						    <!-- Remove link. -->
						    <?php $url = SolrSearch_Helpers_Facet::removeFacet($f[0], $f[1]); ?>
						    <br><small><em><a class="facet-kill" href="<?php echo $url; ?>"><span class="glyphicon glyphicon-remove-circle" aria-hidden="true"></span>&nbsp;
						    <!-- Facet label. -->
						    <?php $label = SolrSearch_Helpers_Facet::keyToLabel($f[0]); ?>
						    <?php if (($label == 'Facet Color') OR ($label == 'Primary Color')): ?>
						      <?php
						      $applied_facet_color_name = color_name($f[1]);
						      $applied_facet_swatch_html = '<div id="swatch" data-toggle="tooltip" title="Color name: '. $applied_facet_color_name . '"><div style="background-color:' . html_escape($f[1]) . ';"></div></div>';
						      ?>
						      <?php echo $applied_facet_swatch_html; ?>
						    <?php else: ?>
						      <span class="applied-facet-value"><?php echo $f[1]; ?></span>
						    <?php endif; ?>
						    </a></em></small>
						  <?php endforeach; ?>
						<?php endif; ?>
					</h4>
				<?php endif; ?>
			<?php endif; ?>
		</div>
		<div class="col-xs-4">
			<div id="filter_button" class="pull-right">
				<button type="button" class="btn btn-default" data-toggle="modal" data-target="#filterModal">Filter Results &nbsp;<span class="glyphicon glyphicon-plus small" aria-hidden="true"></span></button>
			</div>
		</div>
	</div>


	<div class="row" id="grid">

		<?php foreach ($results->response->docs as $doc): ?>

		<!-- Document. -->
		<div class="result col-lg-2 col-md-2 col-sm-3 col-xs-6 item-thumb">

			<!-- Record URL. -->
			<?php $url = SolrSearch_Helpers_View::getDocumentUrl($doc); ?>

			<!-- Title. -->
			<a href="<?php echo $url; ?>" class="thumbnail">
				<?php $record = get_db()->getTable($doc->model)->find($doc->modelid); ?>
				<?php $recordType = $doc->resulttype; ?>
				<?php switch($recordType):
				case 'Exhibit Page': ?>
				  <?php if ($attachments = $record->getAllAttachments()): ?>
					  <?php $item = $attachments[0]->getItem();
					  $recordImage = mdid_thumbnail_tag($item, 'img-responsive');
					  ?>
					<?php else: ?>
				    <?php $recordImage = '<img src="' . img("fallback-image.png") . '" />'; ?>
					<?php endif; ?>
				<?php break; ?>
				<?php case 'Exhibit': ?>
				  <?php if ($item = get_exhibit_item ($record)): ?>
				    <?php $recordImage = mdid_thumbnail_tag($item, 'img-responsive'); ?>
				  <?php else: ?>
				    <?php $recordImage = '<img src="' . img("fallback-image.png") . '" />'; ?>
				  <?php endif; ?>
				<?php break; ?>
				<?php case 'Simple Page': ?>
					<?php $recordImage = '<img src="' . img("fallback-image.png") . '" />'; ?>
				<?php break; ?>
				<?php case 'Item': ?>
				  <?php $recordImage = mdid_thumbnail_tag($record, 'img-responsive'); ?>
				<?php break; ?>
				<?php endswitch; ?>
				<?php echo $recordImage; ?>
				<!-- Result type. -->
				<?php if ($recordType !== 'Item'): ?>
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

	<!-- Modal -->
	<div class="modal fade" id="filterModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
	  <div class="modal-dialog" role="document">
	    <div class="modal-content">
	      <div class="modal-header">
	        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
	        <h4 class="modal-title" id="myModalLabel">Filter Results</h4>
	      </div>
	      <div class="modal-body">

					<!-- Facets. -->
					<div id="solr-facets">
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
										<a class="list-group-item facet-value" href="<?php echo $url; ?>">
										<!-- Facet label. -->
										<?php $label = SolrSearch_Helpers_Facet::keyToLabel($f[0]); ?>
										<?php if (($label == 'Facet Color') OR ($label == 'Primary Color')): ?>
											<?php
											$applied_facet_color_name = color_name($f[1]);
											$applied_facet_swatch_html = '<div id="swatch" data-toggle="tooltip" title="Color name: '. $applied_facet_color_name . '"><div style="background-color:' . html_escape($f[1]) . ';"></div></div>';
											?>
											<?php echo $applied_facet_swatch_html; ?>
											<button type="button" class="close" aria-label="Close"><span aria-hidden="true">&times;</span></button>
										<?php else: ?>
											<span class="applied-facet-value"><?php echo $f[1]; ?> </span>
											<button type="button" class="close" aria-label="Close"><span aria-hidden="true">&times;</span></button>
										<?php endif; ?>
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

									<!-- Color Facets -->
									<?php if (($label == 'Facet Color') OR ($label == 'Primary Color')): ?>
										<div class="panel-heading">
											<?php if ($label == 'Facet Color'): ?>
											<strong><?php echo 'Color'; ?></strong>
											<?php elseif ($label == 'Primary Color'): ?>
												<strong><?php echo 'Color Family'; ?></strong>
											<?php endif; ?>
										</div>
										<div class="list-group">
											<!-- Facets. -->
											<?php $display_facets = array_slice(get_object_vars($facets), 0, 3); ?>
											<?php foreach ($display_facets as $value => $count): ?>
												<!-- Facet URL. -->
												<?php $url = SolrSearch_Helpers_Facet::addFacet($name, $value); ?>
												<!-- Facet link. -->
												<?php
												$facet_color_name = color_name($value);
												$facet_swatch_html = '<div id="swatch" data-toggle="tooltip" title="Color name: '. $facet_color_name . '"><div style="background-color:' . html_escape($value) . ';"></div></div>';
												?>
												<a href="<?php echo $url; ?>" class="list-group-item facet-value">
													<span class="badge facet-count"><?php echo $count; ?></span><?php echo $facet_swatch_html; ?>
												</a>
											<?php endforeach; ?>
											<?php if ((count(get_object_vars($facets))) > 3 ): ?>
												<?php $hidden_facets = array_slice(get_object_vars($facets), 3); ?>
												<div id="collapse<?php echo $collapse_count; ?>" class="panel-collapse collapse">
												<?php foreach ($hidden_facets as $value => $count): ?>
													<!-- Facet URL. -->
													<?php $url = SolrSearch_Helpers_Facet::addFacet($name, $value); ?>
													<!-- Facet link. -->
													<?php
													$facet_color_name = color_name($value);
													$facet_swatch_html = '<div id="swatch" data-toggle="tooltip" title="Color name: '. $facet_color_name . '"><div style="background-color:' . html_escape($value) . ';"></div></div>';
													?>
													<a href="<?php echo $url; ?>" class="list-group-item facet-value">
														<span class="badge facet-count"><?php echo $count; ?></span><?php echo $facet_swatch_html; ?>
													</a>
												<?php endforeach; ?>
												</div>
												<a class="list-group-item more" role="button" data-toggle="collapse" href="#collapse<?php echo $collapse_count++; ?>">More...</a>
											<?php endif; ?>
										</div>

									<!-- Public Domain Facets -->
									<?php elseif ($label == 'Rights'): ?>
										<?php var_dump($facets); ?>
									  <?php if (property_exists($facets, 'Public Domain')): ?>
									    <div class="panel-heading">
									      <strong><?php echo $label; ?></strong>
									    </div>
									    <div class="list-group">
									      <!-- Facets. -->
									      <?php foreach ($facets as $value => $count): ?>
									        <!-- Facet URL. -->
									        <?php $url = SolrSearch_Helpers_Facet::addFacet($name, $value); ?>
									        <!-- Facet link. -->
									        <a href="<?php echo $url; ?>" class="list-group-item facet-value">
									          <span class="badge facet-count"><?php echo $count; ?></span><?php echo $value; ?>
									        </a>
									      <?php endforeach; ?>
									    </div>
									  <?php endif; ?>

									<!-- Default Facets -->
									<?php else: ?>
										<div class="panel-heading">
											<strong><?php echo $label; ?></strong>
										</div>
										<div class="list-group">
											<!-- Facets. -->
											<?php $display_facets = array_slice(get_object_vars($facets), 0, 3); ?>
											<?php foreach ($display_facets as $value => $count): ?>
												<!-- Facet URL. -->
												<?php $url = SolrSearch_Helpers_Facet::addFacet($name, $value); ?>
												<!-- Facet link. -->
												<a href="<?php echo $url; ?>" class="list-group-item facet-value">
													<span class="badge facet-count"><?php echo $count; ?></span><?php echo $value; ?>
												</a>
											<?php endforeach; ?>
											<?php if ((count(get_object_vars($facets))) > 3 ): ?>
												<?php $hidden_facets = array_slice(get_object_vars($facets), 3); ?>
												<div id="collapse<?php echo $collapse_count; ?>" class="panel-collapse collapse">
												<?php foreach ($hidden_facets as $value => $count): ?>
													<!-- Facet URL. -->
													<?php $url = SolrSearch_Helpers_Facet::addFacet($name, $value); ?>
													<!-- Facet link. -->
													<a href="<?php echo $url; ?>" class="list-group-item facet-value">
														<span class="badge facet-count"><?php echo $count; ?></span><?php echo $value; ?>
													</a>
												<?php endforeach; ?>
												</div>
												<a class="list-group-item more" role="button" data-toggle="collapse" href="#collapse<?php echo $collapse_count++; ?>">More...</a>
											<?php endif; ?>
										</div>
									<?php endif; ?>
								</div>
							<?php endif; ?>
						<?php endforeach; ?>
					</div>
				</div>
	    </div>
	  </div>
	</div>

	<?php echo pagination_links(); ?>
<?php endif; ?>
<?php echo foot();
