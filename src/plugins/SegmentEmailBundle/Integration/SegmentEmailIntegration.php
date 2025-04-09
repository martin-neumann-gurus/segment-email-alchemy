
<?php

namespace MauticPlugin\SegmentEmailBundle\Integration;

use Mautic\PluginBundle\Integration\AbstractIntegration;

/**
 * Class SegmentEmailIntegration.
 */
class SegmentEmailIntegration extends AbstractIntegration
{
    /**
     * {@inheritdoc}
     */
    public function getName()
    {
        return 'SegmentEmail';
    }

    /**
     * {@inheritdoc}
     */
    public function getDisplayName()
    {
        return 'Segment Email Settings';
    }

    /**
     * {@inheritdoc}
     */
    public function getAuthenticationType()
    {
        return 'none';
    }

    /**
     * {@inheritdoc}
     */
    public function getRequiredKeyFields()
    {
        return [];
    }
}
?>
