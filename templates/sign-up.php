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
    <form class="form container" action="sign-up.php" method="post" autocomplete="off"> <!-- form--invalid -->
      <h2>Регистрация нового аккаунта</h2>
      <?php $classname = isset($errors['email']) ? 'form__item--invalid' : "";
      $value = isset($user['email']) ? $user['email']: '';
      $message = isset($errors['email']) ? $errors['email']: ''?>
      <div class="form__item <?=$classname;?>">
        <label for="email">E-mail <sup>*</sup></label>
        <input id="email" type="text" name="user[email]" placeholder="Введите e-mail" value="<?=$value;?>">
        <span class="form__error"><?=$message;?></span>
      </div>
      <?php $classname = isset($errors['password']) ? 'form__item--invalid' : "";
      $value = isset($user['password']) ? $user['password']: '';
      $message = isset($errors['password']) ? $errors['password']: ''?>
      <div class="form__item <?=$classname;?>">
        <label for="password">Пароль <sup>*</sup></label>
        <input id="password" type="password" name="user[password]" placeholder="Введите пароль" value="<?=$value;?>">
        <span class="form__error"><?=$message;?></span>
      </div>
      <?php $classname = isset($errors['name']) ? 'form__item--invalid' : "";
      $value = isset($user['name']) ? $user['name']: '';
      $message = isset($errors['name']) ? $errors['name']: ''?>
      <div class="form__item <?=$classname;?>">
        <label for="name">Имя <sup>*</sup></label>
        <input id="name" type="text" name="user[name]" placeholder="Введите имя" value="<?=$value;?>">
        <span class="form__error"><?=$message;?></span>
      </div>
      <?php $classname = isset($errors['message']) ? 'form__item--invalid' : "";
      $value = isset($user['message']) ? $user['message']: '';
      $message = isset($errors['message']) ? $errors['message']: ''?>
      <div class="form__item <?=$classname;?>">
        <label for="message">Контактные данные <sup>*</sup></label>
        <textarea id="message" name="user[message]" placeholder="Напишите как с вами связаться"><?=$value;?></textarea>
        <span class="form__error"><?=$message;?></span>
      </div>
      <span class="form__error form__error--bottom">Пожалуйста, исправьте ошибки в форме.</span>
      <button type="submit" class="button">Зарегистрироваться</button>
      <a class="text-link" href="#">Уже есть аккаунт</a>
    </form>
  </main>
