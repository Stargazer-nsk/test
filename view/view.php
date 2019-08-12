<?php
include_once 'templates.php';
include_once 'selectPage.php';

if ($_POST['data'] == 'main') {
    $page = 1;
} elseif ((!empty($_POST['data'])) && (substr_count($_POST['data'], ',') != 0)) {
    $page = 2;
} elseif (!empty($_POST['data'])) {
    $page = 3;
} else {
    $page = 0;
}

$select_page = new selectPage;
$page_data = $select_page->select($page, $tariffs);
$template = new templates;

switch ($page) {
    case 0:
        $template->header();
        $template->tariffRow($page_data);
        $template->footer();
        break;
    case 1:
        $template->tariffRow($page_data);
        break;
    case 2:
        $template->tariffCurrent($page_data);
        break;
    case 3:
        $template->selectTariff($page_data);
        break;
}


