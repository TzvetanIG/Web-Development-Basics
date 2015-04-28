<nav class="navbar navbar-default">
    <div class="container-fluid">
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <?php if($this->___session->username) { ?>
                <ul class="nav navbar-nav">
                    <li class="active"><a href="/">Добави задача</a></li>
                    <li class="active"><a href="/">Качени задачи</a></li>
                </ul>
                <ul class="nav navbar-nav navbar-right">
                    <li class="dropdown"  data-dropdown="dropdown">
                        <a class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                            <?= $this->___session->username ?> <span class="caret"></span>
                        </a>
                        <ul class="dropdown-menu" role="menu">
                            <li><a href="#">Редактиране на профил</a></li>
                            <li><a href="/users/logout">Изход</a></li>
                        </ul>
                    </li>
                    </li>

                </ul>
            <?php } else { ?>
                <ul class="nav navbar-nav navbar-right">
                    <li><a href="/users/registration">Регистрация</a></li>
                    <li><a href="/users/login">Вход</a></li>
                </ul>
            <?php } ?>
        </div>
    </div>
</nav>