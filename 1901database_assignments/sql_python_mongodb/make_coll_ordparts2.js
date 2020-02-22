var auto_id = 0;
var ptr = db.orders.find({}, {_id:1, "items":1});

while (ptr.hasNext()){
    var doc = ptr.next(); 
	for (var j = 0; j < doc.items.length; j++) {
        var row = {"_id":auto_id, "ord_id":doc._id, "part_id":doc.items[j].part_id, 
                   "qty":doc.items[j].qty, "price":doc.items[j].price};
        db.ordparts.insert(row);
        auto_id++;
    }
}

