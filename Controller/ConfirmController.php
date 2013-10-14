<?php

namespace SymfonyContrib\Bundle\ConfirmBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Confirmation controller.
 *
 * Forward requests to this controller:action to confirm an action.
 */
class ConfirmController extends Controller
{
    public function confirmAction(array $options = [])
    {
        $request = $this->getRequest();

        $form = $this->createForm('confirm_form', null, $options);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Allow for several confirm action methods.
            // @see http://php.net/manual/en/language.types.callable.php
            if (is_callable($options['confirmAction'])) {
                return call_user_func($options['confirmAction'], $options['confirmActionArgs']);
            } else {
                throw new \Exception('Confirm action not callable.');
            }
        }

        return $this->render(
            'ConfirmBundle:Confirm:confirm.html.twig',
            [
                'form' => $form->createView(),
                'options' => $options,
            ]
        );
    }
}
