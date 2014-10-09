<?php namespace Jralph\Notification\Contracts;

interface Notification {

    /**
     * Specify tags to add to the next key to be stored.
     *
     * @param  array $tags
     * @return this
     */
    public function tags(array $tags = []);

    /**
     * Fetch all notifications for a specified tag.
     *
     * @param  string $tag
     * @return array
     */
    public function tag($tag);

    /**
     * Put an notification into storage.
     *
     * @param  string $key
     * @param  mixed $value
     * @return boolean
     */
    public function put($key, $value);

    /**
     * Get a notification from storage.
     *
     * @param  string $key
     * @param  mixed $default
     * @return mixed
     */
    public function get($key, $default = null);

    /**
     * Check if the store has a specified key.
     *
     * @param  string  $key
     * @return boolean
     */
    public function has($key);

}
