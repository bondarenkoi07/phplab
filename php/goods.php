<?php
//  db1.mati.su/php/cart.php - проверка;
include 'IShopPage.php';
function countnz(array $source){
    $cnt=0;
    foreach ($source as $value){
        if ($value!=0){
            $cnt++;
        }
    }
    return $cnt;
}
class ShopGoods extends ShopPage{
    private  $cookie = array();
    private  $product =array();
    private  $user_authed=false;
    function __construct(string $title='')
    {
        session_start();
        $this->create_title($title);
        $this->start_db_connection();
        if(isset($_SESSION['user'])&&!empty($_SESSION['user']))
            $this->user_authed = true;
        $this->create_body();

    }
    private function input_template(string $key){
        echo ' <div class="position1">
                <form action="cart.php" method="POST">
        '.$this->product[$key]['name'].' - '.$this->product[$key]['cost'].' <input type="hidden" name="p'.$key.'" value="'.$key.'"><input type="submit"  value="В корзину">
                </form>
             </div>';
    }
    public function payload()
    {
        $query = $this->dbp->query("SELECT * FROM items");
        $query->setFetchMode(PDO::FETCH_ASSOC);
        while($row=$query->fetch()){
            $this->product[$row['id']]=array('name'=>$row['name'],'cost'=>$row['cost']);
            $this->input_template($row['id']);
            }
         echo '   <div class="title">
            <h2 class="font-effect-anaglyphic">Корзина</h2>
        </div>
        <div class="position1">';
                if (isset($_SESSION['cart'])&&!empty($_SESSION['cart'])){
                    $this->cookie = unserialize($_SESSION['cart']);
                }
                elseif (isset($_COOKIE['cart'])&&!empty($_COOKIE['cart'])) {
                    $this->cookie = unserialize($_COOKIE['cart']);
                }
                if(isset($this->cookie)&&!empty($this->cookie)) {
                    echo '<p>Товаров в корзине: '.countnz($this->cookie).' шт.</p>';
                    foreach ($this->cookie as $key => $value) {
                        if ($value > 0 && isset($this->product[$key])) {
                            $value = htmlspecialchars($value);
                            $name = $this->product[$key]['name'];
                            echo "<br> $name: $value шт. <br/>\n";
                        }
                    }
                }
                else {
                    echo "<p>Нет товаров.</p>";
                }
            echo'</div>';
        }
    }
?>
<html lang="ru" xmlns="http://www.w3.org/1999/html">
<?php
    $PageController = new ShopGoods('Каталог товаров');
?>
<article>
    <div class="catalog">
        <div class="title">
            <h2 class="font-effect-anaglyphic">Каталог товаров</h2>
        </div>
            <?php
            $PageController->payload();
            ?>
    </div>
</article>
<?php
$PageController->end_body();
unset($PageController);
?>
</html>