
<?php
?>
<main>
    <nav class="nav">
      <ul class="nav__list container">
      <?php foreach ($categories as $value) :?>
        <li class="nav__item">
          <a href="all-lots.html"><?=$value['name']; ?></a>
        </li>
        <?php endforeach; ?>
      </ul>
    </nav>
    <?php $classname = (empty($errors)) ? '' : 'form--invalid'; ?>
    <form class="form form--add-lot container <?=$classname?>" action="add.php" method="post" enctype="multipart/form-data"> <!-- form--invalid -->
      <h2>Добавление лота</h2>
      <div class="form__container-two">
      <?php $classname = isset($errors['name']) ? 'form__item--invalid' : '';
      $value = isset($lot['name']) ? $lot['name']: '';
      $message = isset($errors['name']) ? $errors['name']: ''?>
        <div class="form__item <?=$classname?>"> <!-- form__item--invalid -->
          <label for="lot-name">Наименование <sup>*</sup></label>
          <input id="lot-name" type="text" name="lot[name]" placeholder="Введите наименование лота" value="<?=$value?>"> 
          <span class="form__error"><?=$message?></span>
        </div>
        <?php $classname = isset($errors['category']) ? 'form__item--invalid' : '';
         $message = isset($errors['category']) ? $errors['category']: '';?>
        <div class="form__item <?=$classname?>">
          <label for="category">Категория <sup>*</sup></label>
          <select id="category" name="lot[category]"> 
            <option>Выберите категорию</option>
            <?php foreach ($categories as $category) :?>
            <option <?=$value?> value="<?=$category['id']; ?>"><?=$category['name']; ?></option>
            <?php endforeach; ?>
          </select>
          <span class="form__error"><?=$message?></span>
        </div>
      </div>
      <?php $classname = isset($errors['description']) ? 'form__item--invalid' : '';
        $value = isset($lot['description']) ? $lot['description']: '';
        $message = isset($errors['description']) ? $errors['description']: '';?>
      <div class="form__item form__item--wide <?=$classname?>">
        <label for="message">Описание <sup>*</sup></label>
        <textarea id="message" name="lot[description]" placeholder="Напишите описание лота"><?=$value?></textarea>
        <span class="form__error"><?=$message?></span>
      </div>
      <?php $classname = isset($errors['img']) ? 'form__item--invalid' : '';
       $message = isset($errors['img']) ? $errors['img']: '';?>
      <div class="form__item form__item--file <?=$classname?>">
        <label>Изображение <sup>*</sup></label>
        <div class="form__input-file">
          <input class="visually-hidden" type="file" id="lot-img" value="" name="img">
          <label for="lot-img">
            Добавить
          </label>
        </div>
      </div>
      <div class="form__container-three">
      <?php $classname = isset($errors['rate']) ? 'form__item--invalid' : '';
        $value = isset($lot['rate']) ? $lot['rate']: '';
        $message = isset($errors['rate']) ? $errors['rate']: '';?>
        <div class="form__item form__item--small <?=$classname?>">
          <label for="lot-rate">Начальная цена <sup>*</sup></label>
          <input id="lot-rate" type="text" name="lot[rate]" placeholder="0" value="<?=$value?>"> 
          <span class="form__error"><?=$message?></span>
        </div>
        <?php $classname = isset($errors['step']) ? 'form__item--invalid' : '';
        $value = isset($lot['step']) ? $lot['step']: '';
        $message = isset($errors['step']) ? $errors['step']: '';?>
        <div class="form__item form__item--small <?=$classname?>">
          <label for="lot-step">Шаг ставки <sup>*</sup></label>
          <input id="lot-step" type="text" name="lot[step]" placeholder="0" value="<?=$value?>"> 
          <span class="form__error"><?=$message?></span>
        </div>
        <?php $classname = isset($errors['date']) ? 'form__item--invalid' : '';
        $value = isset($lot['date']) ? $lot['date']: '';
        $message = isset($errors['date']) ? $errors['date']: '';?>
        <div class="form__item <?=$classname?>">
          <label for="lot-date">Дата окончания торгов <sup>*</sup></label>
          <input class="form__input-date" id="lot-date" type="text" name="lot[date]" placeholder="Введите дату в формате ГГГГ-ММ-ДД" value="<?=$value?>"> 
          <span class="form__error"><?=$message?></span>
        </div>
      </div>
      <span class="form__error form__error--bottom">Пожалуйста, исправьте ошибки в форме.</span>
      <button type="submit" class="button">Добавить лот</button>
    </form>
  </main>