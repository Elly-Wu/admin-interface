
# 主題活動
create table activity(
aty_id int not null primary key auto_increment,
aty_name varchar(20),
start_time timestamp,
end_time timestamp,
create_time timestamp not null default now(),
jin_id int,
foreign key(jin_id) references address_book(sid) on delete cascade,
jin_name varchar(255),
pdo_id int,
foreign key(pdo_id) references products(sid) on delete cascade,
pdo_name varchar(100),
pdo_price int,
pdo_count int not null default '0'
);



insert into activity(aty_name, start_time, end_time, jin_id, jin_name, pdo_id, pdo_name, pdo_price, pdo_count)
values
('網紅標配', null, null, 5, '李小明4', 27, '蘋果筆記型電腦Pro 16', 1999, 80),
('網紅標配', null, null, 5, '李小明4', 28, '索尼 PlayStation 5', 499, 50),
('網紅標配', null, null, 6, '李小明5', 29, '任天堂 Switch', 299, 150),
('母親節', '2024-05-07 18:00:00', '2024-05-12 23:59:00', 6, '李小明5', 30, '蘋果手機 13', 999, 100),
('母親節', '2024-05-07 18:00:00', '2024-05-12 23:59:00', 7, '李小明6', 31, '三星 Galaxy S22', 899, 120),
('母親節', '2024-05-07 18:00:00', '2024-05-12 23:59:00', 7, '李小明6', 32, '蘋果筆記型電腦Pro 16', 1999, 80),
('限時優惠', '2024-05-13 18:00:00', '2024-05-20 23:59:00', 8, '李小明7', 33, '索尼 PlayStation 5', 499, 50),
('限時優惠', '2024-05-13 18:00:00', '2024-05-20 23:59:00', 9, '李小明8', 34, '任天堂 Switch', 299, 150),
('限時優惠', '2024-05-13 18:00:00', '2024-05-20 23:59:00', 10, '李小明9', 35, '蘋果手機 13', 999, 100);

select * from activity;