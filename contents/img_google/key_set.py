# -*- coding: utf-8 -*-

class Key:
	def __init__(self):
		self._key = None
		self._parents_key = []
		self._img_count = 0
		self._corr_cnt = 0
		self._dep = 0
		self._land_sel = None
		self._print_sel = None

	@property
	def key(self):
		return self._key

	@key.setter
	def key(self, value):
		self._key = value

	@property
	def parents_key(self):
		return self._parents_key

	@parents_key.setter
	def parents_key(self, value):
		self._parents_key.append(value)

	@property
	def img_count(self):
		return self._img_count

	@img_count.setter
	def img_count(self, value):
		self._img_count = value

	@property
	def corr_cnt(self):
		return self._corr_cnt

	@corr_cnt.setter
	def corr_cnt(self, value):
		self._corr_cnt = value

	@property
	def dep(self):
		return self._dep

	@dep.setter
	def dep(self, value):
		self._dep = value

	@property
	def land_sel(self):
		return self._land_sel

	@land_sel.setter
	def land_sel(self, value):
		self._land_sel = value

	@property
	def print_sel(self):
		return self._print_sel

	@print_sel.setter
	def print_sel(self, value):
		self._print_sel = value

