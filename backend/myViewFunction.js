/****************************************************/
// Filename: myViewFunction.js
// Created: Dong Nguyen
// Purpose: Get information of four games that have largest views
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
  console.log(event);
  
  pool.getConnection(function(err, connection) {
    if(err) callback(err)
    else
      // Use the connection
      connection.query('SELECT ID,Images FROM gameInfo ORDER BY View DESC LIMIT 4', function (error, results, fields) {
          // And done with the connection.
        connection.release();
        // Handle error after the release.
        if (error) callback(error);
        else callback(null,results);
      });
  });
};

