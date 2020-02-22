install.packages("plyr", dependencies= TRUE)
install.packages("arules")
library(plyr)
library(data.table)
library(dplyr)
library(arules)

product_clean <- read.csv("/Users/jiyewang/Desktop/Courses/Data_and_Text_Mining/A3/product_clean.csv")
item = product_clean[,2:3]
item_name = item[!duplicated(item$StockCode),]

product_clean_new = left_join(product_clean,item_name,c("StockCode" = "StockCode"))

sorted <- product_clean_new[order(product_clean$InvoiceNo),]
product_am <- ddply(sorted,'InvoiceNo',function(groupby)c(ItemName=paste(groupby$Description.y,collapse=',')))
product_am$InvoiceNo = NULL
write.table(product_am,"~/Desktop/Courses/Data_and_Text_Mining/A3/product_am.csv", quote=FALSE, row.names = FALSE, col.names = FALSE)
product_fn = read.transactions("~/Desktop/Courses/Data_and_Text_Mining/A3/product_am.csv",format="basket",sep=",")
summary(product_fn)
itemFrequencyPlot(product_fn, topN=10)


rules = apriori(product_fn,parameter = list(supp=0.02,conf=0.5))
rules_in = inspect(rules)

maximal.sets = apriori(product_fn, parameter=list(supp=0.02, conf=0.5, target="maximally frequent itemset"))
inspect(maximal.sets)

is.maximal(itemsets)
is.maximal(rules)

inspect(sort(rules,by='lift')[1:15])
itemsets=unique(generatingItemsets(rules))
itemsets
inspect(itemsets)




