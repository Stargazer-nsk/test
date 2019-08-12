<?php
// Здесь мы определяем какой набор данных нам нужен, и вызываем соответствующий метод.
class selectPage {
    public function select($page, $tariffs) {
        $page_data = new prepareData;
        switch ($page) {
            case 0:
            case 1:
                return $page_data->firstPageData($tariffs);
                break;
            case 2:
                return $page_data->secondPageData($tariffs);
                break;
            case 3:
                return $page_data->thirdPageData($tariffs);
                break;
            default:
                return false;
                break;
        }
    }
}