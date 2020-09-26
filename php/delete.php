<?php
include "IShopPage.php";
class DeletePage extends ShopPage{
    public function __construct(string $title='')
    {
        session_start();
        $this->start_db_connection();
    }
    public function payload()
    {
        if($_SESSION['rigths']=='admin')
            foreach ($_GET as $key => $value) {
                if (isset($_GET[$key]) && $value == 'delete') {
                    $key1= str_replace('p','',$key);
                    $query = $this->dbp->prepare('DELETE FROM items WHERE id='.$key1);
                    $query->execute();
                    if ($query->execute())
                        header("refresh:0;url='http://localhost/php/show.php?delete=ok' ");
                    else
                        header("refresh:0;url='http://localhost/php/show.php?delete=wrong' ");
                    return 0;
                }
            }
        header("refresh:0;url='http://localhost/php/show.php?delete=empty' ");
        return 1;
    }
}
$PageController = new DeletePage('');
$PageController->payload();
unset($PageController);
?>