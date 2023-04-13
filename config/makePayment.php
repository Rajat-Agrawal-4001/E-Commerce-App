<?php
if (!isset($conn)) {
    die("Connection not set");
}

$vid = getVendorID();

$name = '';
$number = '';
$email = '';

if ($vid != -1) {
    $qry = "SELECT * FROM vendor WHERE id = '$vid' ";
    $res = mysqli_query($conn, $qry);
    $data = mysqli_fetch_assoc($res);

    $name = $data['name'];
    $email = $data['email'];
    $number = $data['whatsapp'];
}

?>
<style>
    #paymentLoader {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        justify-content: center;
        align-items: center;
        flex-direction: column;
        width: 100%;
        background: rgba(0, 0, 0, 0.75) no-repeat center center;
        z-index: 10000;
        color: white;
    }
</style>
<div id="paymentLoader">
    <div class="row">
        <div class="col-sm-12 text-center">
            <div class="spinner-border text-primary" style="height: 4rem; width: 4rem;"></div>
        </div>
        <div class="col-sm-12 text-center">
            Making Payment...
        </div>

    </div>
</div>

<script src="https://checkout.razorpay.com/v1/checkout.js"></script>
<script>
    function makePayment(targetURL, initialForm, finalKey, successMsg, errorMsg, successLink = false, errorLink = false, confirm_msg = false, accept = false, deny = false, confirm_icon = "question") {
        var flag = true;
        $.ajax({
            url: targetURL,
            method: "POST",
            data: initialForm,
            processData: false,
            contentType: false,
            beforeSend: function() {
                $("#paymentLoader").css("display", "flex");
            },
            success: function(response) {
                $("#paymentLoader").css("display", "none");
                console.log(response);
                var response = $.parseJSON(response);
                if (response.cod || response.wallet) {
                    Swal.fire(successMsg, "", "success");
                    if (successLink != false) {
                        location.href = successLink;
                    } else {
                        setTimeout(() => {
                            location.reload();
                        }, 2000);
                    }

                    return;
                }

                if (response.error) {
                    Swal.fire(errorMsg, response.error, "error");
                    flag = false;
                    return;
                }

                var options = {
                    "key": "<?php echo RAZORPAY_KEY ?>",
                    "amount": response.amount,
                    "currency": "INR",
                    "name": "Vikas Kumar",
                    "description": "Test Transaction",
                    // "order_id": response.id, // production
                    "handler": function(response) {
                        $("#paymentLoader").css("display", "flex");
                        var formData = new FormData();
                        formData.append(finalKey, response);
                        $.ajax({
                            url: targetURL,
                            method: "POST",
                            data: formData,
                            processData: false,
                            contentType: false,
                            success: function(data) {
                                $("#paymentLoader").css("display", "none");
                                if (data.trim() == '1') {
                                    if (confirm_msg) {
                                        Swal.fire({
                                            title: "Confirmation",
                                            icon: confirm_icon,
                                            text: confirm_msg,
                                            showConfirmButton: true,
                                            confirmButtonText: "Yes",
                                            showCancelButton: true,
                                            cancelButtonText: "No, Skip",
                                        }).then(result => {
                                            if (result.isConfirmed) {
                                                if (accept == 'reload')
                                                    location.reload();
                                            } else {
                                                location.href = deny;
                                            }
                                        });
                                    } else {
                                        if (successMsg !== false)
                                            Swal.fire(successMsg, "", "success");
                                        if (successLink != false) {
                                            location.href = successLink;
                                        } else {
                                            setTimeout(() => {
                                                location.reload();
                                            }, 2000);
                                        }
                                    }
                                    return true;
                                } else {
                                    flag = false;
                                    console.log(data);
                                    Swal.fire(errorMsg, "", "error");
                                    if (errorLink !== false) {
                                        location.href = errorLink;
                                    }
                                    return false;
                                }
                            }
                        })
                    },
                    "prefill": {
                        "name": "<?php echo htmlspecialchars($name) ?>",
                        "email": "<?php echo htmlspecialchars($email) ?>",
                        "contact": "<?php echo htmlspecialchars($number) ?>",
                    },
                };


                var rzp1 = new Razorpay(options);
                rzp1.open();
            },
            error: function() {
                flag = false;
            }
        });
    }
</script>