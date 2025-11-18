<!-- Js Plugins -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
<script src="/temp/assets/js/jquery-3.3.1.min.js"></script>
<script src="/temp/assets/js/bootstrap.min.js"></script>
<script src="/temp/assets/js/jquery.nice-select.min.js"></script>
<script src="/temp/assets/js/jquery.nicescroll.min.js"></script>
<script src="/temp/assets/js/jquery.magnific-popup.min.js"></script>
<script src="/temp/assets/js/jquery.countdown.min.js"></script>
<script src="/temp/assets/js/jquery.slicknav.js"></script>
<script src="/temp/assets/js/mixitup.min.js"></script>
<script src="/temp/assets/js/owl.carousel.min.js"></script>
<script src="/temp/assets/js/main.js"></script>
<script src="/temp/js/main.js"></script>
<script src="/temp/js/validate.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script>
        var swiper = new Swiper(".mySwiper", {
      spaceBetween: 10,
      slidesPerView: 4,
      freeMode: true,
      watchSlidesProgress: true,
    });
    var swiper2 = new Swiper(".mySwiper2", {
      spaceBetween: 10,
      navigation: {
        nextEl: ".swiper-button-next",
        prevEl: ".swiper-button-prev",
      },
      thumbs: {
        swiper: swiper,
      },
    });
   $(document).on("submit", "#form-change-password", function (e) {
    e.preventDefault();
    let form = $(this);
    let formData = form.serialize();

    // Xóa lỗi cũ trước khi gửi
    $(".error-message").text("");

    $.ajax({
        url: form.attr("action"),
        type: "POST",
        data: formData,
        beforeSend: function () {
            $(".btn-primary").prop("disabled", true);
        },
        success: function (response) {
            $(".btn-primary").prop("disabled", false);
            alert(response.message); // Hiển thị thông báo thành công
            form[0].reset(); // Reset form nếu đổi mật khẩu thành công
        },
        error: function (xhr) {
            $(".btn-primary").prop("disabled", false);
            let errors = xhr.responseJSON.errors;

            // Kiểm tra lỗi cho trường old_password
            if (errors.old_password) {
                let errorMessage = errors.old_password[0]; // Lấy lỗi đầu tiên
                $("input[name='old_password']").next(".error-message").text(errorMessage);
            }

            // Hiển thị lỗi cho các trường khác (new_password, new_password_confirmation)
            for (let key in errors) {
                let errorMessage = errors[key][0]; // Lấy lỗi đầu tiên
                $(`input[name="${key}"]`).next(".error-message").text(errorMessage);
            }
        }
    });
});

</script>
<script>
    $("#latest-posts-slider").owlCarousel({
        loop: true,
        margin: 20,
        items: 3,
        autoplay: true,
        autoplayTimeout: 3500,
        autoplayHoverPause: true,
        nav: false,
        dots: true,
        responsive:{
            0:{ items:1 },
            600:{ items:2 },
            1000:{ items:3 }
        }
    });
</script>