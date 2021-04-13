# Database
The database is used to keep track of who can sign and who can add new users, moderators and admins. It is also used to be kept as a log off when the request were sent and by whom.

## Uses
The database is used to keep track of every time the request system is used and to keep track off who is an admin and what personel is allowed to have free access.

## Setup

The database setup is done in three steps

### Database setup (first step)
First part is to set up a database which can be reached from any ip (Recommended for ease of setup). The database login you create for the server/website needs to have permissions to add, change, remove and read information in tables.

### Database setup (second step)
The important part after you managed to set up a database is to open the [```enter_info-db_info.php```](enter_info-db_info.php) and enter all the relavent information, after that is done you remove "**enter_info-**" from the name of the file.

### Database setup (Thrid step)
Copy the code in [```db_setup.sql```](db_setup&removal/db_setup.sql) and paste it into the terminal of the database. You also need to write this (change Your-name, Your-lastname and Your-email. This will allow that email to log in and it will have the rank of *fallback admin*)

```
INSERT INTO `RDL_users` (`id`, `given_name`, `family_name`, `email`, `rank`, `added_by`, `time_added`) VALUES 
(NULL, 'Your-name', 'Your-lastname', 'Your-email', '4', 'added-by-terminal', NULL)
```


### Setup tabels
The setup of tabels into the database is simple, just copy the code in [```db_setup.sql```](db_setup&removal/db_setup.sql) and input it into the database terminal.

## Removal

### Removal of all data
To remove all data in the tabels, just copy the code in [```db_clear.sql```](db_setup&removal/db_clear.sql) and input it into the database terminal.

### Removal of all tabels
To remove all tabels into the database, just copy the code in [```db_drop.sql```](db_setup&removal/db_drop.sql) and input it into the database terminal.
