psql template1

CREATE DATABASE golimbre ENCODING='latin1' template=template0;

\q

createlang plpgsql golimbre;


CREATE SEQUENCE users_seq;

CREATE TABLE users (
    id integer DEFAULT nextval('users_seq'::regclass) NOT NULL,
    name character varying(256) DEFAULT ''::character varying NOT NULL,
    lastname character varying(256),
    username character varying(256) NOT NULL,
    password character varying(256) NOT NULL,
    type character varying(32) NOT NULL,
    email character varying(256) NOT NULL,
    hash character varying(256)  NULL,
    created timestamp without time zone DEFAULT now() NOT NULL,
    updated timestamp without time zone DEFAULT now() NOT NULL
);



CREATE TABLE users (
   `id` int(9) NOT NULL AUTO_INCREMENT,
   `name` varchar(256) NOT NULL,
   `lastname` varchar(256) NOT NULL,
   `username` varchar(256) NOT NULL,
   `password` varchar(256) NOT NULL,
   `type` varchar(256) NOT NULL,
   `email` varchar(256) NOT NULL,
   `hash` varchar(256) NULL,
   `created` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE  
CURRENT_TIMESTAMP,
   `updated` timestamp NOT NULL DEFAULT '0000-00-00 00:00:00',
   PRIMARY KEY (`id`)
)
