window.onload = () => {
    let clicksBar = document.querySelectorAll('.link-click');

    clicksBar.forEach((el, k, o) => {
        el.querySelector('span').addEventListener('click', () => {
            if(el.classList.contains('active')) {
                el.classList.remove('active');
            } else {
                el.classList.add('active');
            }
        });
    });

    let perkLink = document.querySelector('.perk-content-link');
    if(perkLink !== null) {
        document.querySelector('.doc-common-content').innerHTML = perkLink.innerHTML;

        perkLink.remove();
    }

    let url = new URL(window.location);
    let params = new URLSearchParams(url.search);

    if(params.get('link') !== undefined) {
        let link = params.get('link').split('_');
        let lengthLink = (link.length > 1) ? link.length - 1 : link.length;

        let similar = document.querySelectorAll('.link-click');
        let similarLinks = [];

        similar.forEach((e) => {
            if(e.getAttribute('id') === link[(link.length > 1) ? link.length - 2 : link.length]) {
                let allLinks = e.querySelectorAll('a');

                allLinks.forEach((l) => {
                    similarLinks.push({
                        href: l.getAttribute('href'),
                        title: l.getAttribute('title')
                    });
                });
            }
        });

        if(similarLinks.length > 0) {
            for(let j = 0; j < ((similarLinks.length < 4) ? similarLinks.length : 4); j++) {
                if(window.location.pathname + window.location.search !== similarLinks[j].href) {
                    let fullLinkSimilar = document.createElement('a');
                    fullLinkSimilar.href = similarLinks[j].href;
                    fullLinkSimilar.title = similarLinks[j].title;
                    fullLinkSimilar.innerHTML = similarLinks[j].title;

                    document.querySelector('.doc-similar-request').append(fullLinkSimilar);
                }
            }
        }

        for(let i = 0; i < lengthLink; i++) {
            let selectedMenu = document.querySelector('#' + link[i]);

            if(selectedMenu !== null) {
                selectedMenu.classList.add('active');
            }
        }

        let lastLink = (link.length > 1) ? lengthLink : link.length - 1;

        let actLink = document.querySelector('#' + link[lastLink] + '> span');

        if(actLink !== null) {
            actLink.style.color = '#000';
            actLink.style.textDecoration = 'underline';
        }
    }
};
