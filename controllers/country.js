'use strict';

var res2xx = require('../results/2xx');
var connection = require('../config/db');

exports.root = function(req, res) {
    connection.query(`SELECT * FROM ms_country`, function (error, rows, fields){
        if(error){
            console.log(error)
        } else{
            res2xx.ok(rows, res)
        }
    });
};