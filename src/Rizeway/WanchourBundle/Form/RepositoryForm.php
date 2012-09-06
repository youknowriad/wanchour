<?php

namespace Rizeway\WanchourBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;
use Rizeway\WanchourBundle\Entity\Repository;

class RepositoryForm extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('name');
        $builder->add('url', 'url');
    }

    public function getName()
    {
        return 'repository';
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'Rizeway\WanchourBundle\Entity\Repository',
        ));
    }
}