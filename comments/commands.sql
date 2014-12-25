create database php_bookshare;
grant all on php_bookshare.* to 'book_dbuser'@'localhost' identified by '7n4Ety';
use php_bookshare

create table comments (
    id int not null auto_increment primary key,
    user_id int,
    name varchar(255),
    comment varchar(512),
    created datetime
);