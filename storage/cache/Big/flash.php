<?php if(Flash::has('flash-error') === true): ?>
<?php $flash = Flash::get('flash-error');?>
	<div class="flash flash-<?php echo array_key_first($flash); ?>">
		<span class="message-flash"><?php echo array_shift($flash); ?></span>
	</div>
<?php endif; ?>