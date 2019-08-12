<?php
// Здесь формируется весь html, включая поднимаемые чеерз ajax.
class templates {
    // Шаблон для head
    public function header() {
         ?>
        <html lang="ru">
            <head>
                <meta content="width=device-width, initial-scale=1" name="viewport" />
                <title></title>
                <link rel="stylesheet" href="./template/css/template.css">
                <script src="./template/js/jquery.min.js"></script>
            </head>
            <body>
                <div class="main">
        <?
    }
    // Шаблон для "футера", с подключенным js.
    public function footer() {
            ?>  </div>
                <script src="./template/js/template.js"></script>
            </body>
        </html>
        <?
    }
    // Шаблон первого экрана
    public function tariffRow($page_data) {
        echo '<div class="tariff_rows">';
        foreach ($page_data as $key => $value) { ?>
            <div class="tariff_row">
                <h2>Тариф "<?=$value['title']?>"</h2>
                <div class="go_to" data-ajax="<?=$value['children']?>" data-parent="<?=$value['children']?>">
                    <div class="speed"><div class="label<?=$value['class']?>"><?=$value['speed']?> Мбит/с</div></div>
                    <div class="price_diapason"><?=$value['price_diapason']?>  <span class="rubl">o</span>/мес</div>
                    <div class="free_options"><?=$value['free_options']?></div>
                </div>
                <div class="link">
                    <a target="_blank" href="<?=$value['link']?>">Узнать подробнее на сайте www.sknt.ru</a>
                </div>
            </div>
        <? }
        echo '</div>';
    }
    // Шаблон второго экрана
    public function tariffCurrent($page_data) {

        foreach ($page_data as $key => $value) { ?>
            <?php if ($key == 0) {?>
                <header class="tariff_head go_to" data-ajax="main">
                    <h1>Тариф "<?=$value['title']?>"</h1>
                </header>
                 <div class="tariff_rows">
            <?php } ?>
            <div class="tariff_row">
                <?php if (!empty($value['pay_period'])) { ?>
                    <h2><?=$value['pay_period']?></h2>
                <?php } else { ?>
                    <h2>1 месяц</h2>
                <?php } ?>
                <div class="go_to" data-ajax="<?=$value['ID']?>" data-parent="<?=$_POST['data']?>">
                    <div class="price_per_month"><?=$value['price_per_month']?>  <span class="rubl">o</span>/мес</div>
                    <div class="price">Разовый платёж - <?=$value['price']?>  <span class="rubl">o</span>
                    <?php if ($value['discount'] != 0) { ?>
                        <br>Скидка - <?=$value['discount']?>  <span class="rubl">o</span>
                    <?php } ?>
                    </div>
                </div>
            </div>
        <? }
        echo '</div>';
    }
    // Шаблон третьего экрана
    public function selectTariff($page_data) {
        foreach ($page_data as $key => $value) { ?>
            <header class="tariff_head go_to" data-ajax="<?=$_POST['parent']?>">
                <h1>Выбор тарифа</h1>
            </header>
            <div class="tariff_row">
                <h2>Тариф "<?=$value['title']?>"</h2>
                <div class="tariff_select">
                    <?php if (!empty($value['pay_period'])) { ?>
                        <div class="price_per_month">Период оплаты - <?=$value['pay_period']?><br>
                            <?=$value['price_per_month']?>  <span class="rubl">o</span>/мес</div>
                    <?php } else { ?>
                        <div class="price_per_month">Период оплаты - 1 месяц<br>
                            <?=$value['price_per_month']?>  <span class="rubl">o</span>/мес</div>
                    <?php } ?>

                    <div class="price">Разовый платёж - <?=$value['price']?>  <span class="rubl">o</span><br>
                    Cо счёта спишется - <?=$value['price']?>  <span class="rubl">o</span></div>
                    <div class="new_payday">Вступит в силу - сегодня<br>
                    Дата следующего платежа - <?=$value['new_payday']?></div>
                    <div class="select_button">
                        <button>Выбрать</button>
                    </div>
                </div>
            </div>
        <? }
    }
}
