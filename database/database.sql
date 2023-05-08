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
     is_admin boolean NOT NULL DEFAULT false,
     CONSTRAINT id_departmentFK FOREIGN KEY(id_department) REFERENCES Department(id)
 );

CREATE TABLE Task (
    id INTEGER PRIMARY KEY AUTOINCREMENT,
    title varchar(255) NOT NULL,
    description TEXT NOT NULL,
    is_completed BOOLEAN NOT NULL DEFAULT False,
    id_user INTEGER,
    CONSTRAINT id_userFK FOREIGN KEY(id_user) REFERENCES User(id) ON DELETE CASCADE
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
    CONSTRAINT id_usertFK FOREIGN KEY(id_user) REFERENCES User(id),
    CONSTRAINT id_agentFK FOREIGN KEY(id_agent) REFERENCES User(id),
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

INSERT INTO User (username, firstName, lastName, email, password) VALUES ('rafa', 'John', 'Doe', 'ola@ola', 'cd882b791d2f3999d17672bfe317683d0989890e5f96b4d4d6df3f4597e03d2d'); /*Pass*word1*/

INSERT INTO Department (id, name) VALUES (1, 'oooooeeeee');
INSERT INTO Department (id, name) VALUES (2, 'Department 2');
INSERT INTO Department (id, name) VALUES (3, 'Department 3');
INSERT INTO Department (id, name) VALUES (4, 'Department 4');
INSERT INTO Department (id, name) VALUES (5, 'Department 5');
INSERT INTO Department (id, name) VALUES (6, 'Department 6');
INSERT INTO Department (id, name) VALUES (7, 'Department 7');
INSERT INTO Department (id, name) VALUES (8, 'Department 8');
INSERT INTO Department (id, name) VALUES (9, 'Department 9');
INSERT INTO Department (id, name) VALUES (10, 'ooooliiii');

INSERT INTO Faq (id, title, description) VALUES (1, 'What is a trouble ticket?', 'A trouble ticket is a record of a customer reported problem or issue that needs to be addressed by technical support staff.');
INSERT INTO Faq (id, title, description) VALUES (2, 'How do I submit a trouble ticket?', 'You can submit a trouble ticket by filling out the ticket submission form.');
INSERT INTO Faq (id, title, description) VALUES (3, 'How long will it take for my ticket to be resolved?', 'The time it takes to resolve a ticket depends on the complexity of the issue and the volume of tickets currently being handled by our support team. We strive to resolve all tickets as quickly as possible, and we will keep you updated on the progress of your ticket throughout the process.');
INSERT INTO Faq (id, title, description) VALUES (4, 'Can I track the status of my ticket?', 'Yes, you can track the status of your ticket by checking the status of your ticket in the respective ticket page.');
INSERT INTO Faq (id, title, description) VALUES (5, 'What information should I include in my trouble ticket?', 'To help us quickly and accurately diagnose and resolve your issue, please include as much detail as possible in your ticket submission. This may include a description of the issue, any error messages or screenshots, and any steps you have already taken to try to resolve the issue.');
INSERT INTO Faq (id, title, description) VALUES (6, 'How do I cancel a ticket?', 'You can cancel a ticket by navigating to the ticket in question.');
INSERT INTO Faq (id, title, description) VALUES (7, 'What types of issues can I submit a trouble ticket for?', 'You can submit a trouble ticket for any technical issue or problem that you are experiencing with a product or service.');

INSERT INTO Hashtag (tag) VALUES ('sports');
INSERT INTO Hashtag (tag) VALUES ('politics');
INSERT INTO Hashtag (tag) VALUES ('news');
INSERT INTO Hashtag (tag) VALUES ('economy');
INSERT INTO Hashtag (tag) VALUES ('hashtag5');
INSERT INTO Hashtag (tag) VALUES ('hashtag6');
INSERT INTO Hashtag (tag) VALUES ('hashtag7');
INSERT INTO Hashtag (tag) VALUES ('hashtag8');
INSERT INTO Hashtag (tag) VALUES ('hashtag9');
INSERT INTO Hashtag (tag) VALUES ('hashtag10');
