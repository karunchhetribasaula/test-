<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>My Business</title>
  <style>
    body { font-family: Arial, sans-serif; margin: 0; padding: 0; }
    header, section { padding: 60px 20px; }
    header { background: #0057b7; color: white; text-align: center; }
    nav { background: #003f87; padding: 10px 20px; }
    nav a { color: white; margin-right: 15px; text-decoration: none; }
    nav a:hover { text-decoration: underline; }

    .container { max-width: 900px; margin: auto; }
    h2 { color: #0057b7; margin-bottom: 10px; }

    form input, form textarea, form select {
        width: 100%; padding: 10px; margin-bottom: 15px; border: 1px solid #ccc;
        border-radius: 5px;
    }

    form button {
        padding: 10px 20px; background: #0057b7; color: white; border: none;
        border-radius: 5px; cursor: pointer;
    }

    .success, .error {
        padding: 10px; margin-bottom: 15px;
        border-left: 4px solid; display: none;
    }

    .success { background: #d4edda; color: #155724; border-color: #28a745; }
    .error { background: #f8d7da; color: #721c24; border-color: #dc3545; }

    footer { text-align: center; padding: 20px; background: #f0f0f0; }
  </style>
</head>
<body>

<nav class="container">
  <a href="#home">Home</a>
  <a href="#about">About</a>
  <a href="#services">Services</a>
  <a href="#contact">Contact</a>
</nav>

<header id="home">
  <div class="container">
    <h1>Welcome to My Business</h1>
    <p>We help you grow online. Affordable. Reliable. Fast.</p>
  </div>
</header>

<section id="about">
  <div class="container">
    <h2>About Us</h2>
    <p>We are a modern digital solutions company focused on web development, online marketing, and business consulting.</p>
  </div>
</section>

<section id="services" style="background:#f9f9f9;">
  <div class="container">
    <h2>Our Services</h2>
    <ul>
      <li>🌐 Web Development</li>
      <li>📈 Digital Marketing</li>
      <li>💼 Business Consulting</li>
      <li>🔧 Custom Software</li>
    </ul>
  </div>
</section>

<section id="contact">
  <div class="container">
    <h2>Contact Us</h2>

    <!-- Success/Error messages will show here -->
    <div class="success" id="formSuccess">Your message has been sent successfully.</div>
    <div class="error" id="formError">There was an error sending your message.</div>

    <form id="contactForm" action="https://api.web3forms.com/submit" method="POST">
      <!-- Your Web3Forms Access Key -->
      <input type="hidden" name="access_key" value="YOUR_WEB3FORMS_SECRET_KEY_HERE" />

      <!-- Optional: Redirect URL after submission -->
      <!-- <input type="hidden" name="redirect" value="thankyou.html"> -->

      <!-- Optional: From name/email -->
      <input type="hidden" name="from_name" value="My Business Website" />
      <input type="hidden" name="subject" value="New Contact Form Submission" />

      <input type="text" name="name" placeholder="Your Name" required>
      <input type="email" name="email" placeholder="Your Email" required>
      <input type="text" name="phone" placeholder="Phone Number (optional)">
      <select name="service">
        <option value="">Select Service</option>
        <option value="web-development">Web Development</option>
        <option value="marketing">Digital Marketing</option>
        <option value="consulting">Business Consulting</option>
        <option value="other">Other</option>
      </select>
      <textarea name="message" placeholder="Your Message" rows="5" required></textarea>
      <button type="submit">Send Message</button>
    </form>
  </div>
</section>

<footer>
  <p>© <?= date('Y') ?> My Business. All rights reserved.</p>
</footer>

<!-- Web3Forms JS (for optional response messages) -->
<script>
  const form = document.getElementById("contactForm");
  const successMessage = document.getElementById("formSuccess");
  const errorMessage = document.getElementById("formError");

  form.addEventListener("submit", async function (e) {
    e.preventDefault();
    const formData = new FormData(form);
    const res = await fetch(form.action, {
      method: "POST",
      body: formData
    });

    if (res.ok) {
      successMessage.style.display = "block";
      errorMessage.style.display = "none";
      form.reset();
    } else {
      successMessage.style.display = "none";
      errorMessage.style.display = "block";
    }
  });
</script>

</body>
</html>
