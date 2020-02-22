#!/usr/bin/env python3
# -*- coding: utf-8 -*-
"""
Created on Wed Jul  3 18:43:53 2019

@author: jiyewang
"""
import nltk
from re import split
from nltk.corpus import stopwords
import pandas as pd

stopWords = set(stopwords.words('english'))
stopWords.add('``')
stopWords.add('<')
stopWords.add('br')
stopWords.add('/')
stopWords.add('>')
stopWords.add('.')
stopWords.add('!')
stopWords.add("''")
stopWords.add('-')
stopWords.add('(')
stopWords.add(')')

documents = []
read_file = "./IMDB_Dataset.csv"

with open(read_file,"r",encoding="utf-8",errors="ignore") as r:
    c = 0
    for line in r:
        splitted = line.strip().split(',') 
        review = (' ').join(splitted[:-1])
        sentiment = splitted[-1]
        documents.extend([ dict(doc=review.lower(), category=sentiment)])
        c = c+1

print(c)

documents.remove(documents[0])

test_documents = documents

print(len(test_documents))

test_index = dict()


for n in range(len(test_documents)):
    tmpwords = nltk.word_tokenize(test_documents[n]['doc'])
    tmpwords_index = {}
    for s in tmpwords:
        if s[-1] == '.':
            s = s.replace('.','')
        if s not in stopWords:
            if s in tmpwords_index:
                tmpwords_index[s] += 1
            else:
                tmpwords_index[s] = 1
    for s1 in tmpwords_index:
        if s1 in test_index:
            test_index[s1].append(dict(index_num=n,rank_score=tmpwords_index[s1]))
        else:
            test_index[s1]=[dict(index_num=n,rank_score=tmpwords_index[s1])]
                
# For the second time, please run from here or it will take quite a long time!
            
final_results = dict()

print("Please enter the keywords you want to search for movie comments.")
search_key = input()
search_key = search_key.lower()
search_keys = split('\W+', search_key)
print(search_keys)

for key in search_keys:
    if key in test_index:
        tmpresults = test_index[key]
        for i in tmpresults:
            tmpindex_num = i['index_num']
            tmpnew_key = str(tmpindex_num)+"th"
            tmprank_score = i['rank_score']
            tmpcomment = test_documents[tmpindex_num]['doc']
            if tmpnew_key in final_results:
                tmprank_scores = final_results[tmpnew_key][0]['rank_scores']
                final_results[tmpnew_key][0]['rank_scores'] = tmprank_scores + tmprank_score + 100
            else:
                final_results[tmpnew_key] = [dict(comment=tmpcomment,rank_scores=tmprank_score)]

final_results_value = final_results.values()

new_final_results = []

for n in final_results_value:
    for s in n:
        new_final_results.append(s)
        
results_frame = pd.DataFrame(columns=['comment','rank_scores'])

for i in range(len(new_final_results)):
    rank = new_final_results[i]['rank_scores']
    comment = new_final_results[i]['comment']
    results_frame = results_frame.append(pd.DataFrame({'comment':comment,'rank_scores':rank}, index = [i]))

results_frame.sort_values(by='rank_scores',inplace=True,ascending=False)
print(results_frame)

results_frame.to_csv("./results.csv",index_label="index_label")