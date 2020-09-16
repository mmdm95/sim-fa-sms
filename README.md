# Simplicity Fa-SMS
A library for iranian sms panels.

## Install
**composer**
```php 
composer require mmdm/sim-persian-sms
```

Or you can simply download zip file from github and extract it, 
then put file to your project library and use it like other libraries.

## How to use
For convenient it has a factory class that can instantiate appropriate 
class according to your panel. If there is no such panel type, it'll 
return **null**.

#### `instance(int $type)`

```php
// SMSFactory from Sim\SMS\SMSFactory namespace
$panel = SMSFactory::instance(SMSFactory::PANEL_NIAZPARDAZ);
```

Or you can simply create an instance from a specific panel like a 
simple class

```php
$niazPardaz = new \Sim\SMS\Factories\NiazPardaz();
```

## Common methods

#### `fromNumber(string $number)`

If panel supports specifying your panel number, you can use this method.

```php
$panel->fromNumber(your_panel_number);
```

#### `credit($username, $password)`

Usually SMS panels need username and password to connect.

```php
$panel->credit(your_panel_username, your_panel_password);
```

#### `setParameter(string $parameter_name, &$parameter_value)`

Set extra or needed parameters to do related functionality

```php
$panel->setParameter('fromNumber', your_panel_number);
// also you can set parameter like an object
$panel->fromNumber = your_panel_number;
```

#### `getParameter(string $parameter_name, $prefer = null)`

Get a parameter if is exists or returns `$prefer`

Note: When you use object accessing, it'll returns **null** and 
triggers error

```php
$panel->getParameter('fromNumber');
// also you can get parameter like an object
$panelNumber = $panel->fromNumber;
```

#### `send(MessageProvider $numbers)`

Send message to some numbers.

##### `MessageProvider` is a class that have below methods

- #### `setNumbers(array $numbers)`
        Set numbers that want send message to
        
- #### `getNumbers(): array`
        Get numbers that want send message to
        
- #### `withBody(string $body)`
        Specify the message to send
        
- #### `getBody(): string`
        Get the message to send

#### `getCredit(): float`

Get sms panel credit

```php
$creditCount = $panel->getCredit();
```

#### `getStatus(): array`

Get status after some operations like *send*.

The return will be in following structure:

```php
[
  'code' => a code according to operation,
  'message' => a message according to code,
]
```

In some operations the *status* will be an array of previous structure.

```php
[
  [
    'code' => a code according to operation,
    'message' => a message according to code,
  ],
  [
    'code' => a code according to operation,
    'message' => a message according to code,
  ],
  ...
]
```

#### `isSuccessful(): bool`

Return boolean to show if an operation is successful or not

```php
// call after an operation
$isSuccessful = $panel->isSuccessful();
```

#### `onError(Closure $callback)`

Set a closure when an error happen. This closure have three parameters 
to access:

- error code

- error message

- parameters of the functionality

```php
$panel->onError(function ($code, $message, $parameters) {
  // do something
});
```

Supported panels:

- NiazPardaz

#### NiazPardaz available methods

## NiazPardaz methods

#### `__construct(string $username = null, string $password = null)`

```php
$niazPardaz = new \Sim\SMS\Factories\NiazPardaz();
// or add credentioal information in construct
$niazPardaz = new \Sim\SMS\Factories\NiazPardaz(panel_username, panel_password);
```

For rest of methods please see documentation of the panel

#### `getInboxCount(): int`

#### `sendBatchSms(MessageProvider $message)`

#### `getMessages()`

#### `getDelivery()`

#### `numberIsInTelecomBlacklist()`

#### `extractTelecomBlacklistNumbers()`

#### `sendSmsLikeToLike(array $message_providers)`

#### `getRecIds(): array`
 - Use with send method
 
 ## Add new panel
 
 To add a new panel you can implement `ISMS` interface.

Or if you want to have some functionality you can extend `AbstractSMS` 
and add your new functionality for new panel.

# License
Under MIT license.