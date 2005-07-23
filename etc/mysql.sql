CREATE TABLE t_page (
	f_id INT NOT NULL AUTO_INCREMENT,
	f_subject CHAR(255) NOT NULL,
	f_last_modify_date INT DEFAULT '0',
	PRIMARY KEY(f_id)
);

CREATE TABLE t_body (
	f_id INT NOT NULL AUTO_INCREMENT,
	f_page_id INT NOT NULL,
	f_content TEXT,
	PRIMARY KEY(f_id)
);

CREATE TABLE t_list (
	f_id INT NOT NULL AUTO_INCREMENT,
	f_page_id INT NOT NULL,
	f_content CHAR(255),
	f_status INT,
	PRIMARY KEY(f_id)
);

CREATE TABLE `t_note` (
	`f_id` int(11) NOT NULL auto_increment,
	`f_page_id` int(11) NOT NULL default '0',
	`f_order` int(11) NOT NULL default '0',
	`f_subject` varchar(255) NOT NULL default '',
	`f_content` text NOT NULL,
	PRIMARY KEY  (`f_id`)
);

