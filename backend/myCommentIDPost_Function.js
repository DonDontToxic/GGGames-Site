/****************************************************/
// Filename: myCommentIDPost_Function.js
// Created: Dong Nguyen
// Purpose: Create a new comment from user by posting provided information to database
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
    const body = JSON.parse(event['body']);
    const gid = event['queryStringParameters']['gid'];
    const aid = event['queryStringParameters']['aid'];

    var name = "'" +body['Name']+ "'";
    var content = "'" +body['Content']+  "'";
    var dt =  "'" +body['DateTime']+  "'";
    var mail =  "'" +body['Mail']+  "'";

  
    pool.getConnection(function(err, connection) {
      if(err) callback(err)
      else
        // Use the connection
        connection.query("INSERT INTO commentInfo(Name,Content,Mail,DateTime,In_gameID,CommentedBy) VALUES ("+name+"," + content +","+mail+"," +dt+"," +gid+","+aid+")", function (error, results, fields) {
          // And done with the connection.
          connection.release();
          // Handle error after the release.
          if (error) callback(error);
          else callback(null,"Post completed");
        });
    });
  };
  
  

