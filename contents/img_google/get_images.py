#!/usr/bin/env python
# -*- coding: utf-8 -*-

import urllib2
import json
from bs4 import BeautifulSoup

class Crawler:
	def __init__(self, key_set, count):
		self.key_set = key_set
		self.count = count
		self.images = []
		self.header = {'User-Agent':"Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/43.0.2357.134 Safari/537.36"}

		# 빈 이미지
		self.null_set = []
		for i in range(self.count):
			self.null_set.append((None, None))

	# 공백으로 자른뒤 +삽입(구글용)
	def key_setting(self, key):
		key = key.split()
		key = '+'.join(key)
		return key

	def get_soup(self, url):
		return BeautifulSoup(urllib2.urlopen(urllib2.Request(url,headers=self.header)),'html.parser')

	# Google Crwaling (i = 배열번호)
	def img_crawl(self):
		for a in range(len(self.key_set)):
			if self.key_set[a].key != None:
				key = self.key_setting(self.key_set[a].key)
				url = "https://www.google.de/search?q="+key+"&tbm=isch&source=lnt&tbs=itp:face"
				# Normal
				# https://www.google.com/search?q="+key+"&source=lnms&tbm=isch
				# 라인아트 & 흑백
				# https://www.google.de/search?q=+key+&tbs=ic:gray,itp:lineart&tbm=isch
				# 얼굴 컬러
				# https://www.google.de/search?q=geometry&tbm=isch&source=lnt&tbs=itp:face

				while(1):
					try:
						soup = self.get_soup(url)
						for b in soup.find_all("div", {"class":"rg_meta"}, limit=int(self.count)):
							link , Type = json.loads(b.text)["tu"], json.loads(b.text)["ity"]
							try:
								self.images.append((link,Type))
							except IOError as e:
								return -2
						break
					except Exception as e:
						continue
			else:
				self.images.extend(self.null_set)

		return self.images
