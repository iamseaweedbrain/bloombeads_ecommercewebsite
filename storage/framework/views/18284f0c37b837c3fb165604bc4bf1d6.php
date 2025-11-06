<?php $__env->startComponent('mail::message'); ?>
# Your OTP Code

Your one-time password is:

**<?php echo new \Illuminate\Support\EncodedHtmlString($otp); ?>**

It expires in **<?php echo new \Illuminate\Support\EncodedHtmlString($ttl); ?> minutes**.

If you didn’t request this, just ignore this email.

Thanks,  
<?php echo new \Illuminate\Support\EncodedHtmlString(config('app.name')); ?>

<?php echo $__env->renderComponent(); ?>
<?php /**PATH C:\Users\Maxine\Herd\bloombeads_website\resources\views/emails/otp.blade.php ENDPATH**/ ?>