Laravel 4 Flash Notifications 
=============================

[![Latest Stable Version](https://poser.pugx.org/jralph/notification/v/stable.svg)](https://packagist.org/packages/jralph/notification) [![Total Downloads](https://poser.pugx.org/jralph/notification/downloads.svg)](https://packagist.org/packages/jralph/notification) [![Latest Unstable Version](https://poser.pugx.org/jralph/notification/v/unstable.svg)](https://packagist.org/packages/jralph/notification) [![License](https://poser.pugx.org/jralph/notification/license.svg)](https://packagist.org/packages/jralph/notification)

A simple and easy to use flash notification setup for Laravel 4.

### Extension ###

By default, the notifications are handled by the Illuminate Session Store but this can be easily replaced by implementing the `Jralph\Notification\Contracts\Store` contract provided and then bound using the IoC container. Once done, any existing code will continue to work as normal. For example, you could easily switch out the Session Store for your own form of storage for flash messages.

Usage
-----

### Laravel ###

To use the Notification in Laravel, you can add the service provider and alias to your `app/config/app.php` file.

```
<?php
...
    'providers' => array(
        ...
        'Jralph\Notification\NotificationServiceProvider',
        ...
    ),
    ...
    'aliases' => array(
        ...
        'Notification' => 'Jralph\Notification\Facades\Notification'
        ...
    ),
...
?>
```

Once this is done, you can use the facade like so.

```
<?php
    Notification::put('key', 'value');
?>
```

_See below for more information on the methods the class provides._

### Methods ###

__PUT__

The put method flashes a key => value message to the session.

```
<?php
    Notification::put('key', 'value');
?>
```

__GET__

The get method retrieves a value from the session by key.

```
<?php
    Notification::get('key'); // If using the above put somewhere, this will return (string) 'value'.
?>
```

__HAS__

The has method checks if a key exists in the notification session storage.

```
<?php
    Notification::has('key',); // If using the above put somewhere, this will return true.
?>
```

__TAGS__

The tags method can be combined with the put method to tag specific notifications.

```
<?php
    Notification::tags(['tag1', 'tag2'])->put('key', 'value');
?>
```

__TAG__

The tag method is used to retrieve an array of notifications attached to a specific tag.

```
<?php
    Notification::tag('tag1'); // Returns an array of all notifications tagged as `tag1`.
?>
```

### Example Usage ###

In a controller processing login somewhere.

```
<?php

class AuthController extends BaseController {

    public function postLogin()
    {
        // Validate Form
        if ($validation->fails())
        {
            Notification::tags(['error'])->put('validation_failed', 'The form validation has failed.'); // Note you could pass an array as the value.
            return Redirect::back();
        }

        // Process User Login
    }

}
?>
```

Somewhere in a view displaying the login form somewhere.

```
@foreach (Notification::tag('error') as $key => $notification)
    <div class="notification">
        <strong>{{ $key }}</strong> {{ $notification }}
    </div>
@endforeach
```

You could also disregard the tags for a simpler approach and just display the validation failed error.

```
@if (Notification::has('validation_failed'))
    <div class="notification">
        <strong>Validation Failed</strong> {{ Notification::get('validation_failed') }}
    </div>
@endif
```
