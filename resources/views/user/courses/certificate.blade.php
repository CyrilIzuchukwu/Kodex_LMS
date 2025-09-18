<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Certificate of Completion</title>
        <style>
            * {
                margin: 0;
                padding: 0;
                box-sizing: border-box;
            }

            @page {
                size: A4 landscape;
                margin: 10mm;
            }

            body {
                font-family: DejaVu Sans, sans-serif;
                background: #f9f9f9;
                margin: 0;
                width: 277mm;
                height: 190mm;
                overflow: hidden;
            }

            .page {
                width: 100%;
                height: 100%;
                padding: 10mm;
                position: relative;
                background: #fff;
            }

            .cert {
                background-image: url({{ asset('img/backg.png') }});
                background-size: contain;
                background-position: center;
                width: 100%;
                height: 100%;
                text-align: center;
                display: flex;
                flex-direction: column;
                padding: 15px;
                position: relative;
                overflow: hidden;
            }

            .logo {
                margin: 10px auto 15px auto;
                max-width: 150px;
                max-height: 100px;
            }

            h3 {
                font-size: 24px;
                font-weight: bold;
                margin: 10px 0;
                color: #111;
            }

            .text {
                font-size: 16px;
                margin-bottom: 8px;
            }

            .cont {
                font-size: 18px;
                margin: 15px 0;
            }

            .name {
                font-size: 22px;
                font-weight: bold;
                margin: 10px 0;
            }

            .line {
                margin: 8px auto;
                width: 50%;
                border-top: 1px solid #000;
            }

            .foot {
                margin-top: 30px;
                font-size: 14px;
                display: table;
                width: 100%;
                text-align: center;
            }

            .foot .col {
                display: table-cell;
                width: 33%;
                vertical-align: top;
            }

            .extra-info {
                position: absolute;
                bottom: 5mm;
                left: 10mm;
                right: 10mm;
                font-size: 12px;
                display: flex;
                justify-content: space-between;
            }

            /* Decorative images */
            .corner {
                position: absolute;
                width: 230px;
                max-height: 200px;
            }

            .corner.tl { top: 10px; left: 10px; }
            .corner.br { bottom: 10px; right: 10px; }

            .bg {
                position: absolute;
                top: 0; left: 0;
                width: 100%; height: 100%;
                z-index: -1;
                opacity: 0.1;
            }
        </style>
    </head>
    <body>
        <div class="page">
            <!-- Decorative corners -->
            <img src="{{ asset('img/top-left.svg') }}" class="corner tl" alt="corner">
            <img src="{{ asset('img/bottom-right.svg') }}" class="corner br" alt="corner">

            <div class="cert">
                <!-- Logo -->
                <img class="logo" src="{{ asset('img/KodexLogo.png') }}" alt="logo">

                <h3>CERTIFICATE OF COMPLETION</h3>
                <p class="text">This certificate is proudly presented to</p>

                <div class="cont">
                    <p class="name">{{ $user->name }}</p>
                    <hr class="line">
                    <p class="text">For successful completion of the course</p>
                    <p class="text"><strong>{{ $course->title }}</strong></p>
                </div>

                <div class="foot">
                    <div class="col">
                        <p><strong>Karchy Orji</strong></p>
                        <p>_________________________</p>
                        <p>Program Coordinator</p>
                    </div>

                    <div class="col">
                        <img src="{{ asset('img/ribbon2.png') }}" width="120" alt="ribbon">
                    </div>

                    <div class="col">
                        <p><strong>Authorized Signatory</strong></p>
                        <p>_________________________</p>
                        <p>Signed</p>
                    </div>
                </div>

                <div class="extra-info">
                    <p>Date Issued: <strong>{{ $completion_date }}</strong></p>
                    <p>Certificate ID: <strong>{{ $certificate_id ?? 'Pending' }}</strong></p>
                </div>
            </div>
        </div>
    </body>
</html>
