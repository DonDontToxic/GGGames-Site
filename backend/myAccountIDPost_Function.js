/****************************************************/
// Filename: myAccountIDPost_Function.js
// Created: Dong Nguyen
// Purpose: Create a new account for user by posting provided information to database
// Location: Stored in the aws lamda services with same name
// Usage: Call through REST API GateWay in frontend code
// API Method: POST
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
    // const http_method = event['httpMethod'];
    
    const body = JSON.parse(event['body']);
      
    var uname = "'" +body['Username']+ "'";
    var password = "'" +body['Password']+  "'";
    var mail =  "'" +body['Mail']+  "'";

    pool.getConnection(function(err, connection) {
      if(err) callback(err)
      else
        // Use the connection
        connection.query("INSERT INTO accountInfo(Username,Password,Mail) VALUES ("+uname+"," + password +"," +mail+")", function (error, results, fields) {
            // And done with the connection.
          connection.release();
          // Handle error after the release.
          if (error) callback(error);
          else callback(null,results);
        });
    });
  };
  
  

