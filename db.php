<?php

class Database {
    public $affected_rows = 0;          // Use after calling query function
    public $qcount = 0;                 // Use after calling query function
    public $qicount = 0;                // Use after calling query function
    public $insert_id = null;           // Use after calling an insert query
    public $db;                         // For use with mysqli php functions
    public $result;                     // For use with mysqli php functions
    
    // Cache-related properties
    private $required_variables = array('caching_path','priority_required'); 
    private $caching_path = ""; 
    private $priority_required = 0;
    private $orgcache = '/cache/';
    private $has_buffer_started = false;
    private $buffer_content = "";
    
    // Other private properties
    private $crlf = "\r\n";
    private $as_file = false;
    private $tmp_buffer = "";
    private $db_host = "";
    private $db_user = "";
    private $db_pass = "";
    private $db_name = "";
    private $cache_time = 1800;

    const CACHE_TIME = 1800;
    const GET_ARRAY = 0;    // get array data
    const GET_ROW = 1;      // get row with data
    const GET_FIELD = 2;    // get single field
    const GET_Num = 3;      // get statement true and false
    const VTYPE_BOTH = "BOTH";
    const VTYPE_SESSION = "SESSION";
    const VTYPE_GLOBAL = "GLOBAL";

    public function __construct($db_host, $db_user, $db_pass, $db_name = '') {
        // Initialize cache settings
        $config = array(
            'priority_required' => 50,
            'caching_path' => '/cache/'
        );
        
        foreach($this->required_variables as $var) {
            $this->{$var} = $config[$var];
        }
        
        // Database connection settings
        $this->db_host = $db_host;
        $this->db_user = $db_user;
        $this->db_pass = $db_pass;
        $this->db_name = $db_name;
    }
    
    public function connect() {
        if (!isset($this->db) || !mysqli_ping($this->db)) {
            $conn = new mysqli($this->db_host, $this->db_user, $this->db_pass, $this->db_name);
            
            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }
            
            $this->db = $conn; 
        }
    }
    
    public function query($query, $cachewhat = 'yes', $return_type = self::GET_ARRAY, $cache_time = '3600') {
        $this->qcount++;
        
        if(!empty($_GET['queryshow'])) {
            echo '<div style="display:none;">No:'.$this->qcount.' : ';
            print_r($query);
            echo '</div>';
        }
        
        // Determine query type
        $q = trim($query);
        $qarr = explode(' ', $q);
        $query_type = strtoupper($qarr[0]);
        
        // Proceed based on query type
        if (in_array($query_type, ["SELECT", "SHOW", "EXPLAIN", "DESCRIBE", "HELP"])) {
            if ($cachewhat == 'yes') {
                $content = $this->retrieve_cache($query . $return_type, 75);
            } else {
                $content = false;
            }

            if ($content === false) {
                $this->qicount++;
                $this->connect();
                $this->result = $this->db->query($query);
                
                if(!$this->result) {
                    $this->show_error($this->db->errno);
                    return false;
                }
                
                $this->affected_rows = $this->db->affected_rows;
                
                if($return_type == self::GET_ARRAY) {
                    $content = $this->result->fetch_all(MYSQLI_ASSOC);
                    if ($cachewhat == 'yes') {
                        $this->cache_content($query . $return_type, $content, $cache_time);
                    }
                } elseif($return_type == self::GET_ROW) {
                    $content = $this->result->fetch_assoc();
                    if ($content && $cachewhat == 'yes') {
                        $this->cache_content($query . $return_type, $content, $cache_time);
                    }
                } elseif($return_type == self::GET_FIELD) {
                    $content = $this->result->fetch_column();
                } elseif($return_type == self::GET_Num) {
                    $content = $this->result->num_rows;
                }
                
                if(!empty($_GET['querycontent'])) {
                    echo '<div style="display:none;">No:'.$this->qcount.' : ';
                    print_r($content);
                    echo '</div>';
                }
                
                return $content;
            }
            
            if(!empty($_GET['samquerysh'])) {
                echo '<div style="display:none;">No:'.$this->qcount.' : ';
                print_r($content);
                echo '</div>';
            }
            
            return $content;
        } else {
            $this->qicount++;
            $this->connect();
            $this->result = $this->db->query($query);
            
            if(!$this->result) {
                $this->show_error($this->db->errno);
                return false;
            }
            
            $this->affected_rows = $this->db->affected_rows;
            
            if ($query_type == "INSERT") {
                $this->insert_id = $this->db->insert_id;
            }
            
            return true;
        }
    }

    public function clean($q) {
        $this->connect();
        return $this->db->real_escape_string($q);
    }

    public function disconnect() {
        if(isset($this->db)) {
            return @mysqli_close($this->db);
        }
        return false;
    }
    
    private function show_error($error) {
        echo "<p><strong>Error:</strong> " . $error . "</p>";
    }
    
    /* Cache-related methods */
    
    public function cache_content($name, $content, $duration = 60) {
        $filename = $this->caching_path . $this->_encrypt_name($name).'.php';
        
        if(!is_dir($this->caching_path)) {
            $this->mkdir_r($this->caching_path, 0755);
        }
        
        $content = array(
            'duration' => $duration,
            'creation' => time(),
            'content' => $content
        );
        
        $content = serialize($content);
        $val = var_export($content, true);
        $val = str_replace('stdClass::__set_state', '(object)', $val);
        
        file_put_contents($filename, '<?php $val = ' . $val . ';', LOCK_EX);
        
        return true;
    }
    
    public function retrieve_cache($name, $priority = 0) {
        $filename = $this->caching_path . $this->_encrypt_name($name).'.php';
        
        if($priority < $this->priority_required) {
            return false;
        }
        
        if(!file_exists($filename)) {
            return false;
        }
        
        include $filename;
        $content = unserialize($val);
        
        if($content['duration'] == 0) {
            return $content['content'];
        } elseif(time() > $content['creation'] + $content['duration']) {
            return false;
        } else {
            return $content['content'];
        }
    }
    
    public function start_buffer() {
        if(!$this->has_buffer_started) {
            ob_start();
            $this->has_buffer_started = true;
        }
    }
    
    public function stop_buffer() {
        if($this->has_buffer_started) {
            $content = ob_get_clean();
            $this->buffer_content = $content;
            $this->has_buffer_started = false;
        }
    }
    
    public function cache_buffer($name, $duration = 60) {
        if(!$this->has_buffer_started) {
            $this->cache_content($name, $this->buffer_content, $duration);
        }
    }
    
    public function delete_cache($name) {
        $filename = $this->caching_path . $this->_encrypt_name($name);
        
        if(!file_exists($filename)) {
            return false;
        }
        
        unlink($filename);
        return true;
    }
    
    private function _encrypt_name($name) {
        return md5($name);
    }
    
    private function mkdir_r($dirName, $rights = 0755) {
        $dirs = explode('/', $dirName);
        $dir = '';
        
        foreach ($dirs as $part) {
            $dir .= $part.'/';
            if (!is_dir($dir) && strlen($dir) > 0) {
                mkdir($dir, $rights);
            }
        }
    }
    
    public function setdir($id, $chk = '0') {
        if(!empty($id) && $chk == '1') {
            $this->caching_path = $this->orgcache.$id.'/';
        }
        
        if(!empty($id) && $chk == '0') {
            $this->caching_path = $this->caching_path.$id.'/';
        }
    }
}
