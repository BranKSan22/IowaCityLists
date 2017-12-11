DROP TABLE IF EXISTS account;

/*This table creates an account for the user, allowing them to enter a username, password, email, and type of Iowa City community member they are*/
CREATE TABLE account (
    id INT NOT NULL AUTO_INCREMENT,
    hashedpass VARCHAR(255) NOT NULL,
    username VARCHAR(255) NOT NULL,
    email VARCHAR(300) NOT NULL,
    persontype VARCHAR(255) NOT NULL,
    PRIMARY KEY (ID)
);

INSERT INTO account (hashedpass, username, email, persontype) values ('$2a$12$s7h33TRR.wjhdKVdNIGON.pBVHlr2rancX6TxExL2UpLjTu.0TdbK', 'bksanders', 'brandy-sanders@uiowa.edu', 'Student');
INSERT INTO account (hashedpass, username, email, persontype) values ('$2a$12$4W4ej8SBkW6Z7wwEnG885OFemfYEPBTD1abWdg9ep0DqvZGc8LwyO','dwyrwas','duncan-wyrwas@uiowa.edu','Student');
INSERT INTO account (hashedpass, username, email, persontype) values ('$2a$12$FqVuPRs7P3A3mlzneMnzC.FRUB6bLqk6mhGpQT00XY7kdD1.XZSuq','spandya', 'sanjana-pandya@uiowa.edu', 'Student');                                             
