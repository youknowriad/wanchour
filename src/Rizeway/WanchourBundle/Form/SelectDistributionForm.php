<?php

namespace Rizeway\WanchourBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Rizeway\WanchourBundle\Entity\Repository;

class SelectDistributionForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('distribution', 'entity', array(
        	'empty_value' => 'Without distribution',
            'class' => 'Rizeway\WanchourBundle\Entity\Distribution'));
    }

    public function getName()
    {
        return 'select_dstribution';
    }
}