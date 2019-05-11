<main>
  <?php $nav_list; ?>
    <section class="rates container">
      <h2>Мои ставки</h2>
      <table class="rates__list">
      <?php foreach ($rates as $rate):  ?>
        <tr class="rates__item">
          <td class="rates__info">
            <div class="rates__img">
              <img src="<?=$rate['image_link']; ?>" width="54" height="40" alt="<?=$rate['NAME']; ?>">
            </div>
            <h3 class="rates__title"><a href="lot.php?id=<?=$rate['id']; ?>"><?=$rate['NAME']?></a></h3>
          </td>
          <td class="rates__category">
          <?=$rate['category']; ?>
          </td>
          <td class="rates__timer">
          <?php $classname = check_passed_date($rate['date_end']) ? 'timer--finishing' : ''; ?>
            <div class="timer <?=$classname; ?>"><?=timer($rate['date_end']); ?></div>
          </td>
          <td class="rates__price">
            <?=format_price($rate['price']); ?>
          </td>
          <td class="rates__time">
          <?=$rate['date_create']; ?>
          </td>
        </tr>
        <? endforeach; ?>
      </table>
    </section>
  </main>