<?php 
session_start();
if (!isset($_SESSION['user_email'])) {
    header("Location: login.php");
    exit;
}

// You can set user name dynamically from session or DB
$username = "Pablo";
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>My Business</title>
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      font-family: 'Segoe UI', sans-serif;
      background-color: #f4f4f4;
      color: #333;
      line-height: 1.6;
    }

    header {
      background-color: #0057b7;
      color: white;
      padding: 20px 0;
      text-align: center;
      box-shadow: 0 4px 6px rgba(0,0,0,0.1);
    }

    nav {
      background-color: #003e92;
      text-align: center;
    }

    nav a {
      color: white;
      text-decoration: none;
      padding: 15px 20px;
      display: inline-block;
      transition: background 0.3s;
      cursor: pointer;
    }

    nav a:hover, nav a.active {
      background-color: #002c6e;
    }

    .container {
      max-width: 1200px;
      margin: 0 auto;
      padding: 0 20px;
    }

    .section {
      display: none;
      padding: 40px 0;
      min-height: 500px;
    }

    .section.active {
      display: block;
    }

    .hero {
      padding: 60px 20px;
      text-align: center;
      background: linear-gradient(to right, #e3f2fd, #fce4ec);
    }

    .hero h1 {
      font-size: 2.5rem;
      margin-bottom: 10px;
    }

    .hero p {
      font-size: 1.1rem;
      color: #555;
    }

    .services {
      display: flex;
      flex-wrap: wrap;
      justify-content: center;
      margin: 40px auto;
      max-width: 1000px;
      gap: 20px;
    }

    .card {
      background: white;
      padding: 30px;
      border-radius: 10px;
      width: 280px;
      box-shadow: 0 0 10px rgba(0,0,0,0.1);
      transition: transform 0.3s ease;
    }

    .card:hover {
      transform: translateY(-5px);
    }

    .card h3 {
      color: #0057b7;
      margin-bottom: 10px;
    }

    .about-content {
      background: white;
      padding: 40px;
      border-radius: 10px;
      box-shadow: 0 0 10px rgba(0,0,0,0.1);
      margin: 20px 0;
    }

    .about-content h2 {
      color: #0057b7;
      margin-bottom: 20px;
    }

    .team-grid {
      display: grid;
      grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
      gap: 30px;
      margin: 40px 0;
    }

    .team-member {
      background: white;
      padding: 30px;
      border-radius: 10px;
      box-shadow: 0 0 10px rgba(0,0,0,0.1);
      text-align: center;
    }

    .team-member img {
      width: 100px;
      height: 100px;
      border-radius: 50%;
      background-color: #0057b7;
      margin-bottom: 15px;
    }

    .contact-form {
      background: white;
      padding: 40px;
      border-radius: 10px;
      box-shadow: 0 0 10px rgba(0,0,0,0.1);
      max-width: 600px;
      margin: 0 auto;
    }

    .form-group {
      margin-bottom: 20px;
    }

    .form-group label {
      display: block;
      margin-bottom: 5px;
      font-weight: bold;
      color: #0057b7;
    }

    .form-group input,
    .form-group textarea,
    .form-group select {
      width: 100%;
      padding: 12px;
      border: 2px solid #ddd;
      border-radius: 5px;
      font-size: 16px;
      transition: border-color 0.3s;
    }

    .form-group input:focus,
    .form-group textarea:focus,
    .form-group select:focus {
      outline: none;
      border-color: #0057b7;
    }

    .form-group textarea {
      height: 120px;
      resize: vertical;
    }

    .btn {
      background-color: #0057b7;
      color: white;
      padding: 12px 30px;
      border: none;
      border-radius: 5px;
      font-size: 16px;
      cursor: pointer;
      transition: background-color 0.3s;
    }

    .btn:hover {
      background-color: #003e92;
    }

    .contact-info {
      background: white;
      padding: 30px;
      border-radius: 10px;
      box-shadow: 0 0 10px rgba(0,0,0,0.1);
      margin: 20px 0;
    }

    .contact-info h3 {
      color: #0057b7;
      margin-bottom: 15px;
    }

    .contact-info p {
      margin-bottom: 10px;
    }

    .service-detail {
      background: white;
      padding: 30px;
      border-radius: 10px;
      box-shadow: 0 0 10px rgba(0,0,0,0.1);
      margin: 20px 0;
    }

    .service-detail h3 {
      color: #0057b7;
      margin-bottom: 15px;
    }

    .service-detail ul {
      margin-left: 20px;
      margin-top: 10px;
    }

    .service-detail li {
      margin-bottom: 5px;
    }

    .welcome-message {
      background: #0057b7;
      color: white;
      padding: 10px 20px;
      border-radius: 5px;
      margin-bottom: 20px;
      text-align: center;
    }

    .alert {
      padding: 15px;
      border-radius: 5px;
      margin-bottom: 20px;
    }

    .alert-success {
      background: #d4edda;
      color: #155724;
      border: 1px solid #c3e6cb;
    }

    .alert-error {
      background: #f8d7da;
      color: #721c24;
      border: 1px solid #f5c6cb;
    }

    footer {
      background-color: #003e92;
      color: white;
      text-align: center;
      padding: 20px 10px;
      margin-top: 40px;
    }

    @media (max-width: 768px) {
      .services {
        flex-direction: column;
        align-items: center;
      }
      
      .hero h1 {
        font-size: 2rem;
      }
      
      .team-grid {
        grid-template-columns: 1fr;
      }
    }
  </style>
</head>
<body>
  <header>
    <h1>My Business Name</h1>
    <p>Your Success is Our Mission</p>
  </header>

  <nav>
    <a href="#" onclick="showSection('home')" class="nav-link active">Home</a>
    <a href="#" onclick="showSection('services')" class="nav-link">Services</a>
    <a href="#" onclick="showSection('about')" class="nav-link">About</a>
    <a href="#" onclick="showSection('contact')" class="nav-link">Contact</a>
  </nav>

  <!-- Home Section -->
  <section id="home" class="section active">
    <div class="welcome-message">
      <p>Welcome back, <?php echo htmlspecialchars($username); ?>! 👋</p>
    </div>
    
    <div class="hero">
      <h1>Welcome to Our Website</h1>
      <p>We provide high-quality solutions to grow your business.</p>
    </div>

    <div class="services">
      <div class="card">
        <h3>🌐 Web Development</h3>
        <p>Custom websites and online stores tailored for your brand.</p>
      </div>
      <div class="card">
        <h3>📈 Marketing</h3>
        <p>Boost your reach with digital marketing strategies.</p>
      </div>
      <div class="card">
        <h3>💼 Consulting</h3>
        <p>Expert advice to help your business grow efficiently.</p>
      </div>
    </div>
  </section>

  <!-- Services Section -->
  <section id="services" class="section">
    <div class="container">
      <div class="hero">
        <h1>Our Services 🚀</h1>
        <p>Comprehensive solutions for your business needs</p>
      </div>

      <div class="service-detail">
        <h3>🌐 Web Development</h3>
        <p>We create modern, responsive websites that work perfectly on all devices. Our development services include:</p>
        <ul>
          <li>Custom website design and development</li>
          <li>E-commerce solutions</li>
          <li>Content Management Systems (CMS)</li>
          <li>Mobile-responsive design</li>
          <li>Website maintenance and updates</li>
        </ul>
      </div>

      <div class="service-detail">
        <h3>📈 Digital Marketing</h3>
        <p>Expand your reach and grow your customer base with our comprehensive marketing strategies:</p>
        <ul>
          <li>Search Engine Optimization (SEO)</li>
          <li>Social Media Marketing</li>
          <li>Pay-Per-Click (PPC) Advertising</li>
          <li>Content Marketing</li>
          <li>Email Marketing Campaigns</li>
        </ul>
      </div>

      <div class="service-detail">
        <h3>💼 Business Consulting</h3>
        <p>Get expert guidance to optimize your business operations and drive growth:</p>
        <ul>
          <li>Business Strategy Development</li>
          <li>Process Optimization</li>
          <li>Market Analysis</li>
          <li>Financial Planning</li>
          <li>Technology Integration</li>
        </ul>
      </div>
    </div>
  </section>

  <!-- About Section -->
  <section id="about" class="section">
    <div class="container">
      <div class="hero">
        <h1>About Us 🏢</h1>
        <p>Learn more about our company and team</p>
      </div>

      <div class="about-content">
        <h2>Our Story</h2>
        <p>Founded in 2015, My Business Name has been dedicated to helping companies achieve their goals through innovative solutions and exceptional service. We believe that every business deserves the tools and support needed to succeed in today's competitive market.</p>
        
        <h2>Our Mission</h2>
        <p>To empower businesses of all sizes with cutting-edge technology solutions, strategic guidance, and unparalleled customer service. We are committed to being your trusted partner in growth and success.</p>
        
        <h2>Why Choose Us?</h2>
        <p>With over 8 years of experience in the industry, we have helped hundreds of businesses transform their operations and achieve remarkable growth. Our team combines technical expertise with deep business knowledge to deliver results that matter.</p>
      </div>

      <div class="team-grid">
        <div class="team-member">
          <div style="width: 100px; height: 100px; border-radius: 50%; background-color: #0057b7; margin: 0 auto 15px; display: flex; align-items: center; justify-content: center; color: white; font-size: 24px;">JD</div>
          <h3>John Doe</h3>
          <p><strong>CEO & Founder</strong></p>
          <p>Leading our company with vision and strategic thinking for over 8 years.</p>
        </div>
        
        <div class="team-member">
          <div style="width: 100px; height: 100px; border-radius: 50%; background-color: #0057b7; margin: 0 auto 15px; display: flex; align-items: center; justify-content: center; color: white; font-size: 24px;">JS</div>
          <h3>Jane Smith</h3>
          <p><strong>CTO</strong></p>
          <p>Expert in technology solutions with 10+ years of development experience.</p>
        </div>
        
        <div class="team-member">
          <div style="width: 100px; height: 100px; border-radius: 50%; background-color: #0057b7; margin: 0 auto 15px; display: flex; align-items: center; justify-content: center; color: white; font-size: 24px;">MJ</div>
          <h3>Mike Johnson</h3>
          <p><strong>Marketing Director</strong></p>
          <p>Specializing in digital marketing strategies that drive real results.</p>
        </div>
      </div>
    </div>
  </section>

  <!-- Contact Section -->
  <section id="contact" class="section">
    <div class="container">
      <div class="hero">
        <h1>Contact Us 📞</h1>
        <p>Get in touch with our team</p>
      </div>

      <div class="contact-info">
        <h3>Get In Touch 📞</h3>
        <p><strong>📍 Address:</strong> 123 Business Street, City, State 12345</p>
        <p><strong>☎️ Phone:</strong> (555) 123-4567</p>
        <p><strong>📧 Email:</strong> chhetrikarun6@gmail.com</p>
        <p><strong>🕒 Hours:</strong> Monday - Friday: 9:00 AM - 6:00 PM</p>
      </div>

      <div class="contact-form">
        <h3>Send us a Message 📧</h3>
        
        <?php if (isset($_SESSION['success_message'])): ?>
          <div class="alert alert-success">
            ✅ <?php echo $_SESSION['success_message']; unset($_SESSION['success_message']); ?>
          </div>
        <?php endif; ?>
        
        <?php if (isset($_SESSION['form_errors'])): ?>
          <div class="alert alert-error">
            ❌ 
            <?php foreach ($_SESSION['form_errors'] as $error): ?>
              <div><?php echo $error; ?></div>
            <?php endforeach; ?>
            <?php unset($_SESSION['form_errors']); ?>
          </div>
        <?php endif; ?>
        
        <form method="POST" action="contact_handler.php">
          <div class="form-group">
            <label for="name">Name *</label>
            <input type="text" id="name" name="name" required>
          </div>
          
          <div class="form-group">
            <label for="email">Email *</label>
            <input type="email" id="email" name="email" required>
          </div>
          
          <div class="form-group">
            <label for="phone">Phone 📱</label>
            <input type="tel" id="phone" name="phone">
          </div>
          
          <div class="form-group">
            <label for="service">Service Interest 🎯</label>
            <select id="service" name="service">
              <option value="">Select a service...</option>
              <option value="web-development">🌐 Web Development</option>
              <option value="marketing">📈 Digital Marketing</option>
              <option value="consulting">💼 Business Consulting</option>
              <option value="other">🔧 Other</option>
            </select>
          </div>
          
          <div class="form-group">
            <label for="message">Message *</label>
            <textarea id="message" name="message" placeholder="Tell us about your project or how we can help you... 💬" required></textarea>
          </div>
          
          <button type="submit" class="btn">Send Message 🚀</button>
        </form>
      </div>
    </div>
  </section>

  <footer>
    <p>&copy; 2025 My Business. All rights reserved.</p>
  </footer>

  <script>
    function showSection(sectionId) {
      // Hide all sections
      const sections = document.querySelectorAll('.section');
      sections.forEach(section => section.classList.remove('active'));
      
      // Show the selected section
      document.getElementById(sectionId).classList.add('active');
      
      // Update navigation active state
      const navLinks = document.querySelectorAll('.nav-link');
      navLinks.forEach(link => link.classList.remove('active'));
      event.target.classList.add('active');
    }

    // Add smooth scrolling effect when switching sections
    document.querySelectorAll('.nav-link').forEach(link => {
      link.addEventListener('click', function(e) {
        e.preventDefault();
        const targetSection = this.getAttribute('onclick').match(/'(\w+)'/)[1];
        showSection(targetSection);
        
        // Smooth scroll to top
        window.scrollTo({
          top: 0,
          behavior: 'smooth'
        });
      });
    });
  </script>
</body>
</html>