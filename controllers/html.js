'use strict';

exports.index = function(req, res) {
  res.sendFile(path + '/public/index.html');
};