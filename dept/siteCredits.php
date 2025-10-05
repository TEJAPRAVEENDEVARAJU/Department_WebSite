<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Designed & Developed By</title>
    <style>
        /* Body Styling */
        body {
            margin: 0;
            font-family: 'Arial', sans-serif;
            background-color: #121212;
            color: #fff;
        }

        /* Section */
        .section5 {
            text-align: center;
            padding: 60px 20px;
        }

        #irshi {
            font-size: 3rem;
            margin-bottom: 50px;
            font-weight: bold;
            background: linear-gradient(to right, #ff6ec7, #f9ff6e, #6e9eff);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            text-shadow: 2px 2px 5px rgba(0,0,0,0.5);
        }

        /* Contact Cards */
        .contact-card {
            position: relative;
            display: flex;
            flex-wrap: wrap;
            justify-content: space-around;
            align-items: center;
            background: rgba(0,0,0,0.5);
            border-radius: 20px;
            padding: 30px;
            margin: 40px auto;
            width: 90%;
            max-width: 1000px;
            overflow: hidden;
            box-shadow: 0 10px 25px rgba(0,0,0,0.5);
            transition: transform 0.3s ease;
        }

        .contact-card:hover {
            transform: scale(1.02);
        }

        /* Animated Background */
        .contact-card::before {
            content: "";
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: linear-gradient(45deg, #ff6ec7, #6effb8, #6e9eff, #f9ff6e);
            background-size: 400% 400%;
            animation: gradientBG 12s ease infinite;
            z-index: 0;
            filter: blur(80px);
        }

        @keyframes gradientBG {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        /* Ensure content is above animated background */
        .contact-card * {
            position: relative;
            z-index: 1;
        }

        /* Text Content */
        .text-content {
            flex: 1 1 300px;
            text-align: left;
            margin: 20px;
        }

        .text-content h3 {
            font-size: 2rem;
            margin-bottom: 10px;
            color: #ff6ec7;
        }

        .text-content p {
            margin: 5px 0;
            font-size: 1.1rem;
        }

        .contact-item {
            margin-top: 10px;
            font-size: 1.2rem;
        }

        /* Profile Images */
        .contact-card img {
            width: 250px;
            height: 250px;
            border-radius: 50%;
            object-fit: cover;
            box-shadow: 0 8px 20px rgba(0,0,0,0.6);
            transition: transform 0.3s ease;
        }

        .contact-card img:hover {
            transform: scale(1.08);
        }

        /* Responsive */
        @media (max-width: 900px) {
            .contact-card {
                flex-direction: column;
            }
            .text-content {
                text-align: center;
            }
            .contact-card img {
                margin-top: 20px;
            }
        }
    </style>
</head>
<body>

    <div class="section5">
        <h1 id="irshi">Designed & Developed By</h1>

        <!-- Contact Card 1 -->
        <div class="contact-card">
            <div class="text-content">
                <h3>Shaik Mahammad Irshad</h3>
                <p>Regd.No: Y21IT113</p>
                <p>Class Of 2025</p>
                <p>Department Of Information Technology</p>
                <p>R.V.R & J.C College Of Engineering</p>
                <div class="contact-item">&#9742; +91 7702053936</div>
                <div class="contact-item">&#9993; shaikirshad1020@gmail.com</div>
            </div>
            <img src="Irshad.png" alt="Shaik Mahammad Irshad">
        </div>

        <!-- Contact Card 2 -->
        <div class="contact-card">
            <div class="text-content">
                <h3>Obulasetty Teja Praveen Deva Raju</h3>
                <p>Regd.No: L22IT140</p>
                <p>Class Of 2025</p>
                <p>Department Of Information Technology</p>
                <p>R.V.R & J.C College Of Engineering</p>
                <div class="contact-item">&#9742; +91 7981715576</div>
                <div class="contact-item">&#9993; tejapraveen2003@gmail.com</div>
            </div>
            <img src="DevRaj.jpg" alt="Obulasetty Teja Praveen Deva Raju">
        </div>

    </div>

</body>
</html>
