<nav class="navbar navbar-expand-lg navbar-dark bg-primary mb-4">
    <div class="container">
        <a class="navbar-brand font-weight-bold" href="/">FLAMiNGO</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav mr-auto">
                <?php
                    $navItems = [
                        "about" => "/about",
                        "messages" => "/messages",
                        "tasks" => "/tasks",
                        "users" => "/users"
                    ];

                    foreach ($navItems as $title => $uri) {
                        $active = $_SERVER['REQUEST_URI'] !== $uri ?: "active";
                        echo "<li class='nav-item {$active}'>";
                        echo "<a href='{$uri}' class='nav-link'>" . ucfirst($title) . "</a>";
                        echo "</li>";
                    }
                ?>
            </ul>
            <ul class="navbar-nav">
                <?php
                $navItems = [
                    "login" => "/auth/login",
                    "register" => "/auth/register",
                ];

                foreach ($navItems as $title => $uri) {
                    $active = $_SERVER['REQUEST_URI'] !== $uri ?: "active";
                    echo "<li class='nav-item {$active}'>";
                    echo "<a href='{$uri}' class='nav-link'>" . ucfirst($title) . "</a>";
                    echo "</li>";
                }
                ?>
            </ul>
        </div>
    </div>
</nav>