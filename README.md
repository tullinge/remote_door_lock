# Remote door lock

## Requirements
**All Dependencies are included in the repository**
* Arduino libraries
  * ArduinoHttpClient
  * ESP32_Arduino_Servo_Libary
  * HTTPClient
  * WiFi
  * WiFiClientSecure
* Website libraries
  * Vendor

All arduino libraries are under [```ESP32/lib```](ESP32/lib), while all the vendor folders are under [```website/vendor```](website/vendor).

## Parts (physical)
**If** you use a **servo** check so it's strong enough.

**If** you use a **relay** check so it can handle the current.
### Required
* ESP32
* Servo/Relay
### Not Required
* LED

## Instructons (deployment)

### Google API Credential
To set up the goggle API you can follow these instruction [```google instructions```](https://developers.google.com/identity/sign-in/web/sign-in) or the ones bellow.

* Go to https://console.developers.google.com/.
* Click on Create New Project.
* Enter Project Name and Project ID and click on **CREATE**.
* Navigate to your projects OAuth consent screen.
* Choose one of the options listed and click **CREATE**.
* Enter App Name, User support email and Developer contact information to continue (other information can be filled out later).
* Click **SAVE AND CONTINUE** til you reach the end and then click back to dashboard.
* Navigate to the Credential page, click **CREATE CREDENTIALS>OAuth client ID**.
* Select **Web application** and name your **OAuth 2.0 client**.
* Add the *primary* URI under **Authorized JavaScript origins**.
  * https://**URL**/
* Add the *redirect* URI under **Authorized redirect URIs**.
  * https://**URL**/index
* To view your **Client ID** and **Client secret** go to the projects Credential page and click on your apps name under **OAuth 2.0 Client IDs**
  

### Server
For this website you will need a server that can host a PHP 8.0 website, HTTPS shouldn't be used since it wouldn't work with the ESP32

We used a Unix server runing with an SSL license and FileZilla(FTP-client) to upload the files to the server.
* PHP 8.0
* Apache 2.4
* FTP access
  
### Database
For this website you will need a mysql database.

We used a MySQL/MariaDB database.

### Website
For the website to work you have to fill out the necessary variables in the designated files(more detail in website [```README```](website/README.md)).

### Arduino
For the Arduino to work you have to fill out the necessary variables in the designated files(more detail in ESP32 [```README```](ESP32/README.md)).

## User stories

A higher rank can do anything the lower ranks can do and have access to more features (the ones mentioned under that ranks subheading).

### User
* A **user** will be able to **login with my google login**.
* A **logged in user** will be able to **logout**.
* A **logged in user** will be able to **send request to database** which the ESP32 will react to.

### Moderator
* A **logged in moderator** will be able to **register new users** by sending in their firstname, lastname and email.

### Admin
* A **logged in admin** will be able to **register new moderators** by sending in their firstname, lastname and email.
* A **logged in admin** will be able to **register new admins** by sending in their firstname, lastname and email.
* A **logged in admin** will be able to **get a list of registered users**.
* A **logged in admin** will be able to **remove registered users** from accessing the system.
* A **logged in admin** will be able to **remove registered moderators** from accessing the system.
* A **logged in admin** will be able to **change registered user rank** in the database
* A **logged in admin** will be able to **change registered moderators rank** in the database

### Fallback Admin
* A **logged in fallback admin** will be able to **remove registered admins** from accessing the system.
* A **logged in fallback admin** will be able to **change registered user given_name, family_name and email** in the database
* A **logged in fallback admin** will be able to **change registered moderators given_name, family_name and email** in the database
* A **logged in fallback admin** will be able to **change registered admins given_name, family_name, email and rank** in the database


## Second button
A Second button to controll a second ESP32 can be added by duplecating some parts of the backend code.

### Database
To get the secoond eesp32 to work independently, you have to a second log tabel in the database (Don't forget to have diftent names on the diffrent logs tabels.)

### Index
To add a second botton you have to copy this part of the [```index```](website/index.php) file, add it in directly after. (Don't forget to change the request scripts name corespondengly.)
```html
<form action="scripts/request-2-script.php" method="post">
  <button type="submit" name="request-submit">
    <p>Turnon Light</p>
  </button>
</form>
```

### Request script
Copy the request script and change the name corespondengly so it matches with the link in [```index```](website/index.php)

you also heve to change the tabel on line 21 so it matches the right log tabel
```php
$sql = "INSERT INTO RDL_log (given_name, family_name, email) VALUES (?, ?, ?)";
```
to something like
```php
$sql = "INSERT INTO RDL_log_2 (given_name, family_name, email) VALUES (?, ?, ?)";
```

### API
For the api page you have to make a copy and change the name of it (Recomended to be an id number with RDL(Remote door lock)/RLS(Remote light switch)) and change the tabel to get the corect data, you do this by changing line 4.
```php
$sql = "SELECT * FROM RDL_log";
```

### ESP32
On the ESP32 side the only thing you have to change from the first deplayment is the URL ending.
