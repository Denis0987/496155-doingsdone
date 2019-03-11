<main class="content__main">
    <h2 class="content__main-heading">Список задач</h2>

    <form class="search-form" action="index.php" method="post">
        <input class="search-form__input" type="text" name="" value="" placeholder="Поиск по задачам">

        <input class="search-form__submit" type="submit" name="" value="Искать">
    </form>

    <div class="tasks-controls">
        <nav class="tasks-switch">
            <a href="index.php" class="tasks-switch__item <?= (!isset($_GET['task_date'])) ? 'tasks-switch__item--active' : '' ?>">Все задачи</a>
            <a href="index.php?task_date=day" class="tasks-switch__item <?= (isset($_GET['task_date']) && $_GET['task_date'] == "day") ? 'tasks-switch__item--active' : '' ?>">Повестка дня</a>
            <a href="index.php?task_date=tomorrow" class="tasks-switch__item <?= (isset($_GET['task_date']) && $_GET['task_date'] == "tomorrow") ? 'tasks-switch__item--active' : '' ?>">Завтра</a>
            <a href="index.php?task_date=dead" class="tasks-switch__item <?= (isset($_GET['task_date']) && $_GET['task_date'] == "dead") ? 'tasks-switch__item--active' : '' ?>">Просроченные</a>
        </nav>

        <label class="checkbox">
            <!--добавить сюда аттрибут "checked", если переменная $show_complete_tasks равна единице-->
            <input class="checkbox__input visually-hidden show_completed" type="checkbox" <?= ($show_complete_tasks) ? 'checked' : ''; ?>>
            <span class="checkbox__text">Показывать выполненные</span>
        </label>
    </div>

    <table class="tasks">
        <?php foreach ($tasks as $key => $value): ?>
            <tr class="tasks__item task <?= (!empty($value['done_at']) && !$show_complete_tasks) ? 'task--hide' : ''; ?><?= (!empty($value['done_at']) && $show_complete_tasks) ? 'task--completed' : ''; ?>">
                <td class="task__select">
                    <label class="checkbox task__checkbox">
                        <input class="checkbox__input visually-hidden task__checkbox" type="checkbox" value="<?= $value['id']; ?>">
                        <span class="checkbox__text"><?=$value["title_task"];?></span>
                    </label>
                </td>

                <td class="task__file">
                  <a class="<?=($value['file_task'] ? "download-link" : "");?>" href="<?=$value['file_task'];?>" target="_blank"><?=htmlspecialchars($value['file_task']) ; ?></a>
                </td>

                <td class="task__date"><?=$value["deadline"];?></td>
            </tr>
        <?php endforeach; ?>
    </table>
</main>
