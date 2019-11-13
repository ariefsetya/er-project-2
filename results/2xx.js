'use strict';

exports.ok = function(values, res) {
  var data = {
      'message': "",
      'result': values
  };
  res.json(data).status(200);
  res.end();
};