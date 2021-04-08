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
For the Arduino to work you have to fill out the necessary variables in the designated files(more detail in ESP32 [```README```](ESP32/README.md))..

## User stories

A higher rank can do anything the lower ranks can do and have access to more features (the ones mentioned under that ranks subheading).

### User
* A **user** will be able to **login with my goggle login**.
* A **logged in user** will be able to **logout**.
* A **logged in user** will be able to **send request to database** which the ESP32 will react to.

### Moderator
* A **logged in moderator** will be able to **register new users** by sending in their firstname, lastname and email.

### Admin
* A **logged in admin** will be able to **reigster new moderators** by sending in their firstname, lastname and email.
* A **logged in admin** will be able to **reigster new admins** by sending in their firstname, lastname and email.
* A **logged in admin** will be able to **get a list of registered users**.
* A **logged in admin** will be able to **remove registered users** from accessing the system.
* A **logged in admin** will be able to **remove registered moderators** from accessing the system.

### Fallback Admin
* A **logged in fallback admin** will be able to **remove registered admins** from accessing the system.
