import csv

def findp(string,word):
	a=[]
	count=0
	string = string.replace('.','')
	string = string.replace(',','')
	a=string.split(" ")
	for i in range(0,len(a)):
	      if(word==a[i]):
	            count=count+1
	return count


arr = []

with open('movie_data.csv', 'r') as csvFile:
    reader = csv.reader(csvFile)
    for row in reader:
        arr.append(row)

csvFile.close()

print len(arr)
c = 0

filtered =[]

for row in arr:
	if(findp(row[7],'divorce') >= 2):
		c = c + 1
		print row[0] + '   ' + row[1] +'   '+ str(findp(row[7],'divorce')) + "\n"
		


print c

