# Website

## Setup
To set up the page you have to fill out these three files with the corect information and then remove "**enter_info-**" from the begining of the file names.
* [```enter_info-db_info.php```](database/enter_info-db_info.php) (The filed responesebel for the connection to the database)
* [```enter_info-info.json```](enter_info-info.json) 
* [```enter_info-config.php```](enter_info-config.php) 

## Index
The index page is the primary page for sign in, sending a request, adding users and link to user list.(add users and userlist is only available for *moderators*, *admins* and *fallback admin*.)

### Send request
To send a request you sign with your registered email and press the **OPEN DOOR** button

### Add user
To add a user you have to sign with a registered *moderator*, *admin* or *fallback admin* account and then write the information of the user you wish to add in the **given_name**, **family_name** and **email** text feilds. Then if you are an *admin* or *fallback admin* you now choose what rank to give them and press **ADD USER**. If you do not specify the rank or you are a *moderator* they will automatically get the rank of *user*

### Remove user
To remove a *user* you have to be logged in as an *admin* or a *fallback admin*. To remove a user sign in with your email and click on **USER LIST** find the account you want to remove and click **REMOVE USER**


## API
The API page is just a page that returns the number of rows in the log tabel in the database, Which is then fetched by the arduino.

## Composer
**all of these files are included**

Composer is a tool for dependency management in PHP. It allows you to declare the libraries your project depends on and it will manage (install/update) them for you.

To download composer you can follow this guide https://getcomposer.org/download/

### Vendor
Vendor is a dependency which is required for google authentication/google login.

To get the vendor files with the correct google libraries use this command

```
composer require google/apiclient:"^2.0"
```

