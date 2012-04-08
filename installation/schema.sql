
create database if not exists feesdb CHARACTER SET 'utf8' COLLATE 'utf8_general_ci';

use feesdb;


create table if not exists academic_year (
    id int unsigned not null auto_increment primary key,
    ayear varchar(10) not null,
    is_current boolean
) character set 'utf8' collate 'utf8_general_ci';


create table if not exists work_offers (
    id int unsigned not null auto_increment primary key,
    professor_email varchar(255),
    professor_name varchar(255),
    title varchar(255),
    lesson varchar(255),
    candidates tinyint unsigned,
    requirements text,
    deliverables varchar(255),
    hours smallint unsigned,
    deadline date,
    at_di boolean,
    academic_year_id int unsigned,
    winter_semester boolean,
    is_available boolean,
    has_expired boolean,
	published boolean,
    addressed_for tinyint(1) unsigned not null, /* for working people: 1 partial time, 2 full time */
    foreign key (academic_year_id) references academic_year(id)
) character set 'utf8' collate 'utf8_general_ci';


create table if not exists work_applications (
    id int not null auto_increment primary key,
    student_email varchar(255) not null,
    student_name varchar(255) not null,
    work_id int unsigned not null,
    applied timestamp default now(),
    accepted boolean default false,
    foreign key (work_id) references work_offers(id)
) character set 'utf8' collate 'utf8_general_ci';


create event update_expired
    on schedule every 1 day
      do
update work_offers set has_expired = true where deadline < now();


