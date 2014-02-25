**This code is part of the [SymfonyContrib](http://symfonycontrib.com/) community.**

# Symfony2 ConfirmBundle

Provides a simple form to confirm an action.

## Use Case

This is **NOT** for simple JavaScript confirmations.

If you are going to delete an object and want to confirm with the user that they
really do want to delete the object, you will usually send them to a confirmation
page for approval.

Installation
============

Installation is the same as a normal bundle. http://symfony.com/doc/current/cookbook/bundles/installation.html

### 1. Add the bundle to your composer.json

```
"require": {
    ...
    "symfonycontrib/confirm-bundle": "@stable"
}
```

### 2. Install the bundle using composer

```bash
$ composer update symfonycontrib/confirm-bundle
```

### 3. Add this bundle to your application's kernel:

```php
    new SymfonyContrib\Bundle\ConfirmBundle\ConfirmBundle(),
```

## Usage

Using the ConfirmBundle is very simple. In short, you simply forward your request
with some options.

Example:

```php
public function objectDeleteAction($object)
{
    $options = [
        'message' => 'Are you sure you want to DELETE this?',
        'warning' => 'This can not be undone!',
        'confirm_button_text' => 'Delete',
        'confirm_action' => [$this, 'delete'],
        'confirm_action_args' => [
            'object' => $object,
        ],
        'cancel_link_text' => 'Cancel',
        'cancel_url' => $this->generateUrl('acme_home'),
    ];

    return $this->forward('ConfirmBundle:Confirm:confirm', ['options' => $options]);
}

public function delete($args)
{
    // delete $args['object']
    // set flash message
    // redirect
}
```

### Options
* **message:** (string) Message displayed to user.
* **warning:** (Optional) (string) A warning to display to the user.
* **confirm_button_text:** (string) Text for positive confirmation button.
* **confirm_action:** (mixed) PHP callable. http://php.net/manual/en/language.types.callable.php
* **confirm_action_args:** (Optional) (array) Array of arguments that will be passed to the confirmAction callable as an array argument.
* **cancel_link_text:** (string) Text for negative cancellation link.
* **cancel_url:** (string) URL that will be used for the cancel action link.

### Views
There are 3 twig templates provided to override how the form and page looks.
* **layout.html.twig:** Simple template to override to easily change the base template that is extended.
* **confirm-form.html.twig:** Template for the confirmation form.
* **confirm.html.twig:** Template for the wrapper around the confirmation form.
