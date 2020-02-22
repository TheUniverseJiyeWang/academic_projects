#!/usr/bin/env python3
# -*- coding: utf-8 -*-
"""
Created on Mon Jun 17 19:11:31 2019

@author: jiyewang
"""

import tweepy as twt
from geopy.geocoders import Nominatim
from newsapi import NewsApiClient

consumer_key = 'V8Ouz...F3rgEV4f'
consumer_secret = '7p33wOIGT...GhFBB0VA68CK3M'
access_token = '11407237137...sYBpwEsRZqzIH9zx'
access_token_secret = 's6O...gMIrUb4uUjvij8D'
api_key = '2db...7d707fe9'
newsapi = NewsApiClient(api_key=api_key)

auth = twt.OAuthHandler(consumer_key, consumer_secret)
auth.set_access_token(access_token, access_token_secret)
api = twt.API(auth)

print("Please enter the place you want to search for treand words and related news")
place_name = input()
gps = Nominatim()
location = gps.geocode(place_name)

place = api.trends_closest(location.latitude,location.longitude)
place_id = place[0]['woeid']
trends_raw = api.trends_place(place_id)


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
