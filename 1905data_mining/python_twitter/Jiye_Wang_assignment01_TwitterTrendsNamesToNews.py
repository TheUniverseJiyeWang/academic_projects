#!/usr/bin/env python3
# -*- coding: utf-8 -*-
"""
Created on Mon Jun 17 19:11:31 2019

@author: jiyewang
"""

import tweepy as twt
from geopy.geocoders import Nominatim
from newsapi import NewsApiClient

consumer_key = 'V8OuzQ...gEV4f'
consumer_secret = '7p33wOIG...H9zx'
access_token_secret = 's6Oab7RTorfT...MIrUb4uUjvij8D'
newsapi_key = '2db...dd87d707fe9'
newsapi = NewsApiClient(api_key=newsapi_key)

auth = twt.OAuthHandler(consumer_key, consumer_secret)
auth.set_access_token(access_token, access_token_secret)
api = twt.API(auth)

print("Please enter the place you want to search for treand words and related news")
place_name = input()
gps = Nominatim()
location = gps.geocode(place_name)

place = api.trends_closest(location.latitude,location.longitude)
print(place)
place_id = place[0]['woeid']
trends_raw = api.trends_place(place_id)

print(trends_raw)
trends_records = trends_raw[0]['trends']
trends_names = [trend['name'] for trend in trends_records]

print(trends_names)

for num in range(0,10):
    topic_raw = trends_names[num]
    if topic_raw[0:1] == '#':
        topic = topic_raw[1:]
    else:
        topic = topic_raw
    print(topic)
    top_headlines = newsapi.get_top_headlines(q=topic,
#                                          sources='google-news',
                                          language='en')
    print(top_headlines)
