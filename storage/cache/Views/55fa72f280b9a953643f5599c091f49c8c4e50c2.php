<?php echo e(View::theme('FastDB.Common.Head')); ?>


<?php ($lang = Lang::selectLang(Lang::getActiveLang())) ?>

<?php echo Assets::execute()->css('FastDB/_login'); ?>


<div class="container">
    <form id="auth-db" action="<?php echo e(route('FastDB.auth-handle')); ?>" method="post">

		<?php echo e(View::theme('FastDB.Common.FlashMessage')); ?>

       	
        <div class="logo">
            <h2>FastDB</h2>
        </div>
        <span class="error_log"></span>
        <input type="hidden" name="cdm_token" value="<?php echo e(protection_token()); ?>">
		<input type="text" name="server-port" placeholder="<?php echo e($lang->get('server_and_port')); ?>" value="127.0.0.1:8000">
        <input type="text" name="username" placeholder="<?php echo e($lang->get('username')); ?>" value="default">
        <input type="password" name="password" placeholder="<?php echo e($lang->get('password')); ?>">
        <button class="btn btn-auth"><?php echo e($lang->get('auth')); ?></button> 
    </form>
</div>

<style>
	.error-message {
		border-radius: 2px;
		padding: 4px 4px;
		text-align: center;
		color: #fff;
		font-weight: 400;
		pointer-events: none;
	}
	
	.message-handle-error {
		background: #f67c7c;
	}
	
	.message-handle-success {
		background: #25c532;
	}
	
	.error-message span {
		pointer-events: none;
	}

	.handle-message span {
		width: 100%;
	}
</style>

<?php echo e(View::theme('FastDB.Common.Footer')); ?>












<?php echo Assets::execute()->css('libs/video-player'); ?>

<?php echo Assets::execute()->css('all.min'); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    
<div video-component="true" video-attr="video1">
    <div class="video-player__content">
        <div class="video-player__content-top">
            <span class="title">Название</span>
        </div>
        <div class="video-player__absolute-content">
            <div class="video-player__play-pause">
                <i class="fas fa-play"></i>
            </div>
        </div>
        <div class="video-player__footer">
            <div class="video-player__footer-absolute">
                <div class="footer-perk-1">
                    <div class="progress-video">
                        <div role="range" data-range="true" range-bg="#fff" range-tail-bg="#15b51a" height="4" class="pR">
                            <div class="hover-progress-video"></div>
                        </div>
                    </div>
                </div>
                <div class="footer-perk-2">
                    <div>
                        <div class="play-pause-footer">
                            <i class="fas fa-play"></i>
                        </div>
                        <div class="volume-video">
                            <i class="fas fa-volume"></i>
                        </div>
                        <div class="progress-volume">
                        <div role="range" data-range="true" range-bg="#fff" range-tail-bg="#15b51a" height="4" width="70"></div>
                        </div>
                    </div>
                    <div>
                        <div class="video-company">
                            <span></span>
                        </div>
                        <div class="video-settings">
                            <i class="fal fa-cog"></i>  
                        </div>
                        <div class="video-fullscreen">
                            <i class="far fa-compress-wide"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <video src="/src/video.mp4"></video>
    </div>
</div>

<?php echo Assets::execute()->js('libs/super/Range'); ?>

<?php echo Assets::execute()->js('libs/super/video-player'); ?>

</body>
</html>
<!-- <script>
    new Video({
        insert: "video1",
        src: "/src/video.mp4",
        company_name: "Codememory",
        title_video: ""
    }).render();
</script> -->
<?php /**PATH W:\domains\myDb.loc\resources\Views/FastDB/login.blade.php ENDPATH**/ ?>