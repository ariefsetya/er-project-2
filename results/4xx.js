'use strict';

exports.ue = function(values, res) {
  var data = {
      'message': "",
      'result': values
  };
  res.json(data).status(422);
  res.end();
};