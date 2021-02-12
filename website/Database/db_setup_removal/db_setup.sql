CREATE TABLE RDL_users (
	id INT NOT NULL AUTO_INCREMENT,
	first_name VARCHAR(50) DEFAULT NULL,
	last_name VARCHAR(50) DEFAULT NULL,
	email VARCHAR(150) DEFAULT NULL,
    free_access bit DEFAULT 0,
	site_admin bit DEFAULT 0,
    inactive bit DEFAULT 0,
	PRIMARY KEY (id)
);
CREATE TABLE RDL_log (
    id INT NOT NULL AUTO_INCREMENT,
	first_name VARCHAR(50) DEFAULT NULL,
	last_name VARCHAR(50) DEFAULT NULL,
	email VARCHAR(150) NOT NULL,
    free_access bit DEFAULT 0,
	site_admin bit DEFAULT 0,
    inactive bit DEFAULT 0,
	time VARCHAR(10) NOT NULL,
	PRIMARY KEY (id)
);
