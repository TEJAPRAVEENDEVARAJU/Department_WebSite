<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet"> <!-- Font Awesome -->
<style>
     body {
            /* margin: 0; */
            background-color: #f0f0f0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            font-family: Arial, sans-serif;
        }

        .container {
            position: relative;
            width: 800px;
            height: 400px;
        }

        .drop {
            position: absolute;
            width: 20px;
            height: 20px;
            background-color: transparent;
            border-radius: 50%;
            opacity: 0;
            animation: fall 2s ease-out forwards;
        }

        /* Drops for Information */
        .drop:nth-child(1) { background-color: #FF5733; left: 50px; animation-delay: 0.1s; }
        .drop:nth-child(2) { background-color: #33FF57; left: 100px; animation-delay: 0.2s; }
        .drop:nth-child(3) { background-color: #3357FF; left: 150px; animation-delay: 0.3s; }
        .drop:nth-child(4) { background-color: #FFC300; left: 200px; animation-delay: 0.4s; }
        .drop:nth-child(5) { background-color: #FF33A6; left: 250px; animation-delay: 0.5s; }
        .drop:nth-child(6) { background-color: #33C4FF; left: 300px; animation-delay: 0.6s; }
        .drop:nth-child(7) { background-color: #AA33FF; left: 350px; animation-delay: 0.7s; }
        .drop:nth-child(8) { background-color: #FF5733; left: 400px; animation-delay: 0.8s; }
        .drop:nth-child(9) { background-color: #33FF57; left: 450px; animation-delay: 0.9s; }
        .drop:nth-child(10) { background-color: #3357FF; left: 500px; animation-delay: 1s; }

        /* Drops for Technology */
        .drop:nth-child(11) { background-color: #AA33FF; left: 50px; animation-delay: 1.2s; }
        .drop:nth-child(12) { background-color: #FF5733; left: 100px; animation-delay: 1.3s; }
        .drop:nth-child(13) { background-color: #33FF57; left: 150px; animation-delay: 1.4s; }
        .drop:nth-child(14) { background-color: #3357FF; left: 200px; animation-delay: 1.5s; }
        .drop:nth-child(15) { background-color: #FFC300; left: 250px; animation-delay: 1.6s; }
        .drop:nth-child(16) { background-color: #FF33A6; left: 300px; animation-delay: 1.7s; }
        .drop:nth-child(17) { background-color: #33C4FF; left: 350px; animation-delay: 1.8s; }
        .drop:nth-child(18) { background-color: #AA33FF; left: 400px; animation-delay: 1.9s; }
        .drop:nth-child(19) { background-color: #FF5733; left: 450px; animation-delay: 2s; }
        .drop:nth-child(20) { background-color: #33FF57; left: 500px; animation-delay: 2.1s; }

        @keyframes fall {
            0% { top: -50px; opacity: 1; }
            80% { top: 200px; opacity: 1; }
            100% { opacity: 0; }
        }

        .letter {
            position: absolute;
            font-size: 2rem;
            font-weight: bold;
            color: #333;
            opacity: 0;
            animation: appear 2s ease-in forwards;
        }

        /* Letters for Information */
        .letter:nth-child(21) { top: 200px; left: 50px; animation-delay: 2s; content: "I"; }
        .letter:nth-child(22) { top: 200px; left: 100px; animation-delay: 2.1s; content: "n"; }
        .letter:nth-child(23) { top: 200px; left: 150px; animation-delay: 2.2s; content: "f"; }
        .letter:nth-child(24) { top: 200px; left: 200px; animation-delay: 2.3s; content: "o"; }
        .letter:nth-child(25) { top: 200px; left: 250px; animation-delay: 2.4s; content: "r"; }
        .letter:nth-child(26) { top: 200px; left: 300px; animation-delay: 2.5s; content: "m"; }
        .letter:nth-child(27) { top: 200px; left: 350px; animation-delay: 2.6s; content: "a"; }
        .letter:nth-child(28) { top: 200px; left: 400px; animation-delay: 2.7s; content: "t"; }
        .letter:nth-child(29) { top: 200px; left: 450px; animation-delay: 2.8s; content: "i"; }
        .letter:nth-child(30) { top: 200px; left: 500px; animation-delay: 2.9s; content: "o"; }
        .letter:nth-child(31) { top: 200px; left: 550px; animation-delay: 3s; content: "n"; }

        /* Letters for Technology */
        .letter:nth-child(32) { top: 250px; left: 50px; animation-delay: 3.2s; content: "T"; }
        .letter:nth-child(33) { top: 250px; left: 100px; animation-delay: 3.3s; content: "e"; }
        .letter:nth-child(34) { top: 250px; left: 150px; animation-delay: 3.4s; content: "c"; }
        .letter:nth-child(35) { top: 250px; left: 200px; animation-delay: 3.5s; content: "h"; }
        .letter:nth-child(36) { top: 250px; left: 250px; animation-delay: 3.6s; content: "n"; }
        .letter:nth-child(37) { top: 250px; left: 300px; animation-delay: 3.7s; content: "o"; }
        .letter:nth-child(38) { top: 250px; left: 350px; animation-delay: 3.8s; content: "l"; }
        .letter:nth-child(39) { top: 250px; left: 400px; animation-delay: 3.9s; content: "o"; }
        .letter:nth-child(40) { top: 250px; left: 450px; animation-delay: 4s; content: "g"; }
        .letter:nth-child(41) { top: 250px; left: 500px; animation-delay: 4.1s; content: "y"; }

        @keyframes appear {
            0% { opacity: 0; transform: translateY(-20px); }
            100% { opacity: 1; transform: translateY(0); }
        }
    </style></style>
</head>
<body>
    

    <div class="container mt-5">
        <h1 class="text-center mb-4">Admin Dashboard</h1>

        <div class="row justify-content-center">
            <div class="col-12 col-md-4 mb-3">
                <button class="btn btn-primary w-100" onclick="location.href='InformaTrix_login.php'">
                    <i class="fas fa-cogs"></i> (Infomatrix)Admin
                </button>
            </div>
			<div class="col-12 col-md-4 mb-3">
                <button class="btn btn-danger w-100" onclick="location.href='IDCC_login.php'">
                    <i class="fas fa-shield-alt"></i> (IDCC)Admin 
                </button>
            </div>
            <div class="col-12 col-md-4 mb-3">
                <button class="btn btn-success w-100" onclick="location.href='GNOME_login.php'">
                    <i class="fas fa-users"></i> (GNOME)Admin
                </button>
            </div>
        </div>
    </div>
 
    <div class="container">
        <!-- Drops for Information -->
        <div class="drop"></div>
        <div class="drop"></div>
        <div class="drop"></div>
        <div class="drop"></div>
        <div class="drop"></div>
        <div class="drop"></div>
        <div class="drop"></div>
        <div class="drop"></div>
        <div class="drop"></div>
        <div class="drop"></div>

        <!-- Drops for Technology -->
        <div class="drop"></div>
        <div class="drop"></div>
        <div class="drop"></div>
        <div class="drop"></div>
        <div class="drop"></div>
        <div class="drop"></div>
        <div class="drop"></div>
        <div class="drop"></div>
        <div class="drop"></div>
        <div class="drop"></div>

        <!-- Letters for Information -->
        <div class="letter">I</div>
        <div class="letter">n</div>
        <div class="letter">f</div>
        <div class="letter">o</div>
        <div class="letter">r</div>
        <div class="letter">m</div>
        <div class="letter">a</div>
        <div class="letter">t</div>
        <div class="letter">i</div>
        <div class="letter">o</div>
        <div class="letter">n</div>

        <!-- Letters for Technology -->
        <div class="letter">T</div>
        <div class="letter">e</div>
        <div class="letter">c</div>
        <div class="letter">h</div>
        <div class="letter">n</div>
        <div class="letter">o</div>
        <div class="letter">l</div>
        <div class="letter">o</div>
        <div class="letter">g</div>
        <div class="letter">y</div>
    </div>
</body>
</html>


 