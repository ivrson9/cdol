import key_set
import main
import sys

keySet = key_set.Key()

keySet.key = sys.argv[1]
keySet.img_count = int(sys.argv[2])
keySet.corr_cnt = int(sys.argv[3])
keySet.dep = int(sys.argv[4])
keySet.land_sel = str(sys.argv[5])
sleep_time = int(sys.argv[6])

main = main.Main(keySet, sleep_time)
main.findImg()
