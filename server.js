var express = require('express'),
    app = express(),
    port = 9000,
    bodyParser = require('body-parser'),
    fs = require('fs'),
    env = 'dev';

app.use(express.static('node_modules/face-api.js/dist'))
app.use(express.static('public_html/js'))

var http = require('http').createServer(app);

if(env!='dev'){
  const privateKey = fs.readFileSync('/etc/letsencrypt/live/aquajapan2019annualdealersgathering.com/privkey.pem', 'utf8');
  const certificate = fs.readFileSync('/etc/letsencrypt/live/aquajapan2019annualdealersgathering.com/cert.pem', 'utf8');
  const ca = fs.readFileSync('/etc/letsencrypt/live/aquajapan2019annualdealersgathering.com/chain.pem', 'utf8');

  const credentials = {
    key: privateKey,
    cert: certificate,
    ca: ca
  };
  var http = require('https').createServer(credentials, app)

}

var io = require('socket.io')(http)
path = __dirname;

app.use(express.static(__dirname + '/'));
app.use(bodyParser.urlencoded({ extended: true }));
app.use(bodyParser.json());

// var api = require('./routes/api');
// api(app);

	io.on('connection', function(socket){
	  console.log('a user connected');
	  socket.on('disconnect', function(){
	    console.log('user disconnected');
	  });
    socket.on('quiz', function(msg){
      console.log(msg);
      io.emit('quiz',msg);
    });
    socket.on('screen.change', function(msg){
      console.log(msg);
      io.emit('screen.change',msg);
    });
    socket.on('polling.refresh', function(msg){
      console.log(msg);
      io.emit('polling.refresh',msg);
    });
	});


http.listen(port, function(){
  console.log((env=='dev'?'HTTP':'HTTPS')+' listening on *:'+port);
});