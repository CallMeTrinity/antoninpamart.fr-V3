<?php

/*
 * This file is part of the antoninpamart.fr-V3 project.
 *
 * (c) Antonin <contact@antoninpamart.fr>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace App\Form;

use App\Entity\Moi;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\File;

class TrinityType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('aboutMe', TextareaType::class, [
                'label' => 'Description',
                'attr' => ['rows' => 16],
            ])
            ->add('pp', TextType::class, ['label' => 'Profile picture file name', 'attr' => ['hidden' => true]])
            ->add('fileUpload', FileType::class, [
                'label' => 'Photo de profil',
                'mapped' => false,
                'required' => false,
                'constraints' => [
                    new File([
                        'maxSize' => '2048k',
                        'mimeTypes' => [
                            'image/jpg',
                            'image/png',
                            'image/svg+xml',
                            'image/jpeg',
                            'image/webp',
                        ],
                        'mimeTypesMessage' => 'Please upload a valid image file',
                    ]),
                ],
            ])
            ->add('age', IntegerType::class, [
                'label' => 'Age',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Moi::class,
        ]);
    }
}
