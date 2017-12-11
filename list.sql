
-- Drop the table if it already exists
DROP TABLE IF EXISTS attribute;
DROP TABLE IF EXISTS item;
DROP TABLE IF EXISTS list;
DROP TABLE IF EXISTS template;
DROP TABLE IF EXISTS template_attribute;
DROP TABLE IF EXISTS votes;

--List table
CREATE TABLE list (
    id INT NOT NULL AUTO_INCREMENT,
    name VARCHAR(120) NOT NULL, 		
    template_id int,
    account_id INT,
    timeTable TIMESTAMP NOT NULL,
    voteCounter INT NOT NULL,
    PRIMARY KEY (id)
);

CREATE TABLE item (
    id INT NOT NULL AUTO_INCREMENT,
    list_id INT NOT NULL,
    name VARCHAR(120) ,
    ordernumber INT NOT NULL,
    PRIMARY KEY (id)
);

CREATE TABLE attribute (
    id INT NOT NULL AUTO_INCREMENT,
    item_id INT NOT NULL,
    ordernumber INT NOT NULL,
    label VARCHAR(120) NOT NULL DEFAULT 'N/A',
    type VARCHAR(120) NOT NULL,
    value VARCHAR(255) NOT NULL,
    PRIMARY KEY (id)    
);

--Template add
CREATE TABLE template (
		id INT NOT NULL AUTO_INCREMENT,
		t_name VARCHAR(120) NOT NULL,
		PRIMARY KEY(id)
);

CREATE TABLE template_attribute (
    id INT NOT NULL AUTO_INCREMENT,
    template_id INT NOT NULL,
    ordernumber INT NOT NULL,
    label VARCHAR(120) NOT NULL,
    type VARCHAR(120) NOT NULL,
    PRIMARY KEY (id)    
);

-- Vote table 
CREATE TABLE votes(
    votes_id INT NOT NULL AUTO_INCREMENT,
    account_id INT NOT NULL,
    list_id INT NOT NULL,
    votes INT NOT NULL,
    PRIMARY KEY (votes_id)
);
--Insert a template, name default, has one attribute with type text 

INSERT INTO template (t_name) VALUES ('Music');		-- id: 2

INSERT INTO template_attribute (template_id, ordernumber, label, type) VALUES (1, 0, 'Artist', 'text'); -- 5th in template_attribute
INSERT INTO template_attribute (template_id, ordernumber, label, type) VALUES (1, 1, 'Album', 'text'); -- 6th in template_attribute
INSERT INTO template_attribute (template_id, ordernumber, label, type) VALUES (1, 2, 'Song', 'text'); -- 7th in template_attribute
INSERT INTO template_attribute (template_id, ordernumber, label, type) VALUES (1, 3, 'Video', 'video'); -- 8th in template_attribute


INSERT INTO template (t_name) VALUES ('Players');		-- id: 3
INSERT INTO template_attribute (template_id, ordernumber, label, type) VALUES (2, 0, 'Name of Player', 'text'); -- 9th in template_attribute
INSERT INTO template_attribute (template_id, ordernumber, label, type) VALUES (2, 1, 'Name of Team', 'text'); -- 10th in template_attribute
INSERT INTO template_attribute (template_id, ordernumber, label, type) VALUES (2, 2, 'Age', 'text'); -- 11th in template_attribute
INSERT INTO template_attribute (template_id, ordernumber, label, type) VALUES (2, 3, 'Position', 'text'); -- 12th in template_attribute

INSERT INTO template (t_name) VALUES ('Games');		-- id: 3
INSERT INTO template_attribute (template_id, ordernumber, label, type) VALUES (3, 0, 'Name of Game', 'text'); -- 13th in template_attribute
INSERT INTO template_attribute (template_id, ordernumber, label, type) VALUES (3, 1, 'Type of Game', 'text'); -- 14th in template_attribute
INSERT INTO template_attribute (template_id, ordernumber, label, type) VALUES (3, 2, 'Type of Game Console', 'text'); -- 15th in template_attribute
INSERT INTO template_attribute (template_id, ordernumber, label, type) VALUES (3, 3, 'Release Year', 'text'); -- 16th in template_attribute
INSERT INTO template_attribute (template_id, ordernumber, label, type) VALUES (3, 4, 'Video', 'video');-- 17th in template_attribute

INSERT INTO template (t_name) VALUES ('Books');		-- id: 3
INSERT INTO template_attribute (template_id, ordernumber, label, type) VALUES (4, 0, 'Title of Book', 'text'); -- 13th in template_attribute
INSERT INTO template_attribute (template_id, ordernumber, label, type) VALUES (4, 1, 'Name of Author', 'text'); -- 14th in template_attribute
INSERT INTO template_attribute (template_id, ordernumber, label, type) VALUES (4, 2, 'Genre of Book', 'text'); -- 15th in template_attribute
INSERT INTO template_attribute (template_id, ordernumber, label, type) VALUES (4, 3, 'Book Release Year', 'text'); -- 16th in template_attribute

INSERT INTO template (t_name) VALUES ('Movies');		-- id: 4
INSERT INTO template_attribute (template_id, ordernumber, label, type) VALUES (5, 0, 'Title of Movie', 'text'); -- 18th in template_attribute
INSERT INTO template_attribute (template_id, ordernumber, label, type) VALUES (5, 1, 'Name of Director', 'text'); -- 19th in template_attribute
INSERT INTO template_attribute (template_id, ordernumber, label, type) VALUES (5, 2, 'Movie Release Year','text');-- 20th in template_attribute

INSERT INTO template (t_name) VALUES ('Miscellaneous');		-- id: 1
INSERT INTO template_attribute (template_id, ordernumber, label, type) VALUES (6, 0, 'Title', 'text'); -- 1st in template_attribute
INSERT INTO template_attribute (template_id, ordernumber, label, type) VALUES (6, 1, 'Type', 'text'); --2nd in template_attribute
INSERT INTO template_attribute (template_id, ordernumber, label, type) VALUES (6, 2, 'Genre', 'text'); -- 3rd in template_attribute
INSERT INTO template_attribute (template_id, ordernumber, label, type) VALUES (6, 3, 'Attribute', 'text'); -- 4th in template_attribute


-- Insert some records
-- When deleteing these tables remember to input template_id

--Local List Template 
--Soccer players
INSERT INTO list (name, account_id) VALUES ('Soccer players', 1);		-- 1st element in list

INSERT INTO item (list_id, name, ordernumber) VALUES (1, 'Lionel Messi', 0);		-- 1st element in item
INSERT INTO attribute (item_id, ordernumber, label, type, value) VALUES (1, 0, 'club', 'text', 'FC Barcelona');
INSERT INTO attribute (item_id, ordernumber, label, type, value) VALUES (1, 1, 'national team', 'text', 'Argentina');
INSERT INTO attribute (item_id, ordernumber, label, type, value) VALUES (1, 2, 'video', 'video', "<iframe src='https://www.youtube.com/embed/0NQL3qZKrTE' frameborder='0' allowfullscreen></iframe>");

INSERT INTO item (list_id, name, ordernumber) VALUES (1, 'Neymar Jr.', 1);		-- 2nd element in item
INSERT INTO attribute (item_id, ordernumber, label, type, value) VALUES (2, 0, 'club', 'text', 'PSG');
INSERT INTO attribute (item_id, ordernumber, label, type, value) VALUES (2, 1, 'national team', 'text', 'Brazil');

	-- Songs
INSERT INTO list (name,account_id) VALUES ('Songs', 2);		-- 2nd element in list

INSERT INTO item (list_id, name, ordernumber) VALUES (2, 'Integral', 0);		-- 3rd element in item
INSERT INTO attribute (item_id, ordernumber, label, type, value) VALUES (3, 0, 'artist', 'text', 'Pet Shop Boys');

INSERT INTO item (list_id, name, ordernumber) VALUES (2, 'Phantoms', 1);		-- 4th element in item
INSERT INTO attribute (item_id, ordernumber, label, type, value) VALUES (4, 0, 'artist', 'text', 'Alphaville');
INSERT INTO attribute (item_id, ordernumber, label, type, value) VALUES (4, 1, 'video', 'video', '<iframe width="560" height="315" src="https://www.youtube.com/embed/VS4Enm-y8EM" frameborder="0" allowfullscreen></iframe>');



