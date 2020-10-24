class ContextMenu {

    constructor() {
        this.menu = [];
    }

    _viewMenu() {
        let container = document.createElement('div');
        container.classList.add('context-menu');
        let content = document.createElement('div');
        content.classList.add('context-menu-content');
        let ul = document.createElement('ul');

        for(let i = 0; i < Object.keys(this.menu).length; i++) {
            if(this.menu[i].el) {
                let elCreate = document.createElement(this.menu[i].el);
                elCreate.style.margin = '0';
                elCreate.classList.add(this.menu[i].class);

                ul.innerHTML += elCreate.outerHTML;
            } else {
                let li = document.createElement('li');
                li.setAttribute('cotext-menu-name', this.menu[i].name);
                li.innerHTML = this.menu[i].value;
                ul.innerHTML += li.outerHTML;    
            }
        }

        content.innerHTML = ul.outerHTML;
        container.innerHTML = content.outerHTML;

        document.body.append(container);
        

        document.onclick = (e) => {
            let containerMenu = document.querySelector('.context-menu');

            const target = e.target;
            const its_menu = target == containerMenu || containerMenu.contains(target);
            const menu_is_active = containerMenu.classList.contains('open');

            if (!its_menu) {
                contextMenu.close();
            }
        };

        window.oncontextmenu = (e) => {
            return contextMenu.open(e);
        };
    }

    add(name, value) {

        this.menu.push({
            name: name,
            value: value
        });

        return this;
    }

    addGroup(menu) {

        for(let i = 0; i < Object.keys(menu).length; i++) {
            this.menu.push(menu[i]);
        }

        this.menu.push({
            el: 'div',
            class: 'hr-light'
        });

        return this;
    }

    render(click = null) {
        this._viewMenu();
        
    }

}

const contextMenu = {
    event: function(name, callback) {
        let fullname = 'cotext-menu-name="' + name + '"';
        let ob = document.querySelector('[' + fullname + ']');

        callback(ob, contextMenu);
    },

    close: function() {
        window.onscroll = () => {
            document.querySelector('.context-menu').classList.remove('active');
        };

        document.querySelector('.context-menu').classList.remove('active');
    },

    open: function(e) {
        let containerMenu = document.querySelector('.context-menu');

        containerMenu.classList.add('active');

        let rect = containerMenu.getBoundingClientRect();
        let widthMenu = rect.width;
        let widthWindow = window.screen.width;
        let xClick = e.clientX;

        let heightMenu = rect.height;
        let heightWindow = window.screen.height;
        let YClick = e.clientY;

        if(xClick + widthMenu > widthWindow) {
            containerMenu.style.left = widthWindow - widthMenu + 'px';
        } else {
            containerMenu.style.left = e.clientX + 'px';
        }

        if(YClick + heightMenu > heightWindow) {
            containerMenu.style.top = heightWindow - heightMenu * 1.75 + 'px';
        } else {
            containerMenu.style.top = e.clientY + 'px';
        }

        return false;
    }
};