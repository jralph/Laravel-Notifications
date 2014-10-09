<?php

use Jralph\Notification\IlluminateSessionStore;

class IlluminateSessionStoreTest extends PHPUnit_Framework_TestCase {
    
    public function setUp()
    {
        parent::setUp();

        $this->session = Mockery::mock('Illuminate\Session\Store');

        $this->store = new IlluminateSessionStore($this->session);
    }

    public function test_get_returns_expected()
    {
        $this->session->shouldReceive('get')->once()->andReturn('my_value');

        $this->assertEquals('my_value', $this->store->get('key'));
    }

    public function test_flash_returns_true()
    {
        $this->session->shouldReceive('flash')->once()->andReturn(true);

        $this->assertTrue($this->store->flash('key', 'value'));
    }

    public function test_has_returns_true_if_key_exists()
    {
        $this->session->shouldReceive('has')->once()->andReturn(true);

        $this->assertTrue($this->store->has('key'));
    }

    public function test_has_returns_false_if_key_does_not_exist()
    {
        $this->session->shouldReceive('has')->once()->andReturn(false);

        $this->assertFalse($this->store->has('key'));
    }

}