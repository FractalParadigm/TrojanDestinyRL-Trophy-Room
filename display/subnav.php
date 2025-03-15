<div class="subNav">
    <?php
    // Is the user is logged in we'll show them a navigation bar with some fancier options
    if (isset($_SESSION["userID"])) {
        echo "<a href=\"/user/" . $_SESSION["username"] . "\" class=\"subNavLink\">ACCOUNT</a>";
        echo "<a href=\"/\" class=\"subNavLink\">HOME</a>";
        echo "<a href=\"/user/logout.php\" class=\"subNavLink\">LOGOUT</a>";
        echo "<a href=\"/admin/data_management/game_form.php\" target=\"dataFrame\" class=\"subNavLink disabled\">ADD GAME DETAILS</a>";
        // Anything we need to show to logged in admins will be below
        if (isset($_SESSION["privileges"]) && $_SESSION["privileges"] == 1) {
            echo "<a href=\"/admin/data_management/tourney_form.php\" target=\"dataFrame\" class=\"subNavLink\">ADD A TOURNEY</a>";
            echo "<a href=\"/admin\" class=\"subNavLink\">ADMIN PANEL</a>";
        }
    } else {
        echo "<a href=\"/user/login_page.php\" target=\"dataFrame\" class=\"subNavLink\">SIGN IN</a>";
        echo "<a href=\"/user/create_account.php\" target=\"dataFrame\" class=\"subNavLink\">CREATE AN ACCOUNT</a>";
        echo "<a href=\"/\" class=\"subNavLink\">HOME</a>";
    }
    ?>
</div>