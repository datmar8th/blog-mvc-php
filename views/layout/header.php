<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>products</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Test ">
    <meta name="author" content="pacificsoftdev@gmail.com">

    <!-- Bootstrap core CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="https://site-assets.fontawesome.com/releases/v6.5.1/css/all.css">
    <link rel="stylesheet" href="https://site-assets.fontawesome.com/releases/v6.5.1/css/sharp-thin.css">
    <link rel="stylesheet" href="https://site-assets.fontawesome.com/releases/v6.5.1/css/sharp-solid.css">
    <link rel="stylesheet" href="https://site-assets.fontawesome.com/releases/v6.5.1/css/sharp-regular.css">
    <link rel="stylesheet" href="https://site-assets.fontawesome.com/releases/v6.5.1/css/sharp-light.css">
    <link href="<?php echo RootREL; ?>media/css/main.css" rel="stylesheet">
    <?php echo html_helpers::cssHeader(); ?>
    <script>
        var rootURL = '<?= RootURL ?>'
    </script>
</head>

<body>
    <header>
        <nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
            <div class="container-fluid">
                <a class="navbar-brand" href="#">Linh Duong</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarCollapse">
                    <ul class="navbar-nav me-auto mb-2 mb-md-0">
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="<?php echo html_helpers::url('/'); ?>">Home</a>
                        </li>
                        <!-- <li class="nav-item">
                            <a class="nav-link" href="<?php echo html_helpers::url(['ctl' => 'about']); ?>">About us</a>
                        </li> -->
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo html_helpers::url(['ctl' => 'tables']); ?>">Tables</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo html_helpers::url(['ctl' => 'products']); ?>">Products</a>
                        </li>
                        <!-- <li class="nav-item">
                            <a class="nav-link" href="<?php echo html_helpers::url(['ctl' => 'contact']); ?>">Contact us</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link disabled" href="#" tabindex="-1" aria-disabled="true">Disabled</a>
                        </li> -->
                        <li class="nav-item">
                            <a class="nav-link" href="<?php echo html_helpers::url(['ctl' => 'users']); ?>">User</a>
                        </li>
                    </ul>
                    <form class="d-flex">
                        <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
                        <button class="btn btn-outline-success" type="submit">Search</button>
                    </form>
                    <div class="btn-login-group me-3 ms-5 d-flex align-items-center">
                        <?php if (!empty($_SESSION['auth'])) { ?>
                            <span class="me-2 text-light d-block">
                                welcome,
                                <a class="text-warning" href="<?php echo html_helpers::url(['ctl' => 'users']); ?>"><?php echo $_SESSION['auth']['username'] ?></a>
                            </span>
                            <a href="<?php echo html_helpers::url(['ctl' => 'users', 'act' => 'logout']); ?>" class="btn btn-custom-auth text-light">Logout</a>
                        <?php } else { ?>
                            <a href="<?php echo html_helpers::url(['ctl' => 'users', 'act' => 'login']); ?>" class="btn btn-custom-auth text-light">Login</a>
                            <a href="<?php echo html_helpers::url(['ctl' => 'users', 'act' => 'signup']); ?>" class="btn btn-custom-auth text-light ms-2">Sign up</a>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </nav>
    </header>
    <main>
        <div class="container">