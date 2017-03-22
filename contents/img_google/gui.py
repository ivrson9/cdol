# -*- coding: utf-8 -*-

from Tkinter import *
import tkMessageBox
import threading
from PIL import ImageTk, Image  # pillow 로 하면 설치하면 py2app에서 에러가 난다
import serial
import time
import os
import key_set
import main


class Interface:
	def __init__(self, Master):
		self.country_sel=StringVar()
		self.print_sel=StringVar()
		self.master = Master
		self.master.geometry('800x450')
		self.keySet = key_set.Key()

		self.print_sel=StringVar()
		self.print1 = "RICOH_SP_150"
		self.print2 = "RICOH_SP_150_2"
		self.count = 0

		# MainFrame

		self.mainFrame = Frame(self.master, background="gray17")
		self.mainFrame.pack(fill=X)

		# titleFrame

		self.titleFrame = Frame(self.mainFrame, background="gray17")
		self.titleFrame.pack(side=TOP, fill=X)

		self.titleLabel = Label(self.titleFrame, background="gray17")
		self.titleLabel.configure(text='INTER[FACE]', foreground="white", font="SourceCodePro-Medium 50")
		self.titleLabel.pack(padx=40, pady=40)

		# selectFrame (Country)
		self.selectCountryFrame = Frame(self.mainFrame, background="gray17")
		self.selectCountryFrame.pack(side=TOP)

		# self.selectCountryLabel = Label(self.selectCountryFrame, background="gray17")
		# self.selectCountryLabel.configure(text='Country: ', foreground="white", font="SourceCodePro-Medium")
		# self.selectCountryLabel.pack(side=LEFT)

		self.selectCountryRadio1 = Radiobutton(self.selectCountryFrame, variable=self.country_sel, value="us", background="gray17")
		self.selectCountryRadio1.pack(side=LEFT)

		self.selectCountryRadio1Label = Label(self.selectCountryFrame, background="gray17")
		self.selectCountryRadio1Label.configure(text="USA", foreground="white")
		self.selectCountryRadio1Label.pack(side=LEFT, padx=10, pady=5)

		self.selectCountryRadio2 = Radiobutton(self.selectCountryFrame, variable=self.country_sel, value="de", background="gray17")
		self.selectCountryRadio2.pack(side=LEFT)

		self.selectCountryRadio2Label = Label(self.selectCountryFrame, background="gray17")
		self.selectCountryRadio2Label.configure(text="German", foreground="white")
		self.selectCountryRadio2Label.pack(side=LEFT, padx=10, pady=5)

		self.country_sel.set("us")

		# selectFrame (print)

		self.selectPrintFrame = Frame(self.mainFrame, background="gray17")
		self.selectPrintFrame.pack(side=TOP)

		# self.selectPrintLabel = Label(self.selectPrintFrame, background="gray17")
		# self.selectPrintLabel.configure(text='Print: ', foreground="white", font="SourceCodePro-Medium")
		# self.selectPrintLabel.pack(side=LEFT)

		self.selectPrintRadio1 = Radiobutton(self.selectPrintFrame, variable=self.print_sel, value=self.print1, background="gray17")
		self.selectPrintRadio1.pack(side=LEFT)

		self.selctPrintRadio1Label = Label(self.selectPrintFrame, background="gray17")
		self.selctPrintRadio1Label.configure(text="L    ", foreground="white")
		self.selctPrintRadio1Label.pack(side=LEFT, padx=10, pady=5)

		self.selectPrintRadio2 = Radiobutton(self.selectPrintFrame, variable=self.print_sel, value=self.print2, background="gray17")
		self.selectPrintRadio2.pack(side=LEFT)

		self.selctPrintRadio2Label = Label(self.selectPrintFrame, background="gray17")
		self.selctPrintRadio2Label.configure(text="R         ", foreground="white")
		self.selctPrintRadio2Label.pack(side=LEFT, padx=10, pady=5)

		self.print_sel.set(self.print1)

		# keyFrame

		self.keyFrame = Frame(self.mainFrame, background="gray17")
		self.keyFrame.pack(side=TOP, fill=X)

		self.keyEntry = Entry(self.keyFrame, background="gray17")
		self.keyEntry.configure(width=25, foreground="white", insertbackground="white", font="SourceCodePro-Medium 20")
		self.keyEntry.pack(padx=20, pady=20)

		# countFrame

		self.countFrame = Frame(self.mainFrame, background="gray17")
		self.countFrame.pack(side=TOP)

		# self.img_cntLabel = Label(self.countFrame, background="gray17")
		# self.img_cntLabel.configure(text='I.C', foreground="white", font="SourceCodePro-Medium")
		# self.img_cntLabel.pack(side=LEFT, padx=3, pady=10)

		self.img_cntEntry = Entry(self.countFrame, background="gray17")
		self.img_cntEntry.configure(width=5, foreground="white")
		self.img_cntEntry.pack(side=LEFT, padx=3, pady=10)

		# self.corr_cntLabel = Label(self.countFrame, background="gray17")
		# self.corr_cntLabel.configure(text='C.C', foreground="white", font="SourceCodePro-Medium")
		# self.corr_cntLabel.pack(side=LEFT, padx=3, pady=10)

		self.corr_cntEntry = Entry(self.countFrame, background="gray17")
		self.corr_cntEntry.configure(width=5, foreground="white")
		self.corr_cntEntry.pack(side=LEFT, padx=3, pady=10)

		# self.depthLabel = Label(self.countFrame, background="gray17")
		# self.depthLabel.configure(text='Dep', foreground="white", font="SourceCodePro-Medium")
		# self.depthLabel.pack(side=LEFT, padx=3, pady=10)

		self.depthEntry = Entry(self.countFrame, background="gray17")
		self.depthEntry.configure(width=5, foreground="white")
		self.depthEntry.pack(side=LEFT, padx=3, pady=10)

		# self.sleepLabel = Label(self.countFrame, background="gray17")
		# self.sleepLabel.configure(text='T.M', foreground="white", font="SourceCodePro-Medium")
		# self.sleepLabel.pack(side=LEFT, padx=3, pady=10)

		self.sleepEntry = Entry(self.countFrame, background="gray17")
		self.sleepEntry.configure(width=5, foreground="white")
		self.sleepEntry.pack(side=LEFT, padx=3, pady=10)

		# ButtonFrame

		self.buttonFrame = Frame(self.mainFrame, background="gray17")
		self.buttonFrame.pack(side=TOP, fill=X)

		self.findButton = Button(self.buttonFrame, command=self.findThreadingStart)
		self.findButton.configure(text='▽', width=30, highlightbackground="gray17")
		self.findButton.pack(padx=7, pady=5)

		# self.startButton = Button(self.buttonFrame, command=self.startThreadingStart)
		# self.startButton.configure(text='Start', width=20)
		# self.startButton.pack(side=LEFT, padx=7, pady=5)

		# self.stopButton = Button(self.buttonFrame, command=self.stopCrawling)
		# self.stopButton.configure(text='Stop', width=30, highlightbackground="gray17")
		# self.stopButton.pack(side=LEFT, padx=7, pady=5)

		# Notification Frame

		self.notificationFrame = Frame(self.mainFrame, background="gray17")
		self.notificationFrame.pack(side=TOP, fill=X)

		self.notification1Frame = Frame(self.notificationFrame, background="gray17")
		self.notification1Frame.pack(side=LEFT, fill=X)

		self.number1Label = Label(self.notification1Frame, background="gray17")
		self.number1Label.pack(side=LEFT, padx=10, pady=5)

		self.numberview1Label = Label(self.notification1Frame, background="gray17")
		self.numberview1Label.pack(side=LEFT, padx=10, pady=5)

		self.notification2Frame = Frame(self.notificationFrame, background="gray17")
		self.notification2Frame.pack(side=RIGHT, fill=X)

		self.number2Label = Label(self.notification2Frame, background="gray17")
		self.number2Label.pack(side=LEFT, padx=10, pady=5)

		self.numberview2Label = Label(self.notification2Frame, background="gray17")
		self.numberview2Label.pack(side=LEFT, padx=10, pady=5)

		# self.notificationButton = Button(self.notificationFrame, command=self.help)
		# self.notificationButton.configure(text = 'Help')
		# self.notificationButton.pack(side=RIGHT, padx=10, pady=5)

		# Warning Frame

		self.warningFrame = Frame(self.mainFrame, background="gray17")
		self.warningFrame.pack(side=TOP, fill=X)

		self.warning1Frame = Frame(self.warningFrame, background="gray17")
		self.warning1Frame.pack(side=LEFT, fill=X)

		self.warning1Label = Label(self.warning1Frame, background="gray17")
		self.warning1Label.pack(side=LEFT, padx=10)

		self.warning2Frame = Frame(self.warningFrame, background="gray17")
		self.warning2Frame.pack(side=RIGHT, fill=X)

		self.warning2Label = Label(self.warning2Frame, background="gray17")
		self.warning2Label.pack(side=LEFT, padx=10)

		# Bluetooth Connect
		print("Start")
		port="/dev/cu.TEST1-DevB" #This will be different for various devices and on windows it will probably be a COM port.
		#self.bluetooth=serial.Serial(port, 9600)#Start communications with the bluetooth unit
		print("Connected")
		self.bluetooth = None

	def findThreadingStart(self):
		self.findThread = threading.Thread(target=self.findImage)
		self.findThread.start()

	def findImage(self):
		self.keySet.key = self.keyEntry.get()

		if self.keySet.key == "":
			self.warningLabel.configure(text='[*] Please input keywords!', foreground="white")
			return

		self.keySet.img_count = self.img_cntEntry.get()
		try:
			self.keySet.img_count  = int(self.keySet.img_count)
			if self.keySet.img_count == 0:
				if self.print_sel.get() == self.print1:
					self.warning1Label.configure(text='[*] Please input lager then 0 in Image Count form', foreground="white")
				else:
					self.warning2Label.configure(text='[*] Please input lager then 0 in Image Count form', foreground="white")
				return
		except:
			if self.print_sel.get() == self.print1:
				self.warning1Label.configure(text='[*] Please input only INTEGER in Image Count form!', foreground="white")
			else:
				self.warning2Label.configure(text='[*] Please input only INTEGER in Image Count form!', foreground="white")
			return

		self.keySet.corr_cnt = self.corr_cntEntry.get()
		try:
			self.keySet.corr_cnt = int(self.keySet.corr_cnt)
		except:
			if self.print_sel.get() == self.print1:
				self.warning1Label.configure(text='[*] Please input only INTEGER in Correlate Count form!', foreground="white")
			else:
				self.warning2Label.configure(text='[*] Please input only INTEGER in Correlate Count form!', foreground="white")

			return

		self.keySet.dep = self.depthEntry.get()
		try:
			self.keySet.dep  = int(self.keySet.dep )
		except:
			if self.print_sel.get() == self.print1:
				self.warning1Label.configure(text='[*] Please input only INTEGER in Depth Number form!', foreground="white")
			else:
				self.warning2Label.configure(text='[*] Please input only INTEGER in Depth Number form!', foreground="white")

			return

		sleep_time = self.sleepEntry.get()
		try:
			sleep_time = int(sleep_time)
		except:
			if self.print_sel.get() == self.print1:
				self.warning1Label.configure(text='[*] Please input only INTEGER in Sleep Time form!', foreground="white")
			else:
				self.warning2Label.configure(text='[*] Please input only INTEGER in Sleep Time form!', foreground="white")

			return

		self.keySet.land_sel = self.country_sel.get()
		self.keySet.print_sel = self.print_sel.get()


		# 창 확장
		if self.count == 0:
			self.process_page()
			self.count += 1

		if self.print_sel.get() == self.print1:
			# 메인 키 bluetooth로 전달
			#self.bluetooth.write(b"K1" + str(key))

			self.warning1Label.configure(text='[*] Finding Images...', foreground="white")
			self.number1Label.configure(text='Images found : ', background="gray17", foreground="white")
			self.numberview1Label.configure(text='N/A', background="gray17", foreground="white")

			self.main = main.Main(self.keySet, self.bluetooth, self.process1Text, self.imageLabel, sleep_time)
			self.number1 = self.main.findImg()

			if self.number1 == -1:
				self.warning1Label.configure(text='[*] No such Tag, please use other Tag', foreground="white")
				return
			elif self.number1 == -2:
				self.warning1Label.configure(text='[*] Exception occured. Please feedback to developer.', foreground="white")
				return
			self.numberview1Label.configure(text=str(self.number1))
			self.warning1Label.configure(text='[*] Finding Images finished', foreground="white")
		else:
			# 메인 키 bluetooth로 전달
			#self.bluetooth.write(b"K2" + str(key))

			self.warning2Label.configure(text='[*] Finding Images...', foreground="white")
			self.number2Label.configure(text='Images found : ', background="gray17", foreground="white")
			self.numberview2Label.configure(text='N/A', background="gray17", foreground="white")

			self.main = main.Main(self.keySet, self.bluetooth, self.process2Text, self.imageLabel, sleep_time)
			self.number2 = self.main.findImg()

			if self.number2 == -1:
				self.warning2Label.configure(text='[*] No such Tag, please use other Tag', foreground="white")
				return
			elif self.number2 == -2:
				self.warning2Label.configure(text='[*] Exception occured. Please feedback to developer.', foreground="white")
				return
			self.numberview2Label.configure(text=str(self.number2))
			self.warning2Label.configure(text='[*] Finding Images finished', foreground="white")


	# def startThreadingStart(self):
	# 	self.startThread = threading.Thread(target=self.startCrawling)
	# 	self.startThread.start()

	# def startCrawling(self):
	# 	self.warningLabel.configure(text='[*] Crawling Started')
	# 	try:
	# 		num = self.countEntry.get()
	# 		if num=="MAX":
	# 			num = self.number
	# 		else:
	# 			try:
	# 				num = int(num)
	# 			except:
	# 				self.warningLabel.configure(text='[*] Please input only INTEGER in number form!')
	# 				return

	# 			if num > self.number:
	# 				num = self.number
	# 		self.crawler.start(num)
	# 	except:
	# 		self.warningLabel.configure(text="[*] Please do 'Find' before 'Start'!")
	# 		return

	def process_page(self):
		DIR = os.path.join(os.path.expanduser('~'), "Desktop/Pictures")

		# self.master.geometry('1000x1000')
		root.attributes('-fullscreen', True)

		self.processFrame = Frame(self.mainFrame, background="gray17")
		self.processFrame.pack(side=TOP)

		self.process1Frame = Frame(self.processFrame, background="gray17")
		self.process1Frame.pack(side=LEFT)

		self.process1Text = Text(self.process1Frame, width=90, height=80, background="gray17", insertbackground="white")
		self.process1Text.configure(foreground="white")
		self.process1Text.pack(fill=X, padx=5, pady=5)

		self.imageFrame = Frame(self.processFrame, background="gray17")
		self.imageFrame.pack(side=LEFT)

		photo = ImageTk.PhotoImage(Image.open(DIR + "/logo.png"))
		self.imageLabel = Label(self.imageFrame, image=photo, width=400, height=500)
		self.imageLabel.image = photo # keep a reference!
		self.imageLabel.pack()

		self.process2Frame = Frame(self.processFrame, background="gray17")
		self.process2Frame.pack(side=RIGHT)

		self.process2Text = Text(self.process2Frame, width=90, height=80, background="gray17", insertbackground="white")
		self.process2Text.configure(foreground="white")
		self.process2Text.pack(fill=X, padx=5, pady=5)

	def stopCrawling(self):
		self.warningLabel.configure(text="[*] It can't be used!!", foreground="white")

	def help(self):
		helpString = """        [Usage]
1. Input the keywords in the box. (ex: car)
2. Input the image count you want to crawl.
  Input the correlate count you want to crawl.
  Input the depth count you want to crawl.
  !! Too many count (like above 100) can take many time.
  !! So please be careful.
3. Click the Find button, and wait for finishing.
4. After finished, input the number you want to crawl.
  If there's anything or number is greater than (3),
  It's automatically set as the maximum(3's number).
  If you want to crawl all of them, input 'MAX'.
5. Click the Start Button, and wait for finishing.
=============================================
This Program was made by Cdol.
It's made up of Python 2.7.10, with Tkinter, BeautifulSoup.
Please Feedback : ivrson9@gmail.com"""
		tkMessageBox.showinfo("Images_Crawler::Help",helpString)

root = Tk()
root.title("Crawler")
root.geometry("600x800+400+200")
root.configure(background="gray17")
#최대화 root.attributes('-fullscreen', True)
myApp = Interface(root)
root.mainloop()
