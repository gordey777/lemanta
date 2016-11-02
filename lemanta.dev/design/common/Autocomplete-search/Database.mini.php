<?php
    // Impera CMS: мини модуль базы данных сервера MySQL.
    // Copyright AIMatrix, 2012.
    // http://imperacms.ru
    // http://aimatrix.itak.info

    class MySQLDatabaseMini {
        public $config = null;
        protected $link = FALSE;
        public $res_id = FALSE;

        public function __construct ( & $config = null ) {
            $this->config = & $config;
        }

        public function connect () {
            if (!isset($this->config->dbhost) || !isset($this->config->dbuser) || !isset($this->config->dbpass) || !isset($this->config->dbname)) return FALSE;

            if (function_exists('mysql_connect')) $this->link = mysql_connect($this->config->dbhost, $this->config->dbuser, $this->config->dbpass);
            elseif (function_exists('mysqli_connect')) $this->link = mysqli_connect($this->config->dbhost, $this->config->dbuser, $this->config->dbpass);
            else return FALSE;

            if ($this->link === FALSE) return FALSE;

            if (function_exists('mysql_select_db')) $result = mysql_select_db($this->config->dbname, $this->link);
            elseif (function_exists('mysqli_select_db')) $result = mysqli_select_db($this->link, $this->config->dbname);
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

        public function select ( $tables, $fields = array(), $where = '', $group = '', $having = '', $order = '', $start = '', $maxcount = '') {
            $from = '';
            $table_num = 1;
            $prefixes = array();
            if (is_array($tables)) {
                foreach ($tables as $table) {
                    if (function_exists('preg_replace')) $table = preg_replace('/\s+/', ' ', $table);
                    $table = trim($table);
                    $table = explode(' ', $table);
                    $last = count($table) - 1;
                    $alias = '';
                    foreach ($table as $index => $field) {
                        $field = strtolower($field);
                        if ($field == 'as') {
                            if (isset($table[$index + 1])) {
                                $alias = strtolower($table[$index + 1]);
                                $table[$index + 1] = $alias;
                                $table = implode(' ', $table);
                                if ($from != '') $from .= ($index == 1) ? ', ' : ' ';
                                $from .= $table;
                                $prefixes['[^' . $table_num . ']'] = $alias . '.';
                                $table_num++;
                            }
                            break;
                        } elseif ($field == 'on') {
                            if (isset($table[$index - 1])) {
                                $table[$index - 1] = $alias;
                                $table = implode(' ', $table);
                                if ($from != '') $from .= ' ';
                                $from .= $table;
                                $prefixes['[^' . $table_num . ']'] = $alias . '.';
                                $table_num++;
                            }
                            break;
                        } elseif ($index == $last) {
                            $table[$index] = $field;
                            $table = implode(' ', $table);
                            if ($from != '') $from .= ($index == 0) ? ', ' : ' ';
                            $from .= $table;
                            $prefixes['[^' . $table_num . ']'] = $field . '.';
                            $table_num++;
                            break;
                        }
                        $alias = $field;
                    }
                }
            }

            if ($from == '') return FALSE;
            $from = 'FROM ' . $from . ' ';

            $query = '';
            if (is_array($fields)) {
                foreach ($fields as $field) {
                    $field = trim($field);
                    if ($field == '') $field = '*';
                    if ($query != '') $query .= ', ';
                    $query .= $field;
                }
            }
            if ($query == '') $query = '*';

            $where = trim($where);
            if ($where != '') $where = 'WHERE ' . $where . ' ';
            $group = trim($group);
            if ($group != '') $group = 'GROUP BY ' . $group . ' ';
            $having = trim($having);
            if ($having != '') $having = 'HAVING ' . $having . ' ';
            $order = trim($order);
            if ($order != '') $order = 'ORDER BY ' . $order . ' ';

            $limit = '';
            if (($start != '') || ($maxcount != '')) {
                $limit = 'LIMIT ';
                if ($start != '') $limit .= $start . ', ';
                if ($maxcount != '') $limit .= $maxcount;
            }

            $query = 'SELECT ' . $query . ' ' . $from . $where . $group . $having . $order . $limit . ';';
            foreach ($prefixes as $index => $table) $query = str_replace($index, $table, $query);
            $result = $this->query($query);
            if ($result === FALSE) return FALSE;

            if ($maxcount === 1) $objects = & $this->fetch_object($result);
            else $objects = & $this->results($result);

            $this->free_result($result);
            return $objects;
        }

        public function query_value ( $value ) {
            if (is_float($value)) {
                $value = strval($value);
                $value = str_replace(',', '.', $value);
            }
            if (function_exists('mysql_real_escape_string')) return mysql_real_escape_string($value, $this->link);
            elseif (function_exists('mysqli_real_escape_string')) return mysqli_real_escape_string($this->link, $value);
            else return $value;
        }

        public function query ( $query ) {
            if ($this->link === FALSE) return FALSE;

            if (function_exists('mysql_query')) $this->res_id = mysql_query($query, $this->link);
            elseif (function_exists('mysqli_query')) $this->res_id = mysqli_query($this->link, $query);
            else return FALSE;

            if ($this->res_id === FALSE) return FALSE;
            return $this->res_id;
        }

        public function results ( & $resource = null ) {
            if (($resource === FALSE) || is_null($resource) && ($this->res_id === FALSE)) return FALSE;
            $result = array();
            if ($resource !== TRUE) {
              if (!is_null($resource)) while ($row = & $this->fetch_object($resource)) array_push($result, $row);
              elseif ($this->res_id !== TRUE) while ($row = & $this->fetch_object($this->res_id)) array_push($result, $row);
            }
            return $result;
        }

        public function fetch_object ( & $resource ) {
            if ($resource === FALSE) return FALSE;
            if (function_exists('mysql_fetch_object')) return mysql_fetch_object($resource);
            elseif (function_exists('mysqli_fetch_object')) return mysqli_fetch_object($resource);
            else return FALSE;
        }

        public function free_result ( & $resource ) {
            if ($resource === FALSE) return TRUE;
            if (function_exists('mysql_free_result')) return mysql_free_result($resource);
            elseif (function_exists('mysqli_free_result')) {
                mysqli_free_result($resource);
                return TRUE;
            } else return FALSE;
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

    return;
?>
