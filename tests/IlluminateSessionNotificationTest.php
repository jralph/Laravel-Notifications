<?php

use Jralph\Notification\IlluminateSessionNotification as Notification;

class IlluminateSessionNotificationTest extends PHPUnit_Framework_TestCase {
    
    public function setUp()
    {
        parent::setUp();

        $this->session = Mockery::mock('Illuminate\Session\Store');

        $this->notification = new Notification($this->session);
    }

    public function test_put_stores_item_in_session()
    {
        $this->session->shouldReceive('flash')->once()->andReturn(true);

        $this->assertEquals(true, $this->notification->put('key', 'my_value'));
    }

    public function test_get_returns_session_value()
    {
        $this->session->shouldReceive('get')->once()->andReturn('my_value');

        $this->assertEquals('my_value', $this->notification->get('key'));
    }

    public function test_get_returns_default_if_session_is_null()
    {
        $this->session->shouldReceive('get')->once()->andReturn(null);

        $this->assertEquals('default_value', $this->notification->get('key', 'default_value'));
    }

    public function test_has_returns_true_for_existing_key()
    {
        $this->session->shouldReceive('has')->once()->andReturn(true);

        $this->assertTrue($this->notification->has('key'));
    }

    public function test_put_works_with_tags()
    {
        $this->session->shouldReceive('get')->once()->andReturn([]);
        $this->session->shouldReceive('flash')->once()->andReturn(null);
        $this->session->shouldReceive('flash')->once()->andReturn(true);

        $this->assertTrue($this->notification->tags(['tag'])->put('key', 'my_value'));
    }

    public function test_tag_returns_keys_with_specified_tag()
    {
        $this->session->shouldReceive('get')->once()->andReturn(['key1', 'key2']);
        $this->session->shouldReceive('get')->twice()->andReturn('my_value');

        $expected = [
            'key1' => 'my_value',
            'key2' => 'my_value'
        ];

        $this->assertEquals($expected, $this->notification->tag('tag'));
    }

}