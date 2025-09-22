<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>6 Vertical Sections</title>
    <style>
        body {
            margin: 0;
            display: flex;
            flex-direction: column;
            height: 100vh;
        }

        .section {
            flex: 1;
            border: 1px solid #ccc; /* Optional: To visually separate sections */
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
        }

        .section:nth-child(odd) {
            background-color: #f0f0f0; /* Alternating colors for better visualization */
        }

        .section:nth-child(even) {
            background-color: #e0e0e0;
        }

        .dashboard-buttons {
            display: flex;
            justify-content: center;
            gap: 150px; /* Spacing between buttons */
            position: absolute;
            top: 10%; /* Position buttons near the top of the image */
            left: 50%;
            transform: translateX(-50%);
            z-index: 1; /* Ensure buttons are above the image */
        }

        .dashboard-buttons button {
            padding: 10px 20px;
            border: none;
            background-color: #FF2400; /* Red */
            color: white;
            font-size: 16px;
            cursor: pointer;
            border-radius: 5px;
        }
		.dashboard-buttons button:hover {
			background-color: #84dcc6; /* Slightly darker red */
			color: white;
			transform: scale(1.05); /* Slight zoom effect */
			transition: all 0.3s ease-in-out;
		}

		/* Hover effect for the Site Credits button */
		button[onclick="siteCredits()"]:hover {
			background-color: #ffa69e; /* Slightly darker red */
			color: white;
			transform: scale(1.05); /* Slight zoom effect */
			transition: all 0.3s ease-in-out;
		}
        .section3 {
            position: relative;
            width: 100%;
        }

        .section3 img {
            width: 100%; /* Makes the image span the full width */
            height: auto; /* Maintains aspect ratio */
        }

        .overlay-text {
            position: absolute;
            font-family: "sans-serif";
            top: 40%; /* Adjusted position to move text slightly higher */
            left: 50%;
            transform: translate(-50%, -40%);
            color: white;
            font-size: 10rem; /* Increased font size */
            font-weight: 900; /* Extra bold font */
            text-shadow: 3px 3px 10px rgba(0, 0, 0, 0.7);
            text-align: center;
            letter-spacing: 0px; /* Added spacing between letters */
        }

        .highlight {
            color: #FF2400; /* Apply red color */
        }

        .section4 {
			background-color:#ffffff
            text-align: center;
            padding: 20px;
        }
        #H1 {
            font-size: 5rem;
            text-align: center;
            text-decoration: underline;
            text-decoration-color: red;
            text-decoration-thickness: 3px;
            text-underline-offset: 15px;
            margin-top: 0;
        }
		#irshi {
            font-size: 5rem;
            text-align: center;
            text-decoration: underline;
            text-decoration-color: red;
            text-decoration-thickness: 3px;
            text-underline-offset: 15px;
            margin-top: 0;
			margin-bottom: 20px;
        }
        h4 {
            font-size: 1.5rem;
            text-align: justify;
            width: 80%;
            margin: 0 auto;
            margin-bottom: 20px; /* Space between paragraph and buttons */
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
		h4 {
			font-size: 1.5rem;
			text-align: justify;
			font-family: Arial, sans-serif;
			width: 80%;
			margin: 0 auto;
			margin-bottom: 60px; /* Increased space between the text and image buttons */
		}
		.clubdesc {
			font-size: 1.5rem;
			text-align: justify;
			font-family: Arial, sans-serif;
			width: 80%;
			margin: 0 auto;
			margin-bottom: 60px; /* Increased space between the text and image buttons */
		}
		.section5 {
			text-align: center;
			padding: 20px;
		}
		.contact-box {
			display: flex;
			justify-content: space-between; /* Align text and image */
			align-items: center; /* Vertically align text and image */
			border-radius: 20px; /* Rounded corners */
			padding: 20px;
			width: 80%; /* Set width of the contact box */
			margin: 0 auto; /* Center the contact box */
			font-family: Arial, sans-serif;
			box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
			background-color: #e3f2fd;
			border: 2px solid #64b5f6;
			color: #0d47a1;
			margin-top: 50px;
		}

		.contact-box .text-content {
			flex: 1; /* Occupy remaining space for text */
			text-align: left; /* Align text to the left */
			margin-right: 20px; /* Add spacing between text and image */
		}

		.contact-box img {
			height: 300;
			width: auto;
			border-radius: 10px;
			object-fit: cover;
		}
		.modern-table-container {
			width: 100%; /* Full width of the parent container */
			display: block;
			padding-left: 0px; /* Add spacing from the left edge */
			margin-top: 40px; /* Space between heading and contact box */
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
    </style>
</head>
<body>
    <!-- Section 1 -->
    <div class="section section1">
        <img src="HeaderImage.png" alt="R.V.R & J.C College Of Engineering">
    </div>

    <!-- Section 2 with Horizontal Buttons -->
    <div class="section" style="width:100%; background-color: lightblue;">
    </div>

    <!-- Section 3 with Overlay Text and Buttons -->
    <div class="section3">
        <img src="HITECH.png" alt="HITECH">
        <div class="overlay-text">
            <span class="highlight">I</span>nformation <span class="highlight">T</span>echnology
        </div>
        <!-- Contact Button in Section 3 -->
		<div class="dashboard-buttons">
			<button onclick="location.href='Main.PHP'">Home</button>
            <button onclick="location.href='admin_panel.php'">Admin</button>
			<button onclick="location.href='InformaTrix.PHP'">InformaTrix</button>
			<button onclick="location.href='Idcc.PHP'">IDCC</button>
			<button onclick="location.href='GNOME.PHP'">GNOME</button>
			<button onclick="location.href='#meet-us'">Contact</button>
		</div>
    </div>
    <!-- Section 4 with Image Buttons -->
    <div class="section4">
        <h1 id = "H1">Student Initiated Technical Clubs</h1>
        <p class="clubdesc">
            The Student Initiated Technical Clubs aims to promote creativity and to increase the technical knowledge-how and productivity of all the students of the department of Information Technology. It achieves this by conducting various interactive coding contests conducted by the numerous technical clubs under it. These clubs even offer the opportunity to participate in the CODE VITA conducted by TCS and other reputed companies.
        <p>
        
        <!-- Image Buttons -->
        <div class="image-buttons">
			<img src="InformaTrix.png" alt="Button 1" onclick="location.href='InformaTrix.php'" style="cursor: pointer;">
			<img src="IDCC.png" alt="Button 2" onclick="location.href='Idcc.php'" style="cursor: pointer;">
			<img src="GNOME.png" alt="Button 3" onclick="location.href='GNOME.php'" style="cursor: pointer;">
		</div>
    </div>
	<!-- Section 5 -->
	<div id="meet-us" class="section5">
		<h1 id="irshi">Meet Us</h1>
		<div class="contact-box">
			<div class="text-content">
				<h3>Dr. A. SriKrishna</h3>
				<p>Professor & HOD</p>
				<p>Clubs Chairman</p>
				<p>Department Of Information Technology</p>
				<p>R.V.R & J.C College Of Engineering</p>
				<div class="contact-item">
					&#9742; +91 9491073318
				</div>
				<p></p>
				<div class="contact-item">
					&#9993; ask@rvrjc.ac.in
				</div>
			</div>
			<img src="HOD.jpeg" alt="Profile Picture">
		</div>
	</div>
		<div class="modern-table-container">
		<h1 style="text-align:center;">Club InformaTrix</h1>
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
                <td>Dr.M.Pompapathi</td>
                <td>Executive Secretary</td>
                <td>mp @ rvrjc.ac.in</td>
                <td>Ext: 354</td>
            </tr>
            <tr>
                <td>Smt. N.Neelima</td>
                <td>Secretary</td>
                <td>nn @ rvrjc.ac.in</td>
                <td>Ext: 351</td>
            </tr>
            <tr>
                <td>Sri V.Venkata Srinivas</td>
                <td>Joint Secretary</td>
                <td>vvsv@rvrjc.ac.in</td>
                <td>Ext : 351</td>
            </tr>
			<tr>
                <td>Dr. G.Swetha</td>
                <td>Teacher Member</td>
                <td>gswetha @ rvrjc.ac.in</td>
                <td>Ext : 351</td>
            </tr>
			<tr>
                <td>Smt.I.Naga Padmaja </td>
                <td>Teacher Member</td>
                <td>inp @ rvrjc.ac.in</td>
                <td>Ext : 351</td>
            </tr>
        </tbody>
    </table>
	<table class="modern-table">
		<h1 style="text-align:center;">Club IDCC</h1>
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
                <td>Dr.V.Sesha Srinivas</td>
                <td>Executive Secretary</td>
                <td>vss @ rvrjc.ac.in</td>
                <td>Ext: 354</td>
            </tr>
            <tr>
                <td>Smt. N.Neelima</td>
                <td>Secretary</td>
                <td>nn @ rvrjc.ac.in</td>
                <td>Ext: 351</td>
            </tr>
			<tr>
                <td>Sri B.Satish Babu</td>
                <td>Teacher Member</td>
                <td>bsb @ rvrjc.ac.in</td>
                <td>Ext : 351</td>
            </tr>
			<tr>
                <td>Smt B.Manasa</td>
                <td>Teacher Member</td>
                <td>manasa @ rvrjc.ac.in</td>
                <td>Ext : 351</td>
            </tr>
        </tbody>
    </table>
	<table class="modern-table">
		<h1 style="text-align:center;">Club GNOME</h1>
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
		</div>
	</div>


    <!-- Section 6 -->
    <div class="section6" style="background-color: #228B22;">
		<h3 style="text-align:center; color: white;">
			&copy; 2025 Department Of IT, RVR & JC CoE. 
			<button style="margin-left: 10px; padding: 5px 10px; background-color: #FF2400; color: white; border: none; border-radius: 5px; cursor: pointer;" onclick="window.location.href='siteCredits.php'">
				Site Credits
			</button>
		</h3>
	</div>
</body>
</html>