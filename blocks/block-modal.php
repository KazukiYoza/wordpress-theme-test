<?php 
    $itemId = block_value('item-id'); //商品IDを取得
    /*
    * 商品関連情報をAPIで取得
    */
    // APIアクセスURL
    $url_b = 'https://item.api.shopserve.jp/v2/items/'. $itemId .'/basic'; //商品基本情報をAPIでショップサーブから取得
    $url_v = 'https://item.api.shopserve.jp/v2/items/'. $itemId .'/variation'; //商品バリエーション情報をAPIでショップサーブから取得
    $url_s = 'https://item.api.shopserve.jp/v2/items/'. $itemId .'/stock'; //商品在庫情報をAPIでショップサーブから取得
    $url_o = 'https://item.api.shopserve.jp/v2/items/'. $itemId .'/options'; //商品オプション情報をAPIでショップサーブから取得

    // ストリームコンテキストのオプションを作成
    $options = array(
        // HTTPコンテキストオプションをセット
        'http' => array(
            'method'=> 'GET',
            'header'=> array(
                'Content-type: application/json; charset=UTF-8', //JSON形式で表示
                'Authorization: Basic ' . base64_encode('takarajima.vo:$2y$11$eTw8n7NZcxDiBnxE.yTWauHZe1jrhd/LYTgduO1EvL6CH49dBf9sOA4')
            )
        ),
        'ssl' => array(
            'verify_peer'      => false,
            'verify_peer_name' => false
        )
    );

    // ストリームコンテキストの作成
    $itemInfo = [
        'basic' => file_get_contents($url_b,false,stream_context_create($options)),
        'variation' => file_get_contents($url_v,false,stream_context_create($options)),
        'stock' => file_get_contents($url_s,false,stream_context_create($options)),
        'options' => file_get_contents($url_o,false,stream_context_create($options))
    ];
    // var_dump($itemInfo);
    
    // jsonの内容を連想配列として、各配列に格納する
    foreach($itemInfo as $key => $value){
        $itemInfo[$key] = json_decode($itemInfo[$key],true);
    }

    // var_dump($itemInfo['basic']);

    // 商品バリエーション情報
    $itemVariation = $itemInfo['variation']['variation']['attributes'];

    // 商品在庫情報
    $itemStock = $itemInfo['stock']['stock']['management_item'];

    // 商品オプション情報
    $itemOption = $itemInfo['options']['options'];

    $itemStockQuantity = $itemStock['quantity']; //在庫数を取得
    $itemStockCondition = $itemStock['stock_condition']; //現在の在庫状況を取得

    // 商品基本情報
    $itemBasic = $itemInfo['basic']['basic'];
    
    // debug
    // var_dump($itemBasic);
    
    /** 
     * 一度に購入できる商品上限数の設定
     */
    $itemCountMaxNum = block_value('item-count-max'); //商品購入数の上限を取得
    $itemCountMax = 10;//商品購入数の上限のデフォルト値の設定
    $itemCountMax = ($itemCountMaxNum != null) ? $itemCountMaxNum : $itemCountMax; //商品購入数の上限が設定されている場合は上限値を更新

    //在庫数が10以下の場合、もしくは指定した購入上限数が現在の在庫数より多い場合
    if( $itemStockQuantity < 10 or $itemStockQuantity < $itemCountMax){ 
        $itemCountMax = $itemStockQuantity; //現在の在庫数を上限値とする
    }else{
        $itemCountMax = $itemCountMax; //指定した購入上限数を上限値とする
    }
    ?>

<div class="shopcart" style="text-align: right;">
    <form method="post" action="https://www.okinawa-takarajima.com/CART/cart.php">
        <input type="hidden" name="ITM" value="<?php echo $itemId; ?>">
        <?php if ($itemVariation != null ) { //商品バリエーションの設定がある場合
        $i = 1;
            foreach ($itemVariation as $value) { 
                echo '<div class="select-option variation">';
                echo '<label>'.$value['title'].'：</label>';
                echo '<select class="option_parts" name="VAR'. $i .'">';
                echo '<option value="">選択してください</option>';
                    foreach ($value['choices'] as $value2) {
                        echo '<option value="'.$value2.'">'.$value2.'</option>';
                    }
                    echo '</select>';
                echo '</div>';
                $i++;
            } ?>
        <?php } ?>

        <?php if ($itemOption != null ) { //商品オプションの設定がある場合 
        $i = 1;
            foreach ($itemOption as $value) { 
                echo '<div class="select-option options">';
                echo '<label>'.$value['name'].'：</label>';
                echo '<select class="option_parts" name="OPTION'. $i .'">';
                echo '<option value="">選択してください</option>';
                    foreach ($value['element_type_selective'] as $value2) {
                        echo '<option value="'.$value2['label'].'">'.$value2['label'].'</option>';
                    }
                    echo '</select>';
                echo '</div>';
                $i++;
            } ?>
        <?php } ?>

        <div class="select-option quantity">
            <?php if( $itemStockCondition == 'SoldOut'): //在庫がない場合 ?>
                <p>現在、品切れです。</p>
            <?php else: ?>
                    <label>数量：</label>
                    <select name="CNT">
                        <?php 
                            for ($i = 1; $i <= $itemCountMax  ; $i++) {
                                echo '<option value="'.$i.'">'.$i.'</option>';
                            }?>
                    </select>
                    <label><?php echo $itemBasic['retail_unit'] ?></label>
            <?php endif; ?>
        </div>

        <?php if( $itemStockCondition != 'SoldOut'): //在庫がある場合 ?>
        <div class="submit">
            <input type="submit" value="購入する" target="_blank" onclick="ga('send','event','item','item_click','<?php echo $itemBasic['item_name'] ?>','<?php echo $itemBasic['retail_price'] ?>',{'nonInteraction':1});">
        </div>
        <?php endif; ?>
    </form>
</div><!-- /.shopcart -->


<style>
    .shopcart {
        width: 100%;
        margin: 0 auto 10px;
    }

    .shopcart select {
        height: 34px !important;
        width: 100px;
        background-color: white;
        padding: 5px;
        border: 1px solid #000000;
    }
    .shopcart .select-option{
        display: flex;
        flex-direction: row;
        width: 100%;
        text-align: left;
        margin-bottom: 10px;
    }
    .shopcart .quantity{
        margin-bottom: 2rem;
    }
    .shopcart .select-option label{
        flex-basis: 40%;
        margin-left: 0;
        margin-right: 10px;
    }
    .shopcart .select-option select{
        flex: 1;
        margin-right: 5px;
    }

    .shopcart .submit{
        text-align: center;
    }

    .shopcart .submit input[type="submit"] {
        padding: 10px;
        background-color: #f74a4a;
        color: white;
        font-size: 18px;
        font-family: 'Noto Sans JP';
        font-weight: bold;
        border-radius: 30px;
        width: 90%;
        transition: .5s;
        border: 0;
    }
    .shopcart .submit input[type="submit"]:hover {
        box-shadow: 0px 5px 10px 2px #a7a7a7;
        transition: .5s;
    }
</style>