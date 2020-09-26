<?php
include "IShopPage.php";
    class AddPage extends ShopPage{
        public function __construct(string $title='')
        {
            session_start();
            $this->start_db_connection();
        }
        public function payload()
        {
            $name = '';
            $cost = 0;
            if($_SESSION['rigths']=='admin')
                if(isset($_POST['name'])&&isset($_POST['cost'])&&is_numeric($_POST['cost'])&&!is_numeric($_POST['name'])){
                    $query = $this->dbp->prepare('INSERT INTO items (name,cost) VALUES (?,?)');
                    $query->bindParam(1, $name);
                    $query->bindParam(2, $cost);
                    $name=htmlspecialchars($_POST['name']);
                    $cost=htmlspecialchars($_POST['cost']);
                    if($query->execute())
                        header( "refresh:0;url='http://localhost/php/show.php?all=is+ok' ");
                    else
                        header( "refresh:0;url='http://localhost/php/show.php?all=is+not+ok' ");
                }
            header( "refresh:0;url='http://localhost/php/show.php?empty=input' ");
        }
    }
    $PageController = new AddPage('');
    $PageController->payload();
unset($PageController);
?>