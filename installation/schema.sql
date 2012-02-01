
create database if not exists workofferdb CHARACTER SET 'utf8' COLLATE 'utf8_general_ci';

use workofferdb;


create table if not exists users (
    id int unsigned not null auto_increment primary key,
    email varchar(255) not null, /* no username! email and password for authentication */
    passwd varchar(40) not null, /* hashed with sha1 */
    is_admin tinyint(1) unsigned default '0' not null, /* 0 users, 1 admins, 2 professors */
    name varchar(255),
    surname varchar(255),
    reg_numb varchar(10), /* student registration number */
    phone varchar(255),
    sex char(1), /* m = male, f = female, g = gay ;) */
    cv text, /* this type can hold a variable amount of data */
    created timestamp default now(), /* not changed during subsequent updates */
    last_login timestamp /* if null account is inactive */
) character set 'utf8' collate 'utf8_general_ci';


create table if not exists academic_year (
    id int unsigned not null auto_increment primary key,
    ayear varchar(10) not null,
    is_current boolean
) character set 'utf8' collate 'utf8_general_ci';


create table if not exists work_offers (
    id int unsigned not null auto_increment primary key,
    professor_id int unsigned,
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
    addressed_for tinyint(1) unsigned not null, /* for working people: 1 partial time, 2 full time */
    foreign key (professor_id) references users(id),
    foreign key (academic_year_id) references academic_year(id)
) character set 'utf8' collate 'utf8_general_ci';


create table if not exists work_applications (
    id int not null auto_increment primary key,
    user_id int unsigned not null,
    work_id int unsigned not null,
    applied timestamp default now(),
    accepted boolean default false,
    foreign key (user_id) references users(id),
    foreign key (work_id) references work_offers(id)
) character set 'utf8' collate 'utf8_general_ci';


create event update_expired
    on schedule every 1 day
      do
update work_offers set has_expired = true where deadline < now();


/* Insert examples */

/* Το 8cb2237d0679ca88db6464eac60da96345513964 είναι το hash του 12345 */
insert into users (email, passwd, is_admin, name, surname, reg_numb, phone, sex, cv) values ("johnathana@gmail.com", "8cb2237d0679ca88db6464eac60da96345513964", 1, "Ιωάννης", "Αθανασέλης", "ΜΟΠ261", "6976525784", "m", "Όταν ήμουνα μικρός...");
insert into users (email, passwd, name, surname, reg_numb, phone, sex, cv) values ("grkjohny@gmail.com", "8cb2237d0679ca88db6464eac60da96345513964", "Giannis", "Iosifidis", "ΜΟΠ278", "6945678999", "m", "Μια νύχτα από τα δικά μου ολόκληρη η δική σου");
insert into users (email, passwd, name, surname, reg_numb, phone, sex, cv) values ("steradams@gmail.com", "8cb2237d0679ca88db6464eac60da96345513964", "Στέργιος", "Αδάμος", "ΜΟΠ288", "6945671234", "m", "Δεν περιγράφω άλλο");
insert into users (email, passwd, name, surname, reg_numb, phone, sex, cv) values ("none@none.com", "8cb2237d0679ca88db6464eac60da96345513964", "Οδυσσέας", "Κανένας", "ΜΟΠ666", "210999999", "m", "Οδύσσεια!!!");
insert into users (email, passwd, is_admin, name, surname, phone, sex, cv) values ("michalak@di.uoa.gr", "8cb2237d0679ca88db6464eac60da96345513964", 2, "Christos", "Michalakelis", "090606060", "m", "Ότι και να πω είναι λίγο.-");

insert into academic_year (ayear, is_current) values ("2009-2010", false);
insert into academic_year (ayear, is_current) values ("2010-2011", true);

insert into work_offers (professor_id, title, lesson, candidates, requirements, deliverables, hours, deadline, at_di, academic_year_id, winter_semester, is_available, has_expired, addressed_for) values (5, "Δημιουργία site παροχής", NULL, 3, "PHP/MySQL, τα πάντα όλα", "Πλατφόρμα παροχής έργου", 400, '2011-05-10', false, 2, false, true, false, 0);

insert into work_applications (user_id, work_id) values (1, 1);
insert into work_applications (user_id, work_id) values (2, 1);
insert into work_applications (user_id, work_id) values (3, 1);

