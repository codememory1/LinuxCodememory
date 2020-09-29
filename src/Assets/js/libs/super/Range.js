function convertHex(hexCode,opacity){
    var hex = hexCode.replace('#','');

    if (hex.length === 3) {
        hex = hex[0] + hex[0] + hex[1] + hex[1] + hex[2] + hex[2];
    }

    var r = parseInt(hex.substring(0,2), 16),
        g = parseInt(hex.substring(2,4), 16),
        b = parseInt(hex.substring(4,6), 16);

    return 'rgba('+r+','+g+','+b+','+opacity+')';
}

function range()
{
    const range = document.querySelectorAll('[data-range]');

    const style = function style(element, style, value) {
        let styleString = '';

        for(let i = 0; i < style.length; i++)
        {
            styleString += style[i] + ':' + value[i] + ';';
        }

        return element + '{' + styleString + '}';
    }

    if(range.length > 0)
    {
        for(let i = 0; i < range.length; i++)
        {
            const statusRange = Boolean(range[i].attributes['data-range'].nodeValue);
            const max = (range[i].attributes.max) ? Number(range[i].attributes.max.nodeValue) : 100;
            const min = (range[i].attributes.min) ? Number(range[i].attributes.min.nodeValue) : 0;
            const steep = (range[i].attributes.steep) ? Number(range[i].attributes.steep.nodeValue) : 1;
            const name = (range[i].attributes.name) ? range[i].attributes.name.nodeValue : '';
            const width = (range[i].attributes.width) ? Number(range[i].attributes.width.nodeValue) : 120;
            const height = (range[i].attributes.height) ? Number(range[i].attributes.height.nodeValue) : 7;
            const bgRange = (range[i].attributes['range-bg']) ? range[i].attributes['range-bg'].nodeValue : '#c9c7c7';
            const bgTail = (range[i].attributes['range-bg']) ? range[i].attributes['range-tail-bg'].nodeValue : '#0c62e4';
            const value = (range[i].attributes.value) ? Number(range[i].attributes.value.nodeValue) : 0;

            const classContainerRange = Math.random().toString(36).substr(2, 10);
            const classTail = Math.random().toString(36).substr(2, 10);

            range[i].classList.add(classContainerRange);

            if(statusRange === true)
            {
                const blockStyle = document.createElement('style');
                const rangeInput = document.createElement('input');
                rangeInput.setAttribute('type', 'range')
                rangeInput.setAttribute('max', max)
                rangeInput.setAttribute('min', min)
                rangeInput.setAttribute('steep', steep)
                rangeInput.setAttribute('name', name);
                rangeInput.setAttribute('value', value);

                const tail = document.createElement('div');
                tail.classList.add(classTail);

                const styleThumbTail = style('.' + classContainerRange + ' input[type="range"]::-webkit-slider-thumb', ['-webkit-appearance', 'width', 'height', 'background-color', 'border-radius', 'cursor', 'opacity', 'transform', 'transition', 'z-index', 'position'], ['none', height + 7 + 'px', height + 7 + 'px', bgTail, '50%','pointer', 1, 'scale(0.8)', '.4s ease', 9, 'relative']);
                const styleThumbTailHover = style('.' + classContainerRange + ':hover input[type="range"]::-webkit-slider-thumb', ['opacity', 'transform', 'box-shadow'], [1, 'scale(1)', '0px 0px 2px 3px ' + convertHex(bgTail, .4)]);
                const styleInputRange = style('input:before', ['content', 'position', 'left', 'top', 'width', 'height', 'cursor'], ["''", 'absolute', 0, 0, '100%', height + 'px', 'pointer']);

                blockStyle.innerHTML += styleThumbTail;
                blockStyle.innerHTML += styleThumbTailHover;
                blockStyle.innerHTML += styleInputRange;

                document.body.appendChild(blockStyle);

                range[i].style.position = 'relative';
                range[i].style.width = width + 'px';
                range[i].style.height = height + 'px';

                rangeInput.style.webkitAppearance = 'none';
                rangeInput.style.width = 'inherit';
                rangeInput.style.height = 'inherit';
                rangeInput.style.backgroundColor = bgRange;
                rangeInput.style.borderRadius = 'inherit';
                rangeInput.style.outline = 'none';
                rangeInput.style.margin = '0';
                rangeInput.style.padding = '0';

                tail.style.position = 'absolute';
                tail.style.left = '0';
                tail.style.top = '0';
                tail.style.height = height + 'px';
                tail.style.backgroundColor = bgTail;
                tail.style.cursor = 'pointer';
                tail.style.borderRadius = 'inherit';
                tail.style.pointerEvents = 'none';

                range[i].append(rangeInput);
                range[i].append(tail);

                let valueDefault = (rangeInput.value / max * 100 == 0) ? 0.5 : rangeInput.value / max * 100;
                tail.style.width = valueDefault + '%';

                rangeInput.oninput = () => {
                    let valueWidth = (rangeInput.value / max * 100);
                    tail.style.width = (valueWidth == 0 ? 0.5 : valueWidth) + '%';
                }
            }
        }
    }

}

range();