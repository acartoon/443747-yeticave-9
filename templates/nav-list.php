<nav class="nav">
      <ul class="nav__list container">
      <?php foreach ($categories as $value) :?>
        <li class="nav__item">
          <a href="all-lots.php?category=<?=$value['id']; ?>"><?=$value['name']; ?></a>
        </li>
        <?php endforeach; ?>
      </ul>
    </nav>