SELECT Date, SUM(Value) FROM dm_a4.mt123electricityclean group by Date;
SELECT Hour, SUM(Value) FROM dm_a4.mt123electricityclean group by Hour;
SELECT Date, Value FROM dm_a4.mt123electricityclean where Minute="16:00:00";