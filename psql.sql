
create database intercityexpress;

--create table Admin

\c intercityexpress

create table admin (
    UID varchar(05) primary key , 
    name varchar(100),
    username text unique, 
    password text not null
);

create table passenger (
    pass_id serial primary key,
    name varchar(100) not null,
    address varchar(500) not null,
    state varchar(100) not null,
    district varchar(100) not null,
    pincode varchar(6) not null,
    date_of_birth date not null,
    mobile_no varchar(10) not null,
    email_id varchar(60) not null unique,
    gender varchar(20) not null,
    username varchar(30) not null unique,
    password text not null,
    sec_ques varchar(200) not null,
    sec_ans text not null,
    status varchar(20)
);

create table travel_agent (
    ta_uid serial primary key,
    ta_name varchar(100) not null,
    ta_res_address varchar(500) not null,
    ta_res_state varchar(100) not null,
    ta_res_district varchar(100) not null,
    ta_res_pincode varchar(6) not null,
    ta_date_of_birth date not null,
    ta_mobile_no varchar(10) not null,
    ta_email_id varchar(60) not null unique,
    ta_gender varchar(20) not null,
    ta_com_address varchar(500) not null,
    ta_com_state varchar(100) not null,
    ta_com_district varchar(100) not null,
    ta_com_pincode varchar(6) not null,
    ta_gov_id varchar(50) not null,
    ta_id varchar(20) not null,
    username varchar(30) not null unique,
    password text not null,
    status varchar(20)
);

create table emp_username_generator(
    emp_id serial primary key,
    counter int
);

insert into emp_username_generator(counter) values (1001);

create table employee (
    emp_uid serial primary key,
    emp_name varchar(100) not null,
    emp_res_address varchar(500) not null,
    emp_res_state varchar(100) not null,
    emp_res_district varchar(100) not null,
    emp_res_pincode varchar(6) not null,
    emp_date_of_birth date not null,
    emp_mobile_no varchar(10) not null,
    emp_email_id varchar(60) not null unique unique,
    emp_gender varchar(20) not null,
    emp_qual varchar(50) not null,
    emp_date_of_joining date not null,
    emp_gov_id varchar(50) not null,
    emp_id varchar(20) not null,
    emp_des varchar(30) not null,
    username varchar(30) not null unique,
    password text not null,
    status varchar(20)
);

create table stations(
    station_code varchar(10) primary key,
    station_name varchar(100) unique,
    no_of_platform int,
    state varchar(100),
    status varchar(20)
);

create table station_code_generator(
    station_id serial primary key,
    counter int
);

insert into station_code_generator(counter) values (1001);

create table seats(
    seat_no int primary key,
    seat_type varchar(50)
);

insert into seats values (1,'Window Side');
insert into seats values (4,'Window Side');
insert into seats values (5,'Window Side');
insert into seats values (8,'Window Side');
insert into seats values (2,'Aisle');
insert into seats values (3,'Aisle');
insert into seats values (6,'Aisle');
insert into seats values (7,'Aisle');

create table routes(
    route_code varchar(10) primary key,
    start_station varchar(10) references stations(station_code) ON DELETE CASCADE,
    end_station varchar(10) references stations(station_code) ON DELETE CASCADE,
    time_taken INTERVAL,
    distance int,
    status varchar(20)
);

create table route_code_generator(
    r_id serial primary key,
    counter int
);

insert into route_code_generator(counter) values (1001);

create table trains(
    train_no int primary key,
    train_name varchar(100),
    route_code varchar(10) references routes(route_code) ON DELETE CASCADE,
    ss_fare int,
    ac_fare int,
    status varchar(20)
);

create table train_schedule(
    route_code varchar(10) references routes(route_code) ON DELETE CASCADE,
    train_no int references trains(train_no) ON DELETE CASCADE,
    mon varchar(5),
    tue varchar(5),
    wed varchar(5),
    thu varchar(5),
    fri varchar(5),
    sat varchar(5),
    sun varchar(5),
    dep time
);

create table ticket_no_generator(
    ticket_id serial primary key,
    counter int
);

insert into ticket_no_generator(counter) values (1000001);


create table tickets(
    ticket_no varchar(10) primary key,
    train_no int references trains(train_no) ON DELETE CASCADE,
    status varchar(20),
    board_stn varchar(10) references stations(station_code) ON DELETE CASCADE,
    drop_stn varchar(10) references stations(station_code) ON DELETE CASCADE,
    starts_on TIMESTAMP,
    ends_on TIMESTAMP,
    user_type varchar(20)
);

create table seat_allocated(
    ticket_no varchar(10) references tickets(ticket_no) ON DELETE CASCADE,
    coach_no varchar(3),
    seat_no int references seats(seat_no) ON DELETE CASCADE,
    doj date
);

create table tickets_pass(
    ticket_no varchar(10) references tickets(ticket_no) ON DELETE CASCADE,
    username varchar(30) references passenger(username) ON DELETE CASCADE,
    user_name varchar(100),
    user_gender varchar(10),
    user_age varchar(10),
    ticket_fare DECIMAL(10, 2),
    total_fare DECIMAL(10, 2),
    user_mob varchar(10),
    user_email varchar(200)
);

create table tickets_ta(
    ticket_no varchar(10) references tickets(ticket_no) ON DELETE CASCADE,
    username varchar(30) references travel_agent(username) ON DELETE CASCADE,
    user_name varchar(100),
    user_gender varchar(10),
    user_age varchar(10),
    ticket_fare DECIMAL(10, 2),
    ta_comm DECIMAL(10, 2),
    total_fare DECIMAL(10, 2),
    user_mob varchar(10),
    user_email varchar(200)
);

create table tickets_emp(
    ticket_no varchar(10) references tickets(ticket_no) ON DELETE CASCADE,
    username varchar(30) references employee(username) ON DELETE CASCADE,
    user_name varchar(100),
    user_gender varchar(10),
    user_age varchar(10),
    ticket_fare DECIMAL(10, 2),
    emp_conn DECIMAL(10, 2),
    total_fare DECIMAL(10, 2),
    user_mob varchar(10),
    user_email varchar(200)
);

create table payment(
    transaction_id serial primary key,
    ticket_no varchar(10) references tickets(ticket_no) ON DELETE CASCADE,
    status varchar(20),
    total_fare DECIMAL(10, 2),
    ticket_fare DECIMAL(10, 2), 
    ta_comm DECIMAL(10, 2),
    emp_conn DECIMAL(10, 2),
    upi_used varchar(100)
);

create table limits(
    uid int primary key,
    user_type varchar(20),
    booking_limit int,
    comm_conn int
);

INSERT INTO limits(uid,user_type) VALUES(1,'passenger');
INSERT INTO limits(uid,user_type) VALUES(2,'travel_agent');
INSERT INTO limits(uid,user_type) VALUES(3,'employee');


create table contact(
    uid int primary key,
    mobile_no varchar(10),
    email_id varchar(100),
    address varchar(200),
    state varchar(100),
    district varchar(100),
    pincode varchar(6)
);

INSERT INTO contact (uid) VALUES(1);

CREATE TABLE feedback (
    id SERIAL PRIMARY KEY,
    username VARCHAR(30) NOT NULL,
    user_type varchar(30) NOT NULL,
    subject VARCHAR(100) NOT NULL,
    content TEXT NOT NULL CHECK (char_length(content) <= 2000)
);
