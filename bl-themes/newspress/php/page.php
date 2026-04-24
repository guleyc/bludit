<!-- Breadcrumb Navigation -->
<nav class="np-breadcrumb" aria-label="<?php echo $L->get('Breadcrumb'); ?>">
	<div class="container">
		<ol class="np-breadcrumb-list" itemscope itemtype="https://schema.org/BreadcrumbList">
			<li class="np-breadcrumb-item" itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
				<a href="<?php echo Theme::siteUrl(); ?>" itemprop="item">
					<i class="bi bi-house" aria-hidden="true"></i>
					<span itemprop="name"><?php echo $L->get('Home'); ?></span>
				</a>
				<meta itemprop="position" content="1" />
			</li>
			<?php if ($page->categoryKey()): ?>
			<li class="np-breadcrumb-item" itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem">
				<a href="<?php echo $page->categoryPermalink(); ?>" itemprop="item">
					<span itemprop="name"><?php echo $page->category(); ?></span>
				</a>
				<meta itemprop="position" content="2" />
			</li>
			<li class="np-breadcrumb-item np-breadcrumb-item--active" itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem" aria-current="page">
				<span itemprop="name"><?php echo $page->title(); ?></span>
				<meta itemprop="item" content="<?php echo $page->permalink(); ?>" />
				<meta itemprop="position" content="3" />
			</li>
			<?php else: ?>
			<li class="np-breadcrumb-item np-breadcrumb-item--active" itemprop="itemListElement" itemscope itemtype="https://schema.org/ListItem" aria-current="page">
				<span itemprop="name"><?php echo $page->title(); ?></span>
				<meta itemprop="item" content="<?php echo $page->permalink(); ?>" />
				<meta itemprop="position" content="2" />
			</li>
			<?php endif ?>
		</ol>
	</div>
</nav>

<!-- Article -->
<article class="np-article" itemscope itemtype="https://schema.org/NewsArticle">

	<!-- Hidden SEO metadata -->
	<meta itemprop="mainEntityOfPage" content="<?php echo $page->permalink(); ?>" />
	<?php if ($page->dateModified()): ?>
		<meta itemprop="dateModified" content="<?php echo $page->dateModified('c'); ?>" />
	<?php else: ?>
		<meta itemprop="dateModified" content="<?php echo $page->dateRaw('c'); ?>" />
	<?php endif; ?>
	<meta itemprop="wordCount" content="<?php echo str_word_count(strip_tags($page->content())); ?>" />
	<span itemprop="publisher" itemscope itemtype="https://schema.org/Organization">
		<meta itemprop="name" content="<?php echo $site->title(); ?>" />
		<span itemprop="logo" itemscope itemtype="https://schema.org/ImageObject">
			<meta itemprop="url" content="<?php echo DOMAIN_THEME . 'img/favicon.svg'; ?>" />
		</span>
	</span>

	<!-- Cover image (full width, above article body) -->
	<?php if ($page->coverImage()): ?>
	<div class="np-article-cover-wrap">
		<img class="np-article-cover" src="<?php echo $page->coverImage(); ?>"
			alt="<?php echo htmlspecialchars($page->title()); ?>"
			loading="eager" itemprop="image" />
	</div>
	<?php endif ?>

	<div class="container">
		<div class="np-article-body">

			<!-- Load Bludit Plugins: Page Begin -->
			<?php Theme::plugins('pageBegin'); ?>

			<header class="np-article-header">

				<!-- Category badge -->
				<?php if ($page->categoryKey()): ?>
				<a class="np-badge np-badge--category" href="<?php echo $page->categoryPermalink(); ?>">
					<?php echo $page->category(); ?>
				</a>
				<?php endif ?>

				<!-- Title -->
				<h1 class="np-article-title" itemprop="headline"><?php echo $page->title(); ?></h1>

				<!-- Description / lead -->
				<?php if ($page->description()): ?>
				<p class="np-article-lead" itemprop="description"><?php echo $page->description(); ?></p>
				<?php endif ?>

				<!-- Meta bar -->
				<?php if (!$page->isStatic() && !$url->notFound()): ?>
				<div class="np-article-meta">
					<!-- Author -->
					<span class="np-meta-author" itemprop="author" itemscope itemtype="https://schema.org/Person">
						<i class="bi bi-person" aria-hidden="true"></i>
						<a href="<?php echo Theme::siteUrl(); ?>" rel="author" itemprop="url">
							<span itemprop="name"><?php echo $page->user('nickname'); ?></span>
						</a>
					</span>

					<!-- Published date -->
					<time class="np-meta-date" datetime="<?php echo $page->dateRaw('c'); ?>" itemprop="datePublished">
						<i class="bi bi-calendar3" aria-hidden="true"></i>
						<?php echo $page->date(); ?>
					</time>

					<!-- Updated date -->
					<?php if ($page->dateModified() && $page->dateModified() !== $page->date()): ?>
					<time class="np-meta-updated" datetime="<?php echo $page->dateModified('c'); ?>">
						<i class="bi bi-pencil" aria-hidden="true"></i>
						<?php echo $L->get('Updated'); ?>: <?php echo $page->dateModified(); ?>
					</time>
					<?php endif ?>

					<!-- Reading time -->
					<span class="np-meta-read">
						<i class="bi bi-clock" aria-hidden="true"></i>
						<?php echo $page->readingTime(); ?> <?php echo $L->get('min read'); ?>
					</span>
				</div>
				<?php endif ?>

			</header>

			<!-- Article content -->
			<div class="np-article-content" itemprop="articleBody">
				<?php echo $page->content(); ?>
			</div>

			<!-- Tags -->
			<?php $tagsList = $page->tags(true); ?>
			<?php if (!empty($tagsList)): ?>
			<div class="np-tags" aria-label="<?php echo $L->get('Tags'); ?>">
				<i class="bi bi-tags" aria-hidden="true"></i>
				<?php foreach ($tagsList as $tagKey => $tagName): ?>
				<a class="np-badge np-badge--tag" href="<?php echo DOMAIN_TAGS . $tagKey; ?>">
					<?php echo $tagName; ?>
				</a>
				<?php endforeach ?>
			</div>
			<?php endif ?>

			<!-- Load Bludit Plugins: Page End -->
			<?php Theme::plugins('pageEnd'); ?>

		</div>
	</div>
</article>
