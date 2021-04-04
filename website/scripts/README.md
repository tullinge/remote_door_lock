# Scripts
In this README we explain how the scripts work in rught trems.

All scripst exept logout-script.php also returns a msg in the URL if it succeeds or gets an error (it adds the error or success msg att the end of the URL).
```
err = already-exist
sus = added-user
```
## Add user
[```This script```](add_user-script.php) gets a post request fom the index file and adds the user if the information is not empty and make sure there are no duplicates.

## Error checking
[```This script```](error_checking-script.php) gets the error message from the URL and echos it back to the user.

## Delete user
[```This script```](delete_user-script.php) gets the id of a user you want to delete when you press the **REMOVE USER** button, then it checks the database to see if you have a higher rank then the user you are trying to remove, if you have a higher rank it will send a request to the database to remove that user.

## Logout
[```This script```](logout-script.php) revokes the user's token and destroy the user's session when the **LOGOUT** button.

## Open
[```This script```](request-script.php) sends a request to add a line in the database containing *given_name*, *family_name*, *email* and *time* **OPEN DOOR**.

## Error messages
```
err = not-loged-in-properly
```
Your session is not working.

Solution: log out and back in.
```
err = form-not-filled-out
```
The form to add a person was not filled out (one or more text fields were empty).

Solution: fill out all the text fields.
```
err = already-exist
```
You tried to add a person that already have their email in the system.

Solution: Don't add them.
```
err = sqlerr1
```
There is something wrong with the prepared statement in the code

Solution: Try to fix the code by checking the $sql = "Statement"
```
err = sqlerr2
```
Your SQL statment failed.

Solution: Check so you don't use any special symbols in the **given_name**, **family_name** or **email**.
```
err = Dont-even-try
```
You tried to reach a site without using the proper links.

Solution: Do it the correct way.
```
err = not-authorized
```
You tried to delete someone with a higher rank.

Solution: There is none

## Succsess messages
```
sus = request-sent
```
The request got sent to the database.
```
sus = added-user
```
Added a user.
```
sus = added-moderator
```
Added a moderator.
```
sus = added-admin
```
Added an admin.
```
sus = user-deleted
```
A user was removed.