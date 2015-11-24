<?php

namespace SymfonyContrib\Bundle\ConfirmBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Session;

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
        $session = $this->get("session");

        $form = $this->createForm('confirm_form', null, $options);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Allow for several confirm action methods.
            // @see http://php.net/manual/en/language.types.callable.php
            if (is_callable($options['confirmAction'])) {

                $args = $session->get('ConfirmBundle:Confirmation:'.$options['confirm_action'][1]);
                $session->remove('ConfirmBundle:Confirmation:'.$options['confirm_action'][1]);

                return call_user_func($options['confirmAction'], $args);
            } else {
                throw new \Exception('Confirm action not callable.');
            }
        }
        else {
            $session->set('ConfirmBundle:Confirmation:'.$options['confirm_action'][1], $options['confirm_action_args']);
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
