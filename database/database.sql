DROP TABLE IF EXISTS User;
DROP TABLE IF EXISTS Client;
DROP TABLE IF EXISTS Agent;
DROP TABLE IF EXISTS admins;
DROP TABLE IF EXISTS Task;
DROP TABLE IF EXISTS Department;
DROP TABLE IF EXISTS Ticket;
DROP TABLE IF EXISTS Hashtag;
DROP TABLE IF EXISTS Ticket_Hashtag;
DROP TABLE IF EXISTS Faq;

--Tables

/*  
    As tabelas Client, Agent e Admin eram irrelevantes pois tudo o que faziam era redirecionar para esta tabela, eram apenas confortáveis
    Qualquer user pode criar um ticket, não interessa se é client, agent ou admin.
    Mas só agents ou admins podem fazer certas ações.ABORT
    Se is_agent for true, id_department terá um valor
    Ao verificar se um user tem permissões, primeiro ver se é admin, depois se é agent, caso não seja nenhum, é client
*/

CREATE TABLE User (
     id INTEGER PRIMARY KEY AUTOINCREMENT,
     username varchar(255) NOT NULL UNIQUE,
     firstName varchar(255) NOT NULL,
     lastName varchar(255) NOT NULL,
     email varchar(255) NOT NULL UNIQUE,
     password varchar(255) NOT NULL,
     id_department INTEGER DEFAULT NULL,
     is_agent boolean NOT NULL DEFAULT false,
     is_admin boolean NOT NULL DEFAULT false
 );

CREATE TABLE Task (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    title varchar(255) NOT NULL,
    description TEXT NOT NULL,
    is_completed BOOLEAN NOT NULL DEFAULT False,
    id_user INTEGER,
    CONSTRAINT id_userFK FOREIGN KEY(id_user) REFERENCES User(id_user) ON DELETE CASCADE
);

CREATE TABLE Department (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    name varchar(255) NOT NULL UNIQUE,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE Ticket (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    title varchar(255) NOT NULL UNIQUE,
    descriptions VARCHAR(255) NOT NULL,
    ticket_status VARCHAR (10)  NOT NULL DEFAULT 'Open' CHECK (ticket_status IN ('Open', 'Assigned', 'Resolved', 'Closed')),
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    id_user INTEGER, /* id do client que criou o ticket */
    id_agent INTEGER, /* id do agent que está a tratar do ticket */
    id_department INTEGER, /* id do department do ticket */
    CONSTRAINT current_edit_date_ck CHECK (created_at <= updated_at),
    CONSTRAINT id_usertFK FOREIGN KEY(id_user) REFERENCES User(id_user),
    CONSTRAINT id_agentFK FOREIGN KEY(id_agent) REFERENCES User(id_user),
    CONSTRAINT id_departmentFK FOREIGN KEY(id_department) REFERENCES Department(id)
);

CREATE TABLE Hashtag (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    tag varchar(255) NOT NULL UNIQUE
);

CREATE TABLE Ticket_Hashtag (
   id_ticket INTEGER,
   id_hashtag INTEGER,
   CONSTRAINT ticket_hashtagPK PRIMARY KEY(id_ticket, id_hashtag),
   CONSTRAINT id_ticketFK FOREIGN KEY(id_ticket) REFERENCES Ticket (id),
   CONSTRAINT id_hashtagFK FOREIGN KEY(id_hashtag) REFERENCES Hashtag (id)
);

CREATE TABLE Faq (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    title varchar(255) NOT NULL UNIQUE,
    description text NOT NULL
);

/*insert into Ticket(title, descriptions) values ("Isto é um ticket", "Isto é um ticket de teste :)");
insert into Ticket(title, descriptions) values ("Isto também é um ticket", "Isto é um ticket de teste :)");*/

INSERT INTO Department (id, name) VALUES (1, 'ola');
INSERT INTO Department (id, name) VALUES (2, 'Department 2');
INSERT INTO Department (id, name) VALUES (3, 'Department 3');
INSERT INTO Department (id, name) VALUES (4, 'Department 4');
INSERT INTO Department (id, name) VALUES (5, 'Department 5');
INSERT INTO Department (id, name) VALUES (6, 'Department 6');
INSERT INTO Department (id, name) VALUES (7, 'Department 7');
INSERT INTO Department (id, name) VALUES (8, 'Department 8');
INSERT INTO Department (id, name) VALUES (9, 'Department 9');
INSERT INTO Department (id, name) VALUES (10, 'ooooliiii');
