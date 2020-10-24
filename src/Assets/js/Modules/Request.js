function FormInput(form) {

    let inputs = document.querySelectorAll(form + ' input');
    let datas = {};

    inputs.forEach((el) => {
        datas[el.getAttribute('name')] = el.value;
    });

    return JSON.stringify(datas);

}

