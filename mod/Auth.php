<?php
class Auth
{
    private $guard = null;
    private $data = [];
    private $config = [];
    private $user = [];

    public function __construct()
    {
        $config = load_config('auth', CONFIG_PATH);
        $this->guard = $config['default_guard'];
        $this->config = $config;

        /** */
        foreach($config['guard'] as $guard)
        {
            $this->data[$guard] = [];
        }
    }

    public function check()
    {
        $session = Session::get('login', null);
        if ($session == null) return false;
        if(isset($session[$this->guard])) return true;
        return false;
    }

    public function logout()
    {
        $session = Session::get('login', null);
        if(isset($session[$this->guard])) unset($session[$this->guard]);
        Session::set('login', $session);
        return ;
    }

    public function guard($name)
    {
        $this->guard = $name;
        return $this;
    }

    public function attempt($username, $password)
    {
        $db = new Database;
        $tb = $this->config['table'][$this->guard];

        $search_username = $db->table($tb)->where('username', $username)->first();
        if (password_verify($password, $search_username->password)) return true;
        return false;
    }

    public function login($username)
    {
        $db = new Database;
        $tb = $this->config['table'][$this->guard];
        $user = $db->table($tb)->where('username', $username)->first();

        $data = [
            'id' => $user->id,
            'time' => time()
        ];
        
        $session = Session::get('login', null);
        if ($session == null) $session = [];
        $session[$this->guard] = $data;
        Session::set('login', $session);
    }

    public function user()
    {
        if (isset($this->user[$this->guard])) return $this->user[$this->guard];
        
        $session = Session::get('login', null);
        $db = new Database;
        $tb = $this->config['table'][$this->guard];
        $user = $db->table($tb)->where('id', $session[$this->guard]['id'])->first();
        $user = (array) $user;
        unset($user['password']);
        $user = (object) $user;
        $this->user[$this->guard] = $user;
        return $user;
    }
}