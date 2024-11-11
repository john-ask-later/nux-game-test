import './bootstrap';

let createSpin = $('#create-spin'),
    historyContainer = $('#history-container'),
    showHistory = $('#spin-history');

let errorHandler = (err) => {
    console.log(err);

    switch (err.response.status) {
        case 404:
        case 409:
            alert(window.app.messages.lp_expired);
            window.location = window.app.url.home;
            break;
    }
}

$(document).ready(function () {
    createSpin.on('click', function () {
        let url = createSpin.data('url');

        createSpin.attr('disabled', true);

        axios.post(url, {})
            .then(resp => {
                historyContainer.html(resp.data.result)
            })
            .catch(errorHandler)
            .then(() => {
                createSpin.attr('disabled', false);
            });
    });

    showHistory.on('click', function (e) {
        e.preventDefault();
        let url = $(this).attr('href');

        axios.get(url)
            .then((resp) => {
                historyContainer.html(resp.data.result)
            })
            .catch(errorHandler);
    })
});
