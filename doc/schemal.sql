/*管理员表*/
create table if not exists admin_user (
	id int unsigned not null auto_increment,	-- 用户id
	username varchar(50) not null,		-- 登录名
	password_hash varchar(100) not null, -- 登录密码
	nickname varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci not null,	-- 用户昵称，可能有一些表情符啥的
	password_reset_token varchar(100), -- 重置密码
	auth_key varchar(100) not null,	-- cookie auth
	status tinyint unsigned not null default 10,	-- 激活状态
	`group` tinyint unsigned default 0,	-- 管理员分组
	created_at int unsigned,	-- 创建时间
	updated_at int unsigned,	-- 最后修改时间
	primary key(id),
	unique (username)
)engine=InnoDB default charset=utf8;

create table if not exists `user`(
  id int unsigned not null auto_increment,
  nickname varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci not null, -- 用户昵称，可能有一些表情符啥的
  username varchar(50),
  type smallint unsigned default 0 , -- 0 手机号 注册 1 邮箱注册
  avatar varchar(200) ,
  access_token varchar(500) not null,
  password_hash varchar(100),
  password_reset_token varchar(100),
  auth_key varchar(100) not null,
  open_id varchar(500),
  union_id varchar(500),
  gender SMALLINT unsigned default 0,
  created_at int unsigned ,
  updated_at int unsigned,
  primary key(id)
)engine=InnoDB default charset=utf8;

create table if not exists `topic` (
  id int unsigned not null auto_increment,
  cover varchar(100),
  title varchar(100),
  created_at int unsigned,
  updated_at int unsigned,
  primary key(id)
)engine=InnoDB default charset=utf8;

create table if not exists `activity` (
  id int unsigned not null auto_increment,
  topic_id int unsigned,
  cover varchar(100),
  title varchar(100),
  en_title varchar(100), -- 英文标题
  location varchar(100), -- 城市
  en_location varchar(100),
  start_time int unsigned,
  end_time int unsigned ,
  join_type smallint unsigned default 0, -- 0 线下 1 线上 2 两者都可以
  people_num int unsigned default 0, -- 报名人数
  `desc` text , -- 简介
  en_desc text ,  -- 英文简介
  price decimal(10,2), -- 报名价格
  benefit_walk smallint unsigned default 0, -- 益行 公里数 若为0 则表示 没有此行动
  benefit_run smallint unsigned default 0, -- 益跑 公里数 若为0 则表示 没有此行动
  benefit_bike smallint unsigned default 0, -- 益骑 公里数 若为0 则表示 没有此行动
  created_at int unsigned,
  updated_at int unsigned,
  foreign key(topic_id) references topic(id) on delete set null on update cascade,
  primary key(id)
)engine=InnoDB default charset=utf8;