<?php

use Jralph\Notification\Notification;

class IlluminateSessionNotificationTest extends PHPUnit_Framework_TestCase {
    
    public function setUp()
    {
        parent::setUp();

        $this->store = Mockery::mock('Jralph\Notification\Contracts\Store');

        $this->notification = new Notification($this->store);
    }

    public function test_put_stores_item_in_session()
    {
        $this->store->shouldReceive('flash')->once()->andReturn(true);

        $this->assertEquals(true, $this->notification->put('key', 'my_value'));
    }

    public function test_get_returns_session_value()
    {
        $this->store->shouldReceive('get')->once()->andReturn('my_value');

        $this->assertEquals('my_value', $this->notification->get('key'));
    }

    public function test_get_returns_default_if_session_is_null()
    {
        $this->store->shouldReceive('get')->once()->andReturn(null);

        $this->assertEquals('default_value', $this->notification->get('key', 'default_value'));
    }

    public function test_has_returns_true_for_existing_key()
    {
        $this->store->shouldReceive('has')->once()->andReturn(true);

        $this->assertTrue($this->notification->has('key'));
    }

    public function test_put_works_with_tags()
    {
        $this->store->shouldReceive('get')->once()->andReturn([]);
        $this->store->shouldReceive('flash')->once()->andReturn(null);
        $this->store->shouldReceive('flash')->once()->andReturn(true);

        $this->assertTrue($this->notification->tags(['tag'])->put('key', 'my_value'));
    }

    public function test_tag_returns_keys_with_specified_tag()
    {
        $this->store->shouldReceive('get')->once()->andReturn(['key1', 'key2']);
        $this->store->shouldReceive('get')->twice()->andReturn('my_value');

        $expected = [
            'key1' => 'my_value',
            'key2' => 'my_value'
        ];

        $this->assertEquals($expected, $this->notification->tag('tag'));
    }

}