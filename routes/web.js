'use strict';

module.exports = function(app) {
    var html = require('../controllers/html');

    app.route('/')
        .get(html.index);
};