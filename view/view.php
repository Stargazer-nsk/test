<?php
include_once 'templates.php';
include_once 'selectPage.php';


$template = new templates;
$data = $template->postItem('data');

if ($data == 'main') {
    $page = 1;
} elseif ((!empty($data)) && (substr_count($data, ',') != 0)) {
    $page = 2;
} elseif (!empty($data)) {
    $page = 3;
} else {
    $page = 0;
}

$select_page = new selectPage;
$page_data = $select_page->select($page, $tariffs);

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


