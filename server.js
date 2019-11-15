var express = require('express'),
    app = express(),
    port = 3000,
    bodyParser = require('body-parser'),
    fs = require('fs');



// Certificate
const privateKey = fs.readFileSync('/etc/letsencrypt/live/aquajapan2019annualdealersgathering.com/privkey.pem', 'utf8');
const certificate = fs.readFileSync('/etc/letsencrypt/live/aquajapan2019annualdealersgathering.com/cert.pem', 'utf8');
const ca = fs.readFileSync('/etc/letsencrypt/live/aquajapan2019annualdealersgathering.com/chain.pem', 'utf8');


const credentials = {
  key: privateKey,
  cert: certificate,
  ca: ca
};

var http = require('http').createServer(app),
    https = require('https').createServer(credentials, app),
    io = require('socket.io')(https)

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
// http.listen(port, function(){
  // console.log('listening on *:'+port);
// });
// console.log('Api Started')



https.listen(port, () => {
  console.log('HTTPS Server running on port 443');
});