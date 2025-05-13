<?php

namespace MauticPlugin\SegmentEmailBundle\EventListener;

use Doctrine\ORM\EntityManager;
use Mautic\EmailBundle\EmailEvents;
use Mautic\EmailBundle\Event\EmailBuilderEvent;
use Mautic\EmailBundle\Event\EmailSendEvent;
use MauticPlugin\SegmentEmailBundle\Helper\TokenHelper;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

/**
 * Class EmailSubscriber.
 */
class EmailSubscriber implements EventSubscriberInterface
{
    /**
     * @var EntityManager
     */
    private $entityManager;

    /**
     * @var TokenHelper
     */
    private $tokenHelper;

    /**
     * EmailSubscriber constructor.
     *
     * @param EntityManager $entityManager
     * @param TokenHelper   $tokenHelper
     */
    public function __construct(EntityManager $entityManager, TokenHelper $tokenHelper)
    {
        $this->entityManager = $entityManager;
        $this->tokenHelper = $tokenHelper;
    }

    /**
     * {@inheritdoc}
     */
    public static function getSubscribedEvents()
    {
        return [
            EmailEvents::EMAIL_ON_BUILD => ['onEmailBuild', 0],
            EmailEvents::EMAIL_ON_SEND => ['onEmailGenerate', 0],
            EmailEvents::EMAIL_ON_DISPLAY => ['onEmailDisplay', 0],
        ];
    }

    /**
     * Add tokens to the email builder.
     *
     * @param EmailBuilderEvent $event
     */
    public function onEmailBuild(EmailBuilderEvent $event)
    {
        $tokens = [
            '{segment_email_header}' => 'mautic.segmentemail.token.header',
            '{segment_unsubscribe_link}' => 'mautic.segmentemail.token.unsubscribe',
        ];

        $event->addTokens(
            $event->tokensFromArray($tokens)
        );
    }

    /**
     * Handle custom tokens when sending an email.
     *
     * @param EmailSendEvent $event
     */
    public function onEmailGenerate(EmailSendEvent $event)
    {
        $this->processTokens($event);
        
        // Set from name and email if defined for the segment
        $lead = $event->getLead();
        $email = $event->getEmail();
        
        if (!$lead || !$email) {
            return;
        }
        
        $lists = $lead['lists'] ?? [];
        if (empty($lists)) {
            return;
        }
        
        // Get the first segment that has custom email settings
        foreach ($lists as $listId => $list) {
            $segmentSettings = $this->tokenHelper->getSegmentEmailSettings((int) $listId);
            if ($segmentSettings) {
                if (!empty($segmentSettings->getFromEmail())) {
                    $event->setEmail($segmentSettings->getFromEmail());
                }
                
                if (!empty($segmentSettings->getFromName())) {
                    $event->setName($segmentSettings->getFromName());
                }
                
                break;
            }
        }
    }

    /**
     * Handle custom tokens when displaying an email.
     *
     * @param EmailSendEvent $event
     */
    public function onEmailDisplay(EmailSendEvent $event)
    {
        $this->processTokens($event);
    }

    /**
     * Process custom tokens.
     *
     * @param EmailSendEvent $event
     */
    private function processTokens(EmailSendEvent $event)
    {
        $lead = $event->getLead();
        if (!$lead) {
            return;
        }

        $lists = $lead['lists'] ?? [];
        if (empty($lists)) {
            return;
        }

        $tokens = [];
        $content = $event->getContent();
        $subject = $event->getSubject();

        // Match tokens
        $headerToken = '{segment_email_header}';
        $unsubscribeToken = '{segment_unsubscribe_link}';

        if (strpos($content, $headerToken) === false && strpos($content, $unsubscribeToken) === false &&
            strpos($subject, $headerToken) === false && strpos($subject, $unsubscribeToken) === false) {
            return;
        }

        // Get the first segment that has custom email settings
        foreach ($lists as $listId => $list) {
            $segmentSettings = $this->tokenHelper->getSegmentEmailSettings((int) $listId);
            if ($segmentSettings) {
                if (!empty($segmentSettings->getEmailHeader())) {
                    $tokens[$headerToken] = $segmentSettings->getEmailHeader();
                }

                if (!empty($segmentSettings->getUnsubscribeLink())) {
                    $tokens[$unsubscribeToken] = $segmentSettings->getUnsubscribeLink();
                }

                break;
            }
        }

        // Replace tokens
        if (!empty($tokens)) {
            $event->addTokens($tokens);
        }
    }
}
