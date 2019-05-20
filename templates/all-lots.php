  <main>
  <?php $nav_list; ?>
    <div class="container">
      <section class="lots">
        <h2><?=$message; ?></h2>
        <ul class="lots__list">
        <?php foreach ($lots as $lot) :?>
          <li class="lots__item lot">
            <div class="lot__image">
              <img src="<?=$lot['image_link']; ?>" width="350" height="260" alt="<?=htmlspecialchars($lot['name']); ?>">
            </div>
            <div class="lot__info">
              <span class="lot__category"><?=$lot['category']; ?></span>
              <h3 class="lot__title"><a class="text-link" href="lot.php?id=<?=$lot['id']; ?>"><?=htmlspecialchars($lot['name']); ?></a></h3>

              <div class="lot__state">
                <div class="lot__rate">
                  <span class="lot__amount">Стартовая цена</span>
                  <span class="lot__cost"><?=format_price($lot['price']); ?></span>

                </div>
                <div class="lot__timer timer">
                <?=timer($lot['date_end'])?>
                </div>
              </div>
            </div>
          </li>
          <?php endforeach; ?>
        </ul>
      </section>
      <?php if ($pages_count > 1): ?>
      <ul class="pagination-list">
        <li class="pagination-item pagination-item-prev"><a href="all-lots.php?category=<?=$category;?>&page=<?=$cur_page -1; ?>">Назад</a></li>
        <?php foreach ($pages as $page): ?>
        <li class="pagination-item <?php if ($page == $cur_page): ?>pagination__item--active<?php endif; ?>"><a href="all-lots.php?category=<?=$category;?>&page=<?=$page;?>"><?=$page;?></a></li>
        <?php endforeach; ?>
        <li class="pagination-item pagination-item-next"><a href="all-lots.php?category=<?=$category;?>&page=<?=$cur_page +1; ?>">Вперед</a></li>
      </ul>
      <?php endif; ?>
    </div>
  </main>