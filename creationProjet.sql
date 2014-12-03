create table MessageBrute(
	num_recu INTEGER NOT NULL PRIMARY KEY,
	corps_mess VARCHAR(200)
);

create table Question(
	num_Quest INTEGER NOT NULL PRIMARY KEY,
	type_Quest VARCHAR(200),
	enonce VARCHAR(200)
);

create table Reponse(
	num_Question INTEGER NOT NULL,
	num_Rep INTEGER UNIQUE NOT NULL,
	description VARCHAR(200),
	point INTEGER,
	FOREIGN KEY (num_Question) REFERENCES Question(num_Quest),
	PRIMARY KEY(num_Question,num_Rep)
);

create table Message (
	id_mess INTEGER NOT NULL PRIMARY KEY,
	num_Question INTEGER,
	num_Reponse INTEGER,
	Date_Recu TIME,
	FOREIGN KEY (num_Question) REFERENCES Question(num_Quest),
	FOREIGN KEY (num_Reponse) REFERENCES Reponse(num_Rep)
);

create table Users(
	num INTEGER	NOT NULL PRIMARY KEY,
	mess INTEGER NOT NULL,
	FOREIGN KEY (mess) REFERENCES Message(id_mess)
);
