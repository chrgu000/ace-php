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
  avatar varchar(200) ,
  access_token varchar(500) not null,
  password_reset_token varchar(100),
  auth_key varchar(100) not null,
  open_id varchar(500),
  union_id varchar(500),
  gender SMALLINT unsigned default 0,
  city varchar(100) , -- 工作城市
  created_at int unsigned ,
  updated_at int unsigned,
  primary key(id)
)engine=InnoDB default charset=utf8;