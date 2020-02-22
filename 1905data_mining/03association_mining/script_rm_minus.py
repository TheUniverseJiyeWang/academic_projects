#!/usr/bin/env python3
# -*- coding: utf-8 -*-
"""
Created on Wed Jun 19 10:13:12 2019

@author: jiyewang
"""

import csv
import pandas as pd
from pandas import DataFrame,Series

csv_file1 = "product_detail_minus.csv"
csv_data1 = pd.read_csv(csv_file1, low_memory = False)
minus_df = pd.DataFrame(csv_data1)

csv_file2 = "product_detail_all.csv"
csv_data2 = pd.read_csv(csv_file2, low_memory = False)
product_df = pd.DataFrame(csv_data2)

pos_df = minus_df
pos_df['Quantity'] = pos_df['Quantity'].map(lambda x: x*(-1))

product_drop = minus_df.append(pos_df)
product_drop = product_drop.drop(columns=['InvoiceNo','InvoiceDate','InvoiceDateTime'])
productN_df = product_df.drop(columns=['InvoiceNo','InvoiceDate','InvoiceDateTime'])

#drop_flag = product_df['StockCode','Description','Quantity','UnitPrice','CustomerID'].isin(product_drop)
product_drop = product_drop.drop_duplicates()

drop_flag = productN_df.isin(product_drop)
diff_flag = [not f for f in drop_flag]
res = productN_df[diff_flag]


#product_new = open('product_clean.csv','w',newline='')
#product_writer = csv.writer(product_new)