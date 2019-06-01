<main class="container">
    <section class="promo">
        <h2 class="promo__title">Нужен стафф для катки?</h2>
        <p class="promo__text">На нашем интернет-аукционе ты найдёшь самое эксклюзивное сноубордическое и
            горнолыжное снаряжение.</p>
        <ul class="promo__list">
            <!--заполните этот список из массива категорий-->

            <?php foreach ($categories as $value) : ?>
                <li class="promo__item promo__item--<?= $value['character_code']; ?>">
                    <a class="promo__link" href="all-lots.php?category=<?= $value['id']; ?>"><?= $value['name']; ?></a>
                </li>
            <?php endforeach; ?>
        </ul>
    </section>
    <section class="lots">
        <div class="lots__header">
            <h2>Открытые лоты</h2>
        </div>
        <ul class="lots__list">

            <?php foreach ($lots as $value): ?>
                <li class="lots__item lot">
                    <div class="lot__image">
                        <img src="<?= $value['URL']; ?>" width="350" height="260"
                             alt="<?= htmlspecialchars($value['name']); ?>">
                    </div>
                    <div class="lot__info">
                        <span class="lot__category"><?= $value['category']; ?></span>
                        <h3 class="lot__title"><a class="text-link"
                                                  href="lot.php?id=<?= $value['id']; ?>"><?= htmlspecialchars($value['name']); ?></a>
                        </h3>
                        <div class="lot__state">
                            <div class="lot__rate">
                                <span class="lot__amount"><?= (int)$value['count_rates'] === 0 ? 'Начальная цена' : $value['count_rates'] . get_noun_plural_form($value['count_rates'],
                                            ' ставка', ' ставки', ' ставок'); ?></span>
                                <span class="lot__cost"><?= format_price($value['initial_price']); ?></span>
                            </div>
                            <div class="lot__timer timer">
                                <?= timer($value['date_end']) ?>
                            </div>
                        </div>
                    </div>
                </li>
            <?php endforeach; ?>
        </ul>
    </section>
</main>