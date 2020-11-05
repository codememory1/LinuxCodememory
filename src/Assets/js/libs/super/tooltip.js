
function aliasAppend(insertEl, appendingText) {

    const randString = (num) => {
        var text = '';
        var possible = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';

        for (var i = 0; i < num; i++) {
            text += possible.charAt(Math.floor(Math.random() * possible.length));
        }

        return text;
    }

    const uniqueAttribute = randString(36);
    
    if (typeof appendingText === 'object') {
        appendingText.setAttribute('unique-class', uniqueAttribute);

        document.querySelector(insertEl).innerHTML += appendingText.outerHTML;
        let elementLink = document.querySelectorAll('[unique-class="' + uniqueAttribute + '"]')[0];

        return elementLink;

    } else if (typeof appendingText === 'string') {
        let NewappendingText = appendingText.replace(/(\<[a-z]+)(\>)/gm, '$1 unique-class="' + uniqueAttribute + '"$2');
        document.querySelector(insertEl).innerHTML += NewappendingText;
        let elementLink = document.querySelectorAll('[unique-class="' + uniqueAttribute + '"]')[0];

        return elementLink;

    } else return null;

}


const allTooltip = document.querySelectorAll('[tooltip-message]');
const positionsTooltip = document.querySelectorAll('[tooltip-position]');
const allPositions = [
    'top', 'bottom', 'left', 'right', 'auto'
];
const mirrorPositions = {
    top: 'bottom',
    bottom: 'top',
    left: 'right',
    right: 'left'
};

let arrayTooltip = [];

const tooltip = function(message, position) {
    let container = document.createElement('div');
    container.classList.add('cdm-tooltip__container');
    container.classList.add(position);

    let content = document.createElement('div');
    content.classList.add('cdm-tooltip__content');

    let viewContent = document.createElement('span');

    viewContent.innerHTML = message;
    content.append(viewContent);
    container.append(content);

    return aliasAppend('.t', container);
};

if (allTooltip.length > 0) {
    for (let i = 0; i < allTooltip.length; i++) {
        arrayTooltip.push({
            tooltip: allTooltip[i].getAttribute('tooltip-message'),
            position: positionsTooltip[i].getAttribute('tooltip-position'),
        });
    }

    allTooltip.forEach((el, k, o) => {

        el.onmouseover = (e) => {
 
            if(e.path[0].getAttribute('tooltip-message')) {
                const addTooltip = tooltip(arrayTooltip[k].tooltip, arrayTooltip[k].position);
                const rectTooltip = addTooltip.getBoundingClientRect();

                let tWidth = rectTooltip.width;
                let tHeight = rectTooltip.height;

                const rectEl = el.getBoundingClientRect();

                let width = rectEl.width;
                let height = rectEl.height;
                let y = rectEl.y;
                let x = rectEl.x;

                const screenWidth = window.screen.width;
                const screenHeight = window.screen.height;
                let funcHandler = arrayTooltip[k].position;
                
                if(arrayTooltip[k].position === 'top') {
                    console.log(y + height + tHeight, window.innerHeight);
                    if((y - tHeight) <= 0) {
                        funcHandler = 'bottom';
                        arrayTooltip[k].position = 'top';
                    }
                } else if(arrayTooltip[k].position === 'bottom') {
                    
                    if((y + height + tHeight) >= screenHeight || ((y + height + tHeight) >= window.innerHeight)) {
                        funcHandler = 'top';
                        arrayTooltip[k].position = 'bottom';
                    } 
                } else if(arrayTooltip[k].position === 'right') {
                    if(x + tWidth >= screenWidth) {
                        funcHandler = 'left';
                        arrayTooltip[k].position = 'right';
                    }
                } else if(arrayTooltip[k].position === 'left') {
                    if(x - tWidth <= 0) {
                        funcHandler = 'right';
                        arrayTooltip[k].position = 'left';
                    }
                }

                const handler = {
                    top:    () => {
                        if((y - tHeight) <= 0) {
                            addTooltip.classList.remove('top');
                            addTooltip.classList.add('bottom');
                        }

                        return {
                            x: (x + (width / 2)) - (tWidth / 2) - (rectTooltip.x),
                            y: (el.offsetTop - (height / 2)) - (tHeight / 2)
                        };
                    },
                    bottom: () => {

                        if((y + height + tHeight) >= screenHeight || ((y + height + tHeight) >= window.innerHeight)) {
                            addTooltip.classList.remove('bottom');
                            addTooltip.classList.add('top');
                        }

                        return {
                            x: (x + (width / 2)) - (tWidth / 2) - (rectTooltip.x),
                            y: el.offsetTop + height + 13
                        };

                        
                    },
                    right:  () => {
                        if(x + tWidth >= screenWidth) {
                            addTooltip.classList.remove('right');
                            addTooltip.classList.add('left');
                        }

                        return {
                            x: el.offsetLeft + width + 3 + 13,
                            y: (el.offsetTop + (height / 4)),
                        };
                    },
                    left:   () => {
                        if(x - tWidth <= 0) {
                            addTooltip.classList.remove('left');
                            addTooltip.classList.add('right');
                        }

                        return {
                            x: el.offsetLeft - width - 23,
                            y: (el.offsetTop + (height / 4)),
                        };
                    }
                };

                let positionsHandler = handler[arrayTooltip[k].position]();

                addTooltip.style.left = positionsHandler.x + 'px';
                addTooltip.style.top = positionsHandler.y + 'px';

                positionsHandler = handler[funcHandler]();
                
                addTooltip.style.left = positionsHandler.x + 'px';
                addTooltip.style.top = positionsHandler.y + 'px';

                setTimeout(() => {
                    addTooltip.classList.add('active');
                });

            }
        };

        el.onmouseleave = (e) => {
            document.querySelector('.cdm-tooltip__container').remove();
        };
    });
}