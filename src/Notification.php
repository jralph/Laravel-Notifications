<?php namespace Jralph\Notification;

use Jralph\Notification\Contracts\Notification as NotificationContract;
use Jralph\Notification\Contracts\Store;

class Notification implements NotificationContract {

    /**
     * The prefix for the notification key.
     *
     * @var string
     */
    const KEY_PREFIX = 'notification_';

    /**
     * The prefix for the tag by key.
     *
     * @var string
     */
    const TAG_PREFIX = 'tag_';

    protected $store;

    /**
     * Any tags to add to the notification being created.
     *
     * @var array
     */
    protected $tags = [];

    public function __construct(Store $store)
    {
        $this->store = $store;
    }

    /**
     * Add any tags to the tags array.
     *
     * @param  array $tags
     * @return this
     */
    public function tags(array $tags = [])
    {
        if ($tags)
        {
            $this->tags = $tags;
        }

        return $this;
    }

    /**
     * Get all keys assigned to a specified tag.
     *
     * @param  string $tag
     * @return array
     */
    public function tag($tag)
    {
        $keys = (array) $this->store->get(self::KEY_PREFIX.self::TAG_PREFIX.$tag);

        $notifications = [];

        foreach ($keys as $key)
        {
            $notifications[$this->removePrefix($key)] = $this->get($this->removePrefix($key));
        }

        return $notifications;
    }

    /**
     * Put a notification into the storage.
     *
     * @param  string $key
     * @param  mixed $value
     * @return boolean
     */
    public function put($key, $value)
    {
        if (!empty($this->tags))
        {
            $this->addKeyToTags(self::KEY_PREFIX.$key);
            $this->tags = [];
        }

        return $this->store->flash(self::KEY_PREFIX.$key, $value);
    }

    /**
     * Add any tags to the specified key.
     *
     * @param string $key
     */
    protected function addKeyToTags($key)
    {
        foreach ($this->tags as $tag)
        {
            $existingTagKeys = (array) $this->store->get(self::KEY_PREFIX.self::TAG_PREFIX.$tag);

            if (!in_array($key, $existingTagKeys))
            {
                $existingTagKeys[] = $key;
            }

            $this->store->flash(self::KEY_PREFIX.self::TAG_PREFIX.$tag, $existingTagKeys);
        }
    }

    /**
     * Get the value of a notification by key.
     *
     * @param  string $key
     * @param  string $default
     * @return mixed
     */
    public function get($key, $default = null)
    {
        return $this->store->get(self::KEY_PREFIX.$key) ?: $default;
    }

    /**
     * Check if a notification is in the store.
     *
     * @param  string  $key
     * @return boolean
     */
    public function has($key)
    {
        return $this->store->has(self::KEY_PREFIX.$key);
    }

    /**
     * Remove the key prefix from a given string.
     *
     * @param  string $key
     * @return string
     */
    protected function removePrefix($key)
    {
        return str_replace(self::KEY_PREFIX, '', $key);
    }

}
