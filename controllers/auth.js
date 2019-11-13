'use strict';

var res2xx = require('../results/2xx');
var res4xx = require('../results/4xx');
var connection = require('../config/db');

exports.check = function(req, res) {
    connection.query(`SELECT * FROM ms_invitation where country_id=${res.country_id} and phone=${res.phone}`, function (error, rows, fields){
        if(error){
            res4xx.ue('Data Not Found')
        } else{
            res2xx.ok(rows, res)
        }
    });
};