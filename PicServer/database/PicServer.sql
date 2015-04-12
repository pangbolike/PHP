drop database picserver;
create database picserver default character set utf8 collate utf8_general_ci;
use picserver;
create table picinfo(
	pic_id int(11) primary key auto_increment,
	openid varchar(32) not null,
	pic_info varchar(512) not null default '',
	upload_time int(11) unsigned NOT NULL DEFAULT 0
)ENGINE=InnoDB AUTO_INCREMENT=1000 DEFAULT CHARSET=utf8;
ALTER TABLE picinfo ADD INDEX PicInfoOpenidIndex (openid);