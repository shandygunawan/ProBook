var express = require('express');
var router = express.Router();
const bodyParser = require('body-parser');
const mysql = require('mysql');


router.use(bodyParser.json());
router.use(bodyParser.urlencoded({
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


/* ROUTES */
// Default route for checking connection
router.get('/', function (req, res) {
    return res.send({ error: true, message: 'hello' })
});

// Check the validity of a card
router.post('/check-validity', function (req, res) {
    let card_number = req.body.card_number;

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

router.post('/transactions/new', function (req, res) {
    try {
        let src_number = req.body.src_number;
        let dst_number = req.body.dst_number;
        let amount = req.body.amount;

        /*
        * Enclosing all processes in getBalance function, why? callback hell.
        * It looks like this because of all those javascript asynchronous bullshits
        * This is the best I could do so far --dion
        * TODO: Device a closure function(?) so that the job of getBalance function
        *   is only to set a variable value with a card's balance.
        */
        getBalance(src_number, function (result) {
            var src_balance;
            src_balance = result;

            getBalance(dst_number, function (result) {
                var dst_balance;
                dst_balance = result;

                if (src_balance > amount) {
                    let new_src_amt = parseInt(src_balance) - parseInt(amount);
                    let new_dst_amt = parseInt(dst_balance) + parseInt(amount);

                    updateBalance(src_number, new_src_amt);
                    updateBalance(dst_number, new_dst_amt);

                    mc.query('INSERT INTO transactions SET ?', { sender: src_number, receiver: dst_number, amount: amount }, function (error, result, field) {
                        if (error) {
                            throw error;
                        }
                        else {
                            return res.send(JSON.stringify({ "status": 200, "error": null, "response": 'Transaction success' }));
                        }
                    });
                }
                else {
                    return res.send(JSON.stringify({ "status": 200, "error": null, "response": 'Insufficient balance' }));
                }
            });
        });
    }
    catch (error) {
        return res.send(JSON.stringify({ "status": 500, "error": error, "response": null }));
    }
});


// Helper functions
let getBalance = (card_number, callback) => {
    mc.query('SELECT balance FROM cards where card_number=?', [card_number], function (error, result, field) {
        if (error) {
            throw error;
        }
        callback(result[0].balance);
    });
}

let updateBalance = (card_number, amount) => {
    mc.query('UPDATE cards SET balance=? where card_number=?', [amount, card_number], function (error, result, field) {
        if (error) {
            throw error;
        }
    });
}


module.exports.router = router;