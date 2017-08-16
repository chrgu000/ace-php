
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