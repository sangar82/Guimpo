CREATE TABLE categoria_gallery (id INT(9) NOT NULL AUTO_INCREMENT PRIMARY KEY ,name  varchar(60)  DEFAULT '' NOT NULL, categoria_id  varchar(200)  DEFAULT '' NOT NULL, stripped varchar(200)  DEFAULT '' NOT NULL, created TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,updated TIMESTAMP NOT NULL);