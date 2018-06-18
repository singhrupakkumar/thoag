<?php echo $this->Html->css('../payfort/css/normalize'); ?>
<?php echo $this->Html->css('../payfort/css/fontello'); ?>
<?php echo $this->Html->css('../payfort/css/style'); ?>
<div class="wrapper">
    <section class="nav">
        <ul>
            <li class="lead" >Payment Method</li>
            <li class="lead active" > Pay</li>
            <li class="lead" > Done</li>
        </ul>
    </section>
<!--    <section class="confirmation">
        <label>Confirm Your Order</label>
    </section>-->
    <!--section class="order-info">
        <ul class="items">
            <span>
                <i class="icon icon-bag"></i>
                <label class="lead" for="">Your Order</label>
            </span>
            <li><?php echo $objFort->itemName ?></li>
             <li>Lorem ipsum dolor sit amet, consectetur adipisicing elit. A ex magni delectus aliquam debitis</li> 
        </ul>
        <ul>
            <li>
                <div class="v-seperator"></div>
            </li>
        </ul>
        <ul class="price">
            <span>
                <i class="icon icon-tag"></i>
                <label class="lead" for="">price</label>
            </span>
            <li><span class="curreny"><?php echo $objFort->currency; ?></span> <?php echo sprintf("%.2f",$totalAmount);?>	</li>
        </ul>
        <ul class="items">
            <span>
                <i class="icon icon-bag"></i>
                <label class="lead" for="">Payment Method</label>
            </span>
            <li><?php //echo $objFort->getPaymentOptionName($paymentMethod) ?></li>
        </ul>
    </section-->
    <?php if($paymentMethod == 'cc_merchantpage') ://merchant page iframe method ?>
        <section class="merchant-page-iframe">
            <?php
                //$merchantPageData = $objFort->getMerchantPageData();
                $postData = $merchantPageData['params'];
                $gatewayUrl = $merchantPageData['url'];
            ?>
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

    <section class="actions">
        <!--<a class="back" id="btn_back" href="index.php">Back</a>-->
    </section>
</div>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>
    <?php echo $this->Html->script('../payfort/js/checkout'); ?>
<!--     <script type="text/javascript" src="vendors/jquery.min.js"></script>
    <script type="text/javascript" src="assets/js/checkout.js"></script> -->
    <script type="text/javascript">
        $(document).ready(function () {
            console.log('jquery works 2 d');
            var order_id = "<?php echo $order_id; ?>";
            var paymentMethod = '<?php echo $paymentMethod?>';
            console.log(paymentMethod)
            //load merchant page iframe
            if(paymentMethod == 'cc_merchantpage') {
                console.log('getpaymentpage')
                getPaymentPage(paymentMethod);
            }
        });
    </script>
<?php //include('footer.php') ?>