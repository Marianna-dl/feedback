create table MessageBrute(
	num_recu VARCHAR(10),
	corps_mess VARCHAR(200),
	date_entree DATETIME,
	PRIMARY KEY (num_recu,corps_mess)
);

create table Question(
	num_Quest INTEGER NOT NULL PRIMARY KEY,
	type_Quest VARCHAR(200),
	enonce VARCHAR(200)
);

create table Reponse(
	num_Question INTEGER NOT NULL,
	num_Rep VARCHAR(10) NOT NULL,
	description VARCHAR(200),
	point INTEGER,
	FOREIGN KEY (num_Question) REFERENCES Question(num_Quest),
	PRIMARY KEY(num_Question,num_Rep)
);

create table Message (
	id_mess INTEGER NOT NULL AUTO_INCREMENT,
	num_user varchar(10),
	num_Question INTEGER,
	num_Reponse VARCHAR(10),
	Date_Recu DATETIME,
	PRIMARY KEY (id_mess,num_user),
	FOREIGN KEY (num_Question) REFERENCES Question(num_Quest),
	FOREIGN KEY (num_Question,num_Reponse) REFERENCES Reponse(num_Question,num_Rep)
);
