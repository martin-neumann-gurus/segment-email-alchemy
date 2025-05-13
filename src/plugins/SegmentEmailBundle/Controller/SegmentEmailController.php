<?php

namespace MauticPlugin\SegmentEmailBundle\Controller;

use Mautic\CoreBundle\Controller\FormController;
use MauticPlugin\SegmentEmailBundle\Entity\SegmentEmail;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class SegmentEmailController.
 */
class SegmentEmailController extends FormController
{
    /**
     * Edit segment email settings.
     *
     * @param int $objectId
     *
     * @return \Symfony\Component\HttpFoundation\JsonResponse|Response
     */
    public function editAction($objectId)
    {
        $segmentId = (int) $objectId;
        $model = $this->getModel('segmentemail.segmentemail');
        $entity = $model->getRepository()->findBySegmentId($segmentId);

        if (!$entity) {
            $entity = new SegmentEmail();
            $entity->setSegmentId($segmentId);
        }

        $form = $this->createForm('segmentemail', $entity);

        if ($this->request->getMethod() === 'POST') {
            if (!$this->isFormCancelled($form)) {
                if ($this->isFormValid($form)) {
                    $model->saveEntity($entity);

                    $this->addFlash('mautic.core.notice.updated', [
                        '%name%' => 'Segment Email Settings',
                        '%url%' => $this->generateUrl(
                            'mautic_segment_email_settings',
                            ['objectId' => $entity->getSegmentId()]
                        ),
                    ]);

                    if (!$this->isFormApplied($form)) {
                        return $this->redirect($this->generateUrl(
                            'mautic_segment_action',
                            ['objectAction' => 'edit', 'objectId' => $segmentId]
                        ));
                    }
                }
            } else {
                return $this->redirect($this->generateUrl(
                    'mautic_segment_action',
                    ['objectAction' => 'edit', 'objectId' => $segmentId]
                ));
            }
        }

        return $this->delegateView([
            'viewParameters' => [
                'form' => $this->setFormTheme($form, 'SegmentEmailBundle:SegmentEmail:form.html.php', 'SegmentEmailBundle:FormTheme'),
                'entity' => $entity,
                'segmentId' => $segmentId,
            ],
            'contentTemplate' => 'SegmentEmailBundle:SegmentEmail:form.html.php',
            'passthroughVars' => [
                'activeLink' => '#mautic_segment_index',
                'mauticContent' => 'segmentEmail',
                'route' => $this->generateUrl(
                    'mautic_segment_email_settings',
                    ['objectId' => $segmentId]
                ),
            ],
        ]);
    }
}
