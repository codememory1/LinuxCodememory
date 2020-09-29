document.querySelector('body').setAttribute('trasition', 'none');

const errors = {
    modal_argument_constructor: 'The argument in the constructor of the Modal class must be object.',
    modal_argument_content: 'The argument in the content of the Modal class must be object.',
    access_forbiden: 'Доступ Запрещен!',
    number_create_columns: 'Укажите кол-во создаваемых колонок!',
    name_column: 'Имя столбца',
    type_column: 'Тип',
    length_column: 'Длина',
    default_column: 'По умолчанию',
    his_default_column: 'Свое по умолчанию',
    charset_column: 'Кодировка',
    fetch_request_error: 'Произойшла ошибка. Повторите попытку снова!'
};

class Modal {
    _id = {};
    _auto_open = {};
    _auto_open_time = {};
    _hide_prev = {};
    _insert = {};
    _title = {};

    constructor(array = false, ...modals) {
        if (typeof modals !== 'object') {
            throw new Error(errors.modal_argument_constructor);
        }

        this.arrayModal = array;

        if (array === true) {
            this.modals = modals[0];
        } else {
            this.modals = modals;
        }
    }

    _defaultArguments() {

        if (this.modals.length > 0) {
            for (let i = 0; i < this.modals.length; i++) {
                const m = this.modals[i];

                this._id[i] = m.id ?? '';
                this._auto_open[i] = Boolean(m.auto_open) ?? false;
                this._auto_open_time[i] = m.auto_open_time ?? false;
                this._hide_prev[i] = Boolean(m.hide_prev) ?? true;
                this._insert[i] = m.insert ?? 'body';
                this._title[i] = m.title ?? '';
            }
        }
    }

    _createElementsModal(titleModal = 'No Title', id = null, insert, userContent = '', key) {
        let container = document.createElement('div');
        container.classList.add('modal-container');
        container.setAttribute('modal-id-open', id);

        let fon = document.createElement('div');
        fon.classList.add('modal-full-fon');
        fon.setAttribute('modal-close', id);

        let contentModalRest = document.createElement('div');
        contentModalRest.classList.add('modal-content-restrictions');
        contentModalRest.style.height = this.modals[key].height ?? '200px';

        let content = document.createElement('div');
        content.classList.add('modal-content');

        let title = document.createElement('div');
        title.classList.add('modal-title');

        let titleH = document.createElement('h5');
        titleH.innerHTML = titleModal;

        let close = document.createElement('span');
        close.classList.add('modal-close');
        close.innerHTML = '<i class="fal fa-times"></i>';
        close.setAttribute('modal-close', id);

        titleH.innerHTML += close.outerHTML;
        title.innerHTML = titleH.outerHTML;
        content.innerHTML = title.outerHTML;
        content.innerHTML += userContent;
        contentModalRest.innerHTML = content.outerHTML;
        container.innerHTML = contentModalRest.outerHTML;
        container.innerHTML += fon.outerHTML;

        document.querySelector(insert).innerHTML += container.outerHTML;
    }

    _eventRenderWindow() {
        let modals = {};

        for (let i = 0; i < this.modals.length; i++) {
            this._createElementsModal(this._title[i], this._id[i], this._insert[i], this.content[i].content, i);

            modals[this._id[i]] = {
                id: this._id[i],
                auto_open: this._auto_open[i],
                auto_open_time: this._auto_open_time[i],
                hide_prev: this._hide_prev[i],
                insert: this._insert[i],
                title: this._title[i]
            };
        }

        const buttonsOpen = document.querySelectorAll('[button-open-modal]');
        const keys = Object.keys(modals);

        for (let j = 0; j < Object.keys(modals).length; j++) {

            let closes = document.querySelectorAll('[modal-close]');

            for (let t = 0; t < closes.length; t++) {
                const attrClose = closes[t].attributes['modal-close'].nodeValue;

                closes[t].onclick = () => {
                    document.querySelector('[modal-id-open=' + attrClose + ']').classList.remove('active');
                }
            }

            if (modals[keys[j]].auto_open === true) {
                if (modals[keys[j]].hide_prev === true) {
                    document.querySelector('[modal-id-open]').classList.remove('active');
                }

                document.querySelector('[modal-id-open=' + keys[j] + ']').classList.add('active');
            }

            if (modals[keys[j]].auto_open_time !== false && typeof modals[keys[j]].auto_open_time === 'number') {
                if (modals[keys[j]].hide_prev === true) {
                    document.querySelector('[modal-id-open]').classList.remove('active');
                }

                setTimeout(() => {
                    document.querySelector('[modal-id-open=' + keys[j] + ']').classList.add('active');
                }, modals[keys[j]].auto_open_time * 1000);
            }
        }

        for (let k = 0; k < buttonsOpen.length; k++) {
            buttonsOpen[k].addEventListener('click', () => {
                const keyOpen = buttonsOpen[k].attributes['button-open-modal'].nodeValue;

                if (keyOpen.hide_prev === true) {
                    document.querySelector('[modal-id-open]').classList.remove('active');
                }

                document.querySelector('[modal-id-open=' + keyOpen + ']').classList.add('active');
            });
        }
    }

    content(...contents) {
        if (typeof contents !== 'object') {
            throw new Error(errors.modal_argument_content);
        }

        if (this.arrayModal === true) {
            this.content = contents[0];
        } else {
            this.content = contents;
        }

        return this;

    }

    render() {
        this._defaultArguments();
        this._eventRenderWindow();
    }
}

function deleteColumn(id) {
    let el = document.querySelector('[data-id-column="' + id + '"]');
    el.style.transform = 'scale(0)';

    setTimeout(() => {
        el.remove();
    }, 200);
}

window.onload = (loaded) => {
    const selectors = {
        body: document.querySelector('body'),
        btn_loader: document.querySelectorAll('[btn-loader]'),
        show_all_tables: document.querySelectorAll('.db-container-click'),
        checkbox: document.querySelectorAll('input[type="checkbox"]'),
        select_all_checkbox: document.querySelectorAll('[select-checkbox]'),
        forbidden: document.querySelectorAll('[data-forbidden]'),
        add_column: document.querySelector('.btn-add-column'),
        value_add_column: document.querySelector('.num-add-column'),
        form_create_table_section: document.querySelectorAll('#create-table-form section'),
        form_create_table: document.querySelector('.sections-form-create-table'),
        deleteColumnForm: document.querySelectorAll('.full-width .close-column'),
        draggable_column_form: document.querySelectorAll('.sections-form-create-table section'),
        request_form: document.querySelectorAll('[data-fetch]'),
        dinamic_btn: document.querySelectorAll('[dinamic-btn]'),
        dinamic_pages: document.querySelectorAll('[name-dinamic-page]'),
        show_data_history_sender: document.querySelectorAll('.show_data_sender'),
        history_close: document.querySelectorAll('.delete-history'),
        timer: document.querySelectorAll('[timer]')
    };

    selectors.body.classList.length === 0 ? selectors.body.classList.add(config.theme) : false;
    setTimeout(() => {
        selectors.body.removeAttribute('trasition');
    }, 500);

    if (selectors.btn_loader.length > 0) {
        for (let i = 0; i < selectors.btn_loader.length; i++) {
            const loader = selectors.btn_loader[i].attributes['btn-loader'].nodeValue;
            const defaultLoader = config.btn_loader;
            const defaultContent = selectors.btn_loader[i].textContent;

            selectors.btn_loader[i].addEventListener('click', (e) => {
                selectors.btn_loader[i].innerHTML = loader == 'default' ? defaultLoader : loader;
            });
        }
    }
    if (selectors.show_all_tables.length > 0) {
        for (let i = 0; i < selectors.show_all_tables.length; i++) {
            selectors.show_all_tables[i].addEventListener('click', () => {
                if (selectors.show_all_tables[i].classList.contains('active')) {
                    selectors.show_all_tables[i].classList.remove('active');
                } else {
                    selectors.show_all_tables[i].classList.add('active');
                }
            });
        }
    }
    if (selectors.checkbox.length > 0) {
        for (let i = 0; i < selectors.checkbox.length; i++) {
            if (selectors.checkbox[i].attributes['empty-checkbox'] && Boolean(selectors.checkbox[i].attributes['empty-checkbox'].nodeValue) === true) {
                const attr = selectors.checkbox[i].attributes;
                let checkbox = document.createElement('input');
                selectors.checkbox[i].removeAttribute('empty-checkbox');

                checkbox.setAttribute('type', 'hidden');
                checkbox.setAttribute('name', attr.name.nodeValue ?? '');
                checkbox.setAttribute('value', 'off');

                selectors.checkbox[i].parentElement.prepend(checkbox);
            }
        }
    }

    if (selectors.forbidden.length > 0) {
        for (let i = 0; i < selectors.forbidden.length; i++) {
            let forbidden = selectors.forbidden[i];
            forbidden.style.position = 'relative';

            let tooltip = document.createElement('span');
            tooltip.classList.add('forbidden');
            tooltip.innerHTML = errors.access_forbiden;

            forbidden.appendChild(tooltip);
        }
    }

    if (selectors.add_column !== null) {
        selectors.add_column.onclick = () => {
            let much = selectors.value_add_column;

            if (much.value == '' || typeof Number(much.value) !== 'number' || Number(much.value) < 1) {
                alert(errors.number_create_columns);
            } else {
                let num = Number(much.value);

                document.querySelector('.loader-add-column-block').innerHTML = '<i class="loader-add-column-in-form far fa-spinner-third fa-spin" style="width: max-content"></i>';

                setTimeout(() => {
                    for (let i = 0; i < num; i++) {
                        let id = Math.round(Math.random() * (9999 + 0) - 0);
                        let section = document.createElement('section');
                        section.classList.add('full-width');
                        section.setAttribute('data-id-column', id);
                        section.setAttribute('draggable', true);

                        let divName = document.createElement('div');
                        let labelName = document.createElement('label');
                        labelName.setAttribute('for', '');
                        let nameColumn = document.createElement('input');
                        nameColumn.setAttribute('type', 'text');
                        nameColumn.setAttribute('name', 'name-column[' + (document.querySelectorAll('#create-table-form section').length) + ']');
                        nameColumn.setAttribute('placeholder', errors.name_column);

                        let divType = document.createElement('div');
                        let labelType = document.createElement('label');
                        labelType.setAttribute('for', '');
                        let typeColumn = document.createElement('select');
                        typeColumn.setAttribute('name', 'type[' + (document.querySelectorAll('#create-table-form section').length) + ']');

                        let divLength = document.createElement('div');
                        let labelLength = document.createElement('label');
                        labelLength.setAttribute('for', '');
                        let LengthColumn = document.createElement('input');
                        LengthColumn.setAttribute('type', 'text');
                        LengthColumn.setAttribute('name', 'length[' + (document.querySelectorAll('#create-table-form section').length) + ']');
                        LengthColumn.setAttribute('placeholder', errors.length_column);

                        let divDefault = document.createElement('div');
                        let labelDefault = document.createElement('label');
                        labelDefault.setAttribute('for', '');
                        let defaultColumn = document.createElement('select');
                        defaultColumn.setAttribute('name', 'default[' + (document.querySelectorAll('#create-table-form section').length) + ']');
                        let defaultHisInput = document.createElement('input');
                        defaultHisInput.setAttribute('type', 'text');
                        defaultHisInput.setAttribute('name', 'other-default[' + (document.querySelectorAll('#create-table-form section').length) + ']');
                        defaultHisInput.setAttribute('placeholder', errors.his_default_column);

                        let divCharset = document.createElement('div');
                        let labelCharset = document.createElement('label');
                        labelType.setAttribute('for', '');
                        let charsetColumn = document.createElement('select');
                        charsetColumn.setAttribute('name', 'charset[' + (document.querySelectorAll('#create-table-form section').length) + ']');

                        let deleteColumn = document.createElement('span');
                        deleteColumn.classList.add('close-column');
                        deleteColumn.setAttribute('onclick', 'deleteColumn(' + id + ')');
                        deleteColumn.innerHTML = '<i class="fal fa-times"></i>';

                        for (let t = 0; t < Object.keys(types).length; t++) {
                            let optionTypes = document.createElement('option');
                            optionTypes.setAttribute('value', Object.keys(types)[t]);
                            optionTypes.innerHTML = types[Object.keys(types)[t]];
                            typeColumn.innerHTML += optionTypes.outerHTML;
                        }

                        for (let d = 0; d < Object.keys(defaults).length; d++) {
                            let optionDefaults = document.createElement('option');
                            optionDefaults.setAttribute('value', Object.keys(defaults)[d]);
                            optionDefaults.innerHTML = defaults[Object.keys(defaults)[d]];
                            defaultColumn.innerHTML += optionDefaults.outerHTML;
                        }

                        for (let c = 0; c < Object.keys(charsets).length; c++) {
                            let optionCharsets = document.createElement('option');
                            optionCharsets.setAttribute('value', Object.keys(charsets)[c]);
                            optionCharsets.innerHTML = charsets[Object.keys(charsets)[c]];
                            charsetColumn.innerHTML += optionCharsets.outerHTML;
                        }

                        labelName.innerHTML = errors.name_column;
                        divName.innerHTML += labelName.outerHTML;
                        divName.innerHTML += nameColumn.outerHTML;
                        section.innerHTML = divName.outerHTML;

                        labelType.innerHTML = errors.type_column;
                        divType.innerHTML += labelType.outerHTML;
                        divType.innerHTML += typeColumn.outerHTML;
                        section.innerHTML += divType.outerHTML;

                        labelLength.innerHTML = errors.length_column;
                        divLength.innerHTML += labelLength.outerHTML;
                        divLength.innerHTML += LengthColumn.outerHTML;
                        section.innerHTML += divLength.outerHTML;

                        labelDefault.innerHTML = errors.default_column;
                        divDefault.innerHTML += labelDefault.outerHTML;
                        divDefault.innerHTML += defaultColumn.outerHTML;
                        divDefault.innerHTML += defaultHisInput.outerHTML;
                        section.innerHTML += divDefault.outerHTML;

                        labelCharset.innerHTML = errors.charset_column;
                        divCharset.innerHTML += labelCharset.outerHTML;
                        divCharset.innerHTML += charsetColumn.outerHTML;
                        section.innerHTML += divCharset.outerHTML;

                        section.innerHTML += deleteColumn.outerHTML;

                        if (i + 1 == num) {
                            document.querySelector('.loader-add-column-in-form').remove();
                        }

                        selectors.form_create_table.append(section);
                    }
                }, 100);
            }
        }
    }

    if (selectors.draggable_column_form.length > 0) {
        let column;
        selectors.draggable_column_form.forEach((el, key, ob) => {
            el.addEventListener('dragstart', (e) => {
                column = e.target;
                setTimeout(() => {
                    el.classList.add('drag-column');
                }, 0);
            });
            el.addEventListener('dragend', () => {
                setTimeout(() => {
                    el.classList.remove('drag-column');
                }, 0);
            });
            el.addEventListener('dragenter', (e) => {
                el.classList.add('drag-border');
            });
            el.addEventListener('dragleave', (e) => {
                el.classList.remove('drag-border');
            });
            el.addEventListener('dragover', (e) => {
                e.preventDefault();
            });
            el.addEventListener('drop', (e) => {
                e.preventDefault();

                const selected = column.getAttribute('data-id-column');
                const select = el.getAttribute('data-id-column');

                if (selected != select) {
                    el.innerHTML = column.outerHTML;
                    column.innerHTML = el.outerHTML;
                }
            });
        });
    }

    const notification = function(status, message) {
        let container = document.createElement('div');
        container.classList.add('notification-container');
        container.classList.add(status);
        let content = document.createElement('div');
        content.classList.add('content-notification');
        content.classList.add('active');
        let containerSpan = document.createElement('span');
        let iconSpan = document.createElement('span');
        iconSpan.classList.add('notification-icon');
        let messageSpan = document.createElement('span');
        messageSpan.classList.add('not-mess');
        messageSpan.innerHTML = message;

        containerSpan.innerHTML += iconSpan.outerHTML;
        containerSpan.innerHTML += messageSpan.outerHTML;
        content.innerHTML += containerSpan.outerHTML;
        container.innerHTML += content.outerHTML;

        document.querySelector('.content-all-notifications').prepend(container);

        let notifications = document.querySelectorAll('.content-all-notifications div > div');

        for (let i = 0; i < notifications.length; i++) {
            setTimeout(() => {
                notifications[i].classList.add('hide');
                setTimeout(() => {
                    notifications[i].remove();
                }, 700)
            }, config.notifications_time)
        }

    }

    selectors.request_form.forEach((el, k, o) => {
        el.addEventListener('submit', (e) => {
            e.preventDefault();
            let text = e.submitter.textContent;
            e.submitter.innerHTML = '<i class="far fa-spinner-third fa-spin"></i>';
            e.submitter.setAttribute('disabled', '');

            let url = el.getAttribute('action');
            let method = el.getAttribute('method');
            let data = new FormData(el);

            fetch(url, {
                    method: method,
                    body: data
                })
                .then(response => {
                    e.submitter.innerHTML = text;
                    e.submitter.removeAttribute('disabled', '');

                    if (response.ok === false) {
                        notification('warning', errors.fetch_request_error);
                    }

                    response.text().then(data => {

                        const jsonData = JSON.parse(data);

                        notification(jsonData.status, jsonData.message);
                        if (jsonData.redirect && (jsonData.redirect !== null)) {
                            location.href = jsonData.redirect;
                        }

                        console.log(data);
                    })
                })
                .catch(error => {
                    notification('warning', error);
                })
        });
    });

    const changeFetch = function(url, method, data) {
        let dataFetch;
        if (method === 'GET') {
            dataFetch = {
                method: method
            };
        } else {
            dataFetch = {
                method: method,
                body: JSON.stringify(data)
            };
        }

        fetch(url, dataFetch).then(response => {

            if (response.ok === false) {
                notification('warning', errors.fetch_request_error);
            }

            response.text().then(data => {
                console.log(data);
                const jsonData = JSON.parse(data);
                notification(jsonData.status, jsonData.message);

                if (jsonData.redirect) {
                    location.href = jsonData.redirect;
                }
            })
        })
    };

    document.querySelectorAll('#as-save-deleted-data').forEach((el) => {
        el.onchange = () => {
            changeFetch('/fastdb/settings/saving-deleted-data', 'POST', {
                'as-save-deleted-data': el.value
            });
        };
    });

    document.querySelectorAll('#save-deleted-data').forEach((el) => {
        el.onchange = () => {
            changeFetch('/fastdb/settings/turn-deleted-data', 'POST', {
                'save-deleted-data': el.checked == 1 ? 'on' : 'off'
            });
        };
    });

    document.querySelectorAll('.banned-account').forEach((el) => {
        el.onchange = () => {
            changeFetch('/fastdb/users/banned-account', 'POST', {
                'banned-account': el.checked == 1 ? 'on' : 'off',
                'user-hash': el.getAttribute('user-hash')
            });
        };
    });

    if (selectors.dinamic_btn !== null && selectors.dinamic_btn !== undefined && (selectors.dinamic_btn.length > 0)) {
        for (let i = 0; i < selectors.dinamic_btn.length; i++) {
            const el = selectors.dinamic_btn[i];
            const pages = selectors.dinamic_pages;

            el.onclick = function() {
                for (let j = 0; j < selectors.dinamic_btn.length; j++) {
                    selectors.dinamic_btn[j].classList.remove('active');
                }
                const namePage = this.attributes['dinamic-btn'].nodeValue;
                el.classList.add('active');

                pages.forEach((el, k, o) => {
                    o[k].classList.remove('active');

                    if (o[k].getAttribute('name-dinamic-page') === namePage) {
                        o[k].classList.add('active');
                    }
                });
            };
        }
    }

    // Interfaces Desing
    const rangeSizeIconMenu = document.querySelector('.range-size-icon-menu');
    const rangeSizeTextMenu = document.querySelector('.range-size-text-menu');
    const numSizeIconMenu = document.querySelector('.num-size-icon-menu');
    const numSizeTextMenu = document.querySelector('.num-size-text-menu');
    const iconMenu = document.querySelectorAll('.item-menu i');
    const textMenu = document.querySelectorAll('.item-menu span');
    const changeIconMenu = document.querySelector('.change-display-icon-menu');
    const changeTextMenu = document.querySelector('.change-display-text-menu');
    const displayLogo = document.querySelector('.display-logo');
    const logo = document.querySelector('.logo-sitebar-left');
    const displayInfoConnect = document.querySelector('.display-info-connect');
    const infoConnect = document.querySelector('.container-info-server');
    const displayUsedMemory = document.querySelector('.display-used-memory');
    const usedMemory = document.querySelector('.container-memory');
    const storageData = localStorage.desin ? JSON.parse(window.localStorage.desin) : {};
    const desing = config.default_interface;

    const handlersInterface = {
        resizeIconMenu: function(value) {
            if (numSizeIconMenu !== null) numSizeIconMenu.innerHTML = value;
            if(iconMenu !== null) {
                iconMenu.forEach((el) => {
                    el.style.fontSize = value + 'px';
                });
            }
            if (rangeSizeIconMenu !== null) rangeSizeIconMenu.value = value;
        },
        resizeTextMenu: function(value) {
            if (numSizeTextMenu !== null) numSizeTextMenu.innerHTML = value;

            if(textMenu !== null) {
                textMenu.forEach((el) => {
                    el.style.fontSize = value + 'px';
                });
            }
            if (rangeSizeTextMenu !== null) rangeSizeTextMenu.value = value;
        },
        showIconMenu: function(checked) {
            if(iconMenu !== null) {
                iconMenu.forEach((el) => {
                    el.style.display = checked === true ? 'revert' : 'none';
                });
            }
            if (changeIconMenu !== null) changeIconMenu.checked = checked;
        },
        showTextMenu: function(checked) {
            if(textMenu !== null) {
                textMenu.forEach((el) => {
                    el.style.display = checked === true ? 'revert' : 'none';
                });
            }
            if (changeTextMenu !== null) changeTextMenu.checked = checked;
        },
        showLogo: function(checked) {
            if(logo !== null) {
                logo.style.display = checked === true ? 'revert' : 'none';
            }
            if (displayLogo !== null) displayLogo.checked = checked;
        },
        showInfoConnect: function(checked) {
            if(infoConnect !== null) {
                infoConnect.style.display = checked === true ? 'revert' : 'none';
            }
            if (displayInfoConnect != null) displayInfoConnect.checked = checked;
        },
        showUsedMemory: function(checked) {
            if(usedMemory !== null) {
                usedMemory.style.display = checked === true ? 'revert' : 'none';
            }
            if (displayUsedMemory != null) displayUsedMemory.checked = checked;
        }
    };

    let dataStorage = {
        sizeIcon: storageData.sizeIcon ?? desing.menu.sizeIcon,
        sizeText: storageData.sizeText ?? desing.menu.sizeText,
        showIconMenu: storageData.showIconMenu ?? desing.menu.showIconMenu,
        showTextMenu: storageData.showTextMenu ?? desing.menu.showTextMenu,
        showLogo: storageData.showLogo ?? desing.content.showLogo,
        showInfoConnect: storageData.showInfoConnect ?? desing.sitebarRight.showDataConnection,
        usedMemory: storageData.usedMemory ?? desing.sitebarRight.usedMemory,
    };

    handlersInterface.resizeIconMenu(dataStorage.sizeIcon);
    handlersInterface.resizeTextMenu(dataStorage.sizeText);
    handlersInterface.showIconMenu(dataStorage.showIconMenu);
    handlersInterface.showTextMenu(dataStorage.showTextMenu);
    handlersInterface.showLogo(dataStorage.showLogo);
    handlersInterface.showInfoConnect(dataStorage.showInfoConnect);
    handlersInterface.showUsedMemory(dataStorage.usedMemory);

    if (rangeSizeIconMenu !== null) {
        rangeSizeIconMenu.oninput = function() {
            handlersInterface.resizeIconMenu(this.value);
            dataStorage.sizeIcon = this.value;
            localStorage.setItem('desin', JSON.stringify(dataStorage));
        };
    }
    if (rangeSizeTextMenu !== null) {
        rangeSizeTextMenu.oninput = function() {
            handlersInterface.resizeTextMenu(this.value);
            dataStorage.sizeText = this.value;
            localStorage.setItem('desin', JSON.stringify(dataStorage));
        };
    }
    if (changeIconMenu !== null) {
        changeIconMenu.onchange = function() {
            handlersInterface.showIconMenu(this.checked);
            dataStorage.showIconMenu = this.checked;
            localStorage.setItem('desin', JSON.stringify(dataStorage));
        };
    }
    if (changeTextMenu !== null) {
        changeTextMenu.onchange = function() {
            handlersInterface.showTextMenu(this.checked);
            dataStorage.showTextMenu = this.checked;
            localStorage.setItem('desin', JSON.stringify(dataStorage));
        };
    }
    if (displayLogo !== null) {
        displayLogo.onchange = function() {
            handlersInterface.showLogo(this.checked);
            dataStorage.showLogo = this.checked;
            localStorage.setItem('desin', JSON.stringify(dataStorage));
        };
    }
    if (displayInfoConnect !== null) {
        displayInfoConnect.onchange = function() {
            handlersInterface.showInfoConnect(this.checked);
            dataStorage.showInfoConnect = this.checked;
            localStorage.setItem('desin', JSON.stringify(dataStorage));
        };
    }
    if (displayUsedMemory !== null) {
        displayUsedMemory.onchange = function() {
            handlersInterface.showUsedMemory(this.checked);
            dataStorage.usedMemory = this.checked;
            localStorage.setItem('desin', JSON.stringify(dataStorage));
        };
    }

    // Select checkbox
    let allSelectionCheckbox = document.querySelectorAll('[select-all-checkbox]');
    let selectCheckbox = document.querySelectorAll('[select-checkbox]');

    const handlersSelectCheckbox = {
        selectAll: function(context) {
            const attChange = context.getAttribute('select-all-checkbox');

            selectCheckbox.forEach((el) => {
                if (el.getAttribute('select-checkbox') == attChange) {
                    el.checked = context.checked;
                }
            });
        },
        selectionReplace: function(attr) {
            let allChecked = document.querySelectorAll('[select-checkbox=' + attr + ']');
            let allSelectionCheckbox = document.querySelector('[select-all-checkbox=' + attr + ']');
            let checked = 0;
            let notChecked = 0;
            allChecked.forEach((el) => {
                if (el.checked === true) {
                    checked++;
                } else {
                    checked--;
                }
            });

            if (checked === allChecked.length) {
                allSelectionCheckbox.checked = true;
            } else {
                allSelectionCheckbox.checked = false;
            }
        }
    };

    if (allSelectionCheckbox !== null && allSelectionCheckbox.length > 0) {
        for (let i = 0; i < allSelectionCheckbox.length; i++) {
            const attrSelect = allSelectionCheckbox[i].getAttribute('select-all-checkbox');

            allSelectionCheckbox[i].onchange = function() {
                handlersSelectCheckbox.selectAll(this);
            }
        }
    }
    if (selectCheckbox !== null && selectCheckbox.length > 0) {
        for (let i = 0; i < selectCheckbox.length; i++) {
            handlersSelectCheckbox.selectionReplace(selectCheckbox[i].getAttribute('select-checkbox'));

            selectCheckbox[i].onchange = function() {
                handlersSelectCheckbox.selectionReplace(this.getAttribute('select-checkbox'));
            };
        }
    }

    let numSelectMememory = document.querySelector('.num-select-memory');
    let rangeMemoryInCreateUser = document.querySelector('#range-memory-in-create-user');

    if (rangeMemoryInCreateUser !== null) {
        rangeMemoryInCreateUser.oninput = function() {
            numSelectMememory.innerHTML = this.value;
        };
    }

    if (selectors.show_data_history_sender !== null && selectors.show_data_history_sender.length > 0) {
        selectors.show_data_history_sender.forEach((el, k, o) => {
            el.onclick = (e) => {
                if (e.path[4].children[1].classList.contains('active')) {
                    e.path[4].children[1].classList.remove('active');
                } else {
                    e.path[4].children[1].classList.add('active');
                }
            };
        });
    }

    if (selectors.history_close !== null && selectors.history_close.length > 0) {
        selectors.history_close.forEach((el) => {
            const id = el.getAttribute('history-close-id');

            el.onclick = () => {
                changeFetch('/fastdb/history/delete/' + id, 'GET');
                document.querySelector('[history-id="' + id + '"]').style.transform = 'scale(0)';

                setTimeout(() => {
                    document.querySelector('[history-id="' + id + '"]').remove();
                }, 300);
            };
        });
    }

    // edit td Table

    let td = document.querySelectorAll('[edit-field]');

    td.forEach((el, k, o) => {
        el.ondblclick = () => {
            const internalText = el.innerText;
            const internalHtml = el.innerHTML;
            const context = el;

            let input = document.createElement('textarea');
            input.innerHTML = internalHtml;
            input.style.width = '98%';
            input.style.height = '100%';
            context.innerHTML = input.outerHTML;

            const contextNew = el;
            const inputEdit = contextNew.querySelector('textarea');

            inputEdit.focus();
            inputEdit.setSelectionRange(-1, -1);

            inputEdit.onblur = function() {
                const value = this.value;
                contextNew.innerHTML = value;

                if (o[k].getAttribute('edit-field-func')) {
                    editorField(el, o, o[k]);
                }
            };

            inputEdit.onkeyup = function(e) {
                const keyCodePress = e.keyCode;

                if (keyCodePress === 13 && e.shiftKey === true) {
                    return false;
                }

                if (keyCodePress === 13) {
                    inputEdit.blur();
                }
            };
        };
    });

    // Обработчик для edit-field
    function editorField(el, element, object) {

    }


    // Resize Table
    let th = document.querySelectorAll('th');

    if(th !== null) {
        th.forEach((el, k, o) => {
            if(el.querySelector('span.resize') !== null && el.querySelector('span.resize') !== undefined) {
                el.querySelector('span.resize').onmousedown = (e) => {
                    window.addEventListener('mousemove', mousemove);
                    window.addEventListener('mouseup', mouseup);
        
                    let x = e.clientX;
                    let y = e.clientY;
        
                    function mousemove(event) {
                        let elMove = el.getBoundingClientRect();
        
                        el.style.width = elMove.width - (x - event.clientX) + 'px';
        
                        x = event.clientX;
                    }
        
                    function mouseup(el) {
                        window.removeEventListener('mousemove', mousemove);
                        window.removeEventListener('mouseup', mouseup);
                    }
                };
            }
        });
    }

    const eventContextMenu = [
        {
            name: 'reload',
            func: () => {
                location.reload();
            }
        },
        {
            name: 'prev',
            func: () => {
                history.go(-1);
            },
            funcHandler: (e) => {
                if(document.referrer === "") {
                    e.classList.add('banned');
                }
            }
        },
        {
            name: 'logout',
            func: () => {
                location.href = '/fastdb/logout';
            },
            funcHandler: (e) => {
                if(location.pathname === '/fastdb/auth') {
                    e.classList.add('banned');
                }
            }
        }
    ];

    eventContextMenu.forEach((e, k, o) => {
        contextMenu.event(e.name, (event, context) => {
            if(e.funcHandler) {
                e.funcHandler(event, context);
            }

            event.onclick = () => {
                e.func(event, context);
    
                context.close();
            };
        });
    });

    let checkStaticicTable = document.querySelector('#check-staticic-table');
    let statisticsTableBlock = document.querySelector('.table_statistics');

    if(checkStaticicTable !== null) {
        let LocalData = JSON.parse(localStorage.getItem('tables')) ?? {};

        checkStaticicTable.checked = LocalData.check_staticics_table ?? true;
        statisticsTableBlock.setAttribute('display', LocalData.check_staticics_table ?? true);

        checkStaticicTable.onchange = () =>  {
            localStorage.setItem('tables', JSON.stringify({
                check_staticics_table: checkStaticicTable.checked
            }));
            statisticsTableBlock.setAttribute('display', checkStaticicTable.checked);
        };
    }

    if(selectors.timer.length > 0) {
        selectors.timer.forEach((el, k, o) => {
            const addNumber = (num) => {
                if(num < 10) {
                    return '0' + num;
                } else {
                    return num;
                }
            };
            const updateTimer = function() {

                let total = Date.parse(el.getAttribute('timer')) - Date.parse(new Date());
                
                let seconds = addNumber(Math.floor((total / 1000)) % 60);
                let minutes = addNumber(Math.floor((total / 1000 / 60) % 60));
                let hours = addNumber(Math.floor((total / (1000 * 60 * 60)) % 24));
                let days = addNumber(Math.floor(total / (1000 * 60 * 60 * 24)));

                if(total <= 0) {
                    clearInterval(updateTimer);
                    seconds = '00';
                    minutes = '00';
                    hours = '00';
                    days = '00';
                }

                if(total > 0) {
                    el.querySelector('[timer-seconds]').innerHTML = seconds;
                    el.querySelector('[timer-minutes]').innerHTML = minutes;
                    el.querySelector('[timer-hours]').innerHTML = hours;
                    el.querySelector('[timer-days]').innerHTML = days;
                }
                
            };

            setInterval(updateTimer, 1000);
        });
    }

    // Сохраняем текущее время в sessionStorage
// Как только любая ссылка будет нажата, выполнение остановится
function check_speed() {
    sessionStorage.now = Date.now();
    setTimeout(check_speed, 25);
}

// Вешаем обработчик на полную загрузку страницы
window.onload = function() {
    var now = Date.now();
    if ( sessionStorage.now ) {
        var loaded_in = now - parseInt(sessionStorage.now);
        // отправляем значение loaded_in на сервер
        // значение в миллисекундах
        console.log(loaded_in);
    }

    check_speed();
};

}