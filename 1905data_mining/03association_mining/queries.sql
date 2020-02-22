select * from dm_a3.product_detail where StockCode = '22654' and CustomerID = '12472' limit 1000;
select * from dm_a3.product_detail where StockCode = ' 21531 ' limit 1000;
select * from dm_a3.product_detail where StockCode = '21258' and CustomerID = '16161'  limit 1000;
select * from test_minus where CustomerID = '17548';
delete from test_minus where CustomerID = '17548' limit 1;
ALTER USER 'root'@'localhost' IDENTIFIED WITH mysql_native_password BY 'wangjiye920116';
SET SQL_SAFE_UPDATES = 0;
delete from product_detail where StockCode = '21258' and Quantity = '1' and CustomerID = '16161' and InvoiceDateTime < '2010-12-14 09:02:00' and InvoiceDateTime >'2010-11-14 09:02:00';
delete from product_detail_all where StockCode = '22620' and Quantity = '8' and CustomerID = '0' and InvoiceDateTime < '2010-12-06 10:04:00' and InvoiceDateTime >'2010-11-06 10:04:00' limit 1;