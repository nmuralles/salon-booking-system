<?php
/**
 * @var SLN_Plugin $plugin
 * @var string     $formAction
 * @var string     $submitName
 * @var SLN_Shortcode_Salon_ThankyouStep $step
 */
$confirmation = $plugin->getSettings()->get('confirmation');
$currentStep = $step->getShortcode()->getCurrentStep();
$ajaxData = "sln_step_page=$currentStep&submit_$currentStep=1";
$ajaxEnabled = $plugin->getSettings()->isAjaxEnabled();
?>
<div id="salon-step-thankyou">
    <?php if($confirmation) : ?>
        <h2><?php _e('Booking status', 'sln') ?></h2>
    <?php else : ?> 
        <h2><?php _e('Booking Confirmation', 'sln') ?></h2>
    <?php endif ?>

    <?php if (isset($paypalOp) && $paypalOp == 'cancel'): ?>

        <div class="alert alert-danger">
            <p><?php _e('The payment on paypal is failed, please try again.', 'sln') ?></p>
        </div>

    <?php else: ?>
        <div class="row">
            <div class="col-md-6 tycol"><?php echo $confirmation ? __('Your booking is pending', 'sln') : __('Your booking is confirmed', 'sln') ?><br/>
                <?php if($confirmation): ?> 
                    <i class="c glyphicon glyphicon-time"></i>
                <?php else : ?>
                    <i class="glyphicon glyphicon-ok-circle"></i>
                <?php endif ?>
            </div>
            <div class="col-md-6 tycol"><?php _e('Booking number', 'sln') ?>
                <br/><span class="num"><?php echo $plugin->getBookingBuilder()->getLastBooking()->getId() ?></span>
            </div>
        </div>
<?php $ppl = false; ?>
<div class="alert ty">
<?php if($confirmation) : ?>
        <p><strong><?php _e('You will receive a confirmation of your booking by email.','sln' )?></strong></p>
        <p><?php echo sprintf(__('If you don\'t receive any news from us or you need to change your reservation please call the %s or send an e-mail to %s', 'sln'), $plugin->getSettings()->get('gen_phone'),  $plugin->getSettings()->get('gen_email') ? $plugin->getSettings()->get('gen_email') : get_option('admin_email') ); ?>
            <?php echo $plugin->getSettings()->get('gen_phone') ?></p>
        <p class="aligncenter"><a href="<?php echo home_url() ?>" class="btn btn-primary"><?php _e('Back to home','sln') ?></a></p>
<?php else : ?>
        <p><?php echo sprintf(__('If you need to change your reservation please call the <strong>%s</strong> or send an e-mail to <strong>%s</strong>', 'sln'), $plugin->getSettings()->get('gen_phone'),  $plugin->getSettings()->get('gen_email') ? $plugin->getSettings()->get('gen_email') : get_option('admin_email') ); ?>
            <?php echo $plugin->getSettings()->get('phone') ?>
        </p>
        </div>

            <div id="sln-notifications"></div>
    <div class="row form-actions aligncenter">
        <?php if($plugin->getSettings()->get('pay_enabled') && $plugin->getSettings()->getPaypalEmail()) : ?>
        <a data-salon-data="<?php echo $ajaxData.'&mode=paypal' ?>" data-salon-toggle="direct"
        href="<?php echo $paypalUrl ?>" class="btn btn-primary">
            <?php $deposit = $plugin->getBookingBuilder()->getLastBooking()->getDeposit(); ?> 
            <?php if($deposit > 0): ?>
                <?php echo sprintf(__('Pay %s as a deposit with Paypal', 'sln'), $plugin->format()->money($deposit)) ?>
            <?php else : ?>
                <?php _e('Pay with Paypal', 'sln') ?>
            <?php endif ?>
        </a>
        <?php $ppl = true; endif; ?>
        <?php if($ppl && $plugin->getSettings()->get('pay_cash')): ?>
        <?php _e('Or', 'sln') ?>
        <a  href="<?php echo $laterUrl ?>" class="btn btn-success"
            <?php if($ajaxEnabled): ?>
                data-salon-data="<?php echo $ajaxData.'&mode=later' ?>" data-salon-toggle="direct"
            <?php endif ?>>
            <?php _e('I\'ll pay later', 'sln') ?>
        </a>
        <?php elseif(!$ppl) : ?>
        <a  href="<?php echo $laterUrl ?>" class="btn btn-success"
            <?php if($ajaxEnabled): ?>
                data-salon-data="<?php echo $ajaxData.'&mode=later' ?>" data-salon-toggle="direct"
            <?php endif ?>>
            <?php _e('Confirm', 'sln') ?>
        </a>
        <?php endif ?>
    </div>
<?php endif ?>
    <?php endif ?>
</div>
