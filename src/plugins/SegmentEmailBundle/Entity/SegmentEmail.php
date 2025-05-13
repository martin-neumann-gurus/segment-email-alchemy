<?php
namespace MauticPlugin\SegmentEmailBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Mautic\CoreBundle\Doctrine\Mapping\ClassMetadataBuilder;
use Mautic\CoreBundle\Entity\CommonEntity;

/**
 * Class SegmentEmail.
 */
class SegmentEmail extends CommonEntity
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var int
     */
    private $segmentId;

    /**
     * @var string|null
     */
    private $fromEmail;

    /**
     * @var string|null
     */
    private $fromName;

    /**
     * @var string|null
     */
    private $emailHeader;

    /**
     * @var string|null
     */
    private $unsubscribeLink;

    public static function loadMetadata(ORM\ClassMetadata $metadata)
    {
        $builder = new ClassMetadataBuilder($metadata);
        $builder->setTable('segment_email_settings')
            ->setCustomRepositoryClass(SegmentEmailRepository::class)
            ->addId();

        $builder->createField('segmentId', 'integer')
            ->columnName('segment_id')
            ->build();

        $builder->createField('fromEmail', 'string')
            ->columnName('from_email')
            ->nullable()
            ->build();

        $builder->createField('fromName', 'string')
            ->columnName('from_name')
            ->nullable()
            ->build();

        $builder->createField('emailHeader', 'text')
            ->columnName('email_header')
            ->nullable()
            ->build();

        $builder->createField('unsubscribeLink', 'string')
            ->columnName('unsubscribe_link')
            ->nullable()
            ->build();
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @return int
     */
    public function getSegmentId()
    {
        return $this->segmentId;
    }

    /**
     * @param int $segmentId
     *
     * @return SegmentEmail
     */
    public function setSegmentId($segmentId)
    {
        $this->segmentId = $segmentId;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getFromEmail()
    {
        return $this->fromEmail;
    }

    /**
     * @param string|null $fromEmail
     *
     * @return SegmentEmail
     */
    public function setFromEmail($fromEmail)
    {
        $this->fromEmail = $fromEmail;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getFromName()
    {
        return $this->fromName;
    }

    /**
     * @param string|null $fromName
     *
     * @return SegmentEmail
     */
    public function setFromName($fromName)
    {
        $this->fromName = $fromName;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getEmailHeader()
    {
        return $this->emailHeader;
    }

    /**
     * @param string|null $emailHeader
     *
     * @return SegmentEmail
     */
    public function setEmailHeader($emailHeader)
    {
        $this->emailHeader = $emailHeader;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getUnsubscribeLink()
    {
        return $this->unsubscribeLink;
    }

    /**
     * @param string|null $unsubscribeLink
     *
     * @return SegmentEmail
     */
    public function setUnsubscribeLink($unsubscribeLink)
    {
        $this->unsubscribeLink = $unsubscribeLink;

        return $this;
    }
}
