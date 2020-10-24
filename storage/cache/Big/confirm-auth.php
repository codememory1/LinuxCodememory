<?php echo \View::theme('header'); ?>
<?php $prev = Common::getPrevUrl();?>

<div class="container-auth">
	<div class="content-auth">
		<div class="logo-login grid">
			<h1>FastDB</h1>
		</div>
		<?php echo \View::theme('flash'); ?>
		<form action="<?php echo route('FastDB.configm-auth-handler'); ?>?redirect=<?php echo $prev['uri']; ?>&login=<?php echo $prev['params']['login']; ?>" method="post" class="grid" style="min-width: 400px;max-width:100%;width:auto">
			<input type="hidden" name="cdm_token" value="<?php echo protection_token(); ?>">
			<input type="password" name="confirm-password" placeholder="Введите текущий пароль">
			<button class="btn btn-success" btn-loader="default">Подтвердить</button>
		</form>
		
	</div>
</div>

<?php echo \View::theme('footer'); ?>
