library(ggplot2)
library(GGally)
library(DMwR)
set.seed(5580)
OnlineRetail=read.csv("~/Desktop/Courses/Data_and_Text_Mining/A1/OnlineRetail.csv", sep=',', header=T)
boxplot(OnlineRetail$Quantity)
summary(OnlineRetail$Quantity)
summary(OnlineRetailCustomerNew)
boxplot(OnlineRetailCustomerNew$RevenuePerVisit)
QR1 <- quantile(OnlineRetailCustomerNew$RevenuePerVisit, probs = 0.25)
QR3 <- quantile(OnlineRetailCustomerNew$RevenuePerVisit, probs = 0.75)
QR31 <- QR3-QR1
loR <- QR1-3*QR31
hiR <- QR3+3*QR31
loR <- unname(loR)
hiR <- unname(hiR)
CusRevClean <- OnlineRetailCustomerNew[-which(OnlineRetailCustomerNew$RevenuePerVisit<loR),]
CusRevClean <- OnlineRetailCustomerNew[-which(OnlineRetailCustomerNew$RevenuePerVisit>hiR),]
CusRevClean <- CusRevClean[-which(CusRevClean$RevenuePerVisit<loR),]
boxplot(CusRevClean$RevenuePerVisit)
summary(CusRevClean$RevenuePerVisit)
boxplot(OnlineRetailCustomerNew$ItemPerVisit)
QI1 <- quantile(OnlineRetailCustomerNew$ItemPerVisit, probs = 0.25)
QI3 <- quantile(OnlineRetailCustomerNew$ItemPerVisit, probs = 0.75)
QI31 <- QI3 - QI1
loI <- QI1-3*QI31
hiI <- QI3+3*QI31
loI <- unname(loI)
hiI <- unname(hiI)
CusItemClean <- OnlineRetailCustomerNew[-which(OnlineRetailCustomerNew$ItemPerVisit<loI),]
CusItemClean <- OnlineRetailCustomerNew[-which(OnlineRetailCustomerNew$ItemPerVisit>hiI),]
boxplot(CusItemClean$ItemPerVisit)
CusTotalClean <- CusRevClean[-which(CusRevClean$ItemPerVisit>hiI),]
ggpairs(CusTotalClean[,which(names(CusTotalClean)!="CustomerID")],upper = list(continous = ggally_points), lower = list(continous = "points"))
CusTotalClean.scale = scale(CusTotalClean[-1])
withinSSrange <- function(data,low,high,maxIter)
  {
    withinss=array(0,dim=c(high-low+1));
    for(i in low:high)
    {
      withinss[i-low+1] <-kmeans(data,i,maxIter)$tot.withinss
    }
    withinss
  }
plot(withinSSrange(CusTotalClean.scale,1,50,150))
plot(withinSSrange(ProTotalClean.Scale,1,50,150))
Cuskm = kmeans(CusTotalClean.scale,6,150)
CusTotalclean.realCenters = unscale(Cuskm$centers,CusTotalClean.scale)
clusteredCus = cbind(CusTotalClean,Cuskm$cluster)
plot(clusteredCus[,2:6],col=Cuskm$cluster)
Cuskm
CusTotalclean.realCenters

library(MASS)
library(fpc)
summary(OnlineRetailProductNew)
OnlineRetailProductNew = OnlineRetailProductNew[1:1958,]
boxplot(OnlineRetailProductNew$RevenuePerVisit)
boxplot(OnlineRetailProductNew$TotalCustomer)
boxplot(OnlineRetailProductNew$Revenue)
boxplot(OnlineRetailProductNew$TotalVisit)
ProTotalClean <- OnlineRetailProductNew
ProTotalClean <- ProTotalClean[-which(ProTotalClean$RevenuePerVisit>700),]
ggpairs(ProTotalClean[,which(names(ProTotalClean)!="StockCode")],upper = list(continous = ggally_points), lower = list(continous = "points"))
ProTotalClean.Scale= scale(ProTotalClean[-1])
plot(withinSSrange(ProTotalClean.Scale,1,50,150))
Prokm = kmeans(ProTotalClean.Scale,5,150)
ProTotalClean.realCenters = unscale(Prokm$centers,ProTotalClean.Scale)
clusteredPro = cbind(ProTotalClean,Prokm$cluster)
plot(clusteredPro[,2:5],col=Prokm$cluster)
 plotcluster(clusteredPro[,2:5],Prokm$cluster,pch = Prokm$cluster,clvecd = c(1,2,3,4,5,6),col = c("red","blue","green","purple","black","orange"))
 summary(clusteredPro)
clusteredPro
Prokm
ProTotalClean.realCenters
