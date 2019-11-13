var express = require('express'),
    app = express(),
    port = 3000,
    bodyParser = require('body-parser'),
    http = require('http').createServer(app),
    io = require('socket.io')(http);



path = __dirname;

app.use(express.static(__dirname + '/'));
app.use(bodyParser.urlencoded({ extended: true }));
app.use(bodyParser.json());

var api = require('./routes/api');
api(app);

	io.on('connection', function(socket){
	  console.log('a user connected');
	  socket.on('disconnect', function(){
	    console.log('user disconnected');
	  });
    socket.on('quiz', function(msg){
      console.log(msg);
      io.emit('quiz',msg);
    });
	});


// app.listen(port);
http.listen(port, function(){
  console.log('listening on *:'+port);
});
console.log('Api Started')
