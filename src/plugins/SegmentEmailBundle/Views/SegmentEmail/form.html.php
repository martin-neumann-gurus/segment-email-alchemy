
<?php
/**
 * @var \MauticPlugin\SegmentEmailBundle\Entity\SegmentEmail $entity
 * @var int                                                  $segmentId
 * @var \Symfony\Component\Form\FormView                     $form
 */
$view->extend('MauticCoreBundle:Default:content.html.php');
$view['slots']->set('mauticContent', 'segmentEmail');
$view['slots']->set('headerTitle', $view['translator']->trans('mautic.segmentemail.header.edit'));
?>

<div class="row">
    <div class="col-md-8 col-md-offset-2">
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title"><?php echo $view['translator']->trans('mautic.segmentemail.header.edit'); ?></h3>
            </div>
            <div class="panel-body">
                <?php echo $view['form']->start($form); ?>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <?php echo $view['form']->row($form['fromEmail']); ?>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <?php echo $view['form']->row($form['fromName']); ?>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <?php echo $view['form']->row($form['emailHeader']); ?>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <?php echo $view['form']->row($form['unsubscribeLink']); ?>
                        </div>
                    </div>
                </div>
                <?php echo $view['form']->end($form); ?>
            </div>
        </div>
    </div>
</div>
