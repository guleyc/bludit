<footer class="np-footer" role="contentinfo">
	<div class="container">
		<div class="np-footer-inner">
			<?php if (defined('BLUDIT_PRO')): ?>
			<span class="np-footer-copy"><?php echo $site->footer(); ?></span>
			<?php else: ?>
			<span class="np-footer-copy"><?php echo $site->footer(); ?></span>
			<span class="np-footer-credit">
				Powered by <a href="https://www.bludit.com" target="_blank" rel="noopener noreferrer">BLUDIT</a>
			</span>
			<?php endif; ?>
		</div>
	</div>
</footer>
