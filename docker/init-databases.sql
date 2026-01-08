-- Create all required databases for tmart microservices architecture

-- Create database user
CREATE USER IF NOT EXISTS 'tmart_user'@'%' IDENTIFIED BY 'tmart_password';

-- Create tmart-users database
CREATE DATABASE IF NOT EXISTS `tmart-users` 
CHARACTER SET utf8mb4 
COLLATE utf8mb4_unicode_ci;

-- Create tmart-menu database
CREATE DATABASE IF NOT EXISTS `tmart-menu` 
CHARACTER SET utf8mb4 
COLLATE utf8mb4_unicode_ci;

-- Create tmart-order database
CREATE DATABASE IF NOT EXISTS `tmart-order` 
CHARACTER SET utf8mb4 
COLLATE utf8mb4_unicode_ci;

-- Create tmart-delivery database
CREATE DATABASE IF NOT EXISTS `tmart-delivery` 
CHARACTER SET utf8mb4 
COLLATE utf8mb4_unicode_ci;

-- Create tmart-feedback database
CREATE DATABASE IF NOT EXISTS `tmart-feedback` 
CHARACTER SET utf8mb4 
COLLATE utf8mb4_unicode_ci;

-- Create tmart-tracking database
CREATE DATABASE IF NOT EXISTS `tmart-tracking` 
CHARACTER SET utf8mb4 
COLLATE utf8mb4_unicode_ci;

-- Grant privileges to the database user
GRANT ALL PRIVILEGES ON `tmart-users`.* TO 'tmart_user'@'%';
GRANT ALL PRIVILEGES ON `tmart-menu`.* TO 'tmart_user'@'%';
GRANT ALL PRIVILEGES ON `tmart-order`.* TO 'tmart_user'@'%';
GRANT ALL PRIVILEGES ON `tmart-delivery`.* TO 'tmart_user'@'%';
GRANT ALL PRIVILEGES ON `tmart-feedback`.* TO 'tmart_user'@'%';
GRANT ALL PRIVILEGES ON `tmart-tracking`.* TO 'tmart_user'@'%';

FLUSH PRIVILEGES;
