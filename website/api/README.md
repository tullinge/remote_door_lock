# API

## Page
The API page is named after which microcontroler is supose to read the number.

## Code
The code is just made to return the number of lines in the log tabel.

# Add multiple servos/relays
To add a second button for a second remotecontrolled servo/relay, you also have to add a second tabel in the same database and a second API page. For the second API page you have to change the ``$sql =`` to take from a difrent table.

For exemple:

``$sql = "SELECT * FROM "RDL_log"";``

``$sql = "SELECT * FROM "RLS_log"";``