<?php
class File
{
    private $name = '';

    public function tes()
    {
        dd('tes');
    }

    public function select($name)
    {
        if (!isset($_FILES[$name])) dd("file " . $name . " is null");
        $this->name = $name;
        return $this;
    }

    public function mimes($mime)
    {
        $info = $this->info();
        if (!in_array($info['ext'], $mime)) dd('file ' . $info['name'] . ' must be (' . implode(',', $mime) . ')');
        return $this;
    }

    public function upload($option)
    {
        $info   = $this->info();
        $path   = isset($option['path']) ? $option['path'] . '/' : BASE_PATH;
        $name   = isset($option['name']) ? $option['name'] : md5($info['name'] . time()); $name = $name . '.' . $info['ext'];
        $dir    = $path . $name;
        $upload = move_uploaded_file($_FILES[$this->name]['tmp_name'], $dir);
        return ($upload) ? ['name' => $name, 'path' => $dir, 'dir' => $path] : false;
    }

    public function info()
    {
        $info = $_FILES[$this->name];
        $info['ext'] = strtolower(pathinfo($info['name'], PATHINFO_EXTENSION));
        return $info;
    }
}