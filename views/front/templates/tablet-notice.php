<?php
add_action('wp', function () {


    $current_url = $_SERVER['REQUEST_URI'];


    if (strpos($current_url, '/lesson') !== false) {
        return;
    } ?>
    <style>
        #tablet-notice {
            position: fixed;
            inset: 0;
            backdrop-filter: blur(16px);
            background: rgba(0, 0, 0, 0.65);
            display: none;
            align-items: center;
            justify-content: center;
            z-index: 999999;
        }

        #tablet-notice .box {
            text-align: center;
            color: #fff;
            font-family: system-ui, -apple-system, Segoe UI, Roboto, Helvetica, Arial;
            max-width: 440px;
            padding: 40px 28px;
            border-radius: 20px;
            background: rgba(255, 255, 255, 0.08);
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.7);
            animation: fadeIn 0.6s ease;
        }

        #tablet-notice h2 {
            font-size: 22px;
            margin-bottom: 14px;
            color: #ffc020;
        }

        #tablet-notice p {
            font-size: 16px;
            line-height: 1.8;
            color: #e0e0e0;
        }

        #tablet-notice strong {
            color: #ffc020;
            font-weight: 600;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @media (min-width: 600px) and (max-width: 1200px) {
            body>*:not(#tablet-notice) {
                display: none !important;
            }

            html,
            body {
                overflow: hidden;
                height: 100%;
            }

            #tablet-notice {
                display: flex;
            }
        }
    </style>
    <div id="tablet-notice">
        <div class="box">
            <h2>نسخه تبلت به‌زودی فعال می‌شود</h2>
            <p>برای تجربه‌ای روان‌تر و کامل‌تر، لطفاً سایت آلفاپیکو را با <strong>موبایل</strong> یا <strong>رایانه رومیزی / لپ‌تاپ</strong> باز کنید.<br>
                نسخه ویژه تبلت خیلی زود آماده خواهد شد.</p>
        </div>
    </div>

<?php
});
?>