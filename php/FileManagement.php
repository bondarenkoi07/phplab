<?php
class FileManagement {
    private $dbp;
    private $email;
    private $payload="";
    private $user;
    private $catalog;

    public function __construct( PDO $dbp,AuthPage $user )
    {
        $this->dbp = $dbp;
        $this->email = $user->username;
        $this->user = $user;
    }
    public function GetFilenames(){
        $path = '/home/ilya/phplab/userfiles/'.$this->user->username;
        if($this->user->authed()){
            $catalog = opendir($path);
            $this->payload .= "<form enctype='text/plain' method='get' >";
            while ($current_file = readdir($catalog) ) {
                if ($current_file !== ".." && $current_file !== '.') {
                    $this->payload .= " <p><input type='checkbox' name='delete[]'  value='$current_file'><a class='pos'>$current_file</a></p> ";

                }
            }
            $this->payload .= "   <input type='submit'  value='Удалить'></form>";
        }
    }
    public function  GetPayload(){
        echo $this->payload;
    }
    public function RemoveFile(string $filename){
        try {
            $hell = "ok";
            $path = '/home/ilya/phplab/userfiles/' . $this->user->username.'/';
            $this->catalog = opendir($path);
            while ($current_file = readdir($this->catalog)) {
                if ($current_file == $filename) {
                    if(!unlink($path . $filename)){
                        echo 'Error';
                    }
                    break;
                }
            }
        }catch (Exception $e)
        {
            echo $e;
        }
        echo 'hey';
        return $hell;
    }
    public function __destruct()
    {
        if(isset($this->catalog)&&!empty($this->catalog))
            closedir($this->catalog);
    }
}