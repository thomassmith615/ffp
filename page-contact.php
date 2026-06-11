<?php
/**
 * Contact page. The form posts to admin-ajax.php (action:
 * fortune_contact, see inc/contact.php) via assets/js/main.js.
 */

get_header();
?>

<div class="page-hero page-hero-dark contact-hero">
  <div class="page-hero-inner">
    <p class="eyebrow">Contact</p>
    <h1 class="display-title">Let's start a <em>conversation</em></h1>
    <p class="body-copy page-hero-copy">Financial clarity is closer than you think. Reach out to schedule a no-pressure introductory call with our team.</p>
  </div>
</div>

<div class="section">
  <div class="section-inner">
    <div class="contact-layout">
      <div class="contact-info">
        <div class="contact-block reveal">
          <div class="contact-block-label">Voorhees Office</div>
          <p>1202 Laurel Oak Road, Suite 206</p>
          <p>Voorhees, NJ 08043</p>
        </div>
        <div class="contact-block reveal d1">
          <div class="contact-block-label">Phone</div>
          <a href="tel:8564545005">(856) 454-5005</a>
          <a href="tel:6096740014" class="contact-fax">Fax: (609) 674-0014</a>
        </div>
        <div class="contact-block reveal d2">
          <div class="contact-block-label">Email</div>
          <a href="mailto:kevin.gianfortune@lpl.com">kevin.gianfortune@lpl.com</a>
        </div>
        <div class="contact-block reveal d3">
          <div class="contact-block-label">Office Hours</div>
          <div class="hours-grid">
            <span>Monday – Thursday</span><span>8:00 AM – 5:00 PM</span>
            <span>Friday</span><span>8:00 AM – 3:00 PM</span>
          </div>
        </div>
        <div class="reveal d4 contact-licensed">
          <p class="contact-licensed-label">Licensed to serve clients in:</p>
          <p class="contact-licensed-states">CT · DE · FL · GA · IL · MA · NJ · NC · PA</p>
        </div>
      </div>
      <div class="contact-form reveal d2">
        <h3>Have a Question?</h3>
        <form id="fortuneContactForm" novalidate>
          <div class="form-row">
            <div class="form-group"><label for="ff-first">First Name</label><input type="text" id="ff-first" name="first_name" placeholder="Jane" autocomplete="given-name" /></div>
            <div class="form-group"><label for="ff-last">Last Name</label><input type="text" id="ff-last" name="last_name" placeholder="Smith" autocomplete="family-name" /></div>
          </div>
          <div class="form-group"><label for="ff-email">Email Address</label><input type="email" id="ff-email" name="email" placeholder="jane@example.com" autocomplete="email" required /></div>
          <div class="form-group"><label for="ff-phone">Phone</label><input type="tel" id="ff-phone" name="phone" placeholder="(856) 000-0000" autocomplete="tel" /></div>
          <div class="form-group">
            <label for="ff-topic">Topic</label>
            <select id="ff-topic" name="topic">
              <option value="">Select a topic...</option>
              <option>Retirement Planning</option>
              <option>Investment Management</option>
              <option>Financial Planning</option>
              <option>Business Succession</option>
              <option>Estate &amp; Insurance</option>
              <option>401(k) Plan Services</option>
              <option>Other</option>
            </select>
          </div>
          <div class="form-group"><label for="ff-message">Message</label><textarea id="ff-message" name="message" placeholder="Tell us a little about your situation or what you'd like to discuss..."></textarea></div>
          <button class="btn btn-green form-submit" id="fortuneSubmitBtn" type="submit">Send Message</button>
        </form>
      </div>
    </div>
  </div>
</div>

<?php get_footer(); ?>
