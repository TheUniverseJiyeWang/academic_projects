#!/usr/bin/env python3
# -*- coding: utf-8 -*-
"""
Created on Sat Aug  3 16:33:48 2019

@author: jiyewang
"""

from efficient_apriori import apriori
import pandas as pd
from graphviz import Digraph
import csv

data = []

#with open('FuTeaShop_Sale.csv','r') as csvFile:
#    reader = csv.reader(csvFile)
#    for row in reader:
#        data.append([row[0],row[3]])
        
#with open('Shop_Order.csv','r') as csvFile:
#    reader = csv.reader(csvFile)
#    for row in reader:
#        data.append([row[1],row[5]])
        
#with open('Sales_Canada1.csv','r') as csvFile:
#    reader = csv.reader(csvFile)
#    for row in reader:
#        data.append([row[1],row[17]])
        
with open('Sales_Canada2.csv','r') as csvFile:
    reader = csv.reader(csvFile)
    for row in reader:
        data.append([row[11],row[17]])
        
#data = data[1:]
transaction = []
tmp = 0
tmpbsk = []

for row in data:
    if row[0] != tmp:
        transaction.append(tmpbsk)
        tmp = row[0]
        tmpbsk = []
        tmpbsk.append(row[1])
    else:
        tmpbsk.append(row[1])
        
count = 0


transactions = transaction[1:]

for row in transactions:
    if len(row) > 1:
        count = count +1
        
print(count)

#itemsets, rules = apriori(transactions, min_support=0.0005,  min_confidence=0.2)
itemsets, rules = apriori(transactions, min_support=0.0035,  min_confidence=0.2)
print(rules)
#print(itemsets)

rule_dt = []
for row in rules:
#    print(row.lhs,row.rhs,row.support,row.confidence,row.lift)
    rule_dt.append([row.lhs,row.rhs,row.support,row.confidence,row.lift])
    
df = pd.DataFrame(rule_dt, columns = ['item1','item2','support','confidence','lift'])
pd.set_option('display.max_columns', None)
pd.set_option('display.max_rows', None)
print(rule_dt)
print(df)
df.to_csv('rules.csv')

#rules_rhs = filter(lambda rule: len(rule.lhs) == 2 and len(rule.rhs) == 1, rules)
#for rule in sorted(rules_rhs, key=lambda rule: rule.lift):
#  print(rule)