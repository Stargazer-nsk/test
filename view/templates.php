<?php
// Здесь формируется весь html, включая поднимаемые чеерз ajax.
class templates extends prepareData {
    // Шаблон для head
    public function header() {
         ?>
        <html lang="ru">
            <head>
                <meta content="width=device-width, initial-scale=1" name="viewport" />
                <title></title>
                <link rel="stylesheet" href="./template/css/template.css">
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
                <h2>Тариф "<?php echo $value['title'] ;?>"</h2>
                <div class="go_to" data-ajax="<?php echo $value['children'] ;?>" data-parent="<?php echo $value['children'] ;?>">
                    <div class="speed"><div class="label<?php echo $value['class'] ;?>"><?php echo $value['speed'] ;?> Мбит/с</div></div>
                    <div class="price_per_month"><?php echo $value['price_per_month'] ;?>  ₽/мес</div>
                    <?php if (!empty($value['free_options'])) { ?>
                    <div class="free_options"><?php echo $value['free_options'] ;?></div>
                    <?php } ?>
                </div>
                <div class="link">
                    <a target="_blank" href="<?php echo $value['link'] ;?>">Узнать подробнее на сайте www.sknt.ru</a>
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
                    <h1>Тариф "<?php echo $value['title'] ;?>"</h1>
                </header>
                 <div class="tariff_rows">
            <?php } ?>
            <div class="tariff_row">
                <h2><?php echo $value['pay_period'] ;?></h2>
                <div class="go_to" data-ajax="<?php echo $value['ID'] ;?>" data-parent="<?php echo $this->postItem('data') ;?>">
                    <div class="price_per_month"><?php echo $value['price_per_month'] ;?>  ₽/мес</div>
                    <div class="price">Разовый платёж – <?php echo $value['price'] ;?>  ₽
                    <?php if ($value['discount'] != 0) { ?>
                        <br>Скидка – <?php echo $value['discount'] ;?>  ₽
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
            <header class="tariff_head go_to" data-ajax="<?php echo $this->postItem('parent') ;?>">
                <h1>Выбор тарифа</h1>
            </header>
            <div class="tariff_row third_page">
                <h2>Тариф "<?php echo $value['title'] ;?>"</h2>
                <div class="tariff_select">
                    <?php if (!empty($value['pay_period'])) { ?>
                        <div class="price_per_month">Период оплаты – <?php echo $value['pay_period'] ;?><br>
                            <?php echo $value['price_per_month'] ;?>  ₽/мес</div>
                    <?php } else { ?>
                        <div class="price_per_month">Период оплаты – 1 месяц<br>
                            <?php echo $value['price_per_month'] ;?>  ₽/мес</div>
                    <?php } ?>

                    <div class="price">Разовый платёж – <?php echo $value['price'] ;?>  ₽<br>
                    Cо счёта спишется – <?php echo $value['price'] ;?>  ₽</div>
                    <div class="new_payday">Вступит в силу – сегодня<br>
                    Дата следующего платежа – <?php echo $value['new_payday'] ;?></div>
                    <div class="select_button">
                        <button>Выбрать</button>
                    </div>
                </div>
            </div>
        <? }
    }
}
