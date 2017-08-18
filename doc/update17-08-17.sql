create table if not exists walk(
	id int unsigned not null auto_increment,	-- id
  user_id int unsigned not null ,
  count int unsigned not null default 0,
	created_at int unsigned,	-- 创建时间
	updated_at int unsigned,	-- 最后修改时间
  foreign key(user_id) references user(id) on delete cascade on update cascade,
	primary key(id)
)engine=InnoDB default charset=utf8mb4;

create table if not exists run_group_join(
	id int unsigned not null auto_increment,	-- id
  user_id int unsigned not null ,
  run_group_id int unsigned not null ,
	created_at int unsigned,	-- 创建时间
	updated_at int unsigned,	-- 最后修改时间
  foreign key(user_id) references user(id) on delete cascade on update cascade,
  foreign key(run_group_id) references run_group(id) on delete cascade on update cascade,
	primary key(id)
)engine=InnoDB default charset=utf8mb4;

create table if not exists link(
	id int unsigned not null auto_increment,	-- id
  type int unsigned not null default 0 ,
  link varchar(255) not null  ,
	created_at int unsigned,	-- 创建时间
	updated_at int unsigned,	-- 最后修改时间
	primary key(id)
)engine=InnoDB default charset=utf8mb4;

create table if not exists run_group_praise(
	id int unsigned not null auto_increment,	-- id
  user_id int unsigned not null ,
  run_group_joiner int unsigned not null ,
  run_group int unsigned not null ,
	created_at int unsigned,	-- 创建时间
	updated_at int unsigned,	-- 最后修改时间
  foreign key(user_id) references user(id) on delete cascade on update cascade,
  foreign key(run_group_joiner) references user(id) on delete cascade on update cascade,
  foreign key(run_group) references run_group(id) on delete cascade on update cascade,
	primary key(id)
)engine=InnoDB default charset=utf8mb4;


alter table user add age int unsigned not null DEFAULT 0;
alter table user add school varchar(255);
alter table user add inauguration_status int unsigned not null DEFAULT 0; -- 就职状态 0 在校 1 在职 2 其他