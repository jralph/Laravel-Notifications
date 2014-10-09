<?php namespace Jralph\Notification\Contracts;

interface Notification {

    public function tags(array $tags = []);
    public function tag($tag);
    public function put($key, $value);
    public function get($key, $default = null);
    public function has($key);

}
