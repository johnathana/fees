
create database if not exists feesdb CHARACTER SET 'utf8' COLLATE 'utf8_general_ci';

use feesdb;


create table if not exists academic_year (
    id int unsigned not null auto_increment primary key,
    ayear varchar(10) not null,
    is_current boolean
) character set 'utf8' collate 'utf8_general_ci';


create table if not exists faculty (
    id int unsigned not null auto_increment primary key,
    title varchar(255),
	edupersonorgunitdn varchar(255)
) character set 'utf8' collate 'utf8_general_ci';


insert into faculty values (1, "Υπολογιστική Επιστήμη","ou=ypoloepi,ou=postgrads,dc=uoa,dc=gr");
insert into faculty values (2, "Προηγμένα Πληροφοριακά Συστήματα","ou=proplirosyst,ou=postgrads,dc=uoa,dc=gr");
insert into faculty values (3, "Τεχνολογία Συστημάτων Υπολογιστών","ou=tecsystiypolo,ou=postgrads,dc=uoa,dc=gr");
insert into faculty values (4, "Συστήματα Επικοινωνιών και Δίκτυα","ou=systepikdikt,ou=postgrads,dc=uoa,dc=gr");
insert into faculty values (5, "Επεξεργασία Σήματος για Επικοινωνίες και Πολυμέσα","ou=epexsimatepik,ou=postgrads,dc=uoa,dc=gr");
insert into faculty values (6, "Νέες Τεχνολογίες Πληροφορικής και Επικοινωνιών","ou=neestechpli,ou=postgrads,dc=uoa,dc=gr");
insert into faculty values (7, "Οικονομική και Διοίκηση των Τηλεπικοινωνιακών Δικτύων","ou=dioioikontilep,ou=postgrads,dc=uoa,dc=gr");

create table if not exists workoffer_categories (
    id int unsigned not null auto_increment primary key,
    category varchar(255)
) character set 'utf8' collate 'utf8_general_ci';


insert into workoffer_categories values (1, "Επιτήρηση εργαστηρίων ελεύθερης πρόσβασης Τμήματος");
insert into workoffer_categories values (2, "Υποστήριξη υλικοτεχνικής υποδομής τμήματος");
insert into workoffer_categories values (3, "Υποστήριξη επιτροπών Τμήματος");
insert into workoffer_categories values (4, "Επιτήρηση εξετάσεων (μόνο υποψήφιοι διδάκτορες)");
insert into workoffer_categories values (5, "Διεξαγωγή φροντιστηρίων ή εργαστηρίων");
insert into workoffer_categories values (6, "Διόρθωση φροντιστηριακών, εργαστηριακών ασκήσεων και εργασιών");
insert into workoffer_categories values (7, "Επίβλεψη πτυχιακών και διπλωματικών εργασιών (μόνο υποψήφιοι διδάκτορες)");
insert into workoffer_categories values (8, "Ανάπτυξη εκπαιδευτικού υλικού");
insert into workoffer_categories values (9, "Επιπρόσθετη διδασκαλία ατόμων με ειδικές αναπηρίες");


create table if not exists work_offers (
    id int unsigned not null auto_increment primary key,
    category_id int unsigned,
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
    faculty_id int unsigned,
    academic_year_id int unsigned,
    winter_semester boolean,
    is_available boolean,
    has_expired boolean,
    published boolean,
    addressed_for tinyint(1) unsigned not null, /* for working people: 1 partial time, 2 full time */
    foreign key (category_id) references workoffer_categories(id),
    foreign key (faculty_id) references faculty(id),
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


