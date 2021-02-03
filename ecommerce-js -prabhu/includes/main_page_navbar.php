<nav class="navbar navbar-expand-lg navbar-light bg-light sticky-top">
    <a class="navbar-brand" href="#">
        <img src="https://www.freelogodesign.org/file/app/client/thumb/6609a28e-c91f-40b3-a71e-5ae02da8b6cc_200x200.png?1608705988926"
            width="76" height="52" alt="" loading="lazy">
    </a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown"
        aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNavDropdown">
        <ul class="navbar-nav">
            <li class="nav-item active">
                <a class="nav-link" href="main-page.php">Home <span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">About</a>
            </li>

            <!-- <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Categories
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                        <a class="dropdown-item" href="#">Mens</a>
                        <a class="dropdown-item" href="#">Womens</a>
                        <a class="dropdown-item" href="#">kids</a>
                    </div>
                </li> -->



            <li class="nav-item">
                <a class="nav-link" href="routes.php?route=carts">Cart</a>
                <!-- <a class="nav-link" href="cart.php">Cart</a> -->
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">Contact</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="login.php"
                    <?php echo (!empty($_SESSION['logged_user']))?'style="display:none"' : '' ?>>Login</a>
            </li>

           
            <li class="nav-item">
                <a class="nav-link" href="logout.php"
                    <?php echo (!empty($_SESSION['logged_user']))?'style="display:none"' : '' ?>>Logout</a>
            </li>

        </ul>
    </div>
</nav>