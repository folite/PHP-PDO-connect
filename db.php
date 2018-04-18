 <?php

    $file = fopen("DB.cfg","r");
    $config = fgetcsv($file);
    // print_r($config);
    fclose($file);

    $hostname = $config[0];
    $port = $config[1];
    $dbname = $config[2];
    $username = $config[3];
    $pwd = $config[4];
    $dbc = new PDO_mssql($hostname, $port, $dbname, $username, $pwd);
    $dbc->selectTest();

    class PDO_mssql{
        //建構子 輸入連線所需的參數參數
        public function __construct($hostname, $port, $dbname, $username, $pwd){

            $this->hostname = $hostname;
            $this->port = $port;
            $this->dbname = $dbname;
            $this->username = $username;
            $this->pwd = $pwd;

            $this->connect();
        }

        //解構子 關閉連線
        public function __destruct(){
            $this->db = NULL;
            // print 'PDO close.';
        }

        //建立連線
        public function connect(){

            try {
                $this->db = new PDO ("dblib:host=$this->hostname:$this->port;dbname=$this->dbname", "$this->username", "$this->pwd");
                // print 'DB start.'
               
            } catch (PDOException $e) {
                $this->logsys .= "Failed to get DB handle: " . $e->getMessage() . "\n";
                print $e;
            }
    
        }

        public function selectTest(){
            $sql = "SELECT * FROM Students";
            $sth = $this->db->prepare($sql);
            $sth->execute();
            $red = $sth->fetchAll(PDO::FETCH_ASSOC);
            print_r (json_encode($red));
        }
    }
?>