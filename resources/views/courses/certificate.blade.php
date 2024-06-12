<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Certificate</title>
    <style>
        body {
            font-family: 'Times New Roman', Times, serif;
            text-align: center;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 100%;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .certificate {
            width: 1000px;
            height: 700px;
            border: 10px solid #1c87c9;
            padding: 50px;
            background: #fff url('path-to-pattern-image') center no-repeat;
            background-size: cover;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            position: relative;
            box-sizing: border-box;
        }
        .title {
            font-size: 48px;
            font-weight: bold;
            color: #333;
            margin-bottom: 20px;
        }
        .subtitle {
            font-size: 24px;
            font-weight: bold;
            color: #333;
            margin-bottom: 40px;
        }
        .content {
            font-size: 18px;
            color: #555;
        }
        .signature {
            margin-top: 40px;
            text-align: left;
        }
        .signature img {
            height: 50px;
        }
        .date {
            margin-top: 30px;
            text-align: right;
            font-size: 16px;
            color: #555;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="certificate">
            <div class="title">Certificate of Completion</div>
            <div class="subtitle">This is to certify that</div>
            <div class="content">
                <strong>{{ $studentName }}</strong><br>
                has successfully completed the course<br>
                <strong>{{ $courseName }}</strong>.
            </div>
            <div class="signature">
                <img src="{{ asset('path-to-signature-image') }}" alt="Signature">
                <br>Authorized Signature
            </div>
            <div class="date">
                Date: {{ date('F j, Y') }}
            </div>
        </div>
    </div>
</body>
</html>
