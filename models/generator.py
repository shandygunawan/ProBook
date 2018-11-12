import codecs, re, os

def esc(text):
	return re.escape(text)

def readToArray(array, filename):
	with codecs.open(filename, "r", encoding = "utf_8") as f:
		for text in f.readlines():
			temp = text.encode('utf_8').decode().strip() 
			array.append(temp)

def createQueryBooks(titles, author, synopsis, picpath):
	temp = []
	query = """INSERT INTO Book VALUES ("", '{}', '{}', '{}', '{}');"""
	for i in range(len(min(titles, author, synopsis))):
		t = query.format(esc(titles[i]), esc(author[i]), esc(synopsis[i]), esc(picpath[i]))
		temp.append(t)
	return temp

def writeQuery(filename, data):
	with codecs.open(filename, "w", encoding = "utf_8") as f:
		for query in data:
			temp = query.encode('utf_8').decode().strip() 
			f.write(temp + "\n")

def generateUser(nama, user, email, password, address, phone):
	temp = []
	picpath = "/asset/user_img/{}.jpg".format(user)
	temp.append(esc(nama))
	temp.append(esc(user))
	temp.append(esc(email))
	temp.append(esc(password))
	temp.append(esc(address))
	temp.append((phone))
	temp.append(esc(picpath))
	return temp

def generateOrder(amount, date, userid, bookid):
	temp = []
	temp.append(amount)
	temp.append(date)
	temp.append(userid)
	temp.append(bookid)
	return temp

def createOrderQuery(data):
	query = """INSERT INTO BookOrder VALUES ("", '{0}', '{1}', '{2}', '{3}');"""
	return query.format(*data)

def createUserQuery(data):
	query = """INSERT INTO User VALUES ("", '{0}', '{1}', '{2}', '{3}', '{4}', '{5}', '{6}');"""
	return query.format(*data)

def generateReview(score, comment, userid, bookid, orderid):
	temp = []
	temp.append(score)
	temp.append(esc(comment))
	temp.append(userid)
	temp.append(bookid)
	temp.append(orderid)
	return temp

def createReviewQuery(data):
	query = """INSERT INTO Review VALUES ('{0}', '{1}', '{2}', '{3}', '{4}');"""
	return query.format(*data)

titles = []
author = []
synopsis = []
picpath = []

readToArray(titles, "models/title.txt")
readToArray(author, "models/author.txt")
readToArray(synopsis, "models/synopsis.txt")
readToArray(picpath, "models/picpath.txt")
t = createQueryBooks(titles, author, synopsis, picpath)

user = []
user1 = generateUser("Ihsan M. A.", "ihsansaktia", "ihsan.saktia@gmail.com", "aingbukanwibutq", "Jalan Bangbayang", "085778522258")
user.append(createUserQuery(user1))

order = []
order1 = generateOrder(10, 0, 1, 5)
order2 = generateOrder(100, int(1e8), 1, 5)
user.append(createOrderQuery(order1))
user.append(createOrderQuery(order2))

review = []
review1 = generateReview(5, "I love Shiraishi <3", 1, 5, 1)
review2 = generateReview(5, "", 1, 5, 2)
user.append(createReviewQuery(review1))
user.append(createReviewQuery(review2))


writeQuery("models/out", t + user + order + review)


