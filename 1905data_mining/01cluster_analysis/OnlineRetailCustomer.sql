select CustomerID,
sum(Quantity) as ItemPurchased, 
count(distinct StockCode) as ItemVariety, 
sum(TotalPrice) as Revenue,
count(distinct InvoiceNo) as TotalVisit,
sum(TotalPrice)/count(distinct InvoiceNo) as RevenuePerVisit,
sum(Quantity)/count(distinct InvoiceNo) as ItemPerVisit
from onlineretail 
group by CustomerID;