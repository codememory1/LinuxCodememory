class Selector {
    static nameSelect;
    static name;
    static selected;
    static embed;
    static datas = {};
    
    /**
     * Настройки Select
     * 
     * @param  {} setting
     */
    static setting(setting) {
        if(typeof setting !== 'object') {
            throw new Error('Argument in class `Selector` and method setting, argument not object.');
        }

        if(!setting.nameSelect) {
            throw new Error('Select name is not specified.');
        }

        Selector.nameSelect = setting.nameSelect;
        Selector.name = setting.name ?? '';
        Selector.selected = setting.selected ?? 'first';
        Selector.embed = setting.embed ?? {selector: 'body', as: 'up'};
        
        return this;
    }
    
    /**
     * Даннные которые будут отображаться
     * 
     * @param  {} ...show
     */
    static valueShow(...show) {
        Selector.valuesShow = show;

        return this;
    }
    
    /**
     * Данные которые будут переденны в input value
     * 
     * @param  {} ...value
     */
    static value(...value) {
        Selector.values = value;

        return this;
    }

    /**
     * Рендер полноценых данных для Select
     */
    static _generateDataSelect() {
        const shows = Selector.valuesShow;
        const values = Selector.values;

        if(shows.length > 0) {
            for(let i = 0; i < shows.length; i++) {
                Selector.datas[i] = {show: shows[i], value: values[i] ?? ''}
            }
        }
    }

    /**
     * Рендер шаблона Select
     */
    static _generateView() {
        let container = document.createElement('div');
        container.classList.add('selector-container');
        container.setAttribute('select-name', Selector.nameSelect);

        let showContainer = document.createElement('div');
        showContainer.classList.add('selector-show');

        let selectedText = document.createElement('span');
        selectedText.classList.add('selector-text-selection');

        let iconArrowDown = document.createElement('span');
        iconArrowDown.classList.add('selector-arrow');
        iconArrowDown.classList.add('down');

        let iconArrowUp = document.createElement('span');
        iconArrowUp.classList.add('selector-arrow');
        iconArrowUp.classList.add('up');

        let input = document.createElement('input');
        input.setAttribute('type', 'hidden');
        input.setAttribute('name', Selector.name);

        let list = document.createElement('div');
        list.classList.add('selector-list');

        let ulList = document.createElement('ul');
        ulList.classList.add('selector-ul-list');

        selectedText.innerHTML = 'User';

        iconArrowUp.innerHTML = '<i class="fal fa-angle-up"></i>';
        iconArrowDown.innerHTML = '<i class="fal fa-angle-down"></i>';

        showContainer.append(selectedText);
        showContainer.append(iconArrowDown);
        showContainer.append(iconArrowUp);
        showContainer.append(input);

        list.append(ulList);

        switch(Selector.embed.as) {
            case 'up':
                document.querySelector(Selector.embed.selector).appendChild(container);
                break;
            case 'down':
                document.querySelector(Selector.embed.selector).append(container);
                break;
            default:
                document.querySelector(Selector.embed.selector).append(container);
                break;
        }
        
        const keysDatas = Object.keys(Selector.datas);

        if(keysDatas.length > 0) {
            for(let i = 0; i < keysDatas.length; i++) {
                let liSelect = document.createElement('li');
                liSelect.classList.add('selector-item');
                liSelect.setAttribute('select-value', Selector.datas[i].value);

                liSelect.innerHTML = Selector.datas[i].show;
                ulList.appendChild(liSelect);
            }
        }

        container.append(showContainer);
        container.append(list);
    }

    static _eventClick() {
        let selects = document.querySelectorAll('[select-name]');

        if(selects.length > 0) {
            for(let i = 0; i < selects.length; i++) {
                const name = selects[i].attributes['select-name'].nodeValue;
                const el = selects[i];
                const attrName = '[select-name=' + selects[i].attributes['select-name'].nodeValue + '] ';

                el.onclick = (e) => {
                    const showC = document.querySelector(attrName + 'div.selector-show');
                    const list = document.querySelector(attrName + 'div.selector-list');

                    if(!showC.classList.contains('active')) {
                        showC.classList.add('active');
                        list.classList.add('active');
                    } else {
                        showC.classList.remove('active');
                        list.classList.remove('active');
                    }
                };

                const li = document.querySelectorAll('[select-name=' + this.nameSelect + '] li');

                for(let j = 0; j < li.length; j++) {
                    li[j].onclick = () => {
                        const value = li[j].attributes['select-value'].nodeValue;
                        document.querySelector(attrName + 'li').classList.remove('active');
                        document.querySelector(attrName + 'span.selector-text-selection').innerHTML = value;
                        document.querySelector(attrName + 'input').value = value;
                        li[j].classList.add('active');
                    }
                }
            }
        }
    }
    

    /**
     * Открыть определеный селект
     * 
     * @param  {} nameSelect
     */
    static open(nameSelect) {
        Selector.openSelect = nameSelect;

        return this;
    }

    /**
     * Закрыть открытый селект, или определеный
     * 
     * @param  {} nameSelect=null
     */
    static close(nameSelect = null) {


        return this;
    }
    
    /**
     * Выбрать элемент у открытого селекта, или у определеного
     * 
     * @param  {} numEl
     * @param  {} nameSelect=null
     */
    static selected(numEl, nameSelect = null) {

        return this;
    }

    /**
     * Рендер самого Select
     * 
     * @param  {} status='included'
     */
    static render(status = 'included') {
        Selector._generateDataSelect();
        Selector._generateView();
        Selector._eventClick();
    }

}

Selector.setting({
    nameSelect: 'charset',
    name: 'charset',
    selected: 0,
    embed: {
        selector: 'body',
        as: 'up'
    }
})
.valueShow('Codememory', 'Category', 'User')
.value('codememory', 'category', 'user')
.render('disbaled');

Selector.setting({
    nameSelect: 'dbname',
    name: 'charset',
    selected: 0,
    embed: {
        selector: 'body',
        as: 'up'
    }
})
.valueShow('Codememory', 'Category', 'User')
.value('codememory', 'category', 'user')
.render('disbaled');