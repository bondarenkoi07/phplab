<?php
   include 'IShopPage.php';
    class ShowShopTable extends ShopPage{
        private $AuthController;
        public function __construct(string $title='')
        {
            session_start();
            $this->start_db_connection();
            $this->AuthController = new AuthPage();
        }
        public function permission(string $right,string $str){
            return $this->AuthController->permission($right,$str);
        }
        public function deauth(){
             $this->AuthController->deauth();
        }
        public function payload()
        {
            $query=$this->dbp->query('SELECT * from items');
            while($row=$query->fetch()){
                echo "<tr><td> ".$row['name'] . "</td><td>".$row['cost'] . "</td>".$this->AuthController->permission('admin','<td>'."<input type=submit name='p".$row['id']."' value='delete' form='data'>".'</td>').'</tr>';
            }
            if(isset($_SESSION['user'])&& !empty($_SESSION['user'])){
                if($_SESSION['rigths']=='admin'){
                    echo '<form action="add.php" method="POST">';
                    echo '<td>'."<input type='text' name='name'>".'</td>';
                    echo '<td>'."<input type='text' name='cost'>".'</td>';
                    echo '<td>'."<input type='submit' value='Добавить'>".'</td>';
                    echo '</form>';
                }
            }
        }
    }
    $PageController = new ShowShopTable('');
?>
<html>
   <?php
        $PageController->create_title('Таблица товаров');
        $PageController->create_body();
   ?>
    <script src="/script/DBErrorCatch.js">
        let message;
        let Get = extractGet('delete');
        if(Get==='wrong'){
            message = 'Ваше последнее действие было выполнено некорректно'
            alert(message);
        }
    </script>
        <article>
            <div class="catalog">
            <table  >
                <caption >Товары</caption>
                <colgroup span="5">
                <tr>
                    <th>Название</th>
                    <th>Стоимость</th>
                    <?php
                    if(isset($_POST['exit'])){
                        $PageController->deauth();
                    }
                    echo $PageController->permission('admin','<th>Действие</th>');
                    ?>
                </tr>
                <?php
                    $PageController->payload();
                ?>
            </table>
            <form id='data' action="delete.php"></form>
            <a class="pos" href="auth_db.php">Aвторизация</a>
            </div>
            <form action="" method="POST" >
                <input type='submit' name='exit' value='Выход' class="exit">
            </form>
        </article>
    <?php
        $PageController->end_body();
    ?>
</html>