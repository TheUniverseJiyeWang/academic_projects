var auto_id = 0;
var X = db.orders.find({}, {_id:1, "items":1}).toArray();

for (var i = 0; i < X.length; i++) {
	for (var j = 0; j < X[i].items.length; j++) {
        var row = {"_id":auto_id, "ord_id":X[i]._id, "part_id":X[i].items[j].part_id, 
                   "qty":X[i].items[j].qty, "price":X[i].items[j].price};
        db.ordparts.insert(row);
        auto_id++;
    }
}

