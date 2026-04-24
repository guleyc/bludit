<header class="np-navbar" role="banner">
	<div class="np-navbar-inner container">

		<!-- Brand -->
		<a class="np-brand" href="<?php echo Theme::siteUrl(); ?>" aria-label="<?php echo $site->title(); ?> - <?php echo $L->get('Home'); ?>">
			<span class="np-brand-name"><?php echo $site->title(); ?></span>
		</a>

		<!-- Mobile toggle -->
		<button class="np-nav-toggle" type="button" data-toggle="collapse" data-target="#npNavMenu"
			aria-controls="npNavMenu" aria-expanded="false"
			aria-label="<?php echo $L->get('Toggle navigation'); ?>">
			<span class="np-nav-toggle-icon"></span>
			<span class="np-nav-toggle-icon"></span>
			<span class="np-nav-toggle-icon"></span>
		</button>

		<nav class="collapse navbar-collapse np-nav-menu" id="npNavMenu" aria-label="<?php echo $L->get('Main navigation'); ?>">
			<ul class="np-nav-list" role="list">

				<!-- Blog link (when homepage is set to a static page) -->
				<?php if ($site->homepage()): ?>
				<li class="np-nav-item">
					<a class="np-nav-link<?php echo ($WHERE_AM_I === 'blog') ? ' np-nav-link--active' : ''; ?>"
						href="<?php echo DOMAIN_BASE . ltrim($url->filters('blog'), '/') ?>">
						<?php echo $L->get('Blog') ?>
					</a>
				</li>
				<?php endif; ?>

				<!-- Static pages -->
				<?php foreach ($staticContent as $staticPage): ?>
				<li class="np-nav-item">
					<a class="np-nav-link<?php echo ($page && $page->key() === $staticPage->key()) ? ' np-nav-link--active' : ''; ?>"
						href="<?php echo $staticPage->permalink(); ?>"
						<?php if ($page && $page->key() === $staticPage->key()): ?>aria-current="page"<?php endif; ?>>
						<?php echo $staticPage->title(); ?>
					</a>
				</li>
				<?php endforeach ?>

				<!-- Social Networks -->
				<?php foreach (Theme::socialNetworks() as $key => $label): ?>
				<li class="np-nav-item">
					<a class="np-nav-link np-nav-social" href="<?php echo $site->{$key}(); ?>"
						target="_blank" rel="noopener noreferrer" aria-label="<?php echo $label; ?>">
						<img class="np-social-icon" src="<?php echo DOMAIN_THEME . 'img/' . $key . '.svg' ?>"
							alt="" aria-hidden="true" />
						<span class="np-social-label"><?php echo $label; ?></span>
					</a>
				</li>
				<?php endforeach; ?>

				<!-- RSS -->
				<?php if (Theme::rssUrl()): ?>
				<li class="np-nav-item">
					<a class="np-nav-link np-nav-rss" href="<?php echo Theme::rssUrl() ?>"
						target="_blank" rel="noopener noreferrer" aria-label="<?php echo $L->get('RSS Feed'); ?>">
						<i class="bi bi-rss-fill" aria-hidden="true"></i>
						<span class="np-social-label"><?php echo $L->get('RSS'); ?></span>
					</a>
				</li>
				<?php endif; ?>

			</ul>
		</nav>

	</div>
</header>
