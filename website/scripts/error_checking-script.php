<?php
    if (isset($_GET['err']))
    {
        if ($_GET['err'] == "not-loged-in-properly")
        {
            echo '<p>You are not loged in properly</p>';
        }

        else if ($_GET['err'] == "form-not-filled-out")
        {
            echo '<p>Add user form not filled out</p>';
        }

        else if ($_GET['err'] == "already-exist")
        {
            echo '<p>User already exist in the system</p>';
        }

        else if ($_GET['err'] == "sqlerr1")
        {
            echo '<p>Error: '.$_GET['err'].'</p>';
        }

        else if ($_GET['err'] == "sqlerr2")
        {
            echo '<p>Charachers in user form are invalid</p>';
        }

        else if ($_GET['err'] == "Dont-even-try" || $_GET['err'] == "Dont-even-try")
        {
            echo '<p>Why?</p>';
        }
    }
    else if (isset($_GET['sus']))
    {
        if ($_GET['sus'] == "request-sent")
        {
            echo '<p>Request properly sent</p>';
        }

        else if ($_GET['sus'] == "added-user")
        {
            echo '<p>User added</p>';
        }

        else if ($_GET['sus'] == "added-moderator")
        {
            echo '<p>Moderator added</p>';
        }

        else if ($_GET['sus'] == "added-admin")
        {
            echo '<p>Admin added</p>';
        }

        else if ($_GET['sus'] == "user-deleted")
        {
            echo '<p>User removed</p>';
        }
    }