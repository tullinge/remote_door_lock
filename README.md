# Remote door lock

## Requirements
**All Libarys are included in the reposertory**
* Arduino libarys
    * ArduinoHttpClient
    * ESP32_Arduino_Servo_Libary
    * HTTPClient
    * WiFi
    * WiFiClientSecure
* Website libarys
  * Vendor

All arduino libarys are in the [```ESP32/lib```](ESP32/lib) folder, while all the vendor folders are under [```website/vendor```](website/vendor).

## Parts


## Instructons (deployment)

### Google API login

### Server

### Database

### Website

### Arduino

## User storys
A higher rank can do anything the lower ranks can do and have access to more features (the ones mentiond under that ranks subheading).

### User
- A **user** will be able to **login with my goggle login**.
- A **logged in user** will be able to **logout**.
- A **logged in user** will be able to **send request to database** which the ESP32 will react to.

### Moderator
- A **logged in moderator** will be able to **register new users** by sending in their firstname, lastname and email.

### Admin
- A **logged in admin** will be able to **reigster new moderators** by sending in their firstname, lastname and email.
- A **logged in admin** will be able to **reigster new admins** by sending in their firstname, lastname and email.
- A **logged in admin** will be able to **get a list of registered users**.
- A **logged in admin** will be able to **remove registered users** from accessing the system.
- A **logged in admin** will be able to **remove registered moderators** from accessing the system.

### Fallback Admin
- A **logged in fallback admin** will be able to **remove registered admins** from accessing the system.
