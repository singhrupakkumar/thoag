        </div>
        
 <script type="text/javascript" src="/thoag/vendors/payfort-php-sdk-master/assets/js/jquery.creditCardValidator.js"></script>
        <script type="text/javascript" src="/thoag/vendors/payfort-php-sdk-master/assets/js/checkout.js"></script>
        <script type="text/javascript">
            $(document).ready(function () {
                console.log('document ready')
                $('input:radio[name=payment_option]').click(function () {
                    $('input:radio[name=payment_option]').each(function () {
                        if ($(this).is(':checked')) {
                            $(this).addClass('active');
                            $(this).parent('li').children('label').css('font-weight', 'bold');
                            $(this).parent('li').children('div.details').show();
                        }
                        else {
                            $(this).removeClass('active');
                            $(this).parent('li').children('label').css('font-weight', 'normal');
                            $(this).parent('li').children('div.details').hide();
                        }
                    });
                });
                $('#btn_continue').click(function () {
                    console.log('i m clicked')
                    var paymentMethod = $('input:radio[name=payment_option]:checked').val();
                    if(paymentMethod == '' || paymentMethod === undefined || paymentMethod === null) {
                        alert('Pelase Select Payment Method!');
                        return;
                    }
                    if(paymentMethod == 'cc_merchantpage') {
                        window.location.href = 'confirm-order.php?payment_method='+paymentMethod;
                    }
                    if(paymentMethod == 'cc_merchantpage2') {
                        var isValid = payfortFortMerchantPage2.validateCcForm();
                        if(isValid) {
                            getPaymentPage(paymentMethod);
                        }
                    }
                    else{
                        getPaymentPage(paymentMethod);
                    }
                });
            });
        </script>
