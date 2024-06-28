create database if not exists i088omor;
use i088omor;
drop table if exists photo; 
create table photo ( 
 account char(12) not null, 
 filename varchar(255) not null, 
 date datetime, 
 lat double, 
 lng double, 
 alt double, 
 comment varchar(255), 
 primary key(account, filename) 
);
