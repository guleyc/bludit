<footer class="np-footer" role="contentinfo">
	<div class="np-footer-top">
		<div class="container">
			<div class="np-footer-cols">

				<!-- About Column -->
				<div class="np-footer-col np-footer-col--about">
					<a class="np-footer-brand" href="<?php echo Theme::siteUrl(); ?>">
						<span class="np-footer-brand-name"><?php echo $site->title(); ?></span>
					</a>
					<?php if ($site->description()): ?>
					<p class="np-footer-about-text"><?php echo htmlspecialchars($site->description()); ?></p>
					<?php endif ?>
					<?php if ($site->slogan()): ?>
					<p class="np-footer-slogan"><?php echo htmlspecialchars($site->slogan()); ?></p>
					<?php endif ?>

					<!-- Social links -->
					<?php $hasSocial = false; foreach (Theme::socialNetworks() as $key => $label): if ($site->{$key}()) { $hasSocial = true; break; } endforeach; ?>
					<?php if ($hasSocial || Theme::rssUrl()): ?>
					<div class="np-footer-social">
						<?php foreach (Theme::socialNetworks() as $key => $label): ?>
						<?php if ($site->{$key}()): ?>
						<a href="<?php echo $site->{$key}(); ?>" target="_blank" rel="noopener noreferrer"
							aria-label="<?php echo $label; ?>" class="np-footer-social-link">
							<img src="<?php echo DOMAIN_THEME . 'img/' . $key . '.svg' ?>" alt="" aria-hidden="true" class="np-footer-social-icon" />
						</a>
						<?php endif; ?>
						<?php endforeach; ?>
						<?php if (Theme::rssUrl()): ?>
						<a href="<?php echo Theme::rssUrl() ?>" target="_blank" rel="noopener noreferrer"
							aria-label="<?php echo $L->get('RSS Feed'); ?>" class="np-footer-social-link">
							<i class="bi bi-rss-fill np-footer-rss" aria-hidden="true"></i>
						</a>
						<?php endif; ?>
					</div>
					<?php endif ?>
				</div>

				<!-- Quick Links Column -->
				<?php if (!empty($staticContent)): ?>
				<div class="np-footer-col">
					<h3 class="np-footer-col-title"><?php echo $L->get('Quick Links'); ?></h3>
					<ul class="np-footer-link-list">
						<li><a class="np-footer-link" href="<?php echo Theme::siteUrl(); ?>"><?php echo $L->get('Home'); ?></a></li>
						<?php foreach ($staticContent as $staticPage): ?>
						<li>
							<a class="np-footer-link" href="<?php echo $staticPage->permalink(); ?>">
								<?php echo $staticPage->title(); ?>
							</a>
						</li>
						<?php endforeach ?>
					</ul>
				</div>
				<?php endif ?>

				<!-- Categories Column -->
				<?php
				$footerCategories = [];
				if (!empty($content)) {
					foreach ($content as $fp) {
						$catKey = $fp->categoryKey();
						if ($catKey && !isset($footerCategories[$catKey])) {
							$footerCategories[$catKey] = ['name' => $fp->category(), 'url' => $fp->categoryPermalink()];
						}
					}
				}
				?>
				<?php if (!empty($footerCategories)): ?>
				<div class="np-footer-col">
					<h3 class="np-footer-col-title"><?php echo $L->get('Categories'); ?></h3>
					<ul class="np-footer-link-list">
						<?php foreach ($footerCategories as $cat): ?>
						<li>
							<a class="np-footer-link" href="<?php echo $cat['url']; ?>">
								<i class="bi bi-chevron-right" aria-hidden="true"></i>
								<?php echo htmlspecialchars($cat['name']); ?>
							</a>
						</li>
						<?php endforeach ?>
					</ul>
				</div>
				<?php endif ?>

			</div><!-- /np-footer-cols -->
		</div>
	</div><!-- /np-footer-top -->

	<div class="np-footer-bottom">
		<div class="container">
			<div class="np-footer-bottom-inner">
				<span class="np-footer-copy"><?php echo $site->footer(); ?></span>
				<?php if (!defined('BLUDIT_PRO')): ?>
				<span class="np-footer-credit">
					<?php echo $L->get('Powered by'); ?> <a href="https://www.bludit.com" target="_blank" rel="noopener noreferrer">BLUDIT</a>
				</span>
				<?php endif; ?>
			</div>
		</div>
	</div><!-- /np-footer-bottom -->
</footer>
