<?php namespace Jralph\Notification;

use Jralph\Notification\Contracts\Store;
use Illuminate\Session\Store as Session;

class IlluminateSessionStore implements Store {

    /**
     * Store the illuminate session store instance.
     *
     * @var Illuminate\Session\Store
     */
    protected $session;

    public function __construct(Session $session)
    {
        $this->session = $session;
    }

    /**
     * Get the specified key from the session.
     * 
     * @param  string $key     
     * @param  mixed $default
     * @return mixed
     */
    public function get($key, $default = null)
    {
        return $this->session->get($key, $default);
    }

    /**
     * Flash some data into the session.
     *
     * @param  string $key
     * @param  mixed $value
     * @return boolean
     */
    public function flash($key, $value)
    {
        return $this->session->flash($key, $value);
    }

    /**
     * Check if the session has a specified key.
     *
     * @param  string  $key
     * @return boolean
     */
    public function has($key)
    {
        return $this->session->has($key);
    }
}