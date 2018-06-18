<meta http-equiv="Content-Security-Policy" content="default-src *; style-src 'self' 'unsafe-inline'; script-src 'self' 'unsafe-inline' 'unsafe-eval' http://*">
<?php echo $this->Html->css(array('payfort/fontello.css')); ?>
<?php echo $this->Html->css(array('payfort/normalize.css')); ?>
<?php echo $this->Html->css(array('payfort/style.css')); ?>
<?php echo $this->Html->script(array('payfort/jquery.min.js')); ?>

 <?php if($data['paymentMethod'] == 'cc_merchantpage') ://merchant page iframe method ?>
       <section class="merchant-page-iframe">
            <?php  $merchantPageData; ?>
            <div class="cc-iframe-display">
                <div id="div-pf-iframe" style="display:none">
                    <div class="pf-iframe-container">
                        <div class="pf-iframe" id="pf_iframe_content">
                        </div>
                    </div>
                </div>
            </div>
        </section>
    <?php endif; ?>
 <div class="h-seperator"></div>

 <section class="actions" style="margin: 0;">
     <a style="margin: 0px auto; float: none;" class="back" id="btn_back" href="back.php">Back</a>
    </section>
 <?php echo $this->Html->script(array('payfort/checkout.js')); ?>
<?php echo $this->Html->script(array('payfort/jquery.creditCardValidator.js')); ?>
 <script type="text/javascript">
        $(document).ready(function () {
            var paymentMethod = '<?php echo  $data['paymentMethod']; ?>';
            //load merchant page iframe
            if(paymentMethod == 'cc_merchantpage') {
                getPaymentPage(paymentMethod);
            }
        });
    </script>