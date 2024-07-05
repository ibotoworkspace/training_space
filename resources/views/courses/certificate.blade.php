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
            width: 90%;
            height: 90%;
            display: flex;
            justify-content: center;
            align-items: center;
            margin: auto;
        }
        .certificate {
            width: 85%;
            height: 95%;
            border: 10px solid #1c87c9;
            padding: 50px;
            background: #fff url('path-to-pattern-image') center no-repeat;
            background-size: cover;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            position: relative;
            box-sizing: border-box;
            font-family: Arial, Helvetica, sans-serif;
        }
        .partners {
            position: absolute;
            bottom: 50px;
            width: 100%;
            text-align: center;
        }
        .title2 {
            font-size: 28px;
            font-weight: bold;
            color: #333;
            margin-bottom: 20px;
            font-family: 'Times New Roman', Times, serif;
        }

        .title {
            font-size: 25px;
            font-weight: bold;
            color: #333;
            margin-bottom: 20px;
            font-family: 'Times New Roman', Times, serif;
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
            text-align: left;
            font-size: 14px;
            color: #555;
        }
    </style>
</head> 
<body>
    <div class="container">
        <div class="certificate">
            <div style="text-align: left;">
                <img src="{{ public_path('images/certlogo.jpg') }}" alt="Logo" class="logo" style="width: 220px;">

            </div>
            <p>
                As a testament to his expertise and knowledge in the <br>ever-evolving word of {{$courseName}},
            </p>
            <p> <span class="title">{{$studentName}}</span> <br>
                ________________________________________ <br>
                <span style="font-family: 'Times New Roman', Times, serif"><b><i>has been awarded a</i></b></span>
            </p>
            <p class="title2"><i>Certificate of Specialization <br> and Competency in {{$courseName}}</i></p>
          
            <p>Based on the successful completeion of all the required theories <br> and practical of HRS Academy {{$courseName}} modules.</p>
            <div style="width: 50%; float: left;">
                <div class="signature">
                    <b>Jacob Oroks Mism CTS <br>
                    Academic Counselor</b> <br><br>
                    <img src="{{ asset('images/sign.jpg') }}" alt="Signature" style="width: 60px;">
                    <br>Authorized Signature
                </div>
    
                <div class="date">
                    Date Issued: {{ date('F j, Y') }}
                </div>
            </div>
            <div style="width: 50%; float: right;">
                <img src="{{ asset('images/certbadge.jpg') }}" alt="Badge" style="width: 140px;">
            </div>



            <div style="justify-content: center; text-align: center; position: relative; clear: both; margin-top: 40px;">
                <img src="{{ asset('images/partners.jpg') }}" alt="Partners" style="width: 50%; margin: auto">
            </div>
           
        </div>
    </div>
</body>
</html>
