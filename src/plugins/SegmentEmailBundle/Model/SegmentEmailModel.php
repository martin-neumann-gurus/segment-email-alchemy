<?php
namespace MauticPlugin\SegmentEmailBundle\Model;

use Doctrine\ORM\EntityManager;
use Mautic\CoreBundle\Model\FormModel;
use MauticPlugin\SegmentEmailBundle\Entity\SegmentEmail;
use MauticPlugin\SegmentEmailBundle\Entity\SegmentEmailRepository;
use MauticPlugin\SegmentEmailBundle\Form\Type\SegmentEmailType;

/**
 * Class SegmentEmailModel.
 */
class SegmentEmailModel extends FormModel
{
    /**
     * @var EntityManager
     */
    private $em;

    /**
     * SegmentEmailModel constructor.
     *
     * @param EntityManager $entityManager
     */
    public function __construct(EntityManager $entityManager)
    {
        $this->em = $entityManager;
    }

    /**
     * {@inheritdoc}
     */
    public function getRepository()
    {
        return $this->em->getRepository(SegmentEmail::class);
    }

    /**
     * {@inheritdoc}
     */
    public function getPermissionBase()
    {
        return 'segment:segments';
    }

    /**
     * {@inheritdoc}
     */
    public function getEntity($id = null)
    {
        if (null === $id) {
            return new SegmentEmail();
        }

        return parent::getEntity($id);
    }

    /**
     * Get the form type for the segment email settings.
     *
     * @return string
     */
    public function getForm($entity, $parameters = [])
    {
        $options = [];

        return $this->formFactory->create(SegmentEmailType::class, $entity, $options);
    }

    /**
     * {@inheritdoc}
     */
    public function createForm($entity, $formFactory, $action = null, $options = [])
    {
        if (!empty($action)) {
            $options['action'] = $action;
        }

        return $formFactory->create('segmentemail', $entity, $options);
    }

    /**
     * Get segment email settings for a specific segment.
     *
     * @param int $segmentId
     *
     * @return SegmentEmail|null
     */
    public function getSegmentEmailSettings($segmentId)
    {
        /** @var SegmentEmailRepository $repository */
        $repository = $this->getRepository();

        return $repository->findBySegmentId($segmentId);
    }

    /**
     * Save segment email settings.
     *
     * @param SegmentEmail $entity
     */
    public function saveEntity($entity)
    {
        parent::saveEntity($entity);
    }
}
?>
