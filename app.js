const express = require('express');
const app = express();

const http = require('http').createServer(app);

const io = require('socket.io')(http);

var mysql = require('mysql');

const connection = mysql.createConnection({
    host: "localhost",
    user: "root",
    database: "100fw",
    password: ""
});

const PORT = 8000;

connection.on('error', function(err) {
  	console.log(err.code);
});

var users = {};
io.on('connection', function(socket) {
	
	socket.on('new_connection', function(data){
		
		users[data.userid] = socket.id;
		
		socket.on('addMessage', function(dataAdd) {
		
			var sql = "INSERT INTO chat (fromSend, toSend, message) VALUES ?";
			var values = [
				[
					data.userid,
					dataAdd.to,
					dataAdd.message
				]
			];

			connection.query(sql, [values], function (err, result) {});

			if(users[dataAdd.to])
			{
				io.sockets.sockets[users[dataAdd.to]].emit('messages', dataAdd);
			
				if(users[dataAdd.from])
				io.sockets.sockets[users[dataAdd.from]].emit('messages', dataAdd);
			}
				
			
			console.log(users);

		});
		
	});
	
});

http.listen(PORT, function () {
    console.log('server start ' + PORT);
});
