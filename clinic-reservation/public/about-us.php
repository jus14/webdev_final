<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>About Us</title>
    <link rel="stylesheet" href="index-register.css">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background-image: url('clinic1.jpg');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            min-height: 100vh;
            display: block;
            flex-direction: column;
        }

        .navbar {
            width: 100%;
            background-color: #ffffff;
            padding: 15px 20px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            display: flex;
            justify-content: center;
        }

        .navbar a {
            text-decoration: none;
            color: #333;
            font-weight: bold;
            margin: 0 20px;
            font-size: 16px;
        }

        .navbar a:hover {
            color: #007BFF;
        }

        .content {
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 40px 20px;
            gap: 40px;
        }

        .about-box {
            background:rgba(255, 255, 255, 0.35);
            padding: 30px 40px;
            border-radius: 10px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
            max-width: 1000px;
            width: 100%;
            text-align: center;
        }

        h2 {
            color: #333;
            margin-bottom: 20px;
        }

        p {
            color: #555;
            font-size: 16px;
            line-height: 1.6;
        }

        #doctorCarousel {
            max-width: 600px;
            width: 100%;
            margin: 0 auto;
        }

        #doctorCarousel .carousel-item {
            text-align: center;
        }

        #doctorCarousel img {
            width: 150px;
            height: 150px;
            object-fit: cover;
            border-radius: 50%;
            margin: 0 auto;
        }

        #doctorCarousel h5 {
            margin-top: 15px;
            color: #333;
        }

        #doctorCarousel p {
            color: #777;
            font-style: italic;
        }
    </style>
</head>
<body>

    <div class="navbar">
        <a href="index.php">Login</a>
        <a href="contact-us.php">Contact Us</a>
    </div>

    <div class="content">
        <div class="about-box">
            <h2>About Our Clinic</h2>
            <p>
                Welcome to MALPRACTICE <br>
                    Here at MALPRACTICE, we pride ourselves on being your last resort 
                    and first mistake in health and wellness. <br>
                    Our team of loosely credentialed individuals is passionately committed to 
                    delivering care that is bold, erratic, and occasionally helpful. <br>
                    Whether you're dropping by for a routine check-up, a mysterious growth you’ve named “Carl”, 
                    or just looking for someone to agree that WebMD was probably right — we’re here for you. Ish. <br><br>

                    We offer a wide range of services including: <br>

                        - General consultations (conducted mostly via vibes) <br>

                        - Specialized care (if you count duct-taping your leg as “orthopedic”) <br>

                        - And state-of-the-art medical equipment that mostly works and only occasionally catches fire. <br>

                    Step into our clinic, where the scent of lavender tries to mask the tension, 
                    the staff may or may not be wearing real pants, and every day is an experiment in trust. 
                    MALPRACTICE — your health is in our hands. Literally. No refunds.


            </p>
        </div>

        <div id="doctorCarousel" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img src="Dr. Chong M. Dong.jpg" alt="Dr. Chong M. Dong">
                    <h5>Dr. Chong M. Dong</h5>
                    <p>Urologist</p>
                </div>
                <div class="carousel-item">
                    <img src="Dr. Willie Fingerman.jpg" alt="Dr. Willie Fingerman">
                    <h5>Dr. Willie Fingerman</h5>
                    <p>Urologist</p>
                </div>
                <div class="carousel-item">
                    <img src="Dr. I.C Notting.jpg" alt="Dr. I.C Notting">
                    <h5>Dr. I.C Notting</h5>
                    <p>Opthalmologist</p>
                </div>
                <div class="carousel-item">
                    <img src="Dr. John Bonebreak.jpg" alt="Dr. John Bonebreak">
                    <h5>Dr. John Bonebreak</h5>
                    <p>Chiropractor</p>
                </div>
            </div>

            <button class="carousel-control-prev" type="button" data-bs-target="#doctorCarousel" data-bs-slide="prev">
                <span class="carousel-control-prev-icon"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#doctorCarousel" data-bs-slide="next">
                <span class="carousel-control-next-icon"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>
    </div>

    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>