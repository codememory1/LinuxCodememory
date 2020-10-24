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
    
<!-- <div video-component="true" video-attr="video1" class="video-player">
    <div class="video-player__content">
        <div class="video-player__content-top">
            <span class="video-player__title">Название</span>
        </div>
        <div class="video-player__absolute-content">
            <div class="video-player__play-pause">
                <i class="fas fa-play"></i>
            </div>
        </div>
        <div class="video-player__footer">
            <div class="video-player__footer-absolute">
                <div class="video-player__footer-perk-1">
                    <div class="video-player__progress-video">
                        <div role="range" data-range="true" range-bg="#fff" range-tail-bg="#15b51a" height="4" class="video-player__range-current-time">
                            <div class="video-player__hover-progress-video"></div>
                        </div>
                    </div>
                </div>
                <div class="video-player__footer-perk-2">
                    <div>
                        <div class="video-player__play-pause-footer">
                            <i class="fas fa-play"></i>
                        </div>
                        <div class="video-player__volume-video">
                            <i class="fas fa-volume"></i>
                        </div>
                        <div class="video-player__progress-volume">
                        <div class="video-player__range-volume" role="range" data-range="true" range-bg="#fff" range-tail-bg="#15b51a" height="4" width="70"></div>
                        </div>
                    </div>
                    <div>
                        <div class="video-player__video-company">
                            <span></span>
                        </div>
                        <div class="video-player__video-settings">
                            <i class="fal fa-cog"></i>  
                        </div>
                        <div class="video-player__video-fullscreen">
                            <i class="far fa-compress-wide"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <video src="/src/video.mp4"></video>
    </div>
</div> -->
<div video-component="true" video-attr="video1"></div>
<div video-component="true" video-attr="video2" style="width:480px;height:360px;"></div>

<?php echo Assets::execute()->js('libs/super/video-player'); ?>

</body>
</html>
<script>
    new Video({
        insert: "video1",
        src: "/src/video.mp4",
        company_name: "Codememory",
        title_video: "Title",
        auto_play: false
    },
    {
        insert: "video2",
        src: "https://r10---sn-3c27sn7e.googlevideo.com/videoplayback?expire=1597362024&ei=CHs1X_TkD4Oa1gLRuL2wBA&ip=80.90.80.54&id=05225c499bd176fb&itag=248&aitags=133%2C134%2C135%2C136%2C137%2C160%2C242%2C243%2C244%2C247%2C248%2C278&source=youtube&requiressl=yes&vprv=1&mime=video%2Fwebm&gir=yes&clen=57104347&dur=282.880&lmt=1597338083053286&fvip=5&keepalive=yes&fexp=23883098&c=WEB&txp=6316222&sparams=expire%2Cei%2Cip%2Cid%2Caitags%2Csource%2Crequiressl%2Cvprv%2Cmime%2Cgir%2Cclen%2Cdur%2Clmt&sig=AOq0QJ8wRgIhAO-rgJnGwKDgkROpFFYiyqXU8KEuB_xR6d0coAjketOLAiEA7rz5wV2YH_SxbF7ITo6m3fIGUPZ3ln61C948pm_u0D0%3D&video_id=BSJcSZvRdvs&title=%D0%A3+%D0%91%D1%96%D0%BB%D0%BE%D1%80%D1%83%D1%81%D1%96+%D0%BD%D0%B0%D1%80%D0%BE%D1%81%D1%82%D0%B0%D1%94+%D1%85%D0%B2%D0%B8%D0%BB%D1%8F+%D0%BF%D1%80%D0%BE%D1%82%D0%B5%D1%81%D1%82%D1%96%D0%B2-+%D0%B2%D0%B4%D0%B5%D0%BD%D1%8C+%D0%BB%D1%8E%D0%B4%D0%B8+%D0%BC%D0%B8%D1%80%D0%BD%D0%BE+%D0%BC%D1%96%D1%82%D0%B8%D0%BD%D0%B3%D1%83%D1%8E%D1%82%D1%8C%2C+%D0%B0+%D0%B2%D0%BD%D0%BE%D1%87%D1%96+%D0%BF%D0%B5%D1%80%D0%B5%D0%BA%D1%80%D0%B8%D0%B2%D0%B0%D1%8E%D1%82%D1%8C+%D0%B4%D0%BE%D1%80%D0%BE%D0%B3%D0%B8&rm=sn-qpbpjvh5a-up5e7l,sn-nv4sr76&req_id=8e74d909e16ba3ee&redirect_counter=2&cms_redirect=yes&hcs=yes&ipbypass=yes&mh=UJ&mip=109.72.126.243&mm=29&mn=sn-3c27sn7e&ms=rdu&mt=1597341294&mv=m&mvi=10&nh=IgpwcjAxLmticDAxKgkxMjcuMC4wLjE&pl=20&shardbypass=yes&lsparams=hcs,ipbypass,mh,mip,mm,mn,ms,mv,mvi,nh,pl,shardbypass&lsig=AG3C_xAwRQIhANQmJC3D1NhtpJzEdbyPcuqBWCKWRUxlx94eQGCBL-jxAiBvCO_PIGyup3OMMJwH8q0oTosp3nCDPhBU-5VhSOt4jQ%3D%3D",
        company_name: "<a href=''>FASTDB</a>",
        title_video: ""
    }).render();
</script>
<?php echo Assets::execute()->js('libs/super/Range'); ?><?php /**PATH W:\domains\myDb.loc\resources\Views/video.blade.php ENDPATH**/ ?>