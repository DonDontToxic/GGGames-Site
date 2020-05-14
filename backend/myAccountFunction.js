/****************************************************/
// Filename: myAccountFunction.js
// Created: Dong Nguyen
// Purpose: Get information of all stored accounts or just one account with the ID != 0
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
    const id = event['queryStringParameters']['id'];
    pool.getConnection(function(err, connection) {
      if(err) callback(err);
      else
      
      if(id == 0) {
        // Use the connection
        connection.query('SELECT ID,Username,Password,Mail from accountInfo', function (error, results, fields) {
          // And done with the connection.
          connection.release();
          // Handle error after the release.
          if (error) callback(error);
          else callback(null,results);
        });
      } else {
        // Use the connection
        connection.query('SELECT * from accountInfo WHERE ID= ' +id, function (error, results, fields) {
          // And done with the connection.
          connection.release();
          // Handle error after the release.
          if (error) callback(error);
          else callback(null,results);
        });
      }

    });
};

