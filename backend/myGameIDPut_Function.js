/****************************************************/
// Filename: myGameIDPut_Function.js
// Created: Dong Nguyen
// Purpose: Get all games stored in the database based on its name
// Location: Stored in the aws lamda services with same name
// Usage: Call through REST API in frontend code
// API Method: PUT
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
    const body = JSON.parse(event['body']);
    const id = event['queryStringParameters']['id'];
    const view = body['View'];


    pool.getConnection(function(err, connection) {
      if(err) callback(err)
      else
        // Use the connection
        connection.query("UPDATE gameInfo SET View = " +view+ " WHERE ID = " +id, function (error, results, fields) {
          // And done with the connection.
          connection.release();
          // Handle error after the release.
          if (error) callback(error);
          else callback(null,"PUT completed");
        });
    });
  };
  
  

