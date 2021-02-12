# Database

The database needed for the programs basic functions and admin, freeaccess and log functions.  
**IT IS NEEDED FOR THE PROGRAM TO WORK**.

## Usees

The database is used to keep track of enery time the RDL is used and to keep track off what personel is allowed to have free access and who is an admin.


## Setup

To set up the database it is done in two parts first part is seting up a database witch can be reatched from any ip (Recomneded for ease of setup).

### Database setup

The inportant part after you have managed to set up a database is to open the [```enter_info-db_info.php```](enter_info-db_info.php) and enter all the relavent information, after that is don you remove "*enter_info-*" from the name of the file.
### Setup tabels

The setup of tabels into the database is simple, just write the code in [```setup_db.sql```](db_setup_removal/setup_db.sql)

## Removal

### Removal of all data

To remove all data in the tabels, just write the code in [```clear_db.sql```](db_setup_removal/clear_db.sql) into the terminal for your database.

### Removal of all tabels

To remove all tabels into the database, just write the code in [```drop_db.sql```](db_setup_removal/drop_db.sql) into the terminal for your database.