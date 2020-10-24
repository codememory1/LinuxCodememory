<?php echo \View::theme('header'); ?>

<div class="container-auth">
	<div class="content-auth">
		<div class="logo-login grid" style="justify-content: center;">
			<img src="/src/images/logo.svg" alt="FastDB" style="width: 200px;">
		</div>
		<?php echo \View::theme('flash'); ?>
		<form action="<?php echo route('FastDB.auth-handler'); ?>" method="post" class="grid" style="min-width: 400px;max-width:100%;width:auto">
			<input type="hidden" name="cdm_token" value="<?php echo protection_token(); ?>">
			<input type="text" name="server" placeholder="Сервер и порт 000.000.00.00.0:000" value="">
			<input type="text" name="login" placeholder="Имя пользователя" value="">
			<input type="password" name="password" placeholder="Пароль">
			<button class="btn btn-success" btn-loader="default">Войти</button>
		</form>
		<div class="footer-login-form" style="text-align: center;">
			<a href="/documentation/docs">Документация</a>
		</div>
	</div>
</div>

<?php echo \View::theme('footer'); ?>

<script>
	document.querySelector('[name=server]').value = config.server;
	document.querySelector('[name=login]').value = config.username;
</script>
