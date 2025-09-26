<?php
function podcast_audio_player_shortcode($atts) {
    global $post;

    if (!$post || get_post_type($post) !== 'podcast') {
        return '<p>پادکست یافت نشد.</p>';
    }

    $audio_file = get_post_meta($post->ID, 'podcast_audio_file', true);

    if (!$audio_file) {
        return '<p>فایل صوتی موجود نیست.</p>';
    }

    ob_start(); 
    ?>
    <script>
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

    </script>
    <div class="audio-player">
      <div class="controls">
        <button class="control-btn secondary prev-btn" id="prevBtn" title="15 ثانیه به عقب">
          <img src="https://alphapico.ir/uploadsfiles/2025/09/rewind.svg" alt="عقب">
        </button>
        
        <button class="control-btn primary play-pause-btn" id="playPauseBtn" title="پخش/توقف">
          <img id="playPauseIcon" src="https://alphapico.ir/uploadsfiles/2025/09/play-pause.svg" alt="پخش/توقف">
        </button>
        
        <button class="control-btn secondary next-btn" id="nextBtn" title="30 ثانیه به جلو">
          <img class="next-icon" src="https://alphapico.ir/uploadsfiles/2025/09/rewind.svg" alt="جلو">
        </button>
      </div>
      <div class="time-display">
        <span id="currentTime">00:00</span>
        <span id="totalTime">--:--</span>
      </div>

      <div class="progress-container">
        <div class="progress-bar" id="progressBar">
          <div class="progress-fill" id="progressFill"></div>
        </div>
      </div>

      <audio id="audioElement" preload="metadata">
        <source src="<?php echo esc_url($audio_file); ?>" type="audio/mpeg">
        Your browser does not support the audio element.
      </audio>
    </div>
    <?php
    return ob_get_clean();
}
add_shortcode('podcast_player', 'podcast_audio_player_shortcode');
