create table ud_error
(error_id int PRIMARY KEY AUTO_INCREMENT NOT NULL,
error_text text NOT NULL,
indt datetime NOT NULL);

create table uc_discount
(discount_code varchar(20) NOT NULL,
discount_desc varchar(255) NOT NULL,
expire_dt datetime NULL,
indt datetime NOT NULL);

create table ud_discount_used
(discount_id int PRIMARY KEY AUTO_INCREMENT NOT NULL,
discount_code varchar(20) NOT NULL,
indt datetime NOT NULL);


