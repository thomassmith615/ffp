<?php
/**
 * Contact partial — page-contact.php
 *
 * Form submission is handled via WP AJAX (fortune_contact action).
 * Handler registered in functions.php → fortune_handle_contact_form()
 * which sends email to admin_email and returns JSON success/error.
 *
 * The JS function fortuneSubmitForm() in main.js reads window.fortuneData
 * (localized by wp_localize_script in functions.php) for the AJAX URL + nonce.
 */
?>
<div id="page-contact" class="page-view">
  <div class="contact-hero page-hero">
    <div class="page-hero-inner">
      <p class="eyebrow">Contact</p>
      <h1 class="display-title" style="color:var(--white)">Let's start a <em style="color:var(--tan)">conversation</em></h1>
      <p class="body-copy" style="color:rgba(255,255,255,0.6);max-width:460px;margin-top:0.6rem">Financial clarity is closer than you think. Reach out to schedule a no-pressure introductory call with our team.</p>
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
            <a href="tel:6096740014" style="color:rgba(57,52,30,0.5);font-size:0.85rem">Fax: (609) 674-0014</a>
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
          <div class="reveal d4" style="margin-top:1.5rem;padding:1.3rem 1.5rem;background:rgba(91,119,71,0.08);border-left:2px solid var(--green);border-radius:3px">
            <p style="font-size:0.85rem;font-weight:500;color:var(--dark);margin-bottom:0.3rem">Licensed to serve clients in:</p>
            <p style="font-size:0.82rem;font-weight:300;color:rgba(57,52,30,0.65)">CT · DE · FL · GA · IL · MA · NJ · NC · PA</p>
          </div>
        </div>
        <div class="contact-form reveal d2">
          <h3>Have a Question?</h3>
          <div class="form-row">
            <div class="form-group"><label>First Name</label><input type="text" id="ff-first" placeholder="Jane" /></div>
            <div class="form-group"><label>Last Name</label><input type="text" id="ff-last" placeholder="Smith" /></div>
          </div>
          <div class="form-group"><label>Email Address</label><input type="email" id="ff-email" placeholder="jane@example.com" /></div>
          <div class="form-group"><label>Phone</label><input type="tel" id="ff-phone" placeholder="(856) 000-0000" /></div>
          <div class="form-group">
            <label>Topic</label>
            <select id="ff-topic">
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
          <div class="form-group"><label>Message</label><textarea id="ff-message" placeholder="Tell us a little about your situation or what you'd like to discuss..."></textarea></div>
          <button class="btn btn-green form-submit" id="fortuneSubmitBtn" onclick="fortuneSubmitForm(event)">Send Message</button>
        </div>
      </div>
    </div>
  </div>
  <?php get_template_part('partials/shared', 'footer'); ?>
</div>