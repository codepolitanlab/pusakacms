<ul class="nav navbar-nav">
	<!--<li>
		<a href="<?php echo site_url('/'); ?>" target="_blank">Pusaka</a>
	</li>-->
	<?php foreach ($navs as $context => $nav): ?>
		<?php if(count($nav) > 1): ?>
			<li class="dropdown">
				<a href="#" class="dropdown-toggle nav-tooltip" data-toggle="dropdown">
				<?php echo $context; ?>
				</a>
				<ul class="dropdown-menu">
					<?php foreach ($nav as $sort => $links): ?>
						<?php if(!isset($links['allowed_sites']) || (isset($links['allowed_sites']) && in_array(SITE_SLUG, $links['allowed_sites']))): ?> 

							<li>
								<a href="<?php echo site_url('panel/'.$links['link']); ?>"><?php echo $links['caption']; ?></a>
							</li>

						<?php endif; ?>
					<?php endforeach; ?>
				</ul>
			</li>
		<?php else: ?>
			<?php foreach ($nav as $links): ?>
				<?php if(!isset($links['allowed_sites']) || (isset($links['allowed_sites']) && in_array(SITE_SLUG, $links['allowed_sites']))): ?>

					<li>
						<a href="<?php echo site_url('panel/'.$links['link']); ?>"><?php echo $links['caption']; ?></a>
					</li>

				<?php endif; ?>
			<?php endforeach; ?>
		<?php endif; ?>
	<?php endforeach; ?>
</ul>