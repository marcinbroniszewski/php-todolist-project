<?= loadPartial('head', ['title' => $title, 'css' => $css]) ?>

<body>

    <main class="main-section d-flex position-relative bg-white">
        <div class="dashboard-nav-container">
            <button class="dashboard-nav-btn">
                <svg xmlns="http://www.w3.org/2000/svg" width="35" height="35" fill="currentColor" class="bi bi-list" viewBox="0 0 16 16">
                    <path fill-rule="evenodd" d="M2.5 12a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5m0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5m0-4a.5.5 0 0 1 .5-.5h10a.5.5 0 0 1 0 1H3a.5.5 0 0 1-.5-.5" />
                </svg>
            </button>
            <div class="back-shadow"></div>
            <div class="dashboard-nav-box">
                <span class="d-none d-md-block logo-icon"><svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-stickies-fill" viewBox="0 0 16 16">
                        <path d="M0 1.5V13a1 1 0 0 0 1 1V1.5a.5.5 0 0 1 .5-.5H14a1 1 0 0 0-1-1H1.5A1.5 1.5 0 0 0 0 1.5" />
                        <path d="M3.5 2A1.5 1.5 0 0 0 2 3.5v11A1.5 1.5 0 0 0 3.5 16h6.086a1.5 1.5 0 0 0 1.06-.44l4.915-4.914A1.5 1.5 0 0 0 16 9.586V3.5A1.5 1.5 0 0 0 14.5 2zm6 8.5a1 1 0 0 1 1-1h4.396a.25.25 0 0 1 .177.427l-5.146 5.146a.25.25 0 0 1-.427-.177z" />
                    </svg></span>
                <ul class="dashboard-nav">
                    <li class="dashboard-nav-link active" id="panel"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-grid-fill" viewBox="0 0 16 16">
                            <path d="M1 2.5A1.5 1.5 0 0 1 2.5 1h3A1.5 1.5 0 0 1 7 2.5v3A1.5 1.5 0 0 1 5.5 7h-3A1.5 1.5 0 0 1 1 5.5zm8 0A1.5 1.5 0 0 1 10.5 1h3A1.5 1.5 0 0 1 15 2.5v3A1.5 1.5 0 0 1 13.5 7h-3A1.5 1.5 0 0 1 9 5.5zm-8 8A1.5 1.5 0 0 1 2.5 9h3A1.5 1.5 0 0 1 7 10.5v3A1.5 1.5 0 0 1 5.5 15h-3A1.5 1.5 0 0 1 1 13.5zm8 0A1.5 1.5 0 0 1 10.5 9h3a1.5 1.5 0 0 1 1.5 1.5v3a1.5 1.5 0 0 1-1.5 1.5h-3A1.5 1.5 0 0 1 9 13.5z" />
                        </svg><span>Panel</span></li>
                    <li class="dashboard-nav-link" id="settings"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-gear-fill" viewBox="0 0 16 16">
                            <path d="M9.405 1.05c-.413-1.4-2.397-1.4-2.81 0l-.1.34a1.464 1.464 0 0 1-2.105.872l-.31-.17c-1.283-.698-2.686.705-1.987 1.987l.169.311c.446.82.023 1.841-.872 2.105l-.34.1c-1.4.413-1.4 2.397 0 2.81l.34.1a1.464 1.464 0 0 1 .872 2.105l-.17.31c-.698 1.283.705 2.686 1.987 1.987l.311-.169a1.464 1.464 0 0 1 2.105.872l.1.34c.413 1.4 2.397 1.4 2.81 0l.1-.34a1.464 1.464 0 0 1 2.105-.872l.31.17c1.283.698 2.686-.705 1.987-1.987l-.169-.311a1.464 1.464 0 0 1 .872-2.105l.34-.1c1.4-.413 1.4-2.397 0-2.81l-.34-.1a1.464 1.464 0 0 1-.872-2.105l.17-.31c.698-1.283-.705-2.686-1.987-1.987l-.311.169a1.464 1.464 0 0 1-2.105-.872l-.1-.34zM8 10.93a2.929 2.929 0 1 1 0-5.86 2.929 2.929 0 0 1 0 5.858z" />
                        </svg><span>Ustawienia</span></li>
                    <li class="dashboard-nav-link" id="logout">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" class="bi bi-door-open-fill" viewBox="0 0 16 16">
                            <path d="M1.5 15a.5.5 0 0 0 0 1h13a.5.5 0 0 0 0-1H13V2.5A1.5 1.5 0 0 0 11.5 1H11V.5a.5.5 0 0 0-.57-.495l-7 1A.5.5 0 0 0 3 1.5V15zM11 2h.5a.5.5 0 0 1 .5.5V15h-1zm-2.5 8c-.276 0-.5-.448-.5-1s.224-1 .5-1 .5.448.5 1-.224 1-.5 1" />
                        </svg>
                        <span>Wyloguj</span>
                    </li>
                </ul>
            </div>
        </div>


        <div class="w-100 p-4 p-sm-5 position-relative mt-lg-5 ms-xl-5">
            <div class="greet-container">
                <?php
                $firstname = htmlspecialchars($user['firstname']);
                $lastname = htmlspecialchars($user['lastname']);
                echo "<h1 class='welcome-header mt-5 py-3 text-light-gray'>Witaj, $firstname!</h1>";
                ?>
                <div class="profile-box"><span><img src="/user/avatar" alt="profile icon" class="profile-icon"></span>
                    <?php echo "<span class='profile-name'>$firstname $lastname</span>"; ?>
                </div>
                <div class="d-flex mb-3">
                    <p><span class="task-counter bigger-text"></span><img class="calendar-icon align-top ms-3" src="./img/calendar-icon.min.png" alt="calendar icon"></p>
                </div>
            </div>

            <div class="main-container">

                <section class="calendar mb-5 d-flex justify-content-center align-items-start">
                    <div>
                        <div class="month-year-box d-flex justify-content-between align-items-top">
                            <div class="me-1">
                                <h2 class="month-year"></h2>
                                <p class="day-date bigger-text"></p>
                            </div>
                            <button class="btn btn-dark add-todo-panel-btn fs-5" data-bs-toggle="modal" data-bs-target="#addTodoModal"><i class="fa-solid fa-plus fa-xs" style="color: #ffffff;"></i> Dodaj zadanie</button>
                        </div>
                        <div>
                            <table class="calendar-table">
                                <thead class="week-days">
                                    <tr>
                                        <th class="week-day">Pon</th>
                                        <th class="week-day">Wt</th>
                                        <th class="week-day">Śr</th>
                                        <th class="week-day">Czw</th>
                                        <th class="week-day">Pt</th>
                                        <th class="week-day">Sob</th>
                                        <th class="week-day">Niedz</th>
                                    </tr>
                                </thead>
                                <tbody class="numeric-days">

                                </tbody>
                            </table>
                        </div>
                        <div class="month-btns-box d-flex justify-content-between my-3 px-4">
                            <button class="prev-month-btn btn switch-month-btn"><i class="fa-solid fa-chevron-left fa-2xl" style="color: #ffffff;"></i></button>
                            <button class="next-month-btn btn switch-month-btn"><i class="fa-solid fa-chevron-right fa-2xl" style="color: #ffffff;"></i></button>
                        </div>
                    </div>
                </section>
                <section class="todo-list">
                    <div class="search-box mb-5 d-none">
                        <i class="fa-solid fa-magnifying-glass fa-xl" style="color: #a8a8a8;"></i>
                        <input type="text" class="search-input" placeholder="Wyszukaj todo...">
                    </div>
                    <h2 class="my-tasks-header bigger-text d-none">Moje zadania</h2>
                    <div class="todo-list-wrapper">
                        <div class="todos-box">
                            <?php
                            if (!empty($todos)) {
                                foreach ($todos as $todo) {
                                    $todo_title = htmlspecialchars($todo['title']);
                                    $todo_description = htmlspecialchars($todo['description']);
                                    $checked_attribute = $todo['checked'] ? 'checked' : '';
                                    $done_class = $todo['checked'] ? 'todo-done' : '';

                                    echo <<<HTML
                                    <div class='todo shadow rounded $done_class' id='{$todo['id']}'>
                                        <div class="checkbox-wrapper-4">
                                            <input class="inp-cbx todo-checkbox" id="morning_{$todo['id']}" type="checkbox" data-todo-id='{$todo['id']}' {$checked_attribute}/>
                                            <label class="cbx" for="morning_{$todo['id']}"><span>
                                                <svg width="12px" height="10px">
                                                    <use xlink:href="#check-4"></use>
                                                </svg></span></label>
                                            <svg class="inline-svg">
                                                <symbol id="check-4" viewbox="0 0 12 10">
                                                    <polyline points="1.5 6 4.5 9 10.5 1"></polyline>
                                                </symbol>
                                            </svg>
                                        </div>
                                        <div class="todo-text-box">
                                            <p class='todo-title' data-todo-id='{$todo['id']}'>{$todo_title}</p>
                                            <p class='todo-description text-light-gray' data-todo-id='{$todo['id']}'>{$todo_description}</p>
                                        </div>
                                        <div class="d-flex">
                                            <button class='remove-todo-btn btn btn-secondary me-2 text-light' data-todo-id='{$todo['id']}'><i class="fa-regular fa-trash-can fa-xl" style="color: #ffffff;"></i></button>
                                            <button class='edit-todo-btn btn btn-warning text-light' data-bs-toggle='modal' data-bs-target='#editTodoModal' data-todo-id='{$todo['id']}'><i class="fa-regular fa-pen-to-square fa-xl" style="color: #ffffff;"></i></button>
                                        </div>
                                    </div>
                                HTML;
                                }
                            }
                            ?>
                        </div>
                    </div>
                </section>
            </div>
            <section class="settings-section d-none p-4">
                <h2 class="mt-5 mx-1 py-3 bigger-text">Ustawienia</h2>
                <div>
                    <h3 class="settings-h3">Zdjęcie profilowe</h3>
                    <form action="/user/avatar" method="post" enctype="multipart/form-data" class="icon-form" id="iconForm">
                        <label for="image" class="profile-image-label">
                            <img src="/user/avatar" alt="profile icon" class="settings-profile-icon">
                            <div class="edit-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil" viewBox="0 0 16 16">
                                    <path d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325" />
                                </svg><span> Edytuj</span>
                            </div>
                        </label>
                        <input type="file" name="image" id="image" accept=".jpg, .jpeg, .png, .webp">
                    </form>
                </div>
                <div class="change-pwd-box">
                    <h3 class="settings-h3">Zmiana hasła</h3>
                    <button class="btn btn-dark settings-btn" data-bs-toggle="modal" data-bs-target="#pwdChangeModal">Zmień hasło</button>
                </div>
            </section>
        </div>
    </main>

    <div class="modal fade fs-5" id="addTodoModal" tabindex="-1" aria-labelledby="addTodoModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-4" id="addTodoModalLabel">Dodaj nowe zadanie</h1>
                    <button type="button" class="btn-close fs-5" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">

                    <form action="/api/add-todo" method='post' id='todo-form' autocomplete="off">
                        <div class="mb-3">
                            <input type="text" class="form-control add-todo-title fs-5" placeholder="Podaj tytuł zadania" name='todo-title'>
                            <p class="error-text d-none text-danger">Tytuł zadania nie może być pusty.</p>
                        </div>
                        <div class="form-floating">
                            <textarea class="form-control add-todo-description fs-5" placeholder="Zmień opis zadania (opcjonalnie)" name="todo-description" rows="50"></textarea>
                            <label for="floatingTextarea" class="text-secondary fs-5">Podaj opis zadania (opcjonalnie)</label>
                        </div>

                        <div class="mt-3">
                            <button type="button" class="btn btn-secondary fs-5" data-bs-dismiss="modal">Anuluj</button>
                            <button type="submit" class="btn btn-warning text-white add-todo-btn fs-5">Zatwierdź</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <div class="modal fade fs-5" id="editTodoModal" tabindex="-1" aria-labelledby="editTodoModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-4" id="editTodoModalLabel">Edytuj zadanie</h1>
                    <button type="button" class="btn-close fs-5" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <section class="edit-todo-panel">
                        <div class="mb-3">
                            <input type="text" placeholder="Podaj nową nazwę zadania" class="edit-todo-input form-control fs-5">
                            <p class="error-text d-none text-danger">Nazwa zadania nie może być pusta.</p>
                        </div>
                        <div class="form-floating">
                            <textarea class="form-control edit-todo-description fs-5" placeholder="Podaj opis zadania (opcjonalnie)" name="edit-todo-description"></textarea>
                            <label for="floatingTextarea" class="text-secondary">Zmień opis zadania lub go usuń</label>
                        </div>
                        <div class="mt-3">
                            <button class="btn btn-secondary fs-5" data-bs-dismiss="modal">Anuluj</button>
                            <button class="save-changes btn btn-warning text-white fs-5">
                                Zatwierdź
                            </button>
                        </div>
                    </section>

                </div>
            </div>
        </div>
    </div>

    <div class="modal fade fs-5" id="pwdChangeModal" tabindex="-1" aria-labelledby="pwdChangeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-4" id="pwdChangeModalLabel">Zmień hasło</h1>
                    <button type="button" class="btn-close fs-5" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="../app/includes/settings_change_pwd.inc.php" method="post" id="changePwdModalForm">
                        <div class="mb-3">
                            <label for="new-password">Aktualne hasło</label>
                            <input type="password" id="current-pwd-input" class="form-control fs-5" placeholder="Podaj aktualne hasło" name='current-password' autocomplete>
                            <p class="error-text text-danger d-none">Hasło składa się z co najmniej 8 znaków</p>
                        </div>
                        <div class="mb-3">
                            <label for="new-password" class="fs-5">Nowe hasło</label>
                            <input type="password" id="new-pwd-input" class="form-control fs-5" placeholder="Podaj nowe hasło" name='new-password' autocomplete>
                            <p class="error-text text-danger d-none">Hasło musi składać się z co najmniej 8 znaków</p>
                        </div>
                        <div class="mb-3">
                            <label for="confirm-password" class="fs-5">Powtórz hasło</label>
                            <input type="password" id="confirm-pwd-input" class="form-control fs-5" placeholder="Potwierdź hasło" name='confirm-password' autocomplete>
                            <p class="error-text text-danger d-none">Podane hasło nie jest takie samo</p>
                        </div>
                        <p>Uwaga! Po zmianie hasła zostaniesz wylogowany z konta.</p>
                        <div class="mt-3">
                            <button type="button" class="btn btn-secondary fs-5" data-bs-dismiss="modal">Anuluj</button>
                            <button type="submit" id="change-pwd-btn" class="btn btn-warning text-white add-todo-btn fs-5">Zatwierdź</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="js/bootstrap.min.js"></script>
    <script src="js/calendar.min.js"></script>
    <script src="js/dashboard-nav.min.js"></script>
    <script src="js/todolist.min.js"></script>
    <script src="js/dashboard-settings.min.js"></script>
</body>