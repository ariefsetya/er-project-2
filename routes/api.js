'use strict';

module.exports = function(app) {
    var country = require('../controllers/country');
    var auth = require('../controllers/auth');

    app.route('/api/country')
        .get(country.root);

    app.route('/api/auth')
        .post(auth.check);
};