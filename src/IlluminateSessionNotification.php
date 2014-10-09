<?php namespace Jralph\Notification;

use Jralph\Notification\Contracts\Notification;
use Illuminate\Session\Store as Session;

class IlluminateSessionNotification implements Notification {

    /**
     * The prefix for the notification session key.
     *
     * @var string
     */
    const KEY_PREFIX = 'notification_';

    /**
     * The prefix for the tag  session key.
     *
     * @var string
     */
    const TAG_PREFIX = 'tag_';

    /**
     * Store the illuminate session manager instance.
     *
     * @var Illuminate\Session\Store
     */
    protected $session;

    /**
     * Any tags to add to the notification being created.
     *
     * @var array
     */
    protected $tags = [];

    public function __construct(Session $session)
    {
        $this->session = $session;
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
        $keys = (array) $this->session->get(self::KEY_PREFIX.self::TAG_PREFIX.$tag);

        $notifications = [];

        foreach ($keys as $key)
        {
            $notifications[$this->removePrefix($key)] = $this->get($key);
        }

        return $notifications;
    }

    /**
     * Put a notification into the session storage.
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

        return $this->session->flash(self::KEY_PREFIX.$key, $value);
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
            $existingTagKeys = (array) $this->session->get(self::KEY_PREFIX.self::TAG_PREFIX.$tag);

            if (!in_array($key, $existingTagKeys))
            {
                $existingTagKeys[] = $key;
            }

            $this->session->flash(self::KEY_PREFIX.self::TAG_PREFIX.$tag, $existingTagKeys);
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
        return $this->session->get(self::KEY_PREFIX.$key) ?: $default;
    }

    /**
     * Check if a notification is in the session.
     *
     * @param  string  $key
     * @return boolean
     */
    public function has($key)
    {
        return $this->session->has(self::KEY_PREFIX.$key);
    }

    protected function removePrefix($key)
    {
        return str_replace(self::KEY_PREFIX, '', $key);
    }

}