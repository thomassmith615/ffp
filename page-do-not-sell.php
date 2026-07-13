<?php
/**
 * Do Not Sell My Personal Information — CCPA request page.
 * Applies to the page with slug "do-not-sell" (created on activation).
 *
 * The form posts to admin-ajax (action: fortune_privacy, see
 * inc/contact.php). Request-type options are verbatim from the firm's
 * previous site.
 */

get_header();
?>

<div class="page-hero">
  <div class="page-hero-inner">
    <p class="eyebrow">Privacy</p>
    <h1 class="display-title">Do not sell my <em>personal information</em></h1>
    <p class="body-copy page-hero-copy">We take protecting your data and privacy very seriously. Use this form to submit a request under the California Consumer Privacy Act (CCPA).</p>
  </div>
</div>

<div class="section">
  <div class="section-inner">
    <div class="contact-layout">
      <div class="contact-info">
        <div class="contact-block reveal">
          <div class="contact-block-label">Office</div>
          <a href="tel:8564545005">(856) 454-5005</a>
        </div>
        <div class="contact-block reveal d1">
          <div class="contact-block-label">Address</div>
          <p>1202 Laurel Oak Road, Suite 206</p>
          <p>Voorhees, NJ 08043</p>
        </div>
        <div class="contact-block reveal d2">
          <div class="contact-block-label">Email</div>
          <a href="mailto:kevin.gianfortune@lpl.com">kevin.gianfortune@lpl.com</a>
        </div>
        <div class="reveal d3 contact-licensed">
          <p class="contact-licensed-label">About this form</p>
          <p class="contact-licensed-states">As of January 1, 2020 the California Consumer Privacy Act (CCPA) provides California residents the rights requested below. We honor these requests for all clients and site visitors.</p>
        </div>
      </div>
      <div class="contact-form reveal d2">
        <h3>Personal Information Form</h3>
        <form id="fortunePrivacyForm" novalidate>
          <div class="form-group"><label for="pf-name">Name</label><input type="text" id="pf-name" name="name" placeholder="Jane Smith" autocomplete="name" /></div>
          <div class="form-group"><label for="pf-email">Email</label><input type="email" id="pf-email" name="email" placeholder="jane@example.com" autocomplete="email" required /></div>
          <div class="form-group">
            <label>Request Type</label>
            <div class="check-group">
              <label class="check-option"><input type="checkbox" name="requests[]" value="Prohibit the sale of personal information" /><span>Prohibit the sale of personal information</span></label>
              <label class="check-option"><input type="checkbox" name="requests[]" value="Request copies of personal information" /><span>Request copies of personal information</span></label>
              <label class="check-option"><input type="checkbox" name="requests[]" value="Request deletion of personal information" /><span>Request deletion of personal information</span></label>
            </div>
          </div>
          <div class="form-group"><label for="pf-message">Message</label><textarea id="pf-message" name="message" placeholder="Anything else we should know about your request..."></textarea></div>
          <button class="btn btn-green form-submit" type="submit">Submit Request</button>
        </form>
      </div>
    </div>
  </div>
</div>

<?php get_footer(); ?>
