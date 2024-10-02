/* Toggle between showing and hiding the navigation menu links when the user clicks on the hamburger menu / bar icon */
function toggleNavbar() {
    let navbar = document.getElementById("my-links");
    let icon = document.getElementById('hamburger-icon');
    if (navbar.style.display === "block") {
        navbar.style.display = "none";
        icon.removeAttribute('class');
        icon.setAttribute('class', 'fa fa-bars');
    } else {
        navbar.style.display = "block";
        icon.removeAttribute('class');
        icon.setAttribute('class', 'fa fa-times');
    }
}
$(document).ready(function () {
    // start of testimonials slider script
    $('.slider').bxSlider({
        pager: true,
        controls: true,
        auto: false,
        infiniteLoop: false
    }); // end of testimonials slider script
    // start of order button click event listener
    $('.toform').click(function () {
        $("html, body").animate({
            scrollTop: $("form").offset().top - 30
        }, 1000);
        return false;
    });
    if ($(".arrow-up").length) {
        var b = $("#scrollToTop"),
            c = $("body,html"),
            d = $(window);
        b.css("display", "none");
        d.scroll(function() {
            0 < $(this).scrollTop() ? b.fadeIn() : b.fadeOut()
        });
        b.click(function() {
            c.animate({
                scrollTop: 0
            }, 400);
            return !1
        })
    } // end of order button click event listener
    // Start of Order Form Handler
    $('.orderForm').submit(function(event) {
        event.preventDefault();
        // clear form method
        const clearOrderForm = (field = null) => {
            switch (field) {
                case 'name':
                    $('.orderForm').find('#order-name').val(null);
                    break;
                case 'phone':
                    $('.orderForm').find('#order-phone').val(null);
                    break;
                default:
                    $('.orderForm').find('#order-name').val(null);
                    $('.orderForm').find('#order-phone').val(null);
            }
        };
        // validate form fields method
        const validate = {
            name: (data) => {
                if (!data.length) {
                    swal.fire({
                        title: 'Eroare!',
                        text: 'Numele este obligatoriu!',
                        icon: 'error',
                        confirmButtonColor: '#a20002',
                        confirmButtonText: 'OK'
                    });
                    clearOrderForm('name');
                    return false;
                }
                if (data.match(/[^a-zA-Z\s]/g)) {
                    swal.fire({
                        title: 'Eroare!',
                        text: 'Numele poate conține doar litere și spații!',
                        icon: 'error',
                        confirmButtonColor: '#a20002',
                        confirmButtonText: 'OK'
                    });
                    clearOrderForm('name');
                    return false;
                }
                return true;
            },
            phone: (data) => {
                if (!data.length) {
                    swal.fire({
                        title: 'Eroare!',
                        text: 'Numărul de telefon este obligatoriu!',
                        icon: 'error',
                        confirmButtonColor: '#a20002',
                        confirmButtonText: 'OK'
                    });
                    clearOrderForm('phone');
                    return false;
                }

                if (isNaN(data) || data.match(/[^0-9\+]/g)) {
                    swal.fire({
                        title: 'Eroare!',
                        text: 'Numărul de telefon trebuie să fie numeric!',
                        icon: 'error',
                        confirmButtonColor: '#a20002',
                        confirmButtonText: 'OK'
                    });
                    clearOrderForm('phone');
                    return false;
                }

                if (data.length < 10) {
                    swal.fire({
                        title: 'Eroare!',
                        html: 'Numărul de telefon nu are formatul corespunzător!</br>Vă rugăm introduce-ți inclusiv prefixul.',
                        icon: 'error',
                        confirmButtonColor: '#a20002',
                        confirmButtonText: 'OK'
                    });
                    clearOrderForm('phone');
                    return false;
                }
                return true;
            }
        };
        // grab form fields values
        const data = {
            name: $(this).find('#order-name').val(),
            phone: $(this).find('#order-phone').val(),
            csrf_token: $(this).find('#csrf_token').val(),
        };
        // send ajax request if everthing is fine
        if (validate.name(data.name) && validate.phone(data.phone)) {
            $.post({
                url: 'http://localhost/fleboxin-site/order.php',
                data: data,
                success: function(response) {
                    response = JSON.parse(response);
                    clearOrderForm();
                    if(response.action == 'redirect') {
                        window.location.href = response.redirectTo;
                    }
                },
                error: function(error) {
                    swal.fire({
                        title: 'Eroare!',
                        html: error.statusText,
                        icon: 'error',
                        confirmButtonColor: '#a20002',
                        confirmButtonText: 'OK'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            clearOrderForm();
                        }
                    });
                }
            });
        }
    }); // End of Order Form Handler
    // Start of contact form handler
    $('#feedback__form').submit(function(event) {
        event.preventDefault();
        const clearContactForm = (field = null) => {
            switch (field) {
                case 'email':
                    $('#feedback__form').find('input[name="name"]').val(null);
                    break;
                case 'email':
                    $('#feedback__form').find('input[name="email"]').val(null);
                    break;
                case 'phone':
                    $('#feedback__form').find('input[name="phone"]').val(null);
                    break;
                case 'message':
                    $('#feedback__form').find('textarea[name="message"]').val(null);
                    break;
                default:
                    $('#feedback__form').find('input[name="name"]').val(null);
                    $('#feedback__form').find('input[name="email"]').val(null);
                    $('#feedback__form').find('input[name="phone"]').val(null);
                    $('#feedback__form').find('textarea[name="message"]').val(null);
            }
        };
        const api_uri = "https://ro-fleboxin.hotproduct.org/land/feedback";
        let country = 'RO';
        let name = $(this).find('input[name="name"]').val();
        let email = $(this).find('input[name="email"]').val();
        let phone = $(this).find('input[name="phone"]').val();
        let message = $(this).find('textarea[name="message"]').val();
        let csrf_token = $(this).find('input[name="csrf_token"]').val();

        if (!name.length) {
            swal.fire({
                title: 'Eroare!',
                text: 'Numele este obligatoriu!',
                icon: 'error',
                confirmButtonColor: '#a20002',
                confirmButtonText: 'OK'
            });
            clearContactForm('name');
            return false;
        }
        if (!email.length) {
            swal.fire({
                title: 'Eroare!',
                text: 'Adresa de Email este obligatorie!',
                icon: 'error',
                confirmButtonColor: '#a20002',
                confirmButtonText: 'OK'
            });
            clearContactForm('email');
            return;
        }
        if (!email.match(/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/)) {
            swal.fire({
                title: 'Eroare!',
                text: 'Vă rugăm introduceți o adresă de Email validă!',
                icon: 'error',
                confirmButtonColor: '#a20002',
                confirmButtonText: 'OK'
            });
            clearContactForm('email');
            return;
        }
        if (!phone.length) {
            swal.fire({
                title: 'Eroare!',
                text: 'Numărul de telefon este obligatoriu!',
                icon: 'error',
                confirmButtonColor: '#a20002',
                confirmButtonText: 'OK'
            });
            clearContactForm('phone');
            return;
        }
        if (isNaN(phone) || phone.match(/[^0-9\+]/g)) {
            swal.fire({
                title: 'Eroare!',
                text: 'Numărul de telefon trebuie să fie numeric!',
                icon: 'error',
                confirmButtonColor: '#a20002',
                confirmButtonText: 'OK'
            });
            clearContactForm('phone');
            return;
        }
        if (!message.length) {
            swal.fire({
                title: 'Eroare!',
                text: 'Mesajul este obligatoriu!',
                icon: 'error',
                confirmButtonColor: '#a20002',
                confirmButtonText: 'OK'
            });
            clearContactForm('message');
            return;
        }

        $.post({
            url: 'http://localhost/fleboxin-site/contact.php',
            data: { csrf_token: csrf_token, name: name, email: email, phone: phone },
            success: function(response) {
                console.log(response);
                return;
            },
            error: function(error) {
                console.warn(error);
            }
        });

        $.post({
            url: api_uri,
            data: { country: country, email: email, phone: phone, message: message },
            success: function(response) {
                $('.feedback__success').css('display', 'block');
                clearContactForm();
            },
            error: function(error) {
                console.warn(error);
            }
        });
    }); // end of contact form handler
    if ($('.feedback__success').css('display') === 'block') {
        $('.feedback__success').css('display', 'none');
    }
});