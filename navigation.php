<nav class="navbar navbar-inverse navbar-fixed-top">
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
                        <?php echo $username;?>&nbsp;
                        <span class="caret"></span>
                    </a>
                    <ul class="dropdown-menu">
                        <li role="presentation">
                            <a role="menuitem" tabindex="-1" href="#">
                                <span class="glyphicon glyphicon-cog"></span>&nbsp;
                                Profile
                            </a>
                        </li>
                        <li role="presentation">
                            <a role="menuitem" tabindex="-1" href="#">
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