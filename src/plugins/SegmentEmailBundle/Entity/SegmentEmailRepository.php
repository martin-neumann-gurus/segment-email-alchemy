
<?php
namespace MauticPlugin\SegmentEmailBundle\Entity;

use Doctrine\ORM\EntityRepository;

/**
 * Class SegmentEmailRepository.
 */
class SegmentEmailRepository extends EntityRepository
{
    /**
     * Get the settings for a segment.
     *
     * @param int $segmentId
     *
     * @return SegmentEmail|null
     */
    public function findBySegmentId($segmentId)
    {
        return $this->findOneBy(['segmentId' => $segmentId]);
    }
}
