CREATE TABLE if not exists `region` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `parent_id` int(10) unsigned NOT NULL DEFAULT '0',
  `region_name` varchar(120) NOT NULL DEFAULT '',
  `region_type` tinyint(1) NOT NULL DEFAULT '2',
  `agency_id` smallint(5) unsigned NOT NULL DEFAULT '0',
  `areaid` varchar(11) DEFAULT NULL,
  `zip` varchar(11) DEFAULT NULL,
  `code` varchar(11) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `parent_id` (`parent_id`),
  KEY `region_type` (`region_type`),
  KEY `agency_id` (`agency_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;



create table if not exists `homepage` (
  id int unsigned not null auto_increment,
  type int unsigned not null DEFAULT 0,
  target_id int unsigned not null,
  rank int unsigned not null DEFAULT 0,
  created_at int unsigned,
  updated_at int unsigned,
  primary key(id)
)engine=InnoDB default charset=utf8;

create table if not exists banner(
	id int unsigned not null auto_increment,	-- id
	target_id int unsigned , 	-- 目标id
	link varchar(255), -- 外链
  type int unsigned not null default 0, -- 0 外链 1 专题  2  线上活动  3 线下活动
  img varchar(1000) ,		-- 封面
  rank int unsigned not null default 1,
	created_at int unsigned,	-- 创建时间
	updated_at int unsigned,	-- 最后修改时间
	primary key(id)
)engine=InnoDB default charset=utf8mb4;


create table if not exists top_set(
	id int unsigned not null auto_increment,	-- id
  type int unsigned not null default 0, -- 0 行动者 1 公众人物  2  企业
  count int unsigned not null default 0,
	created_at int unsigned,	-- 创建时间
	updated_at int unsigned,	-- 最后修改时间
	primary key(id)
)engine=InnoDB default charset=utf8mb4;

create table if not exists run_group(
	id int unsigned not null auto_increment,	-- id
	user_id int unsigned not null,	-- 用户id
	name varchar(255) not null ,
	introduction text not null ,
	head varchar(255) not null ,

	title varchar(255),
	en_title varchar(255),

	province int unsigned not null, -- 省
	city int unsigned not null,	-- 市
	region int unsigned not null,	-- 区


  benefit_walk smallint unsigned default 0, -- 益行  若为0 则表示 没有此行动
  benefit_run smallint unsigned default 0, -- 益跑  若为0 则表示 没有此行动
  benefit_bike smallint unsigned default 0, -- 益骑  若为0 则表示 没有此行动

	created_at int unsigned,	-- 创建时间
	updated_at int unsigned,	-- 最后修改时间

	foreign key(user_id) references user(id) on delete cascade on update cascade,
	foreign key(province) references region(id) on delete cascade on update cascade,
	foreign key(city) references region(id) on delete cascade on update cascade,
	foreign key(region) references region(id) on delete cascade on update cascade,
	primary key(id)
)engine=InnoDB default charset=utf8mb4;

create table if not exists run_group_img(
	id int unsigned not null auto_increment,	-- id
	run_group_id int unsigned not null,
	src varchar(255) not null ,
	cover int unsigned not null default 0 , -- 1为封面
	created_at int unsigned,	-- 创建时间
	updated_at int unsigned,	-- 最后修改时间

	foreign key(run_group_id) references run_group(id) on delete cascade on update cascade,
	primary key(id)
)engine=InnoDB default charset=utf8mb4;

create table if not exists top_run_group(
	id int unsigned not null auto_increment,	-- id
	run_group_id int unsigned not null,
	rank int unsigned not null default 1,
	created_at int unsigned,	-- 创建时间
	updated_at int unsigned,	-- 最后修改时间

	foreign key(run_group_id) references run_group(id) on delete cascade on update cascade,
	primary key(id)
)engine=InnoDB default charset=utf8mb4;

create table if not exists `recruit` (
  id int unsigned not null auto_increment,
  user_id int unsigned not null ,
  status int unsigned not null default 0,
  type int unsigned not null default 0,

  document_type varchar(255) ,
  idcard varchar(255) ,
  gender int unsigned not null default 0,
  company varchar(255) ,
  position varchar(255),
  remark text,

  enterprise_name varchar(255),
  profile text,

  number varchar(255),

  name varchar(100) ,
  country_area varchar(255),
  host_city varchar(255),
  mobile varchar(50)  ,
  email varchar(100),
  address text,

  created_at int unsigned,
  updated_at int unsigned,
  foreign key(user_id) references user(id) on delete cascade on update cascade,
  primary key(id)
)engine=InnoDB default charset=utf8;



