create table setting (
    id bigint not null primary key auto_increment,
    blog_name varchar(63) not null,
    email varchar(250) not null,
    display_name varchar(63) not null,
    password_hash varchar(128) not null,
    password_salt varchar(31) not null
)ENGINE=InnoDB;

create table session (
    id bigint not null primary key auto_increment,
    code varchar(31) not null,
    created datetime not null
)ENGINE=InnoDB;

create table entry (
    id bigint not null primary key auto_increment,
    title varchar(127) not null,
    image_url varchar(255) not null,
    published tinyint(1) not null,
    snippet varchar(1023) not null,
    body text not null,
    created datetime not null,
    updated datetime null
)ENGINE=InnoDB;

create table tag (
    id bigint not null primary key auto_increment,
    name varchar(255) not null
)ENGINE=InnoDB;

create table entry_tag (
    entry bigint not null references entry(id),
    tag bigint not null references tag(id)
)ENGINE=InnoDB;

alter table entry_tag add index (entry, tag);