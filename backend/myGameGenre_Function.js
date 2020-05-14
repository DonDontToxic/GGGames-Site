/****************************************************/
// Filename: myGameGenre_Function.js
// Created: Dong Nguyen
// Purpose: Get all games stored in the database based on its category
// Location: Stored in the aws lamda services with same name
// Usage: Call through HTTP API GateWay in frontend code
// API Method: GET
/****************************************************/

var mysql = require('mysql');
var config = require('./config.json');


var pool  = mysql.createPool({
    host     : config.dbhost,
    user     : config.dbuser,
    password : config.dbpassword,
    database : config.dbname
  });


exports.handler =  (event, context, callback) => {
  //prevent timeout from waiting event loop
    context.callbackWaitsForEmptyEventLoop = false;
  
    const startFrom = event['queryStringParameters']['startFrom'];
    const limit = event['queryStringParameters']['limit'];
    var genre = event['queryStringParameters']['genre'];
    genre = "'%" + genre + "%'"; 

    pool.getConnection(function(err, connection) {
      if(err) callback(err);
      else
        // Use the connection
        connection.query("SELECT* from gameInfo WHERE Category LIKE " +genre+ " LIMIT " +startFrom+","+limit, function (error, results, fields) {
            // And done with the connection.
        connection.release();
        // Handle error after the release.
        if (error) callback(error);
        else callback(null,results);
        });
    });
};

