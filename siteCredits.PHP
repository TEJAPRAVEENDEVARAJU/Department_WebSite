<html>
	<head>
		<style>
			/* Body Background Gradient */
			body {
				background: linear-gradient(135deg, #ff6ec7, #f9ff6e, #6effb8, #6e9eff, #c96eff);
				background-size: 500% 500%;
				animation: gradientAnimation 8s ease infinite;
				margin: 0;
				font-family: Arial, sans-serif;
				color: #333;
			}

			@keyframes gradientAnimation {
				0% { background-position: 0% 50%; }
				50% { background-position: 100% 50%; }
				100% { background-position: 0% 50%; }
			}

			/* Section Styling */
			.section5 {
				text-align: center;
				padding: 20px;
				color: #ffffff;
			}

			/* Contact Box Styling */
			.contact-box1{
				display: flex;
				justify-content: space-between;
				align-items: center;
				border-radius: 20px;
				padding: 20px;
				width: 80%;
				margin: 50px auto;
				box-shadow: 0 6px 12px rgba(0, 0, 0, 0.4);
				background: linear-gradient(135deg, #6effb8, #6e9eff);
				color: #ffffff;
				border: 2px solid #ffffff;
				transition: transform 0.3s ease, box-shadow 0.3s ease;
			}
			.contact-box2{
				display: flex;
				justify-content: space-between;
				align-items: center;
				border-radius: 20px;
				padding: 20px;
				width: 80%;
				margin: 50px auto;
				box-shadow: 0 6px 12px rgba(0, 0, 0, 0.4);
				background: linear-gradient(135deg, #6effb8, #6e9eff);
				color: #ffffff;
				border: 2px solid #ffffff;
				transition: transform 0.3s ease, box-shadow 0.3s ease;
			}
			.contact-box1:hover {
				transform: scale(1.05);
				box-shadow: 0 10px 20px rgba(0, 0, 0, 0.5);
			}
			.contact-box2:hover {
				transform: scale(1.05);
				box-shadow: 0 10px 20px rgba(0, 0, 0, 0.5);
			}
			.contact-box1 .text-content {
				flex: 1;
				text-align: left;
				margin-right: 20px;
			}
			.contact-box2 .text-content {
				flex: 1;
				text-align: left;
				margin-right: 20px;
			}
			.contact-box1 img {
				height: 300px;
				width: auto;
				border-radius: 50px;
				object-fit: cover;
				box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
			}
			.contact-box2 img {
				height: 300px;
				width: auto;
				border-radius: 270px;
				object-fit: cover;
				box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
			}
			/* Header Styling */
			#irshi {
				font-size: 4.5rem;
				text-align: center;
				margin-top: 0;
				margin-bottom: 30px;
				color: #ff6ec7;
				text-shadow: 3px 3px 6px rgba(0, 0, 0, 0.4);
				background: linear-gradient(to right, #ff6ec7, #f9ff6e, #6e9eff);
				-webkit-background-clip: text;
				-webkit-text-fill-color: transparent;
			}

			/* Contact Items Styling */
			.contact-item {
				font-size: 1.2rem;
				margin-top: 10px;
				display: flex;
				align-items: center;
				gap: 10px;
			}

			.contact-item svg {
				fill: #ffffff;
			}
		</style>
	</head>
	<body>
	<nav class="navbar navbar-light bg-light">
        <div class="container-fluid">
            <a href="Main.php" class="btn btn-primary">Home</a>
        </div>
    </nav>
		<div id="meet-us" class="section5">
			<h1 id="irshi">Designed & Developed By</h1>
			<div class="contact-box1">
				<div class="text-content">
					<h3>Shaik Mahammad Irshad</h3>
					<p>Regd.No Y21IT113</p>
					<p>Class Of 2025</p>
					<p>Department Of Information Technology</p>
					<p>R.V.R & J.C College Of Engineering</p>
					<div class="contact-item">
						&#9742; +91 7702053936
					</div>
					<div class="contact-item">
						&#9993; shaikirshad1020@gmail.com
					</div>
				</div>
				<img src="Irshad.png" alt="Profile Picture">
			</div>
			<div class="contact-box2">
				<div class="text-content">
					<h3>Obulasetty Teja Praveen Deva Raju</h3>
					<p>Regd.No L22IT140</p>
					<p>Class Of 2025</p>
					<p>Department Of Information Technology</p>
					<p>R.V.R & J.C College Of Engineering</p>
					<div class="contact-item">
						&#9742; +91 7981715576
					</div>
					<div class="contact-item">
						&#9993; tejapraveen2003@gmail.com
					</div>
				</div>
				<img src="DevRaj.jpg" alt="Profile Picture">
			</div>
		</div>
	</body>
</html>
