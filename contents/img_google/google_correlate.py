#!/usr/bin/env python
# -*- coding: utf-8 -*-

import urllib2
import copy
import re
from bs4 import BeautifulSoup
import key_set

class Correlate:
	def __init__(self, key_set, corr_cnt, land_sel):
		self.key_set = key_set
		self.corr_cnt = corr_cnt
		self.land_sel = land_sel
		self.header = {'User-Agent':"Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/43.0.2357.134 Safari/537.36"}

		# 빈 검색어
		self.null_set = []
		for i in range(self.corr_cnt):
			self.null_set.append(None)

	def get_soup(self, url):
		return BeautifulSoup(urllib2.urlopen(urllib2.Request(url,headers=self.header)),'html.parser')

	# 공백으로 자른뒤 +삽입(구글용)
	def key_setting(self, key):
		key = key.split()
		key = '+'.join(key)
		return key

	# get_correlate
	def get_correlate(self, keySet):
		next_key_set = []
		# &p=us : United States &p=de : Deutschland
		url = "https://www.google.com/trends/correlate/search?e="+self.key_setting(keySet.key)+"&t=weekly&p="+self.land_sel

		while(1):
			try:
				soup = self.get_soup(url)
				for a in soup.find_all("li", {"class":"result","style":""}, limit=int(self.corr_cnt)):
					tmp = copy.deepcopy(keySet)
					tmp.parents_key = keySet.key

					# a["event"] = re.sub(ur'[\p{Arabic}\p{Han}\p{Hangul}\p{Thai}\p{Cyrillic}]+', "", a["event"]) # 영어만 처리
					if not a["event"] or a["event"] == " ":
						tmp.key = None
					else:
						tmp.key = a["event"]

					next_key_set.append(tmp)
				break
			except Exception as e:
				continue

		return next_key_set

	# 검색어 추출 시작점
	def set_correlate(self):
		next_key_set = []

		for a in range(len(self.key_set)):
			if not self.key_set[a].key:
				next_key_set.extend(self.null_set)
			else:
				next_key_set.extend(self.get_correlate(self.key_set[a]))
		return next_key_set



