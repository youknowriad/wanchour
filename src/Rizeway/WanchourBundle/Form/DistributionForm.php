<?php

namespace Rizeway\WanchourBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Rizeway\WanchourBundle\Entity\Distribution;

class DistributionForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('name');
        $builder->add('parameters', 'collection', array(
            'type' => new ParameterForm(),
            'allow_add' => true,
            'by_reference' => false,
            'allow_delete' => true,
        ));
    }

    public function getName()
    {
        return 'distribution';
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Rizeway\WanchourBundle\Entity\Distribution',
        ));
    }
}