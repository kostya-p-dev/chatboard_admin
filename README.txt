After clonnig project
1. cd ProjectName
2. composer install (will install vendors) symfony will ask you to enter some information (input:  dbName, dbUserName, dbPassword  )
 
	database_driver (pdo_mysql): ENTER
	database_host (127.0.0.1): ENTER
	database_port (null): ENTER
	database_name (symfony): dbName
	database_user (root): dbUserName
	database_password (null): dbPassword
	mailer_transport (smtp): ENTER
	mailer_host (127.0.0.1): ENTER
	mailer_user (null): ENTER
	mailer_password (null): ENTER
	locale (en): ENTER
	secret (ThisTokenIsNotSoSecretChangeIt):ENTER
3. app/console  doctrine:database:create (will create dataBase)
4. app/console doctrine:schema:create (will create tables in your dataBase )
5. app/console  doctrine:fixtures:load (will create adminUser )
END. got to http://mysyte.com    (login: admin, password: qwerty)

