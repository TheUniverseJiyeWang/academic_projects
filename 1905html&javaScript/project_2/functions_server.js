const SERVER_PORT = 8172;
var express = require('express');
var fs = require('fs');
const FILE_NAME = "result.txt";

//CORS Middleware, causes Express to allow Cross-Origin Requests
// Do NOT change anythinghere
var allowCrossDomain = function (req, res, next) {
    res.header('Access-Control-Allow-Origin', '*');
    res.header('Access-Control-Allow-Methods','GET,PUT,POST,DELETE');
    res.header('Access-Control-Allow-Headers','Content-Type');
    next();
};


//set up the server variables
var app = express();
app.use(express.bodyParser());
app.use(allowCrossDomain);
app.use('/scripts', express.static(__dirname + '/scripts'));
app.use('/css', express.static(__dirname + '/css'));
app.use(express.static(__dirname));


//mongo db connection

var mongodb = require('mongodb');
NAME_OF_COLLECTION = 'university_record';
var user = 'ji_wang';
var password = 'A00426401';
var database = 'ji_wang';

//These should not change, unless the server spec changes
var host = '127.0.0.1';
var port = '27017'; // Default MongoDB port


// Now create a connection String to be used for the mongo access
var connectionString = 'mongodb://' + user + ':' + password + '@' + host + ':' + port + '/' + database;
var unicollection;

//now connect to the db
mongodb.connect(connectionString, function(error, db){

    if(error){
    throw error;
    }//end if

    console.log("DB object connected successfully");
    unicollection = db.collection(NAME_OF_COLLECTION);
    console.log(unicollection);

     // Close the database connection and server when the application ends
    process.on('SIGTERM', function () {
        console.log("Shutting server down.");
        db.close();
        app.close();
    });
    /**
    *  code if successfully accessing the db!!
    */

    //now start the application server
    var server = app.listen(SERVER_PORT, function () {
        console.log('Listening on port %d',
                server.address().port);
    });
})

app.post('/saveUniversity',function(request, response){
    console.log("saveUniversity being executed in " + __dirname)  
	console.log(request.body.Name);
	console.log(request.body.Address);
	console.log(request.body.Phone);
    var name =  request.body.Name;
    var address = request.body.Address;
    var phone = request.body.Phone;
    var count;
    var count = unicollection.count({"Name":name},function(err, result){
        if(err){
            return response.send(400,'An error occurred retrieving records.');
        }
        console.log("Results");
        console.log(result);
        if(result == 0) {
            console.log("Inserting Record!")
           	unicollection.insert(request.body,function(err, result1){
                if(err){
                    return response.send(400,'An error occurred saving a record.');
                }
                return response.send(200, "Record saved successfully.");
            });
        }else{
            return response.send(400,'Unversity already exists!');
        }
        return result;
    });           
});

app.post('/deleteUniversity', function(request, response){
    console.log("deleteUniversity being executed in " + __dirname);
    console.log(request.body.Name);
    unicollection.remove({'Name':request.body.Name},function(err, result){
       	if(err){
           return response.send(400,'An error occurred deleting records.');
       	}
    var obj = JSON.parse(result);
       	console.log(obj.n + " records");
       	return response.send(200, "Successfully deleted the record");
    });
});

app.post('/searchUniversity', function(request, response){
    console.log("searching being executed in " + __dirname);
	console.log("Searching Record!");
	console.log("Results");
	console.log(request.body.Name);    
    unicollection.find({'Name':request.body.Name},function(err, result){
        if (err) {
            return response.send(400,'An error occurred retrieving records.');
        }
        result.toArray(function(err, resultArray){
            if (err) {
                return response.send(400, 'An error occurred processing your records.');
            }
            return response.send(200, resultArray);
        });
        console.log(result);
    });
});

app.post('/displayUniversity', function(request, response){
    console.log("displayUniversity being executed in " + __dirname);
   	console.log("Display");
    unicollection.find(function(err, result){
        if (err) {
            return response.send(400,'An error occurred retrieving records.');
        }
       	result.toArray(function(err, resultArray){
            if (err) {
                return response.send(400, 'An error occurred processing your records.');
            }
            return response.send(200, resultArray);
        });
        console.log(result);
    });
});


