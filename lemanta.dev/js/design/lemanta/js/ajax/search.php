<?php
    error_reporting(0);
    if (!function_exists('json_encode')) return;

    chdir('../../../../');
    require_once('objects/Definition.php');

    class MySQLDatabaseMini {
        public $config = null;
        protected $link = FALSE;
        public $res_id = FALSE;

        public function __construct ( & $config = null ) {
            $this->config = & $config;
        }

        public function connect () {
            if (!isset($this->config->dbhost) || !isset($this->config->dbuser) || !isset($this->config->dbpass) || !isset($this->config->dbname)) return FALSE;

            if (function_exists('mysqli_connect')) $this->link = mysqli_connect($this->config->dbhost, $this->config->dbuser, $this->config->dbpass);
            elseif (function_exists('mysql_connect')) $this->link = mysql_connect($this->config->dbhost, $this->config->dbuser, $this->config->dbpass);
            else return FALSE;

            if ($this->link === FALSE) return FALSE;

            if (function_exists('mysqli_select_db')) $result = mysqli_select_db($this->link, $this->config->dbname);
            elseif (function_exists('mysql_select_db')) $result = mysql_select_db($this->config->dbname, $this->link);
            else return FALSE;

            if (!$result) return FALSE;
            return $this->link;
        }

        public function set_charset ( $charset = 'utf8' ) {
            $charset = trim($charset);
            if ($charset != '') {
                setlocale(LC_ALL, 'ru_RU.' . $charset);
                $this->query('SET NAMES ' . $charset);
            }
        }

        public function query_value ( $value ) {
            if (is_float($value)) {
                $value = strval($value);
                $value = str_replace(',', '.', $value);
            }
            if (function_exists('mysqli_real_escape_string')) return mysqli_real_escape_string($this->link, $value);
            elseif (function_exists('mysql_real_escape_string')) return mysql_real_escape_string($value, $this->link);
            else return $value;
        }

        public function query ( $query ) {
            if ($this->link === FALSE) return FALSE;

            if (function_exists('mysqli_query')) $this->res_id = mysqli_query($this->link, $query);
            elseif (function_exists('mysql_query')) $this->res_id = mysql_query($query, $this->link);
            else return FALSE;

            if ($this->res_id === FALSE) return FALSE;
            return $this->res_id;
        }

        public function results ( & $resource = null ) {
            if ($resource === FALSE || is_null($resource) && $this->res_id === FALSE) return FALSE;
            $result = array();
            if ($resource !== TRUE) {
              if (!is_null($resource)) while ($row = & $this->fetch_object($resource)) array_push($result, $row);
              elseif ($this->res_id !== TRUE) while ($row = & $this->fetch_object($this->res_id)) array_push($result, $row);
            }
            return $result;
        }

        public function fetch_object ( & $resource ) {
            if ($resource === FALSE) return FALSE;
            if (function_exists('mysqli_fetch_object')) return mysqli_fetch_object($resource);
            elseif (function_exists('mysql_fetch_object')) return mysql_fetch_object($resource);
            else return FALSE;
        }

        public function free_result ( & $resource ) {
            if ($resource === FALSE) return TRUE;
            if (function_exists('mysqli_free_result')) {
                mysqli_free_result($resource);
                return TRUE;
            } elseif (function_exists('mysql_free_result')) return mysql_free_result($resource);
            else return FALSE;
        }

        public function get_root_url () {
            $dir = isset($_SERVER['SCRIPT_NAME']) ? trim(dirname($_SERVER['SCRIPT_NAME'])) : '';
            $dir = str_replace('\\', '/', $dir);
            $dir = rtrim($dir, '/ ');
            $url = isset($_SERVER['HTTP_HOST']) ? trim($_SERVER['HTTP_HOST']) : '';
            $url = str_replace('\\', '/', strtolower($url));
            $url = rtrim($url, '/ ');
            $url .= $dir;
            return $url;
        }

        public function get_site_url () {
            $url = $this->get_root_url();
            $url = 'http://' . $url . '/';
            return $url;
        }
    }

    $keyword = isset($_REQUEST['query']) ? $_REQUEST['query'] : '';
    $response = array('query'       => $keyword,
                      'suggestions' => array(),
                      'data'        => array());
    $keyword = preg_replace('/[^a-z0-9а-яё]+/iu', ' ', $keyword);
    $keyword = preg_replace('/\s+/u', ' ', $keyword);
    $keyword = trim($keyword);
    if ($keyword != '') {

        $db = new MySQLDatabaseMini();
        $db->config = new Config();

        if ($db->connect()) {
            $db->set_charset('utf8');

            $keyword = explode(' ', $keyword, 5);
            if (count($keyword) > 4) array_pop($keyword);

            $filter = '';
            foreach ($keyword as & $w) {
                $w = $db->query_value($w);
                if ($w != '') $filter .= 'AND (`products`.`model` LIKE "%' . $w . '%" OR '
                                            . '`products`.`pcode` LIKE "%' . $w . '%" OR '
                                            . '`products_variants`.`sku` LIKE "%' . $w . '%") ';
            }

            $res = $db->query('SELECT `products`.`model` AS `name`, '
                                   . '`products_variants`.`sku`, '
                                   . '`products`.`pcode`, '
                                   . '`products`.`url`, '
                                   . '`products`.`url_special`, '
                                   . '`products`.`small_image` AS `image` '
                            . 'FROM `products` '
                            . 'LEFT JOIN `products_variants` ON `products_variants`.`product_id` = `products`.`product_id` '
                            . 'WHERE `products`.`enabled` = 1 ' . $filter
                            . 'GROUP BY `products`.`product_id` '
                            . 'ORDER BY `name` ASC '
                            . 'LIMIT 0, 30');
            $items = $db->results($res);
            if (!empty($items)) {
                foreach ($items as & $item) {
                    $item->name = trim($item->name);
                    if ($item->name != '') {
                        $item->image = trim($item->image);
                        if ($item->image != '') {
                            if (strtolower(substr($item->image, 0, 5)) != 'http:') $item->image = 'files/products/' . $item->image;
                        } else $item->image = 'design/lemanta/images/no-photo.png';
                        $item->url = ($item->url_special ? '' : 'products/') . trim($item->url);
                        $item->pcode = trim($item->pcode);
                        $item->sku = trim($item->sku);
                        $response['suggestions'][] = $item->name;
                        $response['data'][] = $item;
                    }
                }
            }
            $db->free_result($res);
        }
    }

    header('Content-type: application/json; charset=UTF-8');
    header('Cache-Control: must-revalidate');
    header('Pragma: no-cache');
    header('Expires: -1');		
    print json_encode($response);
?>