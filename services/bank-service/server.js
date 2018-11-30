// grab the packages we need
const express = require('express');
var path = require('path');

const app = express();
const port = process.env.PORT || 8083;


// Enable CORS
app.use(function(req, res, next) {
    res.header("Access-Control-Allow-Origin", "*");
    res.header("Access-Control-Allow-Headers", "Origin, X-Requested-With, Content-Type, Accept");
    next();
});


// start the server
app.listen(port, function() {
    console.log('Server started at http://localhost:' + port);
});


app.use('/api/v1', require('./routes/routes').router);


module.exports = app;