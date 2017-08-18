alter table user add age int unsigned not null DEFAULT 0;
alter table user add school varchar(255);
alter table user add inauguration_status int unsigned not null DEFAULT 0; -- 就职状态 0 在校 1 在职 2 其他
alter table user add province int unsigned not null ;
alter table user add city int unsigned not null ;
alter table user add sign text;
