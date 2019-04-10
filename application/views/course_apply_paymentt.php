<p>Total price: <?php echo $price;?></p>
<p>Please click the following button to proceed payment</p>

<script src="https://www.paypal.com/sdk/js?client-id=AYDQJl8dnU3Uma0Sulb7wLiBdqe55xo9GNJDuomq9BqN4Vt32ugISG_2wH_YLcDwLTOoGX2H1wbQZ1Kd"></script>
<div id="paypal-button-container"></div>
<script>
  paypal.Buttons({
    createOrder: function(data, actions) {
      return actions.order.create({
        purchase_units: [{
          amount: {
            currencyCode: 'HKD',
            value: '<?php echo $price;?>'
          }
        }]
      });
    },
    onApprove: function(data, actions) {
      // Capture the funds from the transaction
      return actions.order.capture().then(function(details) {
        $.ajax({
            type: 'POST',
            url: '<?php echo $page_url."course/course_apply_payment_finish";?>',
            data: { course_id: <?php echo $course_id?> },
            success: function() {
              console.log('success');
              window.location.href='<?php echo base_url();?>';
            }
        });

        // Show a success message to your buyer
        alert('Transaction completed by ' + details.payer.name.given_name);

      });
    }
  }).render('#paypal-button-container');
</script>