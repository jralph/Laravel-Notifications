<?php namespace Jralph\Notification\Contracts;

interface Store {

    /**
     * Get the specified key.
     * 
     * @param  string $key     
     * @param  mixed $default
     * @return mixed
     */
    public function get($key, $default = null);

    /**
     * Flash some data.
     *
     * @param  string $key
     * @param  mixed $value
     * @return boolean
     */
    public function flash($key, $value);

     /**
     * Check if the specified key exists.
     *
     * @param  string  $key
     * @return boolean
     */
    public function has($key);

}
