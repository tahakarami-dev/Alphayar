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

  $('.user-avatar-button, .user-box-icon').on('click', function(e) {
    e.stopPropagation();
    const $button = $(this).hasClass('user-avatar-button') ? $(this) : $(this).closest('.user-menu-wrapper').find('.user-avatar-button');
    const $dropdown = $button.closest('.user-menu-wrapper').find('.user-dropdown-card');
    toggleDropdown($button, $dropdown);
  });

  $(document).on('click', '.cart-button, .cart-box-icon', function(e) {
    e.stopPropagation();
    const $button = $(this).hasClass('cart-button') ? $(this) : $(this).closest('.cart-menu-wrapper').find('.cart-button');
    const $dropdown = $button.closest('.cart-menu-wrapper').find('.cart-dropdown-card');
    toggleDropdown($button, $dropdown);
  });

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
  $(document).on('click', '.remove-item', function(e) {
    e.preventDefault();
    e.stopPropagation();

    const $this = $(this);
    const $cartItem = $this.closest('.cart-item');
    const cartItemKey = $cartItem.data('key');
    const nonce = aac_ajax_object.nonce;

    $cartItem.addClass('removing').css({
      'opacity': '0.5',
      'pointer-events': 'none'
    });

    $this.html('<i class="fas fa-spinner fa-spin"></i>');

    $.ajax({
      url: aac_ajax_object.ajax_url,
      type: 'POST',
      data: {
        action: 'aac_remove_from_cart',
        cart_item_key: cartItemKey,
        nonce: nonce
      },
      success: function(response) {
        if (response.success) {
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
          }, 500);

        } else {
          console.error('خطا:', response.data.message);
          alert('خطا در حذف محصول: ' + response.data.message);

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

        $cartItem.removeClass('removing').css({
          'opacity': '1',
          'pointer-events': 'auto'
        });
        $this.html('<i class="fas fa-times"></i>');
      }
    });
  });

  $(document.body).on('added_to_cart', function() {
    setTimeout(function() {
      location.reload();
    }, 1500);
  });
});

// Podcast Player 
window.onload = function() {
  $(document).ready(function() {
    let isPlaying = false;
    let isDragging = false;
    let currentTime = 0;
    let duration = 0;

    const $playPauseBtn = $('#playPauseBtn');
    const $playPauseIcon = $('#playPauseIcon');
    const $prevBtn = $('#prevBtn');
    const $nextBtn = $('#nextBtn');
    const $progressBar = $('#progressBar');
    const $progressFill = $('#progressFill');
    const $progressHandle = $('#progressHandle');
    const $currentTimeDisplay = $('#currentTime');
    const $totalTimeDisplay = $('#totalTime');
    const $audioElement = $('#audioElement')[0];

    function formatTime(seconds) {
      if (isNaN(seconds) || !isFinite(seconds)) return '۰۰:۰۰';
      const mins = Math.floor(seconds / 60);
      const secs = Math.floor(seconds % 60);
      const persianNums = ['۰','۱','۲','۳','۴','۵','۶','۷','۸','۹'];
      let minStr = mins.toString().split('').map(d => persianNums[parseInt(d)]).join('');
      let secStr = secs.toString().padStart(2, '0').split('').map(d => persianNums[parseInt(d)]).join('');
      return minStr + ':' + secStr;
    }

    function updatePlayButton() {
      $playPauseIcon.css('opacity', isPlaying ? '1' : '0.7');
    }

    function updateProgress() {
      if (!isDragging && duration > 0) {
        const progress = (currentTime / duration) * 100;
        $progressFill.css('width', progress + '%');
        $progressHandle.css('left', progress + '%');
      }
      $currentTimeDisplay.text(formatTime(currentTime));
    }

    $audioElement.addEventListener('loadedmetadata', function() {
      duration = $audioElement.duration;
      $totalTimeDisplay.text(formatTime(duration));
      updateProgress();
    });

    $audioElement.addEventListener('timeupdate', function() {
      currentTime = $audioElement.currentTime;
      updateProgress();
    });

    $audioElement.addEventListener('ended', function() {
      isPlaying = false;
      updatePlayButton();
      currentTime = 0;
      updateProgress();
    });

    $playPauseBtn.click(function() {
      if (isPlaying) {
        $audioElement.pause();
        isPlaying = false;
      } else {
        $audioElement.play().then(() => {
          isPlaying = true;
        }).catch(error => {
          console.error('Play error:', error);
          isPlaying = false;
        });
      }
      updatePlayButton();
    });

    $prevBtn.click(function() {
      currentTime = Math.max(0, currentTime - 15);
      $audioElement.currentTime = currentTime;
      updateProgress();
    });

    $nextBtn.click(function() {
      currentTime = Math.min(duration, currentTime + 30);
      $audioElement.currentTime = currentTime;
      updateProgress();
    });

    $progressBar.click(function(e) {
      if (!isDragging && duration > 0) {
        const rect = this.getBoundingClientRect();
        const clickX = e.clientX - rect.left;
        const progress = clickX / rect.width;
        currentTime = progress * duration;
        $audioElement.currentTime = currentTime;
        updateProgress();
      }
    });

    let startDrag = function(e) {
      isDragging = true;
      $(document).on('mousemove', handleDrag);
      $(document).on('mouseup', endDrag);
      e.preventDefault();
    };

    let handleDrag = function(e) {
      if (isDragging && duration > 0) {
        const rect = $progressBar[0].getBoundingClientRect();
        const dragX = Math.max(0, Math.min(rect.width, e.clientX - rect.left));
        const progress = dragX / rect.width;
        const newTime = progress * duration;
        $progressFill.css('width', (progress * 100) + '%');
        $progressHandle.css('left', (progress * 100) + '%');
        $currentTimeDisplay.text(formatTime(newTime));
      }
    };

    let endDrag = function(e) {
      if (isDragging && duration > 0) {
        const rect = $progressBar[0].getBoundingClientRect();
        const dragX = Math.max(0, Math.min(rect.width, e.clientX - rect.left));
        const progress = dragX / rect.width;
        currentTime = progress * duration;
        $audioElement.currentTime = currentTime;
        isDragging = false;
        $(document).off('mousemove', handleDrag);
        $(document).off('mouseup', endDrag);
      }
    };

    $progressHandle.on('mousedown', startDrag);

    $(document).keydown(function(e) {
      switch(e.code) {
        case 'Space':
          e.preventDefault();
          $playPauseBtn.click();
          break;
        case 'ArrowLeft':
          $prevBtn.click();
          break;
        case 'ArrowRight':
          $nextBtn.click();
          break;
      }
    });
  });
};

// End Podcast Player 