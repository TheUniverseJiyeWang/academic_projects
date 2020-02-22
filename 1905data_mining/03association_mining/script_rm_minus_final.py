#!/usr/bin/env python3
# -*- coding: utf-8 -*-
"""
Created on Wed Jun 19 15:56:40 2019

@author: jiyewang
"""
import MySQLdb

with open('product_detail_minus','r') as neg:
    neg_records = neg.readlines()
    
