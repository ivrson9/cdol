// DB 생성 & 유저생성
CREATE DATABASE KAFFE;
CREATE USER 'cdol'@'localhost' identified by 'xkznal86';
GRANT ALL PRIVILEGES ON cdol.* to cdol@localhost;

// List Table (Rating default 10)
// wifi : none, restricted, not free, free
// power : none, a few, several
create table cafe (
  no int unsigned not null primary key auto_increment,
  name varchar(100) not null,
  country varchar(100),
  city varchar(100),
  zipcode varchar(10),
  address text,
  latitude double,
  longitude double,
  rating double unsigned,
  wifi int unsigned default 0,
  power int unsigned default 0,
  opening_hours text,
  google_id varchar(200),
  isDel boolean default false
  etc text
);
INSERT INTO `cafe`(`name`, `address`, `latitude`, `longitude`) VALUES ('westberlin bar&shop', 'Friedrichstraße 215, 10969 Berlin', 52.505666, 13.390473 );

// cafe User ( 0: local , 1: google , 2:facebook)
create table cafe_user (
  id varchar(100) NOT NULL,
  email varchar(50) NOT NULL primary key,
  name varchar(50),
  photo varchar(100),
  bookmark text not null,
  signupChannel int unsigned,
  isDel boolean DEFAULT false
);

// Comment
create table cafe_comment (
  comment_no int unsigned not null primary key auto_increment,
  id varchar(20) not null,
  comment text not null,
  rating double unsigned,
  comment_date datetime not null,
  cafe_no int unsigned not null,
  isDel boolean default false
);

// Cafe Add List
// isDone : not, error, complate
create table cafe_add (
  add_no int unsigned not null primary key auto_increment,
  name varchar(100) not null,
  address text,
  wifi int unsigned default 0,
  power int unsigned default 0,
  isDone int unsigned default 0
);


SELECT *,	(6371*acos(cos(radians(52.522486))*cos(radians(latitude))*cos(radians(longitude)-radians(13.409629))+sin(radians(52.522486))*sin(radians(latitude))))
AS distance
FROM cafe
HAVING distance <= 1
ORDER BY distance
LIMIT 0,1000