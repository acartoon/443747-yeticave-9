<main>
<?php $nav_list; ?>
    <section class="lot-item container">
        <h2><?=htmlspecialchars($lot['name']); ?></h2>
        <div class="lot-item__content">
            <div class="lot-item__left">
                <div class="lot-item__image">
                    <img src="../<?=$lot['image_link'];?>" width="730" height="548" alt="Сноуборд">
                </div>
                <p class="lot-item__category">Категория: <span><?=$lot['category'];?></span></p>
                <p class="lot-item__description"><?=htmlspecialchars($lot['description']);?></p>
            </div>
            <div class="lot-item__right">
                <div class="lot-item__state">
                <?php $classname = check_passed_date($lot['date_end']) ? 'timer--finishing' : ''; ?>
                    <div class="lot-item__timer timer <?=$classname; ?>">
                    <?=timer($lot['date_end']);?>
                    </div>
                    <div class="lot-item__cost-state">
                        <div class="lot-item__rate">
                            <span class="lot-item__amount">Текущая цена</span>
                            <span class="lot-item__cost"><?=format_price($lot['price']);?></span>
                        </div>
                        <div class="lot-item__min-cost">
                            Мин. ставка <span><?=format_price($lot['min_price']);?></span>
                        </div>
                    </div>
                    <?php if($add_rate): ?>
                    <form class="lot-item__form" action="lot.php?id=<?=$lot['id']?>" method="post" autocomplete="off">
                    <?php $classname = !empty($error) ? 'form__item--invalid' : '';
                    $value = !empty($step) ? $step: '';
                    $message = !empty($error) ? $error: '';?>
                        <p class="lot-item__form-item form__item <?=$classname; ?>">
                            <label for="cost">Ваша ставка</label>
                            <input id="cost" type="text" name="cost" placeholder="12 000" value ="<?=$value; ?>">
                            <span class="form__error"><?=$message; ?></span>
                        </p>
                        <button type="submit" class="button">Сделать ставку</button>
                    </form>
                    <?php endif; ?>
                </div>
                <div class="history">
                    <h3>История ставок (<span><?=$rates_count?></span>)</h3>
                    <table class="history__list">
                        <?php foreach ($rates as $rate) :?>
                        <tr class="history__item">
                            <td class="history__name"><?=$rate['name']?></td>
                            <td class="history__price"><?=format_price($rate['price'])?></td>
                            <td class="history__time"><?=$rate['date_create']?></td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
            </div>
        </div>
    </section>
</main>
