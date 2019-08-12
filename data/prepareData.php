<?php
// Каждая страница поулчает свой набор данных. Здесь я получаю исзодный json, и формирую массив для каждого конкретного случая.
class prepareData {
    // Получаем json
    public function getData () {
        $url = 'https://www.sknt.ru/job/frontend/data.json';
        $data = json_decode(file_get_contents($url), true);
        $result = $data['result'];
        $tariffs = $data['tarifs'];
        if ($result == 'ok') {
            return $tariffs;
        } else {
            return 'error';
        }
    }
    // Набор данных для первого экрана
    public function firstPageData($tariffs) {
        if (is_array($tariffs)) {
            $first_page_data = array();
            foreach ($tariffs as $key => $tariff) {
                $current_array = array();
                $min_price = 0;
                $max_price = 0;
                $free_options = '';
                $children = '';

                $current_array['title'] = $tariff['title'];
                $current_array['speed'] = $tariff['speed'];
                $current_array['link'] =  $tariff['link'];

                if (substr_count($current_array['title'], 'Земля') != 0) {
                    $current_array ['class']= ' earth';
                } elseif (substr_count($current_array['title'], 'Вода') != 0) {
                    $current_array ['class']= ' water';
                } elseif (substr_count($current_array['title'], 'Огонь') != 0) {
                    $current_array ['class']= ' fire';
                }

                foreach ($tariff['tarifs'] as $k0 => $subTariff) {
                    $current_price = $subTariff['price'] / $subTariff['pay_period'];

                    if ($k0 == 0) {
                        $children .= $subTariff['ID'];
                    } else {
                        $children .= ','.$subTariff['ID'];
                    }

                    if ($k0 == 0) {
                        $min_price = $current_price;
                        $max_price = $current_price;
                    } elseif ($min_price > $current_price) {
                        $min_price = $current_price;
                    } elseif ($max_price < $current_price) {
                        $max_price = $current_price;
                    }
                }

                $current_array['children'] = $children;
                $current_array['price_diapason'] =  $min_price.' - '.$max_price;

                if (isset($tariff['free_options'])) {
                    foreach ($tariff['free_options'] as $k1 => $option) {
                        if ($k1 == 0) {
                            $free_options .= $option;
                        } else {
                            $free_options .= '<br>'.$option;
                        }
                    }
                }

                $current_array['free_options'] =  $free_options;

                $first_page_data [$key]=  $current_array;
            }

        } else {
            $first_page_data = 'error';
        }
        return $first_page_data;
    }
    // Набор данных для второго экрана
    public function secondPageData($tariffs) {
        if (is_array($tariffs)) {
            $second_page_data = array();
            $current_array = array();
            $ids_array = explode(',', $_POST['data']);
            foreach ($tariffs as $key => $tariff) {
                foreach ($tariff['tarifs'] as $k0 => $subTariff) {
                    if (in_array($subTariff['ID'], $ids_array) == true) {
                        $price_per_month = $subTariff['price'] / $subTariff['pay_period'];
                        $current_array ['ID']= $subTariff['ID'];
                        $current_array ['title'] = preg_split("/\(.*\)/", $subTariff['title'])[0];
                        $current_array ['title'] = trim($current_array ['title']);
                        $current_array ['pay_period_sort']= $subTariff['pay_period'];
                        preg_match("/\(.*\)/", $subTariff['title'], $found);
                        $current_array ['pay_period']= str_replace('(', '', $found[0]);
                        $current_array ['pay_period']= str_replace(')', '', $current_array['pay_period']);
                        $current_array ['price_per_month']= $price_per_month;
                        $current_array ['price']= $subTariff['price'];
                        $second_page_data []= $current_array;
                    }
                }
            }
        } else {
            $second_page_data = 'error';
        }
        function pay_period_sort($first, $second) {
            if ($first['pay_period_sort'] == $second['pay_period_sort']) {
                return 0;
            }
            return ($first['pay_period_sort'] < $second['pay_period_sort']) ? -1 : 1;
        }
        usort($second_page_data, "pay_period_sort");

        $max_price = $second_page_data[0]['price_per_month'];
        foreach ($second_page_data as $k1 => $array) {
            if ($k1 == 0) {
                $array['discount'] = 0;
            } else {
                $array['discount'] = ($max_price - $array['price_per_month']) * $array['pay_period'];
            }
            $second_page_data [$k1]= $array;
        }

        return $second_page_data;
    }
    // Набор данных для третьего экрана
    public function thirdPageData($tariffs) {
        if (is_array($tariffs)) {
            $third_page_data = array();
            $current_array = array();
            foreach ($tariffs as $key => $tariff) {
                foreach ($tariff['tarifs'] as $k0 => $subTariff) {
                    if ($subTariff['ID'] == $_POST['data']) {
                        $current_array ['title'] = preg_split("/\(.*\)/", $subTariff['title'])[0];
                        $current_array ['title'] = trim($current_array ['title']);
                        $price_per_month = $subTariff['price'] / $subTariff['pay_period'];
                        $current_array ['ID']= $subTariff['ID'];
                        $current_array ['price_per_month']= $price_per_month;
                        $current_array ['price']= $subTariff['price'];
                        $current_array ['new_payday']= date('d.m.Y' ,explode('+', $subTariff['new_payday'])[0]+explode('+', $subTariff['new_payday'])[1]);
                        preg_match("/\(.*\)/", $subTariff['title'], $found);
                        $current_array ['pay_period']= str_replace('(', '', $found[0]);
                        $current_array ['pay_period']= str_replace(')', '', $current_array['pay_period']);
                        $third_page_data []= $current_array;
                    }
                }
            }
        } else {
            $third_page_data = 'error';
        }
        return $third_page_data;
    }
}
