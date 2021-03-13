<?php
//function curl_f() {
    global $sum_btc, $sum_eth, $sum_xrp, $sum_eos, $sum_bch, $br_btc, $br_eth, $br_xrp, $br_bch;
    // exchange
    $url1 = "https://quotation-api-cdn.dunamu.com/v1/forex/recent?codes=FRX.KRWUSD,FRX.KRWJPY,FRX.KRWCNY,FRX.KRWEUR";
    $ch1 = curl_init();  // curl initialization
    curl_setopt($ch1, CURLOPT_URL, $url1);  // URL designate
    curl_setopt($ch1, CURLOPT_RETURNTRANSFER, true);  // a return of results to string
    curl_setopt($ch1, CURLOPT_CONNECTTIMEOUT, 10);  // connection timeout 10second
    $respons = json_decode(curl_exec($ch1));
    curl_close($ch1);
    $exchanges = array();
    array_push($exchanges, $respons[0]->basePrice, $respons[1]->basePrice, $respons[2]->basePrice, $respons[3]->basePrice);

    $url_arr = array("https://api.bithumb.com/public/ticker/BTC", "https://api.bithumb.com/public/ticker/ETH", "https://api.bithumb.com/public/ticker/XRP", "https://api.bithumb.com/public/ticker/EOS", "https://api.bithumb.com/public/ticker/BCH",
        "https://api.upbit.com/v1/ticker?markets=KRW-BTC", "https://api.upbit.com/v1/ticker?markets=KRW-ETH", "https://api.upbit.com/v1/ticker?markets=KRW-XRP", "https://api.upbit.com/v1/ticker?markets=KRW-EOS", "https://api.upbit.com/v1/ticker?markets=KRW-BCH",
        "https://api.bittrex.com/api/v1.1/public/getmarketsummary?market=usd-btc", "https://api.bittrex.com/api/v1.1/public/getmarketsummary?market=usd-eth", "https://api.bittrex.com/api/v1.1/public/getmarketsummary?market=usd-xrp", "https://api.bittrex.com/api/v1.1/public/getmarketsummary?market=usd-bch"
    );
    for($i=0; $i<14; $i++) {
        $curl_in[$i] = curl_init();
        curl_setopt($curl_in[$i], CURLOPT_URL, $url_arr[$i]);  // URL designate
        curl_setopt($curl_in[$i], CURLOPT_RETURNTRANSFER, true);  // a return of results to string
        curl_setopt($curl_in[$i], CURLOPT_CONNECTTIMEOUT, 10);  // connection timeout 10second
        $curl_ex[$i] = json_decode(curl_exec($curl_in[$i]));
        curl_close($curl_in[$i]);
    }
    // bittrex coin(btc,eth,xrp,bch) USD -> KRW exchange
    $br_btc = (($curl_ex[10]->result[0]->High + $curl_ex[10]->result[0]->Low) * $respons[0]->basePrice) / 2;
    $br_eth = (($curl_ex[11]->result[0]->High + $curl_ex[11]->result[0]->Low) * $respons[0]->basePrice) / 2;
    $br_xrp = (($curl_ex[12]->result[0]->High + $curl_ex[12]->result[0]->Low) * $respons[0]->basePrice) / 2;
    $br_bch = (($curl_ex[13]->result[0]->High + $curl_ex[13]->result[0]->Low) * $respons[0]->basePrice) / 2;
    $bt_arr = array();  // krw
    array_push($bt_arr, (float)$curl_ex[0]->data->average_price, (float)$curl_ex[1]->data->average_price, (float)$curl_ex[2]->data->average_price, (float)$curl_ex[3]->data->average_price, (float)$curl_ex[4]->data->average_price, $curl_ex[5][0]->trade_price, $curl_ex[6][0]->trade_price, $curl_ex[7][0]->trade_price, $curl_ex[8][0]->trade_price, $curl_ex[9][0]->trade_price, $br_btc, $br_eth, $br_xrp, '-', $br_bch);

    // exchange table using
    $db_exc_con = mysqli_connect("HOST", "USER ID", "PASSWORD", "DATABASE");
    mysqli_set_charset($db_exc_con,"utf8");
    $exc_sql = "insert into `exchange` values ('','{$respons[0]->basePrice}', '{$respons[1]->basePrice}', '{$respons[2]->basePrice}', '{$respons[3]->basePrice}')";
//    $sql_exchange = "select * from `exchange` order by ids desc limit 1";
    $exc_result = mysqli_query($db_exc_con, $exc_sql);
//    $exc_result1 = mysqli_query($db_exc_con, $sql_exchange);
    mysqli_close($db_exc_con);

    //p_trade table using
    $conn = mysqli_connect("HOST", "USER ID", "PASSWORD", "DATABASE");
    mysqli_set_charset($conn,"utf8");
    $sql = "insert into `p_trade` values ('', '{$bt_arr[0]}', '{$bt_arr[1]}', '{$bt_arr[2]}', '{$bt_arr[3]}', '{$bt_arr[4]}', '{$bt_arr[5]}', '{$bt_arr[6]}', '{$bt_arr[7]}', '{$bt_arr[8]}', '{$bt_arr[9]}', '{$bt_arr[10]}', '{$bt_arr[11]}', '{$bt_arr[12]}', '', '{$bt_arr[14]}')";
//    $sql_trade = "select * from `p_trade` order by ids desc limit 1";
    $result = mysqli_query($conn, $sql);
//    $result1 = mysqli_query($conn, $sql_trade);
    mysqli_close($conn);

    $t_usd = array(); $t_jpy = array(); $t_krw = array(); $t_cny = array(); $t_eur = array();
    $d_all = array(
        bithumb=>array(),
        upbit=>array(),
        bittrex=>array()
    );  // array and object to go in exchange information
    $timestamp = time();  // timestamp type
    for($i=0; $i<15; $i++) {
        $t_usd[] = $bt_arr[$i] / $exchanges[0];  // krw -> usd
        $t_jpy[] = $bt_arr[$i] / $exchanges[1];  // krw -> jpy
        $t_cny[] = $bt_arr[$i] / $exchanges[2];  // krw -> cny
        $t_eur[] = $bt_arr[$i] / $exchanges[3];  // krw -> eur
        $t_krw[] = $bt_arr[$i];  // kind of coin(1ea) -> money type krw
    }

    // trade_exc table using
    $trade_exc = mysqli_connect("HOST", "USER ID", "PASSWORD", "DATABASE");
    mysqli_set_charset($trade_exc,"utf8");
    $sql_usd = "insert into `trade_exc` values ('', 'USD', '{$t_usd[0]}', '{$t_usd[1]}', '{$t_usd[2]}', '{$t_usd[3]}', '{$t_usd[4]}', '{$t_usd[5]}', '{$t_usd[6]}', '{$t_usd[7]}', '{$t_usd[8]}', '{$t_usd[9]}', '{$t_usd[10]}', '{$t_usd[11]}', '{$t_usd[12]}', '-', '{$t_usd[14]}', '{$timestamp}')";
    $sql_jpy = "insert into `trade_exc` values ('', 'JPY', '{$t_jpy[0]}', '{$t_jpy[1]}', '{$t_jpy[2]}', '{$t_jpy[3]}', '{$t_jpy[4]}', '{$t_jpy[5]}', '{$t_jpy[6]}', '{$t_jpy[7]}', '{$t_jpy[8]}', '{$t_jpy[9]}', '{$t_jpy[10]}', '{$t_jpy[11]}', '{$t_jpy[12]}', '-', '{$t_jpy[14]}', '{$timestamp}')";
    $sql_krw = "insert into `trade_exc` values ('', 'KRW', '{$t_krw[0]}', '{$t_krw[1]}', '{$t_krw[2]}', '{$t_krw[3]}', '{$t_krw[4]}', '{$t_krw[5]}', '{$t_krw[6]}', '{$t_krw[7]}', '{$t_krw[8]}', '{$t_krw[9]}', '{$t_krw[10]}', '{$t_krw[11]}', '{$t_krw[12]}', '-', '{$t_krw[14]}', '{$timestamp}')";
    $sql_cny = "insert into `trade_exc` values ('', 'CNY', '{$t_cny[0]}', '{$t_cny[1]}', '{$t_cny[2]}', '{$t_cny[3]}', '{$t_cny[4]}', '{$t_cny[5]}', '{$t_cny[6]}', '{$t_cny[7]}', '{$t_cny[8]}', '{$t_cny[9]}', '{$t_cny[10]}', '{$t_cny[11]}', '{$t_cny[12]}', '-', '{$t_cny[14]}', '{$timestamp}')";
    $sql_eur = "insert into `trade_exc` values ('', 'EUR', '{$t_eur[0]}', '{$t_eur[1]}', '{$t_eur[2]}', '{$t_eur[3]}', '{$t_eur[4]}', '{$t_eur[5]}', '{$t_eur[6]}', '{$t_eur[7]}', '{$t_eur[8]}', '{$t_eur[9]}', '{$t_eur[10]}', '{$t_eur[11]}', '{$t_eur[12]}', '-', '{$t_eur[14]}', '{$timestamp}')";
    $tra_exc_result = mysqli_query($trade_exc, $sql_usd);
    $tra_exc_result1 = mysqli_query($trade_exc, $sql_jpy);
    $tra_exc_result2 = mysqli_query($trade_exc, $sql_krw);
    $tra_exc_result3 = mysqli_query($trade_exc, $sql_cny);
    $tra_exc_result4 = mysqli_query($trade_exc, $sql_eur);
    $sql_trade_exc = "select * from `trade_exc` order by ids desc limit 5";
    $tra_exc_result9 = mysqli_query($trade_exc, $sql_trade_exc);
    while($r_trade_exc = mysqli_fetch_assoc($tra_exc_result9)) { $all_to[] = $r_trade_exc; }
    mysqli_close($trade_exc);
    //bithumb zone
    $object = '';
    $ob_arr = array('bt_btc', 'bt_eth', 'bt_xrp', 'bt_eos', 'bt_bch', 'up_btc', 'up_eth', 'up_xrp', 'up_eos', 'up_bch', 'br_btc', 'br_eth', 'br_xrp', 'br_eos', 'br_bch');
    $coin_type = array('BTC', 'ETH', 'XRP', 'EOS', 'BCH', 'BTC', 'ETH', 'XRP', 'EOS', 'BCH', 'BTC', 'ETH', 'XRP', 'EOS', 'BCH');
    $cont = -1;
    for($i=1; $i<16; $i++) {
        $cont++;
        ${"object".$i}->type = $coin_type[$cont]; ${"object".$i}->value_USD = $all_to[4][$ob_arr[$cont]]; ${"object".$i}->value_JPY = $all_to[3][$ob_arr[$cont]]; ${"object".$i}->value_KRW = $all_to[2][$ob_arr[$cont]]; ${"object".$i}->value_CNY = $all_to[1][$ob_arr[$cont]]; ${"object".$i}->value_EUR = $all_to[0][$ob_arr[$cont]]; ${"object".$i}->time = $all_to[4]['timestamp'];
    }
    class data{
        public $type, $value_USD, $value_JPY, $value_KRW, $value_CNY, $value_EUR, $time;
        function v_key() { print_r($this); }
    }

    $hostname = getenv("QUERY_STRING");  // come over GET value
    if($hostname == 'coin=BTC' || $hostname == 'coin=btc') { array_push($d_all[bithumb], $object1); array_push($d_all[upbit], $object6); array_push($d_all[bittrex], $object11); }
    else if($hostname == 'coin=ETH' || $hostname == 'coin=eth') { array_push($d_all[bithumb], $object2); array_push($d_all[upbit], $object7); array_push($d_all[bittrex], $object12); }
    else if($hostname == 'coin=XRP' || $hostname == 'coin=xrp') { array_push($d_all[bithumb], $object3); array_push($d_all[upbit], $object8); array_push($d_all[bittrex], $object13); }
    else if($hostname == 'coin=EOS' || $hostname == 'coin=eos') { array_push($d_all[bithumb], $object4); array_push($d_all[upbit], $object9); array_push($d_all[bittrex], $object14); }
    else if($hostname == 'coin=BCH' || $hostname == 'coin=bch') { array_push($d_all[bithumb], $object5); array_push($d_all[upbit], $object10); array_push($d_all[bittrex], $object15); }
    else if($hostname == 'coin=ALL' || $hostname == 'coin=all') { array_push($d_all[bithumb], $object1, $object2, $object3, $object4, $object5); array_push($d_all[upbit], $object6, $object7, $object8, $object9, $object10); array_push($d_all[bittrex], $object11, $object12, $object13, $object14, $object15); }
    else { header("Location: http://127.0.0.1/curl_get_json.php?coin=ALL"); }
    print_r(json_encode($d_all));
//}
//curl_f();