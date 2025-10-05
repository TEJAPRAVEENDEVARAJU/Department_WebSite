<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>6 Vertical Sections</title>
    
    
<style>
  :root {
    --primary: #FF2400;
    --secondary: #84dcc6;
    --bg-light: #ffffff;
    --bg-dark: #121212;
    --text-light: #000000;
    --text-dark: #ffffff;
  }

  body {
    margin: 0;
    display: flex;
    flex-direction: column;
    min-height: 100vh;
    font-family: Arial, sans-serif;
    background-color: var(--bg-light);
    color: var(--text-light);
    transition: background-color 0.3s ease, color 0.3s ease;
  }

  body.dark-mode {
    background-color: var(--bg-dark);
    color: var(--text-dark);
  }

  /* General sections */
  .section {
    flex: 1;
    border: 1px solid #ccc;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
    padding: 10px;
  }

  .section:nth-child(odd) {
    background-color: #f0f0f0;
  }

  body.dark-mode .section:nth-child(odd),
  body.dark-mode .section:nth-child(even) {
    background-color: #1e1e1e;
  }

  /* Top navigation buttons */
  .dashboard-buttons {
    display: flex;
    justify-content: center;
    flex-wrap: wrap;
    gap: 25px;                 /* spacing between buttons */
    position: absolute;
    top: 10%;
    left: 50%;
    transform: translateX(-50%);
    z-index: 1;
  }

  .dashboard-buttons button {
    padding: 12px 24px;
    border: none;
    background-color: var(--primary);
    color: white;
    font-size: 16px;
    cursor: pointer;
    border-radius: 6px;
    transition: all 0.3s ease-in-out;
  }

  .dashboard-buttons button:hover {
    background-color: var(--secondary);
    transform: scale(1.08);
  }

  .dark-mode .dashboard-buttons button {
    background-color: #bb86fc;
    color: #121212;
  }

  /* Section 3 (header image & overlay text) */
  .section3 {
    position: relative;
    width: 100%;
  }

  .section3 {
    position: relative;
    width: 100%;
    text-align: center; /* centers overlay text */
}

.section3 img {
    width: 100%;
    height: auto;
    max-height: 500px;
    object-fit: cover;
    display: block;
}

/* Overlay Text stays centered on image */
.overlay-text {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    font-family: sans-serif;
    color: white;
    font-size: clamp(2rem, 6vw, 5rem);
    font-weight: 900;
    text-shadow: 3px 3px 10px rgba(0,0,0,0.7);
    text-align: center;
    width: 90%;
}

/* Dashboard Buttons always below the image */
.dashboard-buttons {
    display: flex;
    flex-wrap: wrap;    /* wraps buttons on smaller screens */
    justify-content: center;
    gap: 15px;
    margin-top: 20px;   /* spacing below image */
    z-index: 1;
}

.dashboard-buttons button {
    padding: 12px 24px;
    border: none;
    background-color: #FF2400;
    color: white;
    font-size: 16px;
    cursor: pointer;
    border-radius: 6px;
    transition: all 0.3s ease-in-out;
}

.dashboard-buttons button:hover {
    background-color: #84dcc6;
    color: white;
    transform: scale(1.08);
}

/* Mobile responsive adjustments */
@media (max-width: 768px) {
    .overlay-text {
        font-size: clamp(1.5rem, 5vw, 3rem);
    }
    .dashboard-buttons button {
        padding: 10px 15px;
        font-size: 14px;
    }
}

@media (max-width: 480px) {
    .overlay-text {
        font-size: clamp(1.2rem, 4vw, 2rem);
    }
    .dashboard-buttons button {
        padding: 8px 12px;
        font-size: 12px;
    }
}


  .highlight {
    color: var(--primary);
  }

  /* Section 4 */
  .section4 {
    background-color: var(--bg-light);
    text-align: center;
    padding: 20px;
  }

  body.dark-mode .section4 {
    background-color: #1e1e1e;
  }

  .clubdesc {
    font-size: 1rem;
    text-align: justify;
    width: 90%;
    margin: 0 auto 30px;
  }

  /* Club images */
  .image-buttons {
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
    gap: 40px;
    margin-top: 20px;
  }

  .image-buttons img {
    width: 350px;
    height: 350px;
    border-radius: 12px;
    box-shadow: 0 5px 10px rgba(0, 0, 0, 0.25);
    cursor: pointer;
    transition: all 0.3s ease-in-out;
  }

  .image-buttons img:hover {
    transform: scale(1.12);
    box-shadow: 0 10px 15px rgba(0, 0, 0, 0.35);
  }

  /* Section 5 (contact box) */
  .section5 {
    text-align: center;
    padding: 20px;
  }

  .contact-box {
    display: flex;
    justify-content: space-between;
    align-items: center;
    border-radius: 20px;
    padding: 20px;
    width: 70%;
    margin: 0 auto;
    background-color: #e3f2fd;
    border: 2px solid #64b5f6;
    color: #0d47a1;
  }

  body.dark-mode .contact-box {
    background-color: #2a2a2a;
    border-color: #444;
    color: #fff;
  }

  .contact-box img {
    max-width: 250px;
    height: auto;
    border-radius: 10px;
  }

  /* Modern tables */
  .modern-table-container {
    width: 100%;
    margin-top: 40px;
    overflow-x: auto;
  }

  .modern-table {
    width: 100%;
    border-collapse: collapse;
    font-family: Arial, sans-serif;
    margin: 0 auto;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
  }

  .modern-table thead {
    background-color: #f0f0f0;
  }

  .modern-table th,
  .modern-table td {
    padding: 10px;
    text-align: left;
    border: 1px solid #ddd;
  }

  .modern-table tr:nth-child(even) {
    background-color: #f9f9f9;
  }

  .modern-table tr:hover {
    background-color: #f1f1f1;
    transition: background-color 0.3s ease;
  }

  body.dark-mode .modern-table thead {
    background-color: #333;
    color: #fff;
  }

  body.dark-mode .modern-table tr:nth-child(even) {
    background-color: #2a2a2a;
  }

  /* Section 6 (footer) */
  .section6 {
    background-color: #228B22;
    text-align: center;
    padding: 15px;
    color: white;
  }

  .dark-mode .section6 {
    background-color: #333;
  }

  /* Titles */
  #H1,
  #irshi {
    font-size: 2.5rem;
    text-align: center;
    text-decoration: underline;
    text-decoration-color: red;
    text-decoration-thickness: 3px;
    text-underline-offset: 10px;
    margin: 20px 0;
  }

  /* Site Credits button */
  .section6 button {
    margin-left: 20px;
    padding: 10px 15px;
    background-color: var(--primary);
    color: white;
    border: none;
    border-radius: 8px;
    cursor: pointer;
    font-size: 1rem;
    transition: all 0.3s ease-in-out;
  }

  .section6 button:hover {
    background-color: #ff6347;
    transform: scale(1.05);
  }

  /* Dark mode toggle */
  .toggle-dark {
    position: fixed;
    top: 15px;
    right: 15px;
    background: var(--primary);
    border: none;
    color: white;
    padding: 10px 15px;
    border-radius: 5px;
    cursor: pointer;
    z-index: 999;
  }
 
  /* Existing styles here ... (as before) */

  /* Responsive / Mobile */
  @media (max-width: 1024px) {
    .dashboard-buttons {
      gap: 15px;
      top: 12%;
    }

    .image-buttons img {
      width: 280px;
      height: 280px;
    }

    #H1, #irshi {
      font-size: 2rem;
    }

    .contact-box {
      width: 85%;
      flex-direction: column;
      text-align: center;
      gap: 20px;
    }

    .contact-box img {
      max-width: 200px;
    }
  }

  @media (max-width: 768px) {
    .dashboard-buttons {
      flex-direction: column;
      top: 15%;
      gap: 12px;
    }

    .image-buttons img {
      width: 220px;
      height: 220px;
    }

    #H1, #irshi {
      font-size: 1.8rem;
    }

    .section3 .overlay-text {
      font-size: clamp(1.5rem, 10vw, 4rem);
    }
  }

  @media (max-width: 480px) {
    .image-buttons img {
      width: 180px;
      height: 180px;
    }

    .dashboard-buttons button {
      padding: 10px 18px;
      font-size: 14px;
    }

    #H1, #irshi {
      font-size: 1.5rem;
    }

    .section3 .overlay-text {
      font-size: clamp(1rem, 12vw, 3rem);
    }

    .contact-box {
      width: 95%;
      padding: 15px;
    }
  }



</style>




     
    
</head>
<body>
       <!-- Dark Mode Button -->
<!-- Dark Mode Toggle -->
<button class="toggle-dark" id="darkModeToggle">🌙 Dark Mode</button>

    <!-- Section 1 -->
    <div class="section section1">
        <img src="headerimage.jpg" alt="R.V.R & J.C College Of Engineering">
    </div>

    <!-- Section 2 -->
    <div class="section" style="width:100%; background-color: lightblue;">
    </div>

   <div class="section3">
    <img src="hitech.jpg" alt="HITECH">
    
    <!-- Overlay Text -->
    <div class="overlay-text">
        <span class="highlight">I</span>nformation <span class="highlight">T</span>echnology
    </div>
    
    <!-- Dashboard Buttons -->
    <div class="dashboard-buttons">
        <button onclick="location.href='index.php'">Home</button>
        <button onclick="location.href='admin_panel.php'">Admin</button>
        <button onclick="location.href='InformaTrix.php'">InformaTrix</button>
        <button onclick="location.href='Idcc.php'">IDCC</button>
        <button onclick="location.href='GNOME.php'">GNOME</button>
        <button onclick="location.href='#meet-us'">Contact</button>
    </div>
</div>


    <!-- Section 4 -->
    <div class="section4">
        <h1 id="H1">Student Initiated Technical Clubs</h1>
        <p class="clubdesc">
            The Student Initiated Technical Clubs aims to promote creativity and to increase the technical knowledge-how and productivity of all the students of the department of Information Technology. It achieves this by conducting various interactive coding contests conducted by the numerous technical clubs under it. These clubs even offer the opportunity to participate in the CODE VITA conducted by TCS and other reputed companies.
        </p>
        
        <div class="image-buttons">
            <img src="infomatrix.jpg" alt="InformaTrix"onclick="location.href='InformaTrix.php'">
            <img src="idcc.jpg" alt="IDCC" onclick="location.href='Idcc.php'">
            <img src="gnome.jpg" alt="GNOME" onclick="location.href='GNOME.php'">
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
                <div class="contact-item">&#9742; +91 9491073318</div>
                <div class="contact-item">&#9993; ask@rvrjc.ac.in</div>
            </div>
            <img src="hod.png" alt="Profile Picture">
        </div>
    </div>

    <!-- Tables -->
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
                <tr><td>Dr.A.SriKrishna</td><td>Chairman</td><td>ask@rvrjc.ac.in</td><td>Ext: 350</td></tr>
                <tr><td>Dr.M.Pompapathi</td><td>Executive Secretary</td><td>mp@rvrjc.ac.in</td><td>Ext: 354</td></tr>
                <tr><td>Smt. N.Neelima</td><td>Secretary</td><td>nn@rvrjc.ac.in</td><td>Ext: 351</td></tr>
                <tr><td>Sri V.Venkata Srinivas</td><td>Joint Secretary</td><td>vvsv@rvrjc.ac.in</td><td>Ext : 351</td></tr>
                <tr><td>Dr. G.Swetha</td><td>Teacher Member</td><td>gswetha@rvrjc.ac.in</td><td>Ext : 351</td></tr>
                <tr><td>Smt.I.Naga Padmaja</td><td>Teacher Member</td><td>inp@rvrjc.ac.in</td><td>Ext : 351</td></tr>
            </tbody>
        </table>

        <h1 style="text-align:center;">Club IDCC</h1>
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
                <tr><td>Dr.A.SriKrishna</td><td>Chairman</td><td>ask@rvrjc.ac.in</td><td>Ext: 350</td></tr>
                <tr><td>Dr.V.Sesha Srinivas</td><td>Executive Secretary</td><td>vss@rvrjc.ac.in</td><td>Ext: 354</td></tr>
                <tr><td>Smt. N.Neelima</td><td>Secretary</td><td>nn@rvrjc.ac.in</td><td>Ext: 351</td></tr>
                <tr><td>Sri B.Satish Babu</td><td>Teacher Member</td><td>bsb@rvrjc.ac.in</td><td>Ext : 351</td></tr>
                <tr><td>Smt B.Manasa</td><td>Teacher Member</td><td>manasa@rvrjc.ac.in</td><td>Ext : 351</td></tr>
            </tbody>
        </table>

        <h1 style="text-align:center;">Club GNOME</h1>
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
                <tr><td>Dr.A.SriKrishna</td><td>Chairman</td><td>ask@rvrjc.ac.in</td><td>Ext: 350</td></tr>
                <tr><td>Dr.B.Hemantha Kumar</td><td>Executive Secretary</td><td>bhkumar@rvrjc.ac.in</td><td>Ext: 267</td></tr>
                <tr><td>Sri G.Srinivasa Rao</td><td>Secretary</td><td>gsrao@rvrjc.ac.in</td><td>Ext: 351</td></tr>
                <tr><td>Sri B.Venkateswarlu</td><td>Joint Secretary</td><td>bvlu@rvrjc.ac.in</td><td>Ext : 355</td></tr>
                <tr><td>Sri M.V.Bhujanga Rao</td><td>Teacher Member</td><td>bujji@rvrjc.ac.in</td><td>Ext : 351</td></tr>
                <tr><td>Dr. A.Yaswanth Kumar</td><td>Teacher Member</td><td>aykumar@rvrjc.ac.in</td><td>Ext : 351</td></tr>
                <tr><td>Dr. Bh.Krishna Mohan</td><td>Teacher Member</td><td>bkrishnamohan@rvrjc.ac.in</td><td>Ext : 351</td></tr>
                <tr><td>Smt. K.Chandana</td><td>Teacher Member</td><td>chandanakotha@gmail.com</td><td>Ext : 351</td></tr>
            </tbody>
        </table>
    </div>
<br/>
    <!-- Section 6 -->
    <div class="section6" style="background-color: #228B22;">
        <h3 style="text-align:center; color: white;">
            &copy; 2025 Department Of IT, RVR & JC CoE. 
            <button style="margin-left: 10px; padding: 5px 10px; background-color: #FF2400; color: white; border: none; border-radius: 5px; cursor: pointer;" onclick="window.location.href='siteCredits.php'">
                Site Credits
            </button>
        </h3>
    </div>
    <script>
  const toggleBtn = document.getElementById('darkModeToggle');
  const body = document.body;

  // Check localStorage for previous theme
  if(localStorage.getItem('theme') === 'dark'){
    body.classList.add('dark-mode');
    toggleBtn.textContent = '☀️ Light Mode';
  }

  toggleBtn.addEventListener('click', () => {
    body.classList.toggle('dark-mode');

    // Update button text
    if(body.classList.contains('dark-mode')){
      toggleBtn.textContent = '☀️ Light Mode';
      localStorage.setItem('theme', 'dark');
    } else {
      toggleBtn.textContent = '🌙 Dark Mode';
      localStorage.setItem('theme', 'light');
    }
  });
</script>

</body>
</html>
