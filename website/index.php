<!DOCTYPE html>

<html lang="en">
  <head>
    <meta name="google-signin-client_id" content="1067212173991-japbajac1p0chmv20sj8q8jpc0ur5rpc.apps.googleusercontent.com">
    <script src="https://apis.google.com/js/platform.js" async defer></script>
  </head>
  <body>
    <div class="g-signin2" data-onsuccess="onSignIn" data-theme="dark"></div>
    <button onclick="signOut()">Sign Out</button>

    <script>
      function onSignIn(googleUser) {
        // Useful data for your client-side scripts:
        var profile = googleUser.getBasicProfile();
        console.log("Email: " + profile.getEmail());
      }

      function myFunction() {
        var email = profile.getEmail().innerHTML;
        document.getElementById("demo").innerHTML = email;
      }

      function signOut() {
        gapi.auth2.getAuthInstance().signOut().then(function() {
          console.log("bye")
        });
      }

    </script>
    <p id="demo" ></p>
  </body>
</html>