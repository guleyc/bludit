<!-- Top Info Bar -->
<div class="np-topbar">
	<div class="container">
		<div class="np-topbar-inner">
			<span class="np-topbar-date">
				<i class="bi bi-calendar3" aria-hidden="true"></i>
				<span id="np-date-display"></span>
			</span>
			<span class="np-topbar-tagline"><?php echo htmlspecialchars($site->slogan()); ?></span>
			<div class="np-topbar-social">
				<?php foreach (Theme::socialNetworks() as $key => $label): ?>
				<a href="<?php echo $site->{$key}(); ?>" target="_blank" rel="noopener noreferrer" aria-label="<?php echo $label; ?>" class="np-topbar-social-link">
					<img src="<?php echo DOMAIN_THEME . 'img/' . $key . '.svg' ?>" alt="" aria-hidden="true" class="np-topbar-social-icon" />
				</a>
				<?php endforeach; ?>
				<?php if (Theme::rssUrl()): ?>
				<a href="<?php echo Theme::rssUrl() ?>" target="_blank" rel="noopener noreferrer" aria-label="<?php echo $L->get('RSS Feed'); ?>" class="np-topbar-social-link">
					<i class="bi bi-rss-fill np-topbar-rss" aria-hidden="true"></i>
				</a>
				<?php endif; ?>
			</div>
		</div>
	</div>
</div>

<!-- Main Navbar -->
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

				<!-- Home link -->
				<li class="np-nav-item">
					<a class="np-nav-link<?php echo ($WHERE_AM_I !== 'page') ? ' np-nav-link--active' : ''; ?>"
						href="<?php echo Theme::siteUrl(); ?>">
						<?php echo $L->get('Home'); ?>
					</a>
				</li>

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

				<!-- Search icon (visible on mobile only, full-width search) -->
				<?php if (pluginActivated('pluginSearch')): ?>
				<li class="np-nav-item np-nav-item--search-mobile">
					<a class="np-nav-link" href="<?php echo Theme::siteUrl(); ?>search/" aria-label="<?php echo $L->get('Search'); ?>">
						<i class="bi bi-search" aria-hidden="true"></i>
						<span class="np-social-label"><?php echo $L->get('Search'); ?></span>
					</a>
				</li>
				<?php endif; ?>

			</ul>
		</nav>

	</div>
</header>

<!-- Secondary Category Nav (desktop only) -->
<?php
$navCategories = [];
if (!empty($content)) {
	foreach ($content as $p) {
		$catKey = $p->categoryKey();
		$catName = $p->category();
		if ($catKey && !isset($navCategories[$catKey])) {
			$navCategories[$catKey] = ['name' => $catName, 'url' => $p->categoryPermalink()];
		}
	}
}
?>
<?php if (!empty($navCategories)): ?>
<nav class="np-catbar" aria-label="<?php echo $L->get('Categories'); ?>">
	<div class="container">
		<ul class="np-catbar-list" role="list">
			<?php foreach ($navCategories as $catData): ?>
			<li class="np-catbar-item">
				<a class="np-catbar-link" href="<?php echo $catData['url']; ?>"><?php echo $catData['name']; ?></a>
			</li>
			<?php endforeach; ?>
		</ul>
	</div>
</nav>
<?php endif; ?>

<script>
(function() {
	var d = document.getElementById('np-date-display');
	if (d) {
		var now = new Date();
		d.textContent = now.toLocaleDateString(undefined, {weekday:'long', year:'numeric', month:'long', day:'numeric'});
	}
})();
</script>
