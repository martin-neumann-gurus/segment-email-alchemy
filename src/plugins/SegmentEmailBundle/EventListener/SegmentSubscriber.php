
<?php
namespace MauticPlugin\SegmentEmailBundle\EventListener;

use Doctrine\ORM\EntityManager;
use Mautic\CoreBundle\CoreEvents;
use Mautic\CoreBundle\Event\CustomButtonEvent;
use Mautic\CoreBundle\Templating\Helper\ButtonHelper;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Translation\TranslatorInterface;

/**
 * Class SegmentSubscriber.
 */
class SegmentSubscriber implements EventSubscriberInterface
{
    /**
     * @var EntityManager
     */
    private $entityManager;

    /**
     * @var RouterInterface
     */
    private $router;

    /**
     * @var TranslatorInterface
     */
    private $translator;

    /**
     * SegmentSubscriber constructor.
     *
     * @param EntityManager       $entityManager
     * @param RouterInterface     $router
     * @param TranslatorInterface $translator
     */
    public function __construct(EntityManager $entityManager, RouterInterface $router, TranslatorInterface $translator)
    {
        $this->entityManager = $entityManager;
        $this->router = $router;
        $this->translator = $translator;
    }

    /**
     * {@inheritdoc}
     */
    public static function getSubscribedEvents()
    {
        return [
            CoreEvents::VIEW_INJECT_CUSTOM_BUTTONS => ['injectViewButtons', 0],
        ];
    }

    /**
     * @param CustomButtonEvent $event
     */
    public function injectViewButtons(CustomButtonEvent $event)
    {
        if ($event->getRoute() !== 'mautic_segment_action') {
            return;
        }

        $objectId = $event->getObjectId();
        if (empty($objectId)) {
            return;
        }

        $buttonOptions = [
            'attr' => [
                'class' => 'btn btn-default btn-sm btn-nospin',
                'icon' => 'fa fa-envelope',
                'href' => $this->router->generate(
                    'mautic_segment_email_settings',
                    ['objectId' => $objectId]
                ),
            ],
            'text' => $this->translator->trans('mautic.segmentemail.button.settings'),
            'primary' => false,
            'priority' => 0,
        ];

        $event->addButton(
            $buttonOptions,
            ButtonHelper::LOCATION_TOOLBAR_ACTIONS,
            ['mautic_segment_action', ['objectAction' => 'edit']]
        );
    }
}
