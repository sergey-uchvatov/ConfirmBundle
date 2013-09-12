**This code is part of the [SymfonyContrib](http://symfonycontrib.com/) community.**

# Symfony2 ConfirmBundle

Provides a simple confirmation form & page to confirm an action.

## Use Case

If you are going to delete an object and want to confirm with the user that they
really do want to delete the object, you will usually send them to a confirmation
page for verification.

This is a very common scenario and so is an area where code can easily be duplicated.

## Installation

Installation is the same as a normal bundle. http://symfony.com/doc/current/cookbook/bundles/installation.html

## Usage

Using the ConfirmBundle is very simple. In short, you simple forward your request
with some options.

Example:

```php
public function objectDeleteAction($object)
{
    $options = [
        'message' => 'Are you sure you want to DELETE this?',
        'warning' => 'This can not be undone!',
        'confirmButtonText' => 'Delete',
        'confirmAction' => [$this, 'delete'],
        'confirmActionArgs' => [
            'object' => $object,
        ],
        'cancelLinkText' => 'Cancel',
        'cancelUrl' => $this->generateUrl('acme_home'),
    ];

    return $this->forward('SymfonyContribConfirmBundle:Confirm:confirm', ['options' => $options]);
}

public function delete($args)
{
    // delete object
    // set flash message
    // redirect
}
```

### Options
* **message:** (string) Message displayed to user.
* **warning:** [Optional] (string) A warning to display to the user.
* **confirmButtonText:** (string) Text for positive confirmation button.
* **confirmAction:** (mixed) PHP callable. http://php.net/manual/en/language.types.callable.php
* **confirmActionArgs:** [Optional] (array) Array of arguments that will be passed to the confirmAction callable as an array argument.
* **cancelLinkText:** (string) Text for negative cancellation link.
* **cancelUrl:** (string) URL that will be used for the cancel action link.

### Views
There are 3 twig templates provided to override how the form and page looks.
* **layout.html.twig:** Simple template to override to easily change the base template that is extended.
* **confirm-form.html.twig:** Template for the confirmation form.
* **confirm.html.twig:** Template for the wrapper around the confirmation form.
