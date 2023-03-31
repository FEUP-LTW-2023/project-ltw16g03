DROP TABLE IF EXISTS users;
DROP TABLE IF EXISTS Client;
DROP TABLE IF EXISTS Agent;
DROP TABLE IF EXISTS Admin;
DROP TABLE IF EXISTS Task;
DROP TABLE IF EXISTS Department;
DROP TABLE IF EXISTS Ticket;
DROP TABLE IF EXISTS Hashtag;
DROP TABLE IF EXISTS Ticket_Hashtag;
DROP TABLE IF EXISTS Faq;

--TYPES

CREATE TYPE Status AS ENUM ('Open','Assigned','Resolved', 'Closed');

--Tables

CREATE TABLE users (
   id SERIAL,
   username varchar(255) NOT NULL UNIQUE,
   name varchar(255) NOT NULL,
   email varchar(255) NOT NULL UNIQUE,
   password varchar(255) NOT NULL,
   is_client boolean NOT NULL DEFAULT true,
   is_agent boolean NOT NULL DEFAULT false,
   is_admin boolean NOT NULL DEFAULT false,
   CONSTRAINT id_userPK PRIMARY KEY(id)
);

CREATE TABLE Client (
    id INTEGER REFERENCES users (id) ON DELETE CASCADE,
    CONSTRAINT id_clientPK PRIMARY KEY(id)
);

CREATE TABLE Agent (
    id INTEGER REFERENCES users (id) ON DELETE CASCADE,
    id_department INTEGER REFERENCES Department (id),
    CONSTRAINT id_agentPK PRIMARY KEY(id),
    CONSTRAINT id_departmentFK FOREIGN KEY(id_department)
);

CREATE TABLE Admin (
    id INTEGER REFERENCES users (id) ON DELETE CASCADE,
    CONSTRAINT id_adminPK PRIMARY KEY(id)
);

CREATE TABLE Task (
    id SERIAL,
    title varchar(255) NOT NULL,
    description TEXT NOT NULL,
    is_completed BOOLEAN NOT NULL DEFAULT False,
    id_agent INTEGER REFERENCES Agent (id),
    CONSTRAINT id_taskPK PRIMARY KEY(id),
    CONSTRAINT id_agentFK FOREIGN KEY(id_agent) ON DELETE CASCADE
);

CREATE TABLE Department (
    id SERIAL,
    name varchar(255) NOT NULL UNIQUE,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
);

CREATE TABLE Ticket (
    id SERIAL,
    title varchar(255) NOT NULL UNIQUE,
    description TEXT NOT NULL,
    ticket_status Status DEFAULT 'Open',
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    id_client INTEGER REFERENCES Client (id),
    id_agent INTEGER REFERENCES Agent (id),
    id_department INTEGER REFERENCES Department (id),
    CONSTRAINT id_ticketPK PRIMARY KEY(id),
    CONSTRAINT current_edit_date_ck CHECK (created_at <= updated_at),
    CONSTRAINT id_clientFK FOREIGN KEY(id_client),
    CONSTRAINT id_agentFK FOREIGN KEY(id_agent),
    CONSTRAINT id_departmentFK FOREIGN KEY(id_department)
);

CREATE TABLE Hashtag (
    id SERIAL,
    tag varchar(255) NOT NULL UNIQUE,
);

CREATE TABLE Ticket_Hashtag (
   id_ticket INTEGER REFERENCES Ticket (id),
   id_hashtag INTEGER REFERENCES Hashtag (id),
   CONSTRAINT ticket_hashtagPK PRIMARY KEY(id_ticket, id_hashtag),
   CONSTRAINT id_ticketFK FOREIGN KEY(id_ticket),
   CONSTRAINT id_hashtagFK FOREIGN KEY(id_hashtag)
);

CREATE TABLE Faq (
    id SERIAL,
    title varchar(255) NOT NULL UNIQUE,
    description text NOT NULL
);