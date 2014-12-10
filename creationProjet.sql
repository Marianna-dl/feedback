create table user(
	num_tel VARCHAR(10) PRIMARY KEY
);

create table messagebrute(
	num_recu VARCHAR(10),
	corps_mess VARCHAR(200),
	date_entree DATETIME,
	PRIMARY KEY (num_recu,corps_mess)
);

create table question(
	id_quest INTEGER PRIMARY KEY AUTO_INCREMENT,
	num_quest INTEGER NOT NULL,
	type_quest VARCHAR(200),
	enonce VARCHAR(200),
    	UNIQUE (num_quest)
);

create table reponse(
	num_question INTEGER NOT NULL,
	num_rep VARCHAR(10) NOT NULL,
	description VARCHAR(200),
	point INTEGER,
	FOREIGN KEY (num_question) REFERENCES question(num_quest),
	PRIMARY KEY(num_question,num_rep)
);

create table message (
	id_mess INTEGER NOT NULL AUTO_INCREMENT,
	num_user varchar(10),
	num_question INTEGER,
	num_reponse VARCHAR(10),
	date_recu DATETIME,
	PRIMARY KEY (id_mess,num_user),
	FOREIGN KEY (num_user) REFERENCES user(num_tel),
	FOREIGN KEY (num_question) REFERENCES question(num_quest),
	FOREIGN KEY (num_question,num_reponse) REFERENCES reponse(num_question,num_rep)
);
