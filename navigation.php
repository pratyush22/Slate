<nav class="navbar navbar-inverse navbar-static-top">
    <div class="container">
        <div class="navbar-header">
            <a class="navbar-brand" href="index.php">Slate</a>
        </div>
        
        <!--
          Right user menu containing
          profile and log out option.
        -->
        <div class="nav navbar-nav navbar-right">
            <ul class="nav navbar-nav">
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <?php echo $_SESSION["name"];?>&nbsp;
                        <span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu">
                        <li role="presentation">
                            <a role="menuitem" tabindex="-1" href="dashboard.php">
                                <span class="glyphicon glyphicon-dashboard"></span>&nbsp;
                                Dashboard
                            </a>
                        </li>
                        <li role="presentation">
                            <a role="menuitem" tabindex="-1" href="profile.php">
                                <span class="glyphicon glyphicon-user"></span>&nbsp;
                                Profile
                            </a>
                        </li>
                        <li role="presentation">
                            <a role="menuitem" tabindex="-1" href="logout.php">
                                <span class="glyphicon glyphicon-log-out"></span>&nbsp;
                                Logout
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>