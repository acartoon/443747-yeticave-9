<main>
    <?php $nav_list; ?>
    <section class="rates container">
        <h2>Мои ставки</h2>
        <table class="rates__list">

            <?php foreach ($rates as $rate): ?>
                <? $classname = class_rates($rate['winner'], $rate['date_end'], 'rates__item--end',
                    'rates__item--win') ?>
                <tr class="rates__item <?= $classname ?>">
                    <td class="rates__info">
                        <div class="rates__img">
                            <img src="<?= $rate['image_link']; ?>" width="54" height="40"
                                 alt="<?= htmlspecialchars($rate['NAME']); ?>">
                        </div>
                        <h3 class="rates__title"><a
                                    href="lot.php?id=<?= $rate['id_lot']; ?>"><?= htmlspecialchars($rate['NAME']) ?></a>
                        </h3>
                    </td>
                    <td class="rates__category">
                        <?= $rate['category']; ?>
                    </td>
                    <td class="rates__timer">
                        <?php $classname = class_rates_timer($rate['winner'], $rate['date_end'], 'timer--finishing',
                            'timer--win') ?>
                        <div class="timer <?= $classname; ?>"><?= format_rates_timer($rate['date_end'],
                                $rate['winner']); ?></div>
                    </td>
                    <td class="rates__price">
                        <?= number_format($rate['price'], 0, '.', ' ') . ' p'; ?>
                    </td>
                    <td class="rates__time">
                        <?= format_rates_time($rate['date_create']); ?>
                    </td>
                </tr>
            <? endforeach; ?>
        </table>
    </section>
</main>