<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us - Book Haven</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        /* Banner Section */
        .contact-banner {
            background: url('https://img.freepik.com/free-photo/teenage-student-reading-book-leaning-shelf_23-2148204270.jpg?t=st=1742735666~exp=1742739266~hmac=13c93bdc4ff82e850f49c0cb093f5c6dbeada529196a20ab4d2bf0e677061e05&w=1380') no-repeat center center/cover;
            height: 350px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 2.5rem;
            font-weight: bold;
            text-shadow: 3px 3px 6px rgba(0, 0, 0, 0.6);
            text-align: center;
            padding: 20px;
        }

        @media (max-width: 768px) {
            .contact-banner {
                font-size: 1.8rem;
                height: 250px;
            }
        }

        /* Contact Section */
        .contact-section {
            padding: 60px 15px;
            background-color: #f8f9fa;
        }

        .contact-form {
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .contact-form .form-group label {
            font-weight: bold;
        }

        .contact-form .btn {
            background-color: #007bff;
            border: none;
            padding: 12px;
            font-size: 18px;
            border-radius: 5px;
        }

        .contact-form .btn:hover {
            background-color: #0056b3;
        }

        /* Contact Info */
        .contact-info {
            font-size: 1.2rem;
            padding: 20px;
            background: white;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .contact-info i {
            font-size: 24px;
            margin-right: 10px;
            color: #007bff;
        }

        /* Social Icons */
        .social-icons a {
            font-size: 1.5rem;
            margin: 10px;
            color: #007bff;
            transition: 0.3s ease;
        }

        .social-icons a:hover {
            color: #0056b3;
            transform: scale(1.2);
        }

        /* Google Map */
        .map-container {
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>

<body>

    <!-- Hero Section -->
    <section class="contact-banner">
        Contact Us
    </section>

    <div class="container contact-section">
        <div class="row">
            <!-- Contact Form -->
            <div class="col-lg-6 col-md-12">
                <h2 class="mb-4">Get in Touch</h2>
                <div class="contact-form">
                    <form>
                        <div class="form-group">
                            <label for="name">Full Name</label>
                            <input type="text" class="form-control" id="name" placeholder="Enter your name" required>
                        </div>
                        <div class="form-group">
                            <label for="email">Email Address</label>
                            <input type="email" class="form-control" id="email" placeholder="Enter your email" required>
                        </div>
                        <div class="form-group">
                            <label for="message">Your Message</label>
                            <textarea class="form-control" id="message" rows="5" placeholder="Write your message here" required></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary btn-block">Send Message</button>
                    </form>
                </div>
            </div>

            <!-- Contact Info -->
            <div class="col-lg-6 col-md-12 mt-5 mt-lg-0">
                <h2 class="mb-4">Contact Information</h2>
                <div class="contact-info">
                    <p><i class="fas fa-map-marker-alt"></i> 123 Book Street, Literature City, USA</p>
                    <p><i class="fas fa-phone-alt"></i> +1 (123) 456-7890</p>
                    <p><i class="fas fa-envelope"></i> contact@bookhaven.com</p>
                    <p><i class="far fa-clock"></i> Mon - Sat: 9 AM - 8 PM | Sun: Closed</p>

                    <!-- Social Media -->
                    <h4 class="mt-4">Follow Us</h4>
                    <div class="social-icons">
                        <a href="#" target="_blank"><i class="fab fa-facebook"></i></a>
                        <a href="#" target="_blank"><i class="fab fa-twitter"></i></a>
                        <a href="#" target="_blank"><i class="fab fa-instagram"></i></a>
                        <a href="#" target="_blank"><i class="fab fa-linkedin"></i></a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Google Map -->
        <hr class="my-5">
        <h2 class="text-center mb-4">Find Us Here</h2>
        <div class="row justify-content-center">
            <div class="col-lg-10 map-container">
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3151.8354345084396!2d144.96305771531672!3d-37.81627997975171!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x6ad642af0f11fd81%3A0xf577ad41e9bbcfb9!2sBook%20Haven!5e0!3m2!1sen!2sus!4v1633999141071!5m2!1sen!2sus"
                    width="100%" height="400" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
            </div>
        </div>
    </div>

</body>

</html>