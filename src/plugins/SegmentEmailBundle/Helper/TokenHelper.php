
<?php

namespace MauticPlugin\SegmentEmailBundle\Helper;

use Doctrine\ORM\EntityManager;
use MauticPlugin\SegmentEmailBundle\Entity\SegmentEmail;

/**
 * Class TokenHelper.
 */
class TokenHelper
{
    /**
     * @var EntityManager
     */
    private $entityManager;

    /**
     * TokenHelper constructor.
     *
     * @param EntityManager $entityManager
     */
    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * Get segment email settings.
     *
     * @param int $segmentId
     *
     * @return SegmentEmail|null
     */
    public function getSegmentEmailSettings($segmentId)
    {
        return $this->entityManager->getRepository(SegmentEmail::class)->findBySegmentId($segmentId);
    }
}
?>
