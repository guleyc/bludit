<?php
// Split articles: first one is featured, rest go to grid
$featuredPage = null;
$gridPages = [];
if (!empty($content)) {
	$featuredPage = $content[0];
	$gridPages = array_slice($content, 1);
}

// Build category list from current content for sidebar
$sidebarCategories = [];
if (!empty($content)) {
	foreach ($content as $p) {
		$catKey = $p->categoryKey();
		$catName = $p->category();
		if ($catKey && !isset($sidebarCategories[$catKey])) {
			$sidebarCategories[$catKey] = ['name' => $catName, 'url' => $p->categoryPermalink(), 'count' => 0];
		}
		if ($catKey) $sidebarCategories[$catKey]['count']++;
	}
}

// Latest posts for sidebar (up to 5)
$latestForSidebar = array_slice($content, 0, 5);
?>

<!-- Search bar when plugin is active -->
<?php if (pluginActivated('pluginSearch')): ?>
<?php $searchPlugin = getPlugin('pluginSearch'); ?>
<div class="np-search-bar">
	<div class="container">
		<form class="np-search-form" role="search" onsubmit="return npSearchNow();">
			<label for="np-search-input" class="np-sr-only"><?php echo $L->get('Search') ?></label>
			<div class="np-search-wrap">
				<i class="bi bi-search np-search-icon" aria-hidden="true"></i>
				<input id="np-search-input" class="np-search-input" type="search"
					placeholder="<?php echo $L->get('Search') ?>"
					aria-label="<?php echo $L->get('Search') ?>"
					value="<?php echo ($WHERE_AM_I === 'search' ? htmlspecialchars($searchPlugin->getSearchTerm()) : '') ?>">
				<button type="submit" class="np-search-btn"><?php echo $L->get('Search') ?></button>
			</div>
		</form>
	</div>
</div>
<script>
function npSearchNow() {
	var val = document.getElementById('np-search-input').value.trim();
	if (!val) return false;
	window.location.href = '<?php echo Theme::siteUrl(); ?>search/' + encodeURIComponent(val);
	return false;
}
</script>
<?php endif ?>

<!-- Breaking News Ticker -->
<?php if (!empty($content)): ?>
<div class="np-ticker">
	<div class="container">
		<div class="np-ticker-inner">
			<span class="np-ticker-label">
				<i class="bi bi-lightning-fill" aria-hidden="true"></i>
				<?php echo $L->get('Breaking'); ?>
			</span>
			<div class="np-ticker-track" aria-live="polite" aria-atomic="true">
				<?php $tickerItems = array_slice($content, 0, 6); ?>
				<ul class="np-ticker-list" aria-label="<?php echo $L->get('Breaking news headlines'); ?>">
					<?php foreach ($tickerItems as $tickerPage): ?>
					<li class="np-ticker-item">
						<a href="<?php echo $tickerPage->permalink(); ?>"><?php echo htmlspecialchars($tickerPage->title()); ?></a>
					</li>
					<?php endforeach; ?>
					<?php /* Duplicate for seamless loop */ foreach ($tickerItems as $tickerPage): ?>
					<li class="np-ticker-item" aria-hidden="true">
						<a href="<?php echo $tickerPage->permalink(); ?>" tabindex="-1"><?php echo htmlspecialchars($tickerPage->title()); ?></a>
					</li>
					<?php endforeach; ?>
				</ul>
			</div>
		</div>
	</div>
</div>
<?php endif ?>

<?php if (empty($content)): ?>
<div class="container np-empty">
	<p><?php echo $L->get('No pages found') ?></p>
</div>
<?php endif ?>

<!-- Featured Article (hero, image overlay style) -->
<?php if ($featuredPage): ?>
<section class="np-hero" aria-label="<?php echo $L->get('Featured article'); ?>">
	<div class="container">
		<article class="np-hero-card" itemscope itemtype="https://schema.org/NewsArticle">
			<meta itemprop="mainEntityOfPage" content="<?php echo $featuredPage->permalink(); ?>" />
			<meta itemprop="datePublished" content="<?php echo $featuredPage->dateRaw('c'); ?>" />
			<?php if ($featuredPage->dateModified()): ?>
				<meta itemprop="dateModified" content="<?php echo $featuredPage->dateModified('c'); ?>" />
			<?php else: ?>
				<meta itemprop="dateModified" content="<?php echo $featuredPage->dateRaw('c'); ?>" />
			<?php endif; ?>
			<span itemprop="publisher" itemscope itemtype="https://schema.org/Organization">
				<meta itemprop="name" content="<?php echo $site->title(); ?>" />
			</span>
			<span itemprop="author" itemscope itemtype="https://schema.org/Person">
				<meta itemprop="name" content="<?php echo $featuredPage->user('nickname'); ?>" />
			</span>

			<?php if ($featuredPage->coverImage()): ?>
			<a href="<?php echo $featuredPage->permalink(); ?>" class="np-hero-img-link" tabindex="-1" aria-hidden="true">
				<div class="np-hero-img-wrap">
					<img class="np-hero-img" src="<?php echo $featuredPage->coverImage(); ?>"
						alt="<?php echo htmlspecialchars($featuredPage->title()); ?>"
						loading="eager" itemprop="image" />
				</div>
			</a>
			<?php endif ?>

			<div class="np-hero-overlay">
				<?php if ($featuredPage->categoryKey()): ?>
				<a class="np-badge np-badge--category" href="<?php echo $featuredPage->categoryPermalink(); ?>">
					<?php echo $featuredPage->category(); ?>
				</a>
				<?php endif ?>

				<h2 class="np-hero-title" itemprop="headline">
					<a href="<?php echo $featuredPage->permalink(); ?>" itemprop="url"><?php echo $featuredPage->title(); ?></a>
				</h2>

				<?php if ($featuredPage->description()): ?>
				<p class="np-hero-desc" itemprop="description"><?php echo $featuredPage->description(); ?></p>
				<?php endif ?>

				<div class="np-meta np-meta--light">
					<time class="np-meta-date" datetime="<?php echo $featuredPage->dateRaw('c'); ?>">
						<i class="bi bi-calendar3" aria-hidden="true"></i>
						<?php echo $featuredPage->date(); ?>
					</time>
					<span class="np-meta-read">
						<i class="bi bi-clock" aria-hidden="true"></i>
						<?php echo $featuredPage->readingTime(); ?> <?php echo $L->get('min read'); ?>
					</span>
				</div>
			</div>

			<?php Theme::plugins('pageBegin'); ?>
			<?php Theme::plugins('pageEnd'); ?>
		</article>
	</div>
</section>
<?php endif ?>

<!-- Main Content + Sidebar -->
<div class="np-content-area">
	<div class="container">
		<div class="np-content-row">

			<!-- Main: Articles Grid -->
			<main class="np-content-main">
				<?php if (!empty($gridPages)): ?>
				<div class="np-section-header">
					<h2 class="np-section-title"><?php echo $L->get('Latest News'); ?></h2>
				</div>
				<div class="np-grid">
					<?php foreach ($gridPages as $page): ?>
					<article class="np-card" itemscope itemtype="https://schema.org/NewsArticle">
						<meta itemprop="mainEntityOfPage" content="<?php echo $page->permalink(); ?>" />
						<meta itemprop="datePublished" content="<?php echo $page->dateRaw('c'); ?>" />
						<?php if ($page->dateModified()): ?>
							<meta itemprop="dateModified" content="<?php echo $page->dateModified('c'); ?>" />
						<?php else: ?>
							<meta itemprop="dateModified" content="<?php echo $page->dateRaw('c'); ?>" />
						<?php endif; ?>
						<span itemprop="publisher" itemscope itemtype="https://schema.org/Organization">
							<meta itemprop="name" content="<?php echo $site->title(); ?>" />
						</span>
						<span itemprop="author" itemscope itemtype="https://schema.org/Person">
							<meta itemprop="name" content="<?php echo $page->user('nickname'); ?>" />
						</span>

						<?php Theme::plugins('pageBegin'); ?>

						<?php if ($page->coverImage()): ?>
						<a href="<?php echo $page->permalink(); ?>" class="np-card-img-link" tabindex="-1" aria-hidden="true">
							<div class="np-card-img-wrap">
								<img class="np-card-img" src="<?php echo $page->coverImage(); ?>"
									alt="<?php echo htmlspecialchars($page->title()); ?>"
									loading="lazy" itemprop="image" />
							</div>
						</a>
						<?php endif ?>

						<div class="np-card-body">
							<?php if ($page->categoryKey()): ?>
							<a class="np-badge np-badge--category" href="<?php echo $page->categoryPermalink(); ?>">
								<?php echo $page->category(); ?>
							</a>
							<?php endif ?>

							<h3 class="np-card-title" itemprop="headline">
								<a href="<?php echo $page->permalink(); ?>" itemprop="url"><?php echo $page->title(); ?></a>
							</h3>

							<?php if ($page->description()): ?>
							<p class="np-card-desc" itemprop="description"><?php echo $page->description(); ?></p>
							<?php endif ?>

							<div class="np-meta">
								<time class="np-meta-date" datetime="<?php echo $page->dateRaw('c'); ?>">
									<i class="bi bi-calendar3" aria-hidden="true"></i>
									<?php echo $page->date(); ?>
								</time>
								<span class="np-meta-read">
									<i class="bi bi-clock" aria-hidden="true"></i>
									<?php echo $page->readingTime(); ?> <?php echo $L->get('min read'); ?>
								</span>
							</div>
						</div>

						<?php Theme::plugins('pageEnd'); ?>
					</article>
					<?php endforeach ?>
				</div>
				<?php endif ?>

				<!-- Pagination -->
				<?php if (Paginator::numberOfPages() > 1): ?>
				<nav class="np-pagination" aria-label="<?php echo $L->get('Page navigation'); ?>">
					<ul class="np-pagination-list">
						<?php if (Paginator::showPrev()): ?>
						<li>
							<a class="np-page-btn" href="<?php echo Paginator::previousPageUrl() ?>" rel="prev">
								<i class="bi bi-chevron-left" aria-hidden="true"></i>
								<span><?php echo $L->get('Previous'); ?></span>
							</a>
						</li>
						<?php endif; ?>
						<li>
							<a class="np-page-btn np-page-btn--home<?php echo (Paginator::currentPage() == 1) ? ' np-page-btn--disabled' : ''; ?>"
								href="<?php echo Theme::siteUrl() ?>"
								<?php echo (Paginator::currentPage() == 1) ? 'aria-current="page" aria-disabled="true"' : ''; ?>>
								<i class="bi bi-house" aria-hidden="true"></i>
								<span><?php echo $L->get('Home'); ?></span>
							</a>
						</li>
						<?php if (Paginator::showNext()): ?>
						<li>
							<a class="np-page-btn" href="<?php echo Paginator::nextPageUrl() ?>" rel="next">
								<span><?php echo $L->get('Next'); ?></span>
								<i class="bi bi-chevron-right" aria-hidden="true"></i>
							</a>
						</li>
						<?php endif; ?>
					</ul>
				</nav>
				<?php endif ?>
			</main><!-- /np-content-main -->

			<!-- Sidebar -->
			<aside class="np-sidebar" aria-label="<?php echo $L->get('Sidebar'); ?>">

				<!-- Categories Widget -->
				<?php if (!empty($sidebarCategories)): ?>
				<div class="np-widget">
					<h3 class="np-widget-title"><?php echo $L->get('Categories'); ?></h3>
					<ul class="np-widget-cat-list">
						<?php foreach ($sidebarCategories as $catData): ?>
						<li class="np-widget-cat-item">
							<a href="<?php echo $catData['url']; ?>" class="np-widget-cat-link">
								<i class="bi bi-chevron-right" aria-hidden="true"></i>
								<?php echo htmlspecialchars($catData['name']); ?>
							</a>
							<span class="np-widget-cat-count"><?php echo $catData['count']; ?></span>
						</li>
						<?php endforeach; ?>
					</ul>
				</div>
				<?php endif ?>

				<!-- Latest Posts Widget -->
				<?php if (!empty($latestForSidebar)): ?>
				<div class="np-widget">
					<h3 class="np-widget-title"><?php echo $L->get('Latest News'); ?></h3>
					<ul class="np-widget-post-list">
						<?php foreach ($latestForSidebar as $sPage): ?>
						<li class="np-widget-post-item">
							<?php if ($sPage->coverImage()): ?>
							<a href="<?php echo $sPage->permalink(); ?>" class="np-widget-post-img-link" tabindex="-1" aria-hidden="true">
								<img src="<?php echo $sPage->coverImage(); ?>" alt="" class="np-widget-post-img" loading="lazy" />
							</a>
							<?php endif ?>
							<div class="np-widget-post-body">
								<?php if ($sPage->categoryKey()): ?>
								<a class="np-badge np-badge--category np-badge--xs" href="<?php echo $sPage->categoryPermalink(); ?>">
									<?php echo $sPage->category(); ?>
								</a>
								<?php endif ?>
								<h4 class="np-widget-post-title">
									<a href="<?php echo $sPage->permalink(); ?>"><?php echo $sPage->title(); ?></a>
								</h4>
								<time class="np-widget-post-date" datetime="<?php echo $sPage->dateRaw('c'); ?>">
									<i class="bi bi-calendar3" aria-hidden="true"></i>
									<?php echo $sPage->date(); ?>
								</time>
							</div>
						</li>
						<?php endforeach; ?>
					</ul>
				</div>
				<?php endif ?>

			</aside><!-- /np-sidebar -->

		</div><!-- /np-content-row -->
	</div><!-- /container -->
</div><!-- /np-content-area -->
