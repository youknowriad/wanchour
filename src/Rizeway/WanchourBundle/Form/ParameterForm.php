<?php

namespace Rizeway\WanchourBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Rizeway\WanchourBundle\Entity\Parameter;

class ParameterForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('key');
        $builder->add('value');
    }

    public function getName()
    {
        return 'parameter';
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Rizeway\WanchourBundle\Entity\Parameter',
        ));
    }
}