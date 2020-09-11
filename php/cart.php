<?php
include 'IShopPage.php';
class ShopCart extends ShopPage{
    private  $cookie = array();
    private  $product =array();
    private  $user_authed=false;
    function __construct(string $title='')
    {
       // $this->create_title($title);
        session_start();
        $this->start_db_connection();
        if(isset($_SESSION['user'])&&!empty($_SESSION['user']))
            $this->user_authed = true;

    }
    function create_cart(){
        $query = $this->dbp->query("SELECT * FROM items");
        $query->setFetchMode(PDO::FETCH_ASSOC);
        if($this->user_authed){
            if(isset($_SESSION['cart'])){
                setcookie("cart","",time());
                $this->cookie=unserialize($_SESSION['cart']);
            }
        }
        elseif ( isset($_COOKIE['cart'])&&!empty($_COOKIE['cart'])) {
            $this->cookie=unserialize($_COOKIE['cart']);
        }
        else {
            while($row=$query->fetch()){
                $this->cookie[$row['id']]=0;
                $this->product[$row['id']]=array('cost'=>$row['cost'],'name'=>$row['name']);
            }
            return 0;
        }
        while($row=$query->fetch()){
            if(!isset($this->cookie[$row['id']]))
                $this->cookie[$row['id']]=0;
            $this->product[$row['id']]=array('cost'=>$row['cost'],'name'=>$row['name']);
        }
    }
    public function change_cart(){
        if(isset($_POST))
            foreach($_POST as $value){
                if(isset($value)){
                    foreach($this->product as $key=>$name){
                        if($key==$value){
                            $this->cookie[$key]+=1;
                        }
                        elseif($value == 'delete'.$key){
                            $this->cookie[$key]-=1;
                            if($this->cookie[$key]<0)
                                $this->cookie[$key]=0;
                            break;
                        }
                    }
                }
            }
        if($this->user_authed){
            $_SESSION['cart'] = serialize($this->cookie);
        }
        else{
            setcookie("cart",serialize($this->cookie),time()+3600);
        }
    }
    function payload()
    {
        $cost=0;
        foreach($this->cookie as $key=>$value){
            if($value>0&&isset($this->product[$key])){
                echo "<br>". $this->product[(int)$key]['name'].' '.$this->product[(int)$key]['cost'].' '. $value
                    .'<input type="submit" name="'.$key.'" value="delete'.$key.'"'.'</br>';
                $cost+=$this->product[(int)$key]['cost']*$value;
            }
        }
        echo "<br>суммарная стоимость товарoв в корзине:",$cost,"</br>";
    }
    public function __destruct()
    {
        parent::__destruct();

    }
}
$PageController = new ShopCart('');
$PageController->create_cart();
$PageController->change_cart();
?>
<html lang="ru">
    <?php
    $PageController->create_title('Корзина');
    $PageController->create_body()
    ?><!--#include file="/header.html"-->
        <article>
            <form action='' method="POST" >
                <?php
                $PageController->payload();
                ?>
            </form>
            </article>
<?php
$PageController->end_body();
unset($PageController);
?>
</html>