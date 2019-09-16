<?php
class Database 
{
    private $pdo = null;
    private $config = [];
    private $query_connection = '';
    private $table = null;
    private $query = '';
    private $order_by = null;
    private $order_short = 'ASC';
    private $where = [];
    private $update = [];
    private $insert = [];
    private $params = [];
    private $delete = false;

    /** init */
    public function __construct()
    {
        /** load config */
        $db_config                  = load_config('db');
        $this->config               = $db_config['dbconfig'];
        $this->query_connection     = $db_config['query'];

        /** make connection */
        if($this->pdo == null)
        {
            $this->pdo = new PDO($this->query_connection, $this->config['username'], $this->config['password']);
            $this->pdo->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING );
        }
    }

    /** select table */
    public function table($name)
    {
        /** change select table */
        $this->table = $name;

        $this->reset();

        /** chaining return */
        return $this;
    }
    
    /** reset param */
    private function reset()
    {
        $this->query = '';
        $this->order_by = null;
        $this->order_short = 'ASC';
        $this->where = [];
        $this->insert = [];
        $this->update = [];
        $this->delete = false;
        $this->params = [];
    }

    /** where */
    public function where()
    {
        $args = func_get_args();
        $args_count = func_num_args();

        if ($args_count == 2)
        {
            $this->where[] = [$args[0], '=', $args[1]];
        } elseif ($args_count == 3) {
            $this->where[] = [$args[0], $args[1], $args[2]];
        }

        return $this;
    }

    /** get last insert data */
    public function getLastInsertId()
    {
        return $this->pdo->lastInsertId();
    }
    public function getLastInsert()
    {
        $id =  $this->pdo->lastInsertId();
        $this->reset();
        return $this->where('id', $id)->first();
    }

    /** update */
    public function update()
    {
        /** convert array */
        $args = func_get_args();
        $args_count = func_num_args();
        if ($args_count == 2)
        {
            $this->update[] = ['key' => $args[0], 'value' => $args[1]];
        } elseif ($args_count == 1 && is_array($args[0])) {
            foreach($args[0] as $item_k => $item)
            {
                $this->update[] = ['key' => $item_k, 'value' => $item];
            }
        }


        /** build query */
        $result = $this->buildQuery('get');
        $params = $result['params'];
        $query  = $result['query'];
        
        /** execute pdo */
        $query = $this->pdo->prepare($query);
        $query->execute($params);

        return true;
    }


    /** insert */
    public function insert($data)
    {
        foreach($data as $item_k => $item)
        {
            $this->insert[] = ['key' => $item_k, 'value' => $item];
        }

        /** build query */
        $result = $this->buildQuery('get');
        $params = $result['params'];
        $query  = $result['query'];
        // dd($query);

        /** execute pdo */
        $query = $this->pdo->prepare($query);
        $query->execute($params);

        return true;
    }


    /** delete */
    public function delete()
    {
        $this->delete = true;

        /** build query */
        $result = $this->buildQuery('get');
        $params = $result['params'];
        $query  = $result['query'];

        /** execute pdo */
        $query = $this->pdo->prepare($query);
        $query->execute($params);

        return true;
    }


    /** get */
    public function get()
    {
        /** build query */
        $result = $this->buildQuery('get');
        $params = $result['params'];
        $query  = $result['query'];
        
        /** execute pdo */
        $query = $this->pdo->prepare($query);
        $query->execute($params);
        
        /** return data */
        return $query->fetchAll(PDO::FETCH_OBJ);
    }

    /** findOrDie */
    public function findOrDie($text)
    {
        $search = $this->get();
        if ( count($search) == 0) return dd($text);
        return $search[0];
    }

    public function first()
    {
        return $this->get()[0];
    }

    /** build query */
    private function buildQuery($type = 'get')
    {
        if ($type == 'get')
        {

            /** update */
            $update_query = '';
            $update_arr = [];
            $update_query = '';
            if(count($this->update) != 0) {
                foreach($this->update as $item)
                {
                    $update_arr[] = $item['key'] . '=' . '?';
                    $this->params[] = $item['value'];
                }
                $update_query = 'SET ' . implode(', ', $update_arr);
            }


            /** insert */
            $insert_query = '';
            if(count($this->insert) != 0) {
                $insert_arr = [];
                foreach($this->insert as $item)
                {
                    $insert_arr[] = $item['key'];
                }
                $insert_query = '(' . implode(', ', $insert_arr) . ')';

                $insert_arr = [];
                foreach($this->insert as $item)
                {
                    $insert_arr[] = '?';
                    $this->params[] = $item['value'];
                }
                $insert_query .= ' VALUES (' . implode(', ', $insert_arr) . ')';
            }


            /** where */
            $where_query = '';
            if(count($this->where) != 0) {
                $where_arr = [];
                $where_query = '';
                foreach($this->where as $item)
                {
                    if (($item[1] == 'in' || $item[1] == 'IN') && is_array($item[2])) {
                        // $where_arr[] = $item[0] . ' ' . $item[1] . ' (?)';
                        // $this->params[] = "'" . implode("', '", $item[2]) . "'";
                        $where_arr[]  = $item[0] . ' IN (' . (count($item[2]) == 0 ? '' : str_repeat('?,', count($item[2]) - 1) . '?') . ')';
                        foreach ($item[2] as $value) {
                            $this->params[] = $value;
                        }
                    } else {
                        $where_arr[] = $item[0] . $item[1] . '?';
                        $this->params[] = $item[2];
                    }
                }
                $where_query = 'WHERE ' . implode(' AND ', $where_arr);
            }

            // prepare query
            $prepare_query = "SELECT * FROM ";
            if (count($this->update) > 0) $prepare_query = "UPDATE ";
            if (count($this->insert) > 0) $prepare_query = "INSERT INTO ";
            if ($this->delete) $prepare_query = "DELETE FROM ";

            // auto make order by
            $order_query = '';
            if (count($this->update) == 0 && count($this->insert) == 0 && !$this->delete)
            {
                if ($this->order_by == null) $this->order_by = 'id';
                $order_query = 'ORDER BY ' . $this->order_by . ' ' . $this->order_short;
            }


            /** build query */
            $this->query = $prepare_query
                . $this->table
                . " "
                . $update_query . $insert_query
                . " "
                . $where_query
                . " "
                . $order_query
                ;
            
            // dd($this->query);
        }

        
        /** return query */
        return [
            'query' => $this->query,
            'params' => $this->params
        ];
    }


    public function query($query, $params = [], $fetch = false, $fetch_type = PDO::FETCH_OBJ)
    {
        $this->reset();

        /** execute pdo */
        $query = $this->pdo->prepare($query);
        $execute = $query->execute($params);
        
        /** return data */
        return $fetch == false ? $execute : $query->fetchAll($fetch_type);
    }

    /** get info db */
    public function info()
    {
        echo $this->config;
    }
}