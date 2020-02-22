library(caret)
library('tseries')
library("forecast")

#15 min for 16:00 each day
raw_min=read.csv("~/Desktop/Courses/Data_and_Text_Mining/A4/MT123electricityMin.csv", sep=',', header=T)
head(raw_min)
tail(raw_min)
raw_value_min=raw_min[,2]
head(raw_value_min,10)
df_min <- data.frame(matrix(unlist(raw_value_min), ncol=7, byrow=T),stringsAsFactors=FALSE)
df_min = df_min[1:50,]
head(df_min,10)
x_min=df_min[,1:6]
y_min=df_min[,7]
head(x_min,10)

myCvControl <- trainControl(method = "repeatedCV",
                            number=10,
                            repeats = 5)

# Linear regression
glmFitTime_min <- train(X7 ~ .,
                    data = df_min,
                    method = "glm",
                    preProc = c("center", "scale"),
                    tuneLength = 10,
                    trControl = myCvControl)
glmFitTime_min
summary(glmFitTime_min)
y_pre_min_glm = predict(glmFitTime_min, newdata = x_min)
mape_min_glm=mean(100*abs(y_pre_min_glm-y_min)/y_min)
mape_min_glm

# Support Vector Regression
svmFitTime_min <- train(X7 ~ .,
                    data = df_min,
                    method = "svmRadial",
                    preProc = c("center", "scale"),
                    tuneLength = 10,
                    trControl = myCvControl)
svmFitTime_min
summary(svmFitTime_min)
y_pre_min_svm = predict(svmFitTime_min, newdata = x_min)
mape_min_svm=mean(100*abs(y_pre_min_svm-y_min)/y_min)
mape_min_svm

# Neural Network
nnFitTime_min <- train(X7 ~ .,
                   data = df_min,
                   method = "avNNet",
                   preProc = c("center", "scale"),
                   trControl = myCvControl,
                   tuneLength = 10,
                   linout = T,
                   trace = F,
                   #MaxNWts = 10 * (ncol(df_min) + 1) + 10 + 1,
                   MaxNWts = 1000,
                   maxit = 100)
nnFitTime_min
summary(nnFitTime_min)
y_pre_min_nn = predict(nnFitTime_min, newdata = x_min)
mape_min_nn=mean(100*abs(y_pre_min_nn-y_min)/y_min)
mape_min_nn

# Compare models
resamps_min <- resamples(list(lm = glmFitTime_min,
                          svn = svmFitTime_min,
                          nn = nnFitTime_min))
summary(resamps_min)

#Time Series
t_min = raw_value_min[1:500]
tSeries_min=ts(t_min,start = 1, frequency = 7)
plot(tSeries_min) 
plot(stl(tSeries_min,s.window="periodic"))
ar_min <- Arima(tSeries_min,order=c(7,0,7))
summary(ar_min)
mape_min_ar=mean(100*abs(fitted(ar_min) - tSeries_min)/tSeries_min)
mape_min_ar

#Hourly for each hour
raw_hr=read.csv("~/Desktop/Courses/Data_and_Text_Mining/A4/MT123electricityHour.csv", sep=',', header=T)
head(raw_hr)
tail(raw_hr)
raw_value_hr=raw_hr[,2]
head(raw_value_hr,10)
df_hr <- data.frame(matrix(unlist(raw_value_hr), ncol=24, byrow=T),stringsAsFactors=FALSE)
df_hr = df_hr[1:50,]
head(df_hr,10)
x_hr=df_hr[,1:23]
y_hr=df_hr[,24]

myCvControl <- trainControl(method = "repeatedCV",
                            number=10,
                            repeats = 5)

# Linear regression
glmFitTime_hr <- train(X24 ~ .,
                        data = df_hr,
                        method = "glm",
                        preProc = c("center", "scale"),
                        tuneLength = 10,
                        trControl = myCvControl)
glmFitTime_hr
summary(glmFitTime_hr)
y_pre_hr_glm = predict(glmFitTime_hr, newdata = x_hr)
mape_hr_glm=mean(100*abs(y_pre_hr_glm-y_hr)/y_hr)
mape_hr_glm

# Support Vector Regression
svmFitTime_hr <- train(X24 ~ .,
                        data = df_hr,
                        method = "svmRadial",
                        preProc = c("center", "scale"),
                        tuneLength = 10,
                        trControl = myCvControl)
svmFitTime_hr
summary(svmFitTime_hr)
y_pre_hr_svm = predict(svmFitTime_hr, newdata = x_hr)
mape_hr_svm=mean(100*abs(y_pre_hr_svm-y_hr)/y_hr)
mape_hr_svm

# Neural Network
nnFitTime_hr <- train(X24 ~ .,
                       data = df_hr,
                       method = "avNNet",
                       preProc = c("center", "scale"),
                       trControl = myCvControl,
                       tuneLength = 10,
                       linout = T,
                       trace = F,
                       #MaxNWts = 10 * (ncol(df_min) + 1) + 10 + 1,
                       MaxNWts = 1000,
                       maxit = 100)
nnFitTime_hr
summary(nnFitTime_hr)
y_pre_hr_nn = predict(nnFitTime_hr, newdata = x_hr)
mape_hr_nn=mean(100*abs(y_pre_hr_nn-y_hr)/y_hr)
mape_hr_nn


# Compare models
resamps_hr <- resamples(list(lm = glmFitTime_hr,
                             svn = svmFitTime_hr,
                             nn = nnFitTime_hr))
summary(resamps_hr)

#Time Series
t_hr = raw_hr[1:1000,2]
tSeries_hr=ts(t_hr,start = 1, frequency = 24)
plot(tSeries_hr) 
plot(stl(tSeries_hr,s.window="periodic"))
ar_hr <- Arima(tSeries_hr,order=c(24,0,24))
summary(ar_hr)
mape_hr_ar=mean(100*abs(fitted(ar_hr) - tSeries_hr)/tSeries_hr)
mape_hr_ar

#Daily for each day
raw_d=read.csv("~/Desktop/Courses/Data_and_Text_Mining/A4/MT123electricityDate.csv", sep=',', header=T)
head(raw_d)
tail(raw_d)
raw_value_d=raw_d[,2]
head(raw_value_d,10)
df_d <- data.frame(matrix(unlist(raw_value_d), ncol=7, byrow=T),stringsAsFactors=FALSE)
df_d = df_d[1:50,]
head(df_d,10)
x_d=df_d[,1:6]
y_d=df_d[,7]

myCvControl <- trainControl(method = "repeatedCV",
                            number=10,
                            repeats = 5)

# Linear regression
glmFitTime_d <- train(X7 ~ .,
                       data = df_d,
                       method = "glm",
                       preProc = c("center", "scale"),
                       tuneLength = 10,
                       trControl = myCvControl)
glmFitTime_d
summary(glmFitTime_d)
y_pre_d_glm = predict(glmFitTime_d, newdata = x_d)
mape_d_glm=mean(100*abs(y_pre_d_glm-y_d)/y_d)
mape_d_glm

# Support Vector Regression
svmFitTime_d <- train(X7 ~ .,
                       data = df_d,
                       method = "svmRadial",
                       preProc = c("center", "scale"),
                       tuneLength = 10,
                       trControl = myCvControl)
svmFitTime_d
summary(svmFitTime_d)
y_pre_d_svm = predict(svmFitTime_d, newdata = x_d)
mape_d_svm=mean(100*abs(y_pre_d_svm-y_d)/y_d)
mape_d_svm

# Neural Network
nnFitTime_d <- train(X7 ~ .,
                      data = df_d,
                      method = "avNNet",
                      preProc = c("center", "scale"),
                      trControl = myCvControl,
                      tuneLength = 10,
                      linout = T,
                      trace = F,
                      #MaxNWts = 10 * (ncol(df_min) + 1) + 10 + 1,
                      MaxNWts = 1000,
                      maxit = 100)
nnFitTime_d
summary(nnFitTime_d)
y_pre_d_nn = predict(nnFitTime_d, newdata = x_d)
mape_d_nn=mean(100*abs(y_pre_d_nn-y_d)/y_d)
mape_d_nn


# Compare models
resamps_d <- resamples(list(lm = glmFitTime_d,
                             svn = svmFitTime_d,
                             nn = nnFitTime_d))
summary(resamps_d)

resamps_all <- resamples(list(lm_min = glmFitTime_min,
                              svn_min = svmFitTime_min,
                              nn_min = nnFitTime_min,
                              lm_hr = glmFitTime_hr,
                              svn_hr = svmFitTime_hr,
                              nn_hr = nnFitTime_hr,
                              lm_d = glmFitTime_d,
                            svn_d = svmFitTime_d,
                            nn_d = nnFitTime_d))
summary(resamps_all)

#Time Series
t_d = raw_d[1:500,2]
tSeries_d=ts(t_d,start = 1, frequency = 7)
plot(tSeries_d) 
plot(stl(tSeries_d,s.window="periodic"))
ar_d <- Arima(tSeries_d,order=c(7,0,7))
summary(ar_d)
mape_d_ar=mean(100*abs(fitted(ar_d) - tSeries_d)/tSeries_d)
mape_d_ar
