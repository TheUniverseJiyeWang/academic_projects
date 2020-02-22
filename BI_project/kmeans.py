#!/usr/bin/env python3
# -*- coding: utf-8 -*-
"""
Created on Wed Aug  7 10:56:37 2019

@author: jiyewang
"""

import numpy as np
import csv
from sklearn.cluster import KMeans
import pandas as pd
import seaborn as sns

data = []
sum0 = 0
sum1 = 0
sum2 = 0
sum3 = 0

with open('customers.csv','r') as csvFile:
    reader = csv.reader(csvFile)
    for row in reader:
        data.append([row[0],row[1],row[2],row[3]])
        sum0 = sum0+float(row[0])
        sum1 = sum1+float(row[1])
        sum2 = sum2+float(row[2])
        sum3 = sum3+float(row[3])
        
avg0 = sum0/795
avg1 = sum1/795
avg2 = sum2/795
avg3 = sum3/795
        
c_names = ['OrderNumber','totalSales','totalProfit','totalProduct']
cluster = pd.DataFrame(data)
cluster[0] = cluster[0].map(lambda x: float(x)/avg0)
cluster[1] = cluster[1].map(lambda x: float(x)/avg1)
cluster[2] = cluster[2].map(lambda x: float(x)/avg2)
cluster[3] = cluster[3].map(lambda x: float(x)/avg3)

num_clusters = 6
km_cluster = KMeans(n_clusters=num_clusters, max_iter=300, n_init=40, \
                    init='k-means++',n_jobs=-1)

result = km_cluster.fit_predict(cluster)
print(result)

cluster_result = pd.DataFrame(data, columns= ['orderNumber','totalSales','totalProfit','totalProduct'])
cluster_result['new_col'] = result

sns.pairplot(cluster_result, hue = "new_col")

