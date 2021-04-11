$(function(){
    /*-------------------
		Quantity change
	--------------------- */
    var proQty = $('.pro-qty');
    proQty.prepend('<span class="dec qtybtn">-</span>');
    proQty.append('<span class="inc qtybtn">+</span>');
    proQty.on('click', '.qtybtn', function() {
        var $button = $(this);
        var oldValue = $button.parent().find('input').val();
        var productId = $button.parent().find('input').data('product');
        console.log(productId);
        if ($button.hasClass('inc')) {
            var newVal = parseFloat(oldValue) + 1;
        } else {
            // Don't allow decrementing below zero
            if (oldValue > 1) {
                var newVal = parseFloat(oldValue) - 1;
            } else {
                newVal = 1;
            }
        }
        $button.parent().find('input').val(newVal);

        //update quantity in back-end
        if (newVal !== oldValue)
        {
            const url = `/cart/update/${productId}/quantity/${newVal}`;
            axios.post(url)
            .then(function (response) {
                window.location.reload()
            })
            .catch(function (error) {
                console.log('error: '+ error);
            });
        }
    });
});