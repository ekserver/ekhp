-- CREATING TABLES NEEDED BY CODEIGNITER

-- Session table to store user informations used by codeigniter session_class
DROP TABLE IF EXISTS `ek_sessions`;
CREATE TABLE IF NOT EXISTS  `ek_sessions` (
session_id VARCHAR(40) DEFAULT '0' NOT NULL,
ip_address VARCHAR(16) DEFAULT '0' NOT NULL,
user_agent VARCHAR(50) NOT NULL,
last_activity INT(10) UNSIGNED DEFAULT 0 NOT NULL,
user_data TEXT NOT NULL,
PRIMARY KEY (session_id)
);