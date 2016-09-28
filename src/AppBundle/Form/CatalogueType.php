<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use AppBundle\Entity\Category;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\FileType;

class CatalogueType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('category')
            ->add('catalogueType', ChoiceType::class, array(
				'choices'  => array(
					'Book' => 'Book',
					'Video' => 'Video',
					'Games' => 'Games'
				),
			))
            ->add('isbn')
            ->add('title')
            ->add('description')
            ->add('author')
            ->add('attachmentThumb', FileType::class, array('label'=>'Thumb Image', 'required'=>false, ))
            ->add('attachmentThumb1', TextType::class, array( "mapped" => false, 'required'=>false, 'label'=>'(OR) Thumb Image Url'))
            ->add('attachmentFile', FileType::class, array('label'=>'Source File(Book Pdf)',  'required'=>false, ))
            ->add('attachmentFile1', TextType::class, array( "mapped" => false,  'required'=>false, 'label'=>'(OR) Source File Url'))
            ->add('status')
        ;
		
    }
    
    /**
     * @param OptionsResolver $resolver
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Catalogue'
        ));
    }
}
