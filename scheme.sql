create table users(
 name varchar(40) not null,
 surname varchar(40) not null,
 password char(32)not null,
 email varchar(128) PRIMARY KEY,
 ip_adress varchar(16),
 birthday date,
 site varchar(128),
 phone varchar(16),
 rights varchar(10)
);
create table if not exists items(
    id serial PRIMARY KEY,
    name varchar(255),
    cost int
);