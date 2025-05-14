
<?php
namespace MauticPlugin\SegmentEmailBundle\Form\Type;

use Doctrine\ORM\EntityManager;
use MauticPlugin\SegmentEmailBundle\Entity\SegmentEmail;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * Class SegmentEmailType.
 */
class SegmentEmailType extends AbstractType
{
    /**
     * @var EntityManager
     */
    private $entityManager;

    /**
     * SegmentEmailType constructor.
     *
     * @param EntityManager $entityManager
     */
    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add(
            'fromEmail',
            TextType::class,
            [
                'label' => 'mautic.segmentemail.form.fromemail',
                'label_attr' => ['class' => 'control-label'],
                'attr' => [
                    'class' => 'form-control',
                    'tooltip' => 'mautic.segmentemail.form.fromemail.tooltip',
                ],
                'required' => false,
            ]
        );

        $builder->add(
            'fromName',
            TextType::class,
            [
                'label' => 'mautic.segmentemail.form.fromname',
                'label_attr' => ['class' => 'control-label'],
                'attr' => [
                    'class' => 'form-control',
                    'tooltip' => 'mautic.segmentemail.form.fromname.tooltip',
                ],
                'required' => false,
            ]
        );

        $builder->add(
            'emailHeader',
            TextareaType::class,
            [
                'label' => 'mautic.segmentemail.form.emailheader',
                'label_attr' => ['class' => 'control-label'],
                'attr' => [
                    'class' => 'form-control',
                    'tooltip' => 'mautic.segmentemail.form.emailheader.tooltip',
                ],
                'required' => false,
            ]
        );

        $builder->add(
            'unsubscribeLink',
            UrlType::class,
            [
                'label' => 'mautic.segmentemail.form.unsubscribelink',
                'label_attr' => ['class' => 'control-label'],
                'attr' => [
                    'class' => 'form-control',
                    'tooltip' => 'mautic.segmentemail.form.unsubscribelink.tooltip',
                ],
                'required' => false,
            ]
        );
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(
            [
                'data_class' => SegmentEmail::class,
            ]
        );
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'segmentemail';
    }
}
