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
    <div class="audio-player">
      <div class="controls">
      <button class="control-btn secondary next-btn" id="nextBtn" title="30 ثانیه به جلو">
          <img class="next-icon" src="https://alphapico.ir/uploadsfiles/2025/09/rewind.svg" alt="جلو">
        </button>

        <button class="control-btn primary play-pause-btn" id="playPauseBtn" title="پخش/توقف">
          <img id="playPauseIcon" src="https://alphapico.ir/uploadsfiles/2025/09/play-pause.svg" alt="پخش/توقف">
        </button>
        
        <button class="control-btn secondary prev-btn" id="prevBtn" title="15 ثانیه به عقب">
          <img src="https://alphapico.ir/uploadsfiles/2025/09/rewind.svg" alt="عقب">
        </button>
        
      </div>
      <div class="time-display">
        <span id="currentTime">00:00</span>
        <span id="totalTime">--:--</span>
      </div>

      <div class="progress-container">
        <div class="progress-bar" id="progressBar">
          <div class="progress-fill" id="progressFill"></div>
          <div class="progress-handle" id="progressHandle"></div>
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