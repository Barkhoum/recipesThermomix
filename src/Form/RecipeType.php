<?php

namespace App\Form;

use App\Entity\Recipe;
use App\Entity\Ingredient;
use App\Repository\IngredientRepository;
use Symfony\Component\Form\AbstractType;
use Vich\UploaderBundle\Form\Type\VichImageType;
use Webmozart\Assert\Assert as AssertAssert;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\RangeType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class RecipeType extends AbstractType
{
    private $token;

    public function __construct(TokenStorageInterface $token)
    {
        $this->token = $token;
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name', TextType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'minlength' => '2',
                    'maxlength' => '50'

                ],
                'label' => 'Nom',
                'label_attr'
                => [
                    'class' => 'form-label mt-4'
                ],
                'constraints' => [
                    new Assert\Length(['min' => 2, 'max' => 50]),
                    new Assert\NotBlank()
                ]
            ])
            ->add('time', IntegerType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'min' => 1,
                    'max' => 1440
                ],
                'label' => 'Temps (en minutes)',
                'label_attr' => [
                    'class' => 1,
                    'max' => 1440
                ],
                'constraints' => [
                    new Assert\Positive(),
                    new Assert\LessThan(1441)

                ]
            ])
            ->add('nbsPersonnes', IntegerType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'min' => 1,
                    'max' => 50
                ],
                'label' => 'Nombre de personnes',
                'label_attr' => [
                    'class' => 'form-label mt-4',
                ],
                'constraints' => [
                    new Assert\Positive(),
                    new Assert\LessThan(5)

                ]

            ])
            ->add('difficulty', RangeType::class, [
                'attr' => [
                    'class' => 'form-range',
                    'min' => 1,
                    'max' => 5
                ],
                'label' => 'Diffilcult??',
                'label_attr' => [
                    'class' => 'form-label mt-4',
                ],
                'constraints' => [
                    new Assert\Positive(),
                    new Assert\LessThan(5)

                ]

            ])
            ->add('description', TextareaType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'min' => 1,
                    'max' => 5
                ],
                'label' => 'Description ',
                'label_attr' => [
                    'class' => 'form-label mt-4',
                ],
                'constraints' => [
                    new Assert\NotBlank()
                ]
            ])

            ->add('price', MoneyType::class, [
                'attr' => [
                    'class' => 'form-control',
                ],
                'label' => 'Prix ',
                'label_attr'
                => [
                    'class' => 'form-label mt-4'
                ],
                'constraints' => [
                    new Assert\Positive(),
                    new Assert\LessThan(1001)
                ]

            ])
            ->add('isFavoris', CheckboxType::class, [
                'attr' => [
                    'class' => 'form-check-label',

                ],
                'required' => false,
                'label' => ' Ajoutez le dans les favoris',
                'label_attr'
                => [
                    'class' => 'form-label mt-4'
                ],
                'constraints' => [
                    new Assert\NotNull()
                ]
            ])
            ->add('imageFile', VichImageType::class,[
                'label' => 'Image de la recette',
                'label_attr' => [
                    'class' => 'form-label mt-4'
                ]
            ])
            ->add('createdAt', DateType::class, [
                'widget' => 'choice',
                'input' => 'datetime_immutable',
                'label' => 'Date de cr??ation',
                'label_attr' => [
                    'class' => 'form-label mt-4'
                ]
            ])

            ->add('ingredients', EntityType::class, [
                'class' => Ingredient::class,
                'query_builder' => function (IngredientRepository $r) {
                    return $r->createQueryBuilder('i')
                        ->where('i.user = :user')
                        ->orderBy('i.name', 'DESC')
                        ->setParameter('user', $this->token->getToken()->getUser());

                },
                'label' => 'Les ingr??dients',
                'label_attr' => [
                    'class' => 'form-label mt-4'
                ],
                'choice_label' => 'name',
                'multiple' => true,
                'expanded' => true,
            ])
            ->add('submit', SubmitType::class, [
                'attr' => [
                    'class' => 'btn btn-primary mt-4'
                ],
                'label' => 'Cr??er une nouvelle recette'
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Recipe::class,
        ]);
    }
}
