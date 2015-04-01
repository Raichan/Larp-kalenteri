CREATE SEQUENCE unique_id_admins;


CREATE TABLE admins (

	id integer NOT NULL DEFAULT nextval('unique_id_admins'),

	username character varying(50) NOT NULL,

	password character varying(50) NOT NULL,

	name character varying(50),

	surname character varying(50),

	email character varying(50)

);


ALTER SEQUENCE unique_id_admins owned by admins.id;
INSERT INTO admins (username, password, name, surname, email) values ('root', 'vfx65h', 'Root', 'Root', 'root@root.com');