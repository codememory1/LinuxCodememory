/**
 *
 * @type {{last_open: boolean}}
 */
const Settings = {
    "last_open": false
};

function randStr(num) {

    var result       = '';
    var words        = '0123456789qwertyuiopasdfghjklzxcvbnmQWERTYUIOPASDFGHJKLZXCVBNM';
    var max_position = words.length - 1;
        for( i = 0; i < num; ++i ) {
            position = Math.floor ( Math.random() * max_position );
            result = result + words.substring(position, position + 1);
        }
    return result;

}

/**
 *
 * @type {*[]}
 */
const SelectorOptions = [];

/**
 *
 * @type {*[]}
 */
SelectorOptions['options'] = [];
SelectorOptions['fields'] = [];

/**
 *
 * @param options
 * @param fields
 * @constructor
 */
const Selector = function(options, fields) {

    SelectorOptions['options'] = options;
    SelectorOptions['fields'] = fields;

    /**
     *
     * @type {*}
     */
    const Options = SelectorOptions['options'];
    const Fields = SelectorOptions['fields'];

    Options.forEach(function(valueOption, keyOption) {

        /**
         *
         * @type {number}
         */
        let fieldLenght = (Object.keys(Fields[keyOption]).length == 0) ? 0 : Object.keys(Fields[keyOption]).length - 1;

        /**
         *
         * @type {string}
         */
        let value = '';
        let value_show;
        let val;
        var keyOpen = randStr(15);
        
        for(let f = 0; f <= fieldLenght; f++) {

            let selected = (valueOption.selected) ? valueOption.selected : 0;

            if(f == selected)
               value += '<li number=' + f + ' index=' + keyOpen + ' class="selected" val="' + Fields[keyOption][f].value + '">' + Fields[keyOption][f].value_show + '</li>';
            else 
                value += '<li number=' + f + ' index=' + keyOpen + ' val="' + Fields[keyOption][f].value + '">' + Fields[keyOption][f].value_show + '</li>';
            
            if(Fields[keyOption][selected])
                selected = selected;
            else selected = 0;

            /**
             *
             * @type {string}
             */
            value_show = Fields[keyOption][selected].value_show;
            val = Fields[keyOption][selected].value;
        }
        
        /**
         *
         * @type {HTMLDivElement}
         */
        let selection_container = document.createElement('div');
        $(selection_container).addClass('container__selector');
		
		if(valueOption.width) {
			selection_container.style.width = valueOption.width;	
		}

        /**
         *
         * @type {HTMLDivElement}
         */
        let visibil__show = document.createElement('div');
        $(visibil__show).addClass('content-visibil__show');
        visibil__show.setAttribute('index-selector', keyOpen);
        
        $(selection_container).prepend(visibil__show);

        /**
         *
         * @type {HTMLSpanElement}
         */
        let show_selector = document.createElement('span');
        $(show_selector).addClass('show-selector');
        show_selector.innerHTML = value_show;

        /**
         *
         * @type {HTMLInputElement}
         */
        let inputValue = document.createElement('input');

        inputValue.setAttribute('type', 'hidden');
        inputValue.setAttribute('name', (valueOption.name) ? valueOption.name : '');
        inputValue.setAttribute('value', val);

        $(visibil__show).prepend(show_selector);
        $(visibil__show).append('<span><i class="fas fa-chevron-down"></i></span>');
        $(visibil__show).append(inputValue);

        /**
         *
         * @type {HTMLDivElement}
         */
        let list__selector = document.createElement('div');
        $(list__selector).addClass('list__selector');
        list__selector.setAttribute('index-selector-list', keyOpen);

        /**
         * 
         * @type {HTMLDivElement}
         */
        let content_list__selector = document.createElement('div');
        $(content_list__selector).addClass('content-list__selector');
        
        let listUl = document.createElement('ul');
        
        $(listUl).append(value);
        
        $(content_list__selector).prepend(listUl);
        
        $(list__selector).prepend(content_list__selector);
        
        $(selection_container).append(list__selector);
        
        var whereDoc = document.querySelector(valueOption.where);
        
        valueOption.add_as = (valueOption.add_as) ? valueOption.add_as : "down";
        
        if(valueOption.add_as == "up") {
            $(whereDoc).prepend(selection_container);
        }
        if(valueOption.add_as == "down") {
            $(whereDoc).append(selection_container);
        }
        
		visibil__show.addEventListener('click', (e) => {
			
			const index = e.target.attributes['index-selector'].nodeValue;

			const showClass = e.target.classList[1];
			
			if(showClass == 'active') {
				$('[index-selector="' + index + '"]').removeClass('active');
				$('[index-selector-list="' + index + '"]').removeClass('active');
			}
			else {
				if(Settings.last_open === false) {
					$('.content-visibil__show').removeClass('active');
					$('.list__selector').removeClass('active');
				}

				$('[index-selector="' + index + '"]').addClass('active');
				$('[index-selector-list="' + index + '"]').addClass('active');
			}
		});
    
		$('.container__selector li').on('click', function(e) {

			e || window.Event;

			const index = $(this).attr('index');
			const number = $(this).attr('number');

			const numField = $(this)[0].innerHTML;
			const val = $(this).attr('val');

			$('[index-selector-list="' + index + '"] li').removeClass('selected');
			$('[index-selector="' + index + '"] input').val(val);
			$('[index-selector="' + index + '"] span.show-selector').html(numField);

			$(this).addClass('selected');

			$('[index-selector="' + index + '"]').removeClass('active');
			$('[index-selector-list="' + index + '"]').removeClass('active');

		});
		
    });
    
}  

$(document).click(function(e){ 
    
    var selector = $('.container__selector'); 
    
    if (selector.has(e.target).length === 0) { 
        $('.list__selector').removeClass('active');
        $('.content-visibil__show').removeClass('active');
    }
    
});

