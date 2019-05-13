  <main>
  <?php $nav_list; ?>
    <div class="container">
      <section class="lots">
        <h2><?=$message; ?></h2>
        <?php if(!empty($lots)) : ?>
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
        <?php endif; ?>
      </section>
      <ul class="pagination-list">
        <li class="pagination-item pagination-item-prev"><a>Назад</a></li>
        <li class="pagination-item pagination-item-active"><a>1</a></li>
        <li class="pagination-item"><a href="#">2</a></li>
        <li class="pagination-item"><a href="#">3</a></li>
        <li class="pagination-item"><a href="#">4</a></li>
        <li class="pagination-item pagination-item-next"><a href="#">Вперед</a></li>
      </ul>
    </div>
  </main>