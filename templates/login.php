  <main>
  <?php $nav_list; ?>
    <?php $classname = isset($errors) ? 'form--invalid' : '';?>
    <form class="form container <?=$classname?>" action="login.php" method="post"> <!-- form--invalid -->
      <h2>Вход</h2>
      <?php $classname = isset($errors['email']) ? 'form__item--invalid' : '';
      $value = isset($data['email']) ? $data['email']: '';
      $message = isset($errors['email']) ? $errors['email']: ''?>
      <div class="form__item <?=$classname?>"> <!-- form__item--invalid -->
        <label for="email">E-mail <sup>*</sup></label>
        <input id="email" type="text" name="email" placeholder="Введите e-mail" value="<?=$value?>">
        <span class="form__error"><?=$message?></span>
      </div>
      <?php $classname = isset($errors['password']) ? 'form__item--invalid' : '';
      $value = isset($data['password']) ? $data['password']: '';
      $message = isset($errors['password']) ? $errors['password']: ''?>
      <div class="form__item <?=$classname?> form__item--last">
        <label for="password">Пароль <sup>*</sup></label>
        <input id="password" type="password" name="password" placeholder="Введите пароль" value="<?=$value?>">
        <span class="form__error"><?=$message?></span>
      </div>
      <button type="submit" class="button">Войти</button>
    </form>
  </main>