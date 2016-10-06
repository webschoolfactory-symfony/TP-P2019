(function () {
    'use strict';

    const onClick = (e) => {
        e.preventDefault();
        const url = e.target.getAttribute('href');

        fetch(url, { credentials: 'same-origin' })
            .then(res => res.text())
            .then((data) => {
                document.querySelector(e.target.getAttribute('data-vote-on')).innerHTML = data;
            });
    };

    const listenEvents = (element) => {
        element.addEventListener('click', onClick);
    };

    document.addEventListener('DOMContentLoaded', () => {
        [].forEach.call(document.querySelectorAll('[data-vote-on]'),  listenEvents);
    });
}());
