// DB 생성 & 유저생성
CREATE DATABASE cdol;
CREATE USER 'cdol'@'localhost' identified by 'xkznal86';
GRANT ALL PRIVILEGES ON cdol.* to cdol@localhost;

// 세션 테이블
CREATE TABLE IF NOT EXISTS `ci_sessions` (
  `id` varchar(40) NOT NULL,
  `ip_address` varchar(45) NOT NULL,
  `timestamp` int(10) unsigned DEFAULT 0 NOT NULL,
  `data` blob NOT NULL,
  PRIMARY KEY (id),
  KEY `ci_sessions_timestamp` (`timestamp`)
);

// user 테이블 생성
CREATE TABLE `user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `email` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `created` datetime NOT NULL,
  `name` varchar(50) NOT NULL,
  `level` int(11) DEFAULT 0 NOT NULL,
  `point` int(11) DEFAULT 100 NOT NULL,
  `isDel` boolean DEFAULT false,
  PRIMARY KEY (`id`),
  UNIQUE KEY `email_idx` (`email`)
);


// 메뉴 테이블 생성
create table service (
  s_no int unsigned not null primary key auto_increment,
  s_id varchar(100) not null,
  s_title varchar(100) not null,
  s_content text not null,
  s_url varchar(100) not null,
  s_date datetime not null,
  m_cnt int unsigned not null default 0,
  isDel boolean default false
);
INSERT INTO `service`(`s_id`, `s_title`, `s_content`, `s_date`) VALUES ('Home', 'Home','home', CURRENT_TIMESTAMP)

// 2단 메뉴 테이블 생성
create table menu (
  m_no int unsigned not null primary key auto_increment,
  s_no int unsigned not null,
  m_id varchar(100) not null,
  m_title varchar(100) not null,
  m_content text not null,
  m_url varchar(100) not null,
  m_date datetime not null,
  m_type varcha(1) not null,
  isDel boolean default false
);
INSERT INTO `menu`(`m_title`, `m_content`, `s_no`,`m_date`) VALUES ('Board','board', 1, CURRENT_TIMESTAMP);

// 게시판 테이블 생성
create table board (
  b_no int unsigned not null primary key auto_increment,
  b_title varchar(100) not null,
  b_content text not null,
  b_date datetime not null,
  b_hit int unsigned not null default 0,
  id varchar(20) not null,
  ip_address varchar(45) NOT NULL,
  b_password varchar(100) not null,
  isDel boolean default false
);
INSERT INTO `board`(`b_title`, `b_content`, `b_date`, `b_hit`, `id`, `b_password`) VALUES ('123', '1231232131231', CURRENT_TIMESTAMP, 0, '', '');

// 댓글 테이블 생성
create table comment (
  comment_no int unsigned not null primary key auto_increment,
  id varchar(20) not null,
  comment text not null,
  c_date datetime not null,
  m_name varchar(100) not null,
  b_no int unsigned not null,
  isDel boolean default false
);

// 게시판 페이징 쿼리
SELECT * FROM `board_free` order by b_date desc LIMIT 0, 20 (처음페이지 20개만 가져오기)

// 게시판 첨부파일
CREATE TABLE fileUpload (
    f_no int unsigned not null primary key auto_increment,
    b_no int unsigned not null,
    b_title varchar(100) not null,
    f_date datetime not null,
    save_name varchar(200),
    original_name varchar(200),
    isDel boolean default false
);

// MEMO 테이블
CREATE TABLE memo (
  m_no int unsigned not null primary key auto_increment,
  id varchar(20) not null,
  send_id varchar(20) not null,
  memo text not null,
  send_date datetime not null,
  read_date datetime,
  isRead boolean default false,
  isDel boolean default false
);
