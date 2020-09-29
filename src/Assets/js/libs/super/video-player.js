class Video {
    _attrComponent = '[video-component]';
    _attrInsert = '[video-attr=%v]';
    _class_video = 'video-player';
    _arrayVideo = [];
    _allComponents = [];
    _views_icons = {
        play:       '<i class="fas fa-play"></i>',
        pause:      '<i class="fas fa-pause"></i>',
        settings:   '<i class="fal fa-cog"></i>',
        fullscreen: '<i class="far fa-compress-wide"></i>',

        volume_0:   '<i class="fas fa-volume-mute"></i>',
        volume_25:  '<i class="fas fa-volume-down"></i>',
        volume_50:  '<i class="fas fa-volume"></i>',
        volume_100: '<i class="fas fa-volume-up"></i>'
    };

    constructor(...video) {
        this._arrayVideo = video;
        this._allComponents = document.querySelectorAll(this._attrComponent);
    }

    _sprintf(search, replace, string) {
        let reaplcedString = string;

        if(typeof search == 'object') {
            for(let i = 0; i < search.length; i++) {
                reaplcedString = reaplcedString.replace(search[i], replace[i]);
            }
        }
        else {
            reaplcedString = reaplcedString.replace(search, replace);
        }

        return reaplcedString;
    }

    _existsAttrVideo(attr, key) {
        if(this._allComponents.length > 0) {
            if(typeof attr == 'object') {
                return attr.hasOwnProperty(key) === true ? attr[key] : undefined;
            }
            return undefined;
        }
    }

    _view() {
        let DataProto = {};
        let $this = this;

        let prefixClass = function(class_name) {
            return $this._class_video + '__' + class_name;
        };

        for(let i = 0; i < this._arrayVideo.length; i++) {
            const el = this._arrayVideo[i];
            const elV = this._allComponents[i];
            elV.classList.add(this._class_video);
            const attrBtn = 'video-btn-' + Math.random().toString(36).substr(2, 10);
            const attrVideoPlayer = 'video-player-' + Math.random().toString(36).substr(2, 10);

            const content = document.createElement('div');
            const contentTop = document.createElement('div');
            const titleVideo = document.createElement('span');
            const absContent = document.createElement('div');
            const playPauseCenter = document.createElement('div');
            const footer = document.createElement('div');
            const absFooter = document.createElement('div');
            const footerPerkOne = document.createElement('div');
            const footerTimer = document.createElement('div');
            const progressCurrentTime = document.createElement('div');
            const rangeProgressCurrentTime = document.createElement('div');
            const footerPerkTwo = document.createElement('div');
            const footerPerkTwo_div_one = document.createElement('div');
            const playPauseFooter = document.createElement('div');
            const volumeFooter = document.createElement('div');
            const progressVolumeFooter = document.createElement('div');
            const rangeProgressVolumeFooter = document.createElement('div');
            const containerFrameCanvas = document.createElement('div');
            const frameConvas = document.createElement('canvas');

            content.setAttribute('video-official-attr', i);
            contentTop.setAttribute('video-official-attr', i);
            titleVideo.setAttribute('video-official-attr', i);
            absContent.setAttribute('video-official-attr', i);
            playPauseCenter.setAttribute('video-official-attr', i);
            footer.setAttribute('video-official-attr', i);
            absFooter.setAttribute('video-official-attr', i);
            footerPerkOne.setAttribute('video-official-attr', i);
            progressCurrentTime.setAttribute('video-official-attr', i);
            rangeProgressCurrentTime.setAttribute('video-official-attr', i);
            footerPerkTwo.setAttribute('video-official-attr', i);
            footerPerkTwo_div_one.setAttribute('video-official-attr', i);
            playPauseFooter.setAttribute('video-official-attr', i);
            progressVolumeFooter.setAttribute('video-official-attr', i);
            rangeProgressVolumeFooter.setAttribute('video-official-attr', i);
            containerFrameCanvas.setAttribute('video-official-attr', i);

            const footerPerkTwo_div_two = document.createElement('div');
            const nameCompanyFooter = document.createElement('div');
            const settingsVideoFooter = document.createElement('div');
            const fullscreenFooter = document.createElement('div');
            
            const video = document.createElement('video');
            video.setAttribute(attrVideoPlayer, true)
    
            content.classList.add(prefixClass('content'));
            contentTop.classList.add(prefixClass('content-top'));
            titleVideo.classList.add(prefixClass('title'));
            absContent.classList.add(prefixClass('absolute-content'));
            playPauseCenter.classList.add(prefixClass('play-pause'));
            playPauseCenter.classList.add(prefixClass('play-pause-'));
            footer.classList.add(prefixClass('footer'));
            absFooter.classList.add(prefixClass('footer-absolute'));
            footerPerkOne.classList.add(prefixClass('footer-perk-1'));
            footerTimer.classList.add(prefixClass('footer-timer'));
            progressCurrentTime.classList.add(prefixClass('progress-video'));
            rangeProgressCurrentTime.classList.add(prefixClass('range-current-time'));
            footerPerkTwo.classList.add(prefixClass('footer-perk-2'));
            playPauseFooter.classList.add(prefixClass('video-player__play-pause-footer'));
            playPauseFooter.classList.add(prefixClass('play-pause-'));
            volumeFooter.classList.add(prefixClass('volume-video'));
            progressVolumeFooter.classList.add(prefixClass('progress-volume'));
            rangeProgressVolumeFooter.classList.add('range-volume');
            nameCompanyFooter.classList.add(prefixClass('video-company'));
            settingsVideoFooter.classList.add(prefixClass('video-settings'));
            fullscreenFooter.classList.add(prefixClass('video-fullscreen'));
            frameConvas.classList.add(prefixClass('frame-video'));
            containerFrameCanvas.classList.add(prefixClass('container-frame-video'));

            containerFrameCanvas.append(frameConvas);

            fullscreenFooter.setAttribute(attrBtn, true);
            settingsVideoFooter.setAttribute(attrBtn, true);
            settingsVideoFooter.setAttribute(attrBtn, true);
            playPauseFooter.setAttribute(attrBtn, true);
            playPauseCenter.setAttribute(attrBtn, true);
            rangeProgressVolumeFooter.setAttribute(attrBtn, true);
            rangeProgressCurrentTime.setAttribute(attrBtn, true);
            volumeFooter.setAttribute(attrBtn, true);
            footerTimer.setAttribute(attrBtn, true);

            video.setAttribute('muted', 'muted');
            video.setAttribute('src', el.src);
            rangeProgressCurrentTime.setAttribute('data-range', true);
            rangeProgressCurrentTime.setAttribute('range-bg', '#fff');
            rangeProgressCurrentTime.setAttribute('range-tail-bg', '#15b51a');
            rangeProgressCurrentTime.setAttribute('height', 4);
            rangeProgressVolumeFooter.setAttribute('data-range', true);
            rangeProgressVolumeFooter.setAttribute('range-bg', '#fff');
            rangeProgressVolumeFooter.setAttribute('range-tail-bg', '#15b51a');
            rangeProgressVolumeFooter.setAttribute('height', 4);
            rangeProgressVolumeFooter.setAttribute('width', 70);
            rangeProgressVolumeFooter.setAttribute('video-btn-' + attrBtn, true);
            
            titleVideo.innerHTML = this._existsAttrVideo(el, 'title_video') ?? '';
            contentTop.append(titleVideo);
            playPauseCenter.innerHTML = '<i class="fas fa-play"></i>';
            absContent.append(playPauseCenter);

            footerTimer.innerHTML = '<div class="current"><span>00:00</span></div><div class="duration"><span>00:00:00</span></div>';

            progressCurrentTime.append(rangeProgressCurrentTime);
            footerPerkOne.append(footerTimer);
            footerPerkOne.append(progressCurrentTime);
            absFooter.append(footerPerkOne);
            
            progressVolumeFooter.append(rangeProgressVolumeFooter);
            volumeFooter.innerHTML = '<i class="fas fa-volume"></i>';
            progressVolumeFooter.append(rangeProgressVolumeFooter);
            playPauseFooter.innerHTML = '<i class="fas fa-play"></i>';
            footerPerkTwo_div_one.append(playPauseFooter);
            footerPerkTwo_div_one.append(volumeFooter);
            footerPerkTwo_div_one.append(progressVolumeFooter);
            footerPerkTwo.append(footerPerkTwo_div_one);
            absFooter.append(footerPerkTwo);

            nameCompanyFooter.innerHTML = '<span>' + this._existsAttrVideo(el, 'company_name') ?? '' + '</span>';
            settingsVideoFooter.innerHTML = '<i class="fal fa-cog"></i>';
            fullscreenFooter.innerHTML = '<i class="far fa-compress-wide"></i>';
            footerPerkTwo_div_two.append(nameCompanyFooter);
            footerPerkTwo_div_two.append(settingsVideoFooter);
            footerPerkTwo_div_two.append(fullscreenFooter);
            footerPerkTwo.append(footerPerkTwo_div_two);
            
            footer.append(absFooter);
            content.append(absContent);
            content.append(contentTop);
            content.append(footer);
            content.append(video);
            content.append(containerFrameCanvas);
            
            document.querySelector(this._sprintf('%v', el.insert, this._attrInsert)).innerHTML = content.outerHTML;

            const eventsBtn = document.querySelectorAll('[' + attrBtn + '=true]');
            const videPlayerAll = document.querySelectorAll('[' + attrVideoPlayer + '=true]');

            DataProto[i] = {
                events: eventsBtn,
                video:  videPlayerAll[0],
                blocks: document.querySelectorAll('[video-official-attr="' + i + '"]'),
                e:      elV
            }
        }

        Object.__proto__ = DataProto;
    }

    _formatTime(seconds) {
        let time = Math.round(Number(seconds));

        let sec = Math.round(time % 60);
        let min = Math.round((time / 60) % 60);
        let hour = Math.round((time / 3600) % 60);

        sec = String(sec < 10 ? '0' + sec : sec);
        min = String(min < 10 ? '0' + min : min);
        hour = String(hour < 10 ? '0' + hour : hour);

        return {sec, min, hour}
    }

    _rangeInput(el, v) {
        let valueWidth = Number(v / el.children[0].attributes.max.nodeValue * 100);
        el.children[1].style.width = (valueWidth == 0 ? 0.5 : valueWidth) + '%';
        el.children[0].value = valueWidth;
    }

    _events() {
        this._view();

        const proto = Object.__proto__;

        for(let i = 0; i < Object.keys(proto).length; i++) {
            const playPauseVideo = function(video) {
                if(video.playing) return true;
                if(!video.playing) return false;
            }
            
            proto[i].events[5].oninput = (e) => {
                const volume = proto[i].events[5].children[0].value;

                if(volume < 1) {
                    proto[i].events[4].innerHTML = this._views_icons.volume_0;
                }

                if(volume > 0) {
                    proto[i].events[4].innerHTML = this._views_icons.volume_25;
                }

                if(volume > 0 && volume > 25) {
                    proto[i].events[4].innerHTML = this._views_icons.volume_50;
                }

                if(volume > 0 && volume > 50) {
                    proto[i].events[4].innerHTML = this._views_icons.volume_100;
                }

                proto[i].video.volume = volume / 100;
            }

            if(this._existsAttrVideo(this._arrayVideo[i], 'auto_play') !== undefined) {
                if(this._existsAttrVideo(this._arrayVideo[i], 'auto_play') === true) {
                    proto[i].video.play();
                }
            }

            const playPauseFunc = () => {
                if(proto[i].video.paused) {
                    proto[i].video.play();
                } else {
                    proto[i].video.pause();
                }
                proto[i].video.muted = false;
            }

            proto[i].events[0].onclick = () => {
                playPauseFunc();
            }

            proto[i].events[3].onclick = () => {
                playPauseFunc();
            }

            let moveVideo = false;
            proto[i].blocks[0].onmousemove = (e) => {
                moveVideo = true;
            }
            proto[i].blocks[0].onmouseover = () => {
                proto[i].blocks[5].classList.add('active');
                proto[i].blocks[3].classList.add('active');
            }
            proto[i].blocks[0].onmouseleave = () => {
                setTimeout(() => {
                    proto[i].blocks[5].classList.remove('active');
                    proto[i].blocks[3].classList.remove('active');
                }, 5000)
            }
  
            proto[i].video.ontimeupdate = () => {
                if(proto[i].video.paused === true) {
                    proto[i].blocks[2].innerHTML = this._views_icons.play;
                    proto[i].blocks[12].innerHTML = this._views_icons.play;
                } else {
                    proto[i].blocks[2].innerHTML = this._views_icons.pause;
                    proto[i].blocks[12].innerHTML = this._views_icons.pause;
                }

                const current = Math.round(proto[i].video.currentTime);
                const duration = Math.round(proto[i].video.duration);
                const timeProsent = current / duration * 100;

                const timeD = this._formatTime(current);
                let hour = timeD.hour != '00' ? timeD.hour + ':' : '';
                proto[i].events[1].children[0].innerHTML = (hour + timeD.min + ':' + timeD.sec);
                
                proto[i].events[2].children[1].style.width = timeProsent + '%';
                proto[i].events[2].children[0].value = timeProsent;            
            }
            
            proto[i].events[7].onclick = () => {
                if(!proto[i].blocks[0].webkitFullscreenElement) {
                    proto[i].blocks[0].webkitRequestFullscreen();
                }
                if(document.webkitFullscreenElement) {
                    document.webkitExitFullscreen();
                    
                }
            }

            proto[i].video.onloadedmetadata = (e) => {
                this._rangeInput(proto[i].events[5], proto[i].video.volume * 100);
                proto[i].video.onseeking = () => {
                    proto[i].blocks[Object.keys(proto[i].blocks).pop()].classList.add('active');
                    let frame = proto[i].blocks[Object.keys(proto[i].blocks).pop()].children[0];
                    const context = frame.getContext('2d');

                    context.fillStyle = "#000";
                    context.fillRect(0, 0, 300, 150);
                    context.drawImage(proto[i].video, 0, 0, 300, 150);
                }

                proto[i].video.onseeked = () => {
                    setTimeout(() => {
                        proto[i].blocks[Object.keys(proto[i].blocks).pop()].classList.remove('active');
                    }, 2000);
                }

                const timeD = this._formatTime(proto[i].video.duration);

                let hour = timeD.hour != '00' ? timeD.hour + ':' : '';

                proto[i].events[1].children[1].innerHTML = (hour + timeD.min + ':' + timeD.sec);
                proto[i].events[2].children[0].oninput = (e) => {
                    const v = proto[i].events[2].children[0].value;
                    const duration = Math.round(proto[i].video.duration);
    
                    proto[i].events[2].children[1].style.width = v + '%';
                    proto[i].video.currentTime = duration * v / 100;
                }

            }
        }

    }

    render() {
        this._view();
        
        this._events();
    }
}