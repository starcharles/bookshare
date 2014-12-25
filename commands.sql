create database php_bookshare;
grant all on php_bookshare.* to 'book_dbuser'@'localhost' identified by '7n4Ety';
use php_bookshare
 
create table books (
    id int not null auto_increment primary key,
    title varchar(255),
    author varchar(255),
    year int(4),
    category varchar(255) default '未分類' ,
    recommend text,
    ownerid int ,
    created datetime,
    modified datetime
);

create table users (
    id int not null auto_increment primary key,
    name varchar(255),
    email varchar(255) unique,
    password varchar(255),
    created datetime,
    modified datetime
);

create table users (
    id int not null auto_increment primary key,
    tw_user_id int(20),
    tw_screen_name varchar(255),
    tw_access_token varchar(255),
    tw_access_token_secret varchar(255),
    name varchar(255),
    email varchar(255) unique,
    password varchar(255),
    created datetime,
    modified datetime
);

insert into books 

insert into books
                (title,author,year,category,recommend,ownerid,created,modified)
                values 
                ("shajj","steven",1986,NULL,'これは非常に良い',1,NULL,NULL);

insert into books
                (title,author,year,recommend,ownerid)
                values 
                ("shajj","steven",1986,'これは非常に良い',1);