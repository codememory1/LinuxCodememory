class PaginationTable {
    dataLoad;
    loaded = 0;
    countLoad = 2;
    buttonClick;
    allLoad = 0;

    static data(data) {
        this.dataLoad = data;

        return this;
    }

    static settings(onceCountLoad = 20, countUpload = 5) {
        this.loaded = onceCountLoad;
        this.countLoad = countUpload;

        return this;
    }

    static _handlerClick(callback, setLoader) {
        let btn = this.buttonClick;
        let allLoad = this.allLoad;
        let dataLoad = [];
        btn.onclick = () => {
            let containerLoader = document.createElement('span');
            
            const idLoader = Math.round(Math.random() * (500 - 0) + 0);

            containerLoader.setAttribute('id-loader', idLoader);
            containerLoader.innerHTML = setLoader.icon;
            setLoader.selector.innerHTML = containerLoader.outerHTML;

            setTimeout(() => {
                console.log(allLoad, allLoad + this.countLoad - 1);
                
                for(let i = allLoad; i < allLoad + this.countLoad; i++) {
                    if(this.dataLoad[i]) {
                        dataLoad.push(this.dataLoad[i]);
                    }

                    if(i + 1 == allLoad + this.countLoad) {
                        document.querySelector('[id-loader="' + idLoader + '"]').remove();
                    }
                }
                callback(dataLoad);
                dataLoad = [];
            }, 100);

            setTimeout(() => {
                allLoad = allLoad + this.countLoad;
            }, 100);
        };
    }

    static onClick(button, callback, loader) {
        this.buttonClick = button;
        
        this._handlerClick(callback, loader);

        return this;
    }

    static upload(callback) {
        let data = [];
        let lengthData = (this.loaded - 1) > this.dataLoad.length ? this.dataLoad.length : (this.loaded - 1);

        for(let i = 0; i <= lengthData; i++) {
            data.push(this.dataLoad[i]);
        }

        this.allLoad = +Number(this.loaded);

        callback(data, this.allLoad);

        return this;
    }
}
