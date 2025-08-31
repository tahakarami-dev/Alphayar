jQuery(document).ready(function($) {
  function toggleDropdown($button, $dropdown) {
    const isOpening = !$dropdown.hasClass('show');

    $('.user-avatar-button, .cart-button').not($button).removeClass('active');
    $('.user-dropdown-card, .cart-dropdown-card').not($dropdown).removeClass('show').hide();

    if (isOpening) {
      $button.addClass('active');
      $dropdown.css({
        'display': 'block',
        'opacity': 0,
        'transform': 'translateY(-5px)'
      }).animate({
        'opacity': 1,
        'transform': 'translateY(0)'
      }, 200, function() {
        $dropdown.addClass('show');
      });
    } else {
      $button.removeClass('active');
      $dropdown.animate({
        'opacity': 0,
        'transform': 'translateY(-5px)'
      }, 200, function() {
        $dropdown.removeClass('show').hide();
      });
    }
  }

  // کلیک روی آواتار کاربر
  $('.user-avatar-button, .user-box-icon').on('click', function(e) {
    e.stopPropagation();
    const $button = $(this).hasClass('user-avatar-button') ? $(this) : $(this).closest('.user-menu-wrapper').find('.user-avatar-button');
    const $dropdown = $button.closest('.user-menu-wrapper').find('.user-dropdown-card');
    toggleDropdown($button, $dropdown);
  });

  // کلیک روی آیکون سبد خرید
  $(document).on('click', '.cart-button, .cart-box-icon', function(e) {
    e.stopPropagation();
    const $button = $(this).hasClass('cart-button') ? $(this) : $(this).closest('.cart-menu-wrapper').find('.cart-button');
    const $dropdown = $button.closest('.cart-menu-wrapper').find('.cart-dropdown-card');
    toggleDropdown($button, $dropdown);
  });

  // بستن منو با کلیک بیرون
  $(document).on('click', function(e) {
    if (!$(e.target).closest('.user-menu-wrapper, .cart-menu-wrapper').length) {
      $('.user-avatar-button, .cart-button').removeClass('active');
      $('.user-dropdown-card, .cart-dropdown-card').animate({
        'opacity': 0,
        'transform': 'translateY(-5px)'
      }, 200, function() {
        $(this).removeClass('show').hide();
      });
    }
  });

});
jQuery(document).ready(function($) {
  // مدیریت حذف آیتم از سبد خرید
  $(document).on('click', '.remove-item', function(e) {
      e.preventDefault();
      e.stopPropagation();

      const $this = $(this);
      const $cartItem = $this.closest('.cart-item');
      const cartItemKey = $cartItem.data('key');
      const nonce = aac_ajax_object.nonce; // Nonce برای امنیت

      // نمایش انیمیشن در حال حذف
      $cartItem.addClass('removing').css({
          'opacity': '0.5',
          'pointer-events': 'none'
      });

      // نمایش اسپینر (اختیاری)
      $this.html('<i class="fas fa-spinner fa-spin"></i>');

      $.ajax({
          url: aac_ajax_object.ajax_url,
          type: 'POST',
          data: {
              action: 'aac_remove_from_cart',
              cart_item_key: cartItemKey,
              nonce: nonce
          },
          beforeSend: function() {
              // کدهای قبل از ارسال درخواست (اختیاری)
          },
          success: function(response) {
              if (response.success) {
                  // نمایش پیام موفقیت (اختیاری)
                  if (typeof Toastify !== 'undefined') {
                      Toastify({
                          text: "محصول با موفقیت حذف شد",
                          duration: 3000,
                          close: true,
                          gravity: "top",
                          position: "left",
                          backgroundColor: "#4CAF50",
                      }).showToast();
                  }

                  
                  setTimeout(function() {
                      location.reload();
                  }, 500 );
                  
              } else {
                  // نمایش خطا
                  console.error('خطا:', response.data.message);
                  alert('خطا در حذف محصول: ' + response.data.message);
                  
                  // بازگرداندن وضعیت دکمه
                  $cartItem.removeClass('removing').css({
                      'opacity': '1',
                      'pointer-events': 'auto'
                  });
                  $this.html('<i class="fas fa-times"></i>');
              }
          },
          error: function(xhr, status, error) {
              console.error('خطای AJAX:', error);
              alert('خطا در ارتباط با سرور');
              
              // بازگرداندن وضعیت دکمه
              $cartItem.removeClass('removing').css({
                  'opacity': '1',
                  'pointer-events': 'auto'
              });
              $this.html('<i class="fas fa-times"></i>');
          },
          complete: function() {
              // کدهای پس از تکمیل درخواست (اختیاری)
          }
      });
  });

  // اگر نیاز به رفرش خودکار پس از افزودن محصول دارید
  $(document.body).on('added_to_cart', function() {
      // رفرش صفحه پس از 1.5 ثانیه
      setTimeout(function() {
          location.reload();
      }, 1500);
  });
});