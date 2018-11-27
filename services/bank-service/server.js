// grab the packages we need
const express = require('express');
const bodyParser = require('body-parser');
const mysql = require('mysql');

const app = express();
const port = process.env.PORT || 8080;

app.use(bodyParser.json());
app.use(bodyParser.urlencoded({
    extended: true
}));

// connection configurations
const mc = mysql.createConnection({
    host: 'localhost',
    user: 'root',
    password: '',
    database: 'bank'
});

// connect to database
mc.connect();

// Enable CORS
app.use(function(req, res, next) {
  res.header("Access-Control-Allow-Origin", "*");
  res.header("Access-Control-Allow-Headers", "Origin, X-Requested-With, Content-Type, Accept");
  next();
});


// routes
app.get('/', function (req, res) {
    return res.send({ error: true, message: 'hello' })
});

app.post('/validate', function (req, res) {
    let card_number = req.body.card_number;

    console.log(req.body.card_number);
    
    mc.query('SELECT * FROM cards where card_number=?', [card_number], function (error, results, fields) {
        if (error) {
            return res.send(JSON.stringify({ "status": 500, "error": error, "response": null }));
        }
        else {
            if (results.length > 0) {
                return res.send(JSON.stringify({ "status": 200, "error": null, "response": 'Valid' }));
            }
            else {
                return res.send(JSON.stringify({ "status": 200, "error": null, "response": 'Invalid' }));
            }
        }
    });
});

app.post('/transfer', function (req, res) {
    let src_number = req.body.src_number;
    let dst_number = req.body.dst_number;
    let amount = req.body.amount;
    
    mc.query('SELECT balance FROM cards where card_number=?', [src_number], function (error, results, fields) {
        if (error) {
            return res.send(JSON.stringify({ "status": 500, "error": error, "response": null }));
        }
        else {
            if (results[0].balance > amount) {
                console.log(results[0].balance);
                let new_src_amt = results[0].balance - amount;
                mc.query('UPDATE cards SET balance=? where card_number=?', [new_src_amt, src_number], function (error, results1, fields) {
                    if (error) {
                        return res.send(JSON.stringify({ "status": 500, "error": error, "response": null }));
                    }
                    else {
                        let new_dst_amt = results[0].balance + amount;
                        mc.query('UPDATE cards SET balance=? where card_number=?', [new_dst_amt, dst_number], function (error, results1, fields) {
                            if (error) {
                                return res.send(JSON.stringify({ "status": 500, "error": error, "response": null }));
                            }
                            else {
                                mc.query('INSERT INTO transactions SET ?', {sender: src_number, receiver: dst_number, amount: amount}, function (error, results2, fields) {
                                    if (error) {
                                        return res.send(JSON.stringify({ "status": 500, "error": error, "response": null }));
                                    }
                                    else {
                                        return res.send(JSON.stringify({ "status": 200, "error": null, "response": 'Transaction success' }));
                                    }
                                });
                            }
                        });
                    }
                });
            }
            else {
                return res.send(JSON.stringify({ "status": 200, "error": null, "response": 'Insufficient balance' }));
            }
        }
    });
});

// start the server
app.listen(port, function() {
    console.log('Server started at http://localhost:' + port);
});

module.exports = app;