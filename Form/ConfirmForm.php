<?php

namespace SymfonyContrib\Bundle\ConfirmBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Confirmation form.
 */
class ConfirmForm extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        // Add submit button that confirms requested action.
        $builder->add('confirm', 'submit', [
            'label' => $options['confirm_button_text'],
            'attr' => [
                'class' => 'btn-danger',
            ],
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        // Pass options to the form template.
        $view->vars = array_replace($view->vars, $options);
    }

    /**
     * {@inheritdoc}
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults([
            'message' => '',
            'warning' => '',
            'confirm_button_text' => '',
            'cancel_link_text' => '',
            'confirm_action' => '',
            'confirm_action_args' => [],
            'cancel_url' => '',
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'confirm_form';
    }
}
