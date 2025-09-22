<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Six Horizontal Divs</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <style>
        @keyframes glow {
            0% {
                text-shadow: 0 0 10px #ff00ff, 0 0 20px #ff00ff, 0 0 30px #00ffff, 0 0 40px #00ffff;
            }
            50% {
                text-shadow: 0 0 10px #00ff00, 0 0 20px #00ff00, 0 0 30px #ffff00, 0 0 40px #ffff00;
            }
            100% {
                text-shadow: 0 0 10px #ff4500, 0 0 20px #ff4500, 0 0 30px #ff6347, 0 0 40px #ff6347;
            }
        }

        .glowing-text {
            font-size: 4.7rem;
            font-weight: bold;
            color: white;
            text-align: center;
            padding: 0rem;
            animation: glow 2s infinite alternate;
        }
        .row.bg-primary.text-white.py-5 {
			background-color: navy !important; /* Force black background */
		}
		.row.bg-light.text-center img {
			object-fit: contain; /* Maintains aspect ratio */
		}
		.button-container {
			gap: 150px; /* Adjust to your preference */
		}
		.row.bg-dark.py-2 {
			background-color: black !important;
		}
		.clubdesc {
			font-size: 1.5rem;
			text-align: justify;
			font-family: Arial, sans-serif;
			width: 80%;
			margin: 0 auto;
			margin-top: 60px;
			margin-bottom: 60px; /* Increased space between the text and image buttons */
		}
		#H1 {
            font-size: 5rem;
            text-align: center;
            text-decoration: underline;
            text-decoration-color: red;
            text-decoration-thickness: 3px;
            text-underline-offset: 15px;
            margin-top:0px;
        }
		.image-buttons {
            display: flex;
            justify-content: center;
            gap: 20px;
            margin-top: 20px;
        }

        .image-buttons img {
            width: 300px; /* Adjust width */
            height: 300px; /* Adjust height */
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.2);
            cursor: pointer;
            transition: all 0.3s ease-in-out;
        }

        .image-buttons img:hover {
            transform: scale(1.1);
            box-shadow: 0 8px 12px rgba(0, 0, 0, 0.3);
        }
		.image-buttons {
			display: flex;
			justify-content: center;
			gap: 150px; /* Increased gap between buttons */
			margin-top: 20px;
		}
		.modern-table-container {
			width: 100%; /* Full width of the parent container */
			display: block;
			padding-left: 0px; /* Add spacing from the left edge */
			margin-top: 40px; /* Space between heading and contact box */
			margin-bottom: 0 !important;
		}
		.modern-table {
			width: 100%; /* Full width of the container */
			border-collapse: collapse; /* Remove spacing between cells */
			font-family: Arial, sans-serif;
			margin: 0 auto; /* Center align the table */
			box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); /* Subtle shadow for modern effect */
		}

		.modern-table thead {
			background-color: #f0f0f0; /* Light Gray Header */
		}

		.modern-table th,
		.modern-table td {
			padding: 15px;
			text-align: left;
			border: 1px solid #ddd; /* Subtle border */
		}

		.modern-table th {
			font-size: 1rem;
			text-transform: uppercase;
			color: #333;
		}

		.modern-table td {
			font-size: 0.9rem;
			color: #555;
		}

		.modern-table tr:nth-child(even) {
			background-color: #f9f9f9; /* Alternating row colors */
		}

		.modern-table tr:hover {
			background-color: #f1f1f1; /* Highlight on hover */
			transition: background-color 0.3s ease; /* Smooth transition */
		}

		.modern-table a {
			color: #007BFF; /* Blue links for emails */
			text-decoration: none;
		}

		.modern-table a:hover {
			text-decoration: underline;
		}
		.modern-table tr:nth-child(even) {
            background-color: #f9f9f9; /* Alternating row colors */
        }

        .modern-table tr:nth-child(odd) {
            background-color: white; /* Odd rows white */
        }

        .modern-table tr:hover {
            background-color: #f1f1f1; /* Highlight on hover */
            transition: background-color 0.3s ease; /* Smooth transition */
        }

        /* Remove gap between Student Executive Body table and Part 6 */
        .row.bg-light.text-center.py-5:last-child {
            margin-bottom: 0 !important;
			padding-bottom: 0 !important; 
        }
        /* Remove space after Part 6 */
        body {
            margin-bottom: 0 !important; /* Ensure no extra margin */
        }
		.section6 {
			padding: 10px 10px;	
			margin-top: 5px;
		}
		.heading{
			background-color: #007bff;
            color: white;
            text-transform: uppercase;
		}
		/* Adjust the button size */
		button {
			padding: 10px 20px;  /* Decrease the vertical padding */
			font-size: 0.9 rem;   /* Reduce the font size */
		}
    </style>
</head>
<body>
    <div class="container-fluid">
        <!-- Part 1 -->
        <div class="row bg-primary text-white py-5 style="background-color: black;">
            <div class="col">
                <h1 class="glowing-text">Department Of Information Technology</h1>
            </div>
        </div>

        <!-- Part 2 -->
        <div class="row bg-dark py-2">
			<div class="col-12">
				<div class="d-flex justify-content-center button-container"> <!-- Increased gap to 5 -->
					<a href="Main.PHP" class="btn btn-danger ms-2">
						<i class="fas fa-home"></i> Home
					</a>
					<a href="InformaTrix.PHP" class="btn btn-danger ms-2">
						<i class="fas fa-info-circle"></i> InformaTrix
					</a>
					<a href="Idcc.PHP" class="btn btn-danger ms-2">
						<i class="fas fa-id-card"></i> IDCC
					</a>
					<a href="Gnome.PHP" class="btn btn-danger ms-2">
						<i class="fas fa-globe"></i> GNOME
					</a>
					<a href="#contact-us-section" class="btn btn-danger ms-2">
						<i class="fas fa-envelope"></i> Contact
					</a>
				</div>
			</div>
		</div>


        <!-- Part 3 -->
        <div class="row bg-light text-center">
            <div class="col p-0">
                <img src="Anime_GNOME.gif" alt="Descriptive Text" class="img-fluid w-100">
            </div>
        </div>

        <!-- Part 4 -->
        <div class="row bg-light text-center py-0">
            <div class="col">
                <h1 id = "H1"><span style="font-weight: bold;font-size: 120px;">V</span>ision & <span style="font-weight: bold;font-size: 120px;">M</span>ission</h1>
				<p class = "clubdesc">RVR & JC GNOME CLUB is a IT student's activity session. This Club conducts various events like CodeObfucation contest, Debugging contest,etc.. for the students of the department and college.</p>
				<div class="image-buttons">
					<img src="GNOME_Prelims.png" alt="Button 1" onclick="location.href='GNOME_student_login.PHP'" style="cursor: pointer;">
					<img src="GNOME_Mains.png" alt="Button 2" onclick="location.href='Compiler.php'" style="cursor: pointer;">
				</div>
            </div>
        </div>
        <div class="row bg-light text-center py-5" id="contact-us-section">
            <div class="col">
				<h1 id = "H1" ><span style="font-weight: bold;font-size: 120px;">C</span>ontact us</h1>
				<h1 style="text-align:center;margin-top: 50px;margin-bottom:30px;">Staff Executive Body</h1>
				<table class="modern-table">
					<thead>
						<tr>
							<th>Staff</th>
							<th>Designation</th>
							<th>Email</th>
							<th>Phone</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td>Dr.A.SriKrishna</td>
							<td>Chairman</td>
							<td>ask@rvrjc.ac.in</td>
							<td>Ext: 350</td>
						</tr>
						<tr>
							<td>Dr.B.Hemantha Kumar</td>
							<td>Executive Secretary</td>
							<td>bhkumar @ rvrjc.ac.in</td>
							<td>Ext: 267</td>
						</tr>
						<tr>
							<td>Sri G.Srinivasa Rao</td>
							<td>Secretary</td>
							<td>gsrao @ rvrjc.ac.in</td>
							<td>Ext: 351</td>
						</tr>
						<tr>
							<td>Sri B.Venkateswarlu</td>
							<td>Joint Secretary</td>
							<td>bvlu @ rvrjc.ac.in</td>
							<td>Ext : 355</td>
						</tr>
						<tr>
							<td>Sri M.V.Bhujanga Rao</td>
							<td>Teacher Member</td>
							<td>bujji @ rvrjc.ac.in</td>
							<td>Ext : 351</td>
						</tr>
						<tr>
							<td>Dr. A.Yaswanth Kumar</td>
							<td>Teacher Member</td>
							<td>aykumar @ rvrjc.ac.in</td>
							<td>Ext : 351</td>
						</tr>
						<tr>
							<td>Dr. Bh.Krishna Mohan</td>
							<td>Teacher Member</td>
							<td>bkrishnamohan @ rvrjc.ac.in</td>
							<td>Ext : 351</td>
						</tr>
						<tr>
							<td>Smt. K.Chandana</td>
							<td>Teacher Member</td>
							<td>chandanakotha@gmail.com</td>
							<td>Ext : 351</td>
						</tr>
					</tbody>
				</table>
				<h1 style="text-align:center;margin-top:50px;margin-bottom:30px;">Student Executive Body</h1>
				<table class="modern-table">
					<thead>
						<tr>
							<th>Student</th>
							<th>Designation</th>
							<th>Email</th>
							<th>Regd No</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<td>K.Vamsi Sashank</td>
							<td>Student Executive Secretary</td>
							<td>y19it049@rvrjc.ac.in</td>
							<td>Y19IT049</td>
						</tr>
						<tr>
							<td>Sk.Imran</td>
							<td>Student Ogranizing Secretary</td>
							<td>y19it100@rvrjc.ac.in</td>
							<td>Y19IT100</td>
						</tr>
						<tr>
							<td>G.S.S.Prasanth Kumar</td>
							<td>Student Secretary</td>
							<td>y19it029@rvrjc.ac.in</td>
							<td>Y19IT029</td>
						</tr>
						<tr>
							<td>T.Mallikarjuna</td>
							<td>Student Joint Secretary</td>
							<td>y19it116@rvrjc.ac.in</td>
							<td>Y19IT116</td>
						</tr>
						<tr>
							<td>K.yamuna Parvathi</td>
							<td>Student Member</td>
							<td>l20it133@rvrjc.ac.in</td>
							<td>L22IT133</td>
						</tr>
						<tr>
							<td>A.Bhargav</td>
							<td>Student Member</td>
							<td>y19it002@rvrjc.ac.in</td>
							<td>Y19IT002</td>
						</tr>
						<tr>
							<td>B.Gruha Lakshmi</td>
							<td>Student Member</td>
							<td>y19it009@rvrjc.ac.in</td>
							<td>Y19IT009</td>
						</tr>
						<tr>
							<td>C.Santhoshi</td>
							<td>Student Member</td>
							<td>y19it013@rvrjc.ac.in</td>
							<td>Y19IT013</td>
						</tr>
						<tr>
							<td>C.Mounika</td>
							<td>Student Member</td>
							<td>y19it021@rvrjc.ac.in</td>
							<td>Y19IT021</td>
						</tr>
						<tr>
							<td>D.Akhil</td>
							<td>Student Member</td>
							<td>y19it024@rvrjc.ac.in</td>
							<td>Y19IT024</td>
						</tr>
						<tr>
							<td>K.Priyanka</td>
							<td>Student Member</td>
							<td>y19it046@rvrjc.ac.in</td>
							<td>Y19IT046</td>
						</tr>
						<tr>
							<td>K.Bharath</td>
							<td>Student Member</td>
							<td>y19it056@rvrjc.ac.in</td>
							<td>Y19IT056</td>
						</tr>
						<tr>
							<td>K.Sai Krishna</td>
							<td>Student Member</td>
							<td>y19it059@rvrjc.ac.in</td>
							<td>Y19IT059</td>
						</tr>
						<tr>
							<td>P.Vasantha sai</td>
							<td>Student Member</td>
							<td>y19it088@rvrjc.ac.in</td>
							<td>Y19IT088</td>
						</tr>
						<tr>
							<td>M.Hema Sudha Varshini</td>
							<td>Student Member</td>
							<td>y19it066@rvrjc.ac.in</td>
							<td>Y19IT066</td>
						</tr>
						<tr>
							<td>N.Tahgore Bala Channakya</td>
							<td>Student Member</td>
							<td>y19it081@rvrjc.ac.in</td>
							<td>Y19IT081</td>
						</tr>
						<tr>
							<td>Shaik.Hajjnni</td>
							<td>Student Member</td>
							<td>y19it099@rvrjc.ac.in</td>
							<td>Y19IT099</td>
						</tr>
						<tr>
							<td>Muppalla.Bhanu Prakash</td>
							<td>Student Member</td>
							<td>y19it076@rvrjc.ac.in</td>
							<td>Y19IT076</td>
						</tr>
						<tr>
							<td>Nada.Daisy Ludia</td>
							<td>Student Member</td>
							<td>y19it078@rvrjc.ac.in</td>
							<td>Y19IT078</td>
						</tr>
						<tr>
							<td>Nasaka.Sai Ram</td>
							<td>Student Member</td>
							<td>y19it082@rvrjc.ac.in</td>
							<td>Y19IT082</td>
						</tr>
						<tr>
							<td>Santhi.Gangolu</td>
							<td>Student Member</td>
							<td>y19it097@rvrjc.ac.in</td>
							<td>Y19IT097</td>
						</tr>
					</tbody>
				</table>
            </div>
        </div>
		<!-- part 6-->
        <div class="section6" style="background-color: #228B22;">
			<h3 style="text-align:center; color: white;">
				&copy; 2025 Department Of IT, RVR & JC CoE. 
				<button style="margin-left: 10px; padding: 0px 10px; background-color: #FF2400; color: white; border: none; border-radius: 10px; cursor: pointer;" onclick="window.location.href='siteCredits.PHP'">
					Site Credits
				</button>
			</h3>
		</div>
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>