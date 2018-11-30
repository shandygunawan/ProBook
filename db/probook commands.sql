
CREATE DATABASE ProBook;

DROP TABLE IF EXISTS User;
CREATE TABLE User
(
  UserID INT NOT NULL AUTO_INCREMENT,
  Name TEXT NOT NULL,
  Username TEXT NOT NULL,
  Email TEXT NOT NULL,
  Password TEXT NOT NULL,
  Address TEXT NOT NULL,
  PhoneNumber TEXT NOT NULL,
  CardNumber VARCHAR(20) NOT NULL,
  PicturePath TEXT NOT NULL,
  PRIMARY KEY (UserID)
);

/* Create Table for Access token */
DROP TABLE IF EXISTS AccessToken;
CREATE TABLE AccessToken
(
  TokenID VARCHAR(10) NOT NULL,
  ExpiryTime DATETIME NOT NULL,
  Browser TEXT NOT NULL,
  IpAddress TEXT NOT NULL,
  UserID INT NOT NULL,
  PRIMARY KEY (TokenID),
  FOREIGN KEY (UserID) REFERENCES User(UserID)
);

/* Create Table for Access token for Google Sign in */
DROP TABLE IF EXISTS AccessTokenGoogle;
CREATE TABLE AccessTokenGoogle
(
  TokenID VARCHAR(10) NOT NULL,
  ExpiryTime DATETIME NOT NULL,
  Browser TEXT NOT NULL,
  IpAddress TEXT NOT NULL,
  UserID VARCHAR(255) NOT NULL,
  PRIMARY KEY (TokenID)
);

INSERT INTO User(Name, Username, Email, Password, Address, PhoneNumber, CardNumber, PicturePath) VALUES ("Shandy Gunawan", "higgsfield", "shandy.gunawan@rocketmail.com", "shandygunawan", "Cisitu", "08989898797", "1234123412341234", "/asset/user_img/higgsfield.jpg");