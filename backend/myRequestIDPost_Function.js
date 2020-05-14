/****************************************************/
// Filename: myRequestIDPost_Function.js
// Created: Dong Nguyen
// Purpose: Create a new request from user only if they logged in website by posting provided information to database
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
    const http_method = event['httpMethod'];
    
    if (http_method == 'POST') {
      const body = JSON.parse(event['body']);
      
      var name = "'" +body['GName']+ "'";
      var version = "'" +body['GVersion']+  "'";
      var infos =  "'" +body['Infos']+  "'";
      var dt = "'" +body['DateTime']+ "'";
      var rb = "'" +body['RequestedBy']+ "'";
  
      pool.getConnection(function(err, connection) {
        if(err) callback(err)
        else
          // Use the connection
          connection.query("INSERT INTO requestInfo(GName,GVersion,Infos,DateTime,RequestedBy) VALUES ("+name+"," + version +"," +infos+","+dt+","+ rb+")", function (error, results, fields) {
              // And done with the connection.
            connection.release();
            // Handle error after the release.
            if (error) callback(error);
            else callback(null,results);
          });
      });
    }
  };
  
  

