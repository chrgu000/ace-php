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

-- create table if not exists `activity` (
--   id int unsigned not null auto_increment,
--   topic_id int unsigned,
--   cover varchar(100),
--   title varchar(100),
--   en_title varchar(100), -- 英文标题
--   start_time int unsigned,
--   people_num int unsigned default 0, -- 报名人数
--   created_at int unsigned,
--   updated_at int unsigned,
--   foreign key(topic_id) references topic(id) on delete set null on update cascade,
--   primary key(id)
-- )engine=InnoDB default charset=utf8;


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

create table if not exists `online_activity` (
  id int unsigned not null auto_increment,
  activity_id int unsigned not null ,
  location varchar(100), -- 城市
  en_location varchar(100),
  end_time int unsigned ,
  people_num int unsigned default 0, -- 报名人数
  `desc` text , -- 简介
  en_desc text ,  -- 英文简介
  price decimal(10,2), -- 报名价格
  benefit_walk_min smallint unsigned default 0,
  benefit_run_min smallint unsigned default 0,
  benefit_bike_min smallint unsigned default 0,
  benefit_walk_max smallint unsigned default 0, -- 益行 公里数 若为0 则表示 没有此行动
  benefit_run_max smallint unsigned default 0, -- 益跑 公里数 若为0 则表示 没有此行动
  benefit_bike_max smallint unsigned default 0, -- 益骑 公里数 若为0 则表示 没有此行动
  created_at int unsigned,
  updated_at int unsigned,
  foreign key(activity_id) references activity(id) on delete cascade on update cascade,
  primary key(id)
)engine=InnoDB default charset=utf8;

create table if not exists `offline_activity` (
  id int unsigned not null auto_increment,
  activity_id int unsigned not null ,
  location varchar(100), -- 城市
  en_location varchar(100),
  end_time int unsigned ,
  people_num int unsigned default 0, -- 报名人数
  `desc` text , -- 简介
  en_desc text ,  -- 英文简介
  price decimal(10,2), -- 报名价格
  benefit_walk_min smallint unsigned default 0,
  benefit_walk_max smallint unsigned default 0, -- 益行 公里数 若为0 则表示 没有此行动
  created_at int unsigned,
  updated_at int unsigned,
  foreign key(activity_id) references activity(id) on delete cascade on update cascade,
  primary key(id)
)engine=InnoDB default charset=utf8;

create table if not exists `online` (
  id int unsigned not null auto_increment,
  user_id int unsigned not null ,
  activity_id int unsigned not null,
  online_activity_id int unsigned not null,
  status int unsigned not null default 0,

  name varchar(100) not null,
  gender int unsigned not null default 0,
  mobile varchar(50) not null ,
  address text,

  benefit_walk smallint unsigned default 0, -- 益行 公里数 若为0 则表示 没有此行动
  benefit_run smallint unsigned default 0, -- 益跑 公里数 若为0 则表示 没有此行动
  benefit_bike smallint unsigned default 0, -- 益骑 公里数 若为0 则表示 没有此行动
  created_at int unsigned,
  updated_at int unsigned,
  foreign key(user_id) references user(id) on delete cascade on update cascade,
  foreign key(activity_id) references activity(id) on delete cascade on update cascade,
  foreign key(online_activity_id) references online_activity(id) on delete cascade on update cascade,
  primary key(id)
)engine=InnoDB default charset=utf8;


create table if not exists `offline` (
  id int unsigned not null auto_increment,
  user_id int unsigned not null ,
  activity_id int unsigned not null,
  offline_activity_id int unsigned not null,
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


  benefit_walk smallint unsigned default 0, -- 益行 公里数 若为0 则表示 没有此行动
  created_at int unsigned,
  updated_at int unsigned,
  foreign key(user_id) references user(id) on delete cascade on update cascade,
  foreign key(activity_id) references activity(id) on delete cascade on update cascade,
  foreign key(offline_activity_id) references offline_activity(id) on delete cascade on update cascade,
  primary key(id)
)engine=InnoDB default charset=utf8;

create table if not exists `order` (
	id int unsigned not null auto_increment,	-- 订单id
	type int unsigned not null ,
	target_id int unsigned not null,
	sn varchar(50) not null, 	-- 订单sn
	time int unsigned not null,	-- 订单时间
	status int unsigned not null default 0,	-- 订单状态
	hidden int unsigned not null default 0, -- 删除 1不可见 0可见
	amount decimal(15,2) not null,		-- 总金额
	paid_amount decimal(15,2) not null default 0,		-- 使用第三方支付的金额
	pay_type tinyint unsigned,	-- 第三方支付类型
	pay_platform tinyint unsigned,	-- 第三方支付发起平台
	pay_trade_no varchar(100),	-- 第三方流水号
	pay_time int unsigned,	-- 支付成功时间
	refund_status int unsigned not null default 0,	-- 退款状态
	refund_paid decimal(15,2) not null default 0,    -- 第三方退款金额
  buyer_id int unsigned ,	-- 买家id
	created_at int unsigned,	-- 创建时间
	updated_at int unsigned,	-- 最后修改时间
	primary key(id),
	foreign key(buyer_id) references user(id) on delete SET NULL on update cascade
)engine=InnoDB default charset=utf8;


