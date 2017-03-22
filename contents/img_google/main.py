#!/usr/bin/env python
# -*- coding: utf-8 -*-

from Tkinter import *
import urllib2
import os
import time
from bs4 import BeautifulSoup
import key_set
import google_correlate
import get_images

class Main:
	#초기 선언
	def __init__(self, keySet, sleep_time):
		self.keySet = keySet
		self.sleep_time = sleep_time
		self.key_set = []
		self.TotalImages = []

		# 쓰레드 생성
		self.search_key_sum = 0
		self.search_img_sum = 0
		for a in range(self.keySet.dep + 1):
			an = pow(int(self.keySet.corr_cnt), int(a))
			self.search_key_sum += an
		self.search_img_sum = self.search_key_sum * self.keySet.img_count

	# 공백으로 자른뒤 _삽입(폴더용)
	def key_setting(self, key):
		key = key.split()
		key = '_'.join(key)
		return key

	# -1: 없음 -2:에러 그외:이미지수 리턴
	def findImg(self):
		first_dep_num = 0
		next_key_set = []
		images = []
		str_tmp = ""
		img_len = 0

		self.key_set.append(self.keySet)
		next_key_set.append(self.keySet)

		for a in range(int(self.keySet.dep) + 1):
			# 검색어 받아서 *연관검색어 검색 후 배열로 리턴
			if a != 0:
				self.correlate = google_correlate.Correlate(next_key_set, self.keySet.corr_cnt, self.keySet.land_sel)
				next_key_set = self.correlate.set_correlate()
				self.key_set.extend(next_key_set)

			# 연관검색어가 없을 경우
			if next_key_set == []:
				self.keySet.dep -= 1
				break

			# print next_key_set

			# 검색어 셋으로 이미지 검색 후 배열로 리턴
			self.crawler = get_images.Crawler(next_key_set, self.keySet.img_count)
			images = self.crawler.img_crawl()
			self.TotalImages.extend(images)

			# print images

			# 이미지 파일로 저장
			for b in range(len(next_key_set)):
				first_num = (b * self.keySet.img_count)
				self.img_print(next_key_set[b], first_num, images)

			# 검색어 저장 폼
			for c in range(len(next_key_set)):
				str_tmp += "{0:^20}".format(next_key_set[c].key) + "\n"
			str_tmp += "{0:=^30}".format("Depth : " + str(a)) + "\n"

		# 검색어 파일로 저장
		self.key_print(self.keySet.key, str_tmp)

		for i in range(len(self.TotalImages)):
			if self.TotalImages[i][0] != None:
				img_len += 1

		return img_len

	def img_print(self, keySet, first_num, images):
		DIR = "./Pictures"
		image_type = "ActiOn"
		header = {'User-Agent':"Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/43.0.2357.134 Safari/537.36"}

		if keySet.key != None:
			# make Dir (Main Folder)
			if not os.path.exists(DIR):
				os.makedirs(DIR)
			# 첫 출력
			if keySet.parents_key == []:
				DIR = os.path.join(DIR, self.key_setting(keySet.key))
				if not os.path.exists(DIR):
					os.mkdir(DIR)
			else:
				# 프린팅 시간간격
				time.sleep(self.sleep_time)

				for a in range(len(keySet.parents_key)):
					# 검색어 키 상위 폴더
					DIR = os.path.join(DIR, self.key_setting(keySet.parents_key[a]))
					if not os.path.exists(DIR):
						os.mkdir(DIR)
				# 검색어 폴더
				DIR = os.path.join(DIR, self.key_setting(keySet.key))
				if not os.path.exists(DIR):
					os.mkdir(DIR)

			for i in range(first_num, first_num+self.keySet.img_count):
				img , Type = images[i][0], images[i][1]

				try:
					req = urllib2.Request(img, headers={'User-Agent' : header})
					raw_img = urllib2.urlopen(req).read()

					cntr = len([i for i in os.listdir(DIR) if image_type in i]) + 1

					if len(Type)==0:
						file_name = image_type + "_"+ str(cntr)+".jpg"
						f = open(os.path.join(DIR , file_name), 'wb')
					else :
						file_name = image_type + "_"+ str(cntr)+"."+Type
						f = open(os.path.join(DIR , file_name), 'wb')

					f.write(raw_img)
					f.close()

				except Exception as e:
					pass
					# print "could not load : "+ str(img)
					# print e

	def key_print(self, key, file_str):
		DIR = "./Keyword"

		if not os.path.exists(DIR):
			os.mkdir(DIR)

		file_name = str(key) + ".txt"

		f = open(os.path.join(DIR, file_name), 'wb')
		f.write(file_str)
		f.close()


