<?php

namespace SymfonyContrib\Bundle\ConfirmBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Session;
use Symfony\Component\HttpFoundation\Request;

/**
 * Confirmation controller.
 *
 * Forward requests to this controller:action to confirm an action.
 */
class ConfirmController extends Controller
{
    public function confirmAction(Request $request, array $options = [])
    {
        $session = $this->get("session");

        $form = $this->createForm('confirm_form', null, $options);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Allow for several confirm action methods.
            // @see http://php.net/manual/en/language.types.callable.php
            if (is_callable($options['confirmAction'])) {

                $args = $session->get('ConfirmBundle:Confirmation:'.$options['confirmAction'][1]);
                $session->remove('ConfirmBundle:Confirmation:'.$options['confirmAction'][1]);

                return call_user_func($options['confirmAction'], $args);
            } else {
                throw new \Exception('Confirm action not callable.');
            }
        }
        else {
            $session->set('ConfirmBundle:Confirmation:'.$options['confirmAction'][1], $options['confirmActionArgs']);
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
