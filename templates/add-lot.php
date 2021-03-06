<?php
?>
<main>
    <?php $nav_list; ?>
    <?php $classname = (empty($errors)) ? '' : 'form--invalid'; ?>
    <form class="form form--add-lot container <?= $classname ?>" action="add.php" method="post"
          enctype="multipart/form-data">
        <h2>Добавление лота</h2>
        <div class="form__container-two">
            <?php $classname = isset($errors['name']) ? 'form__item--invalid' : '';
            $value = isset($lot['name']) ? $lot['name'] : '';
            $message = isset($errors['name']) ? $errors['name'] : '' ?>
            <div class="form__item <?= $classname ?>">
                <label for="lot-name">Наименование <sup>*</sup></label>
                <input id="lot-name" type="text" name="name" placeholder="Введите наименование лота"
                       value="<?= $value ?>">
                <span class="form__error"><?= $message ?></span>
            </div>
            <?php $classname = isset($errors['category']) ? 'form__item--invalid' : '';
            $message = isset($errors['category']) ? $errors['category'] : ''; ?>
            <div class="form__item <?= $classname ?>">
                <label for="category">Категория <sup>*</sup></label>
                <select id="category" name="category">
                    <option>Выберите категорию</option>
                    <?php foreach ($categories as $category) : ?>
                        <option value="<?= $category['id']; ?>" <?= isset($lot['category']) ?
                            ($category['id'] === $lot['category'] ? 'selected' : '') : '' ?> ><?= $category['name']; ?></option>

                    <?php endforeach; ?>
                </select>
                <span class="form__error"><?= $message ?></span>
            </div>
        </div>
        <?php $classname = isset($errors['description']) ? 'form__item--invalid' : '';
        $value = isset($lot['description']) ? $lot['description'] : '';
        $message = isset($errors['description']) ? $errors['description'] : ''; ?>
        <div class="form__item form__item--wide <?= $classname ?>">
            <label for="message">Описание <sup>*</sup></label>
            <textarea id="message" name="description" placeholder="Напишите описание лота"><?= $value ?></textarea>
            <span class="form__error"><?= $message ?></span>
        </div>
        <?php $classname = isset($errors['file']) ? 'form__item--invalid' : '';
        $message = isset($errors['file']) ? $errors['file'] : ''; ?>
        <div class="form__item form__item--file <?= $classname ?>">
            <label>Изображение <sup>*</sup></label>
            <div class="form__input-file">
                <input class="visually-hidden" type="file" id="lot-img" value="" name="img">
                <label for="lot-img">
                    Добавить
                </label>
                <span class="form__error"><?= $message ?></span>
            </div>
        </div>
        <div class="form__container-three">
            <?php $classname = isset($errors['rate']) ? 'form__item--invalid' : '';
            $value = isset($lot['rate']) ? $lot['rate'] : '';
            $message = isset($errors['rate']) ? $errors['rate'] : ''; ?>
            <div class="form__item form__item--small <?= $classname ?>">
                <label for="lot-rate">Начальная цена <sup>*</sup></label>
                <input id="lot-rate" type="text" name="rate" placeholder="0" value="<?= $value ?>">
                <span class="form__error"><?= $message ?></span>
            </div>
            <?php $classname = isset($errors['step']) ? 'form__item--invalid' : '';
            $value = isset($lot['step']) ? $lot['step'] : '';
            $message = isset($errors['step']) ? $errors['step'] : ''; ?>
            <div class="form__item form__item--small <?= $classname ?>">
                <label for="lot-step">Шаг ставки <sup>*</sup></label>
                <input id="lot-step" type="text" name="step" placeholder="0" value="<?= $value ?>">
                <span class="form__error"><?= $message ?></span>
            </div>
            <?php $classname = isset($errors['date']) ? 'form__item--invalid' : '';
            $value = isset($lot['date']) ? $lot['date'] : '';
            $message = isset($errors['date']) ? $errors['date'] : ''; ?>
            <div class="form__item <?= $classname ?>">
                <label for="lot-date">Дата окончания торгов <sup>*</sup></label>
                <input class="form__input-date" id="lot-date" type="text" name="date"
                       placeholder="Введите дату в формате ГГГГ-ММ-ДД" value="<?= $value ?>">
                <span class="form__error"><?= $message ?></span>
            </div>
        </div>
        <span class="form__error form__error--bottom">Пожалуйста, исправьте ошибки в форме.</span>
        <button type="submit" class="button">Добавить лот</button>
    </form>
</main>