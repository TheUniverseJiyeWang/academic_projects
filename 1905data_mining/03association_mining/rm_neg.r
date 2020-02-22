library("RMySQL")
library("lubridate")

conn = dbConnect(MySQL(),user = 'root', password = 'wangjiye920116', dbname = 'dm_a3', host = 'localhost')
dbListTables(conn)

num = nrow(neg_records)
rows = 0;

dbClearResult(dbListResults(conn)[[1]])

for(j in 0:10){
  start = j*1000+1
  end = (j+1)*1000
  for(i in start:end){
    record = neg_records[i,]
    tmpStockCodeR = record[2]
    tmpStockCode = tmpStockCodeR[1,1]
    tmpQuantity = record[4]*(-1)
    tmpUnitPrice = record[6]
    tmpCustomerID = record[7]
    tmpDateTimeR = record[8]
    tmpDateTime = toString(tmpDateTimeR[1,1])
    tmpDate = ymd_hms(tmpDateTime)-days(30)
    tmpquery = paste(sep="","delete from product_detail where StockCode = '",tmpStockCode,"' and Quantity = '",
                     tmpQuantity,"' and CustomerID = '",tmpCustomerID,"' and InvoiceDateTime < '",tmpDateTime,
                     "' and InvoiceDateTime >'",tmpDate,"' limit 1;")
    dbSendStatement(conn,tmpquery)
    print(tmpquery)
  }
}


