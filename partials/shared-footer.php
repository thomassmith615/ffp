<!--
  Footer nav uses real href URLs with data-route so right-click
  "Copy Link Address" works correctly. JS router intercepts clicks.
  Topic links deep-link directly into the resources category tab.
-->
<footer>
  <div class="footer-main">
    <div class="footer-brand">
      <a class="nav-logo" href="/" data-route data-page="home" style="cursor:pointer">
        <div class="nav-logo-mark">F</div>
        <div class="nav-logo-text">Fortune Financial<span>Planning</span></div>
      </a>
      <p>Helping individuals, families, and business owners in South Jersey pursue financial clarity, confidence, and a life lived with purpose.</p>
      <p style="margin-top:0.8rem;font-size:0.74rem;color:rgba(255,255,255,0.3)">Securities and Advisory services offered through LPL Financial, a Registered Investment Advisor. Member FINRA &amp; SIPC.</p>
    </div>
    <div class="footer-col">
      <h5>Navigate</h5>
      <a href="/"          data-route data-page="home">Home</a>
      <a href="/about"     data-route data-page="about">About</a>
      <a href="/solutions" data-route data-page="solutions">Solutions</a>
      <a href="/insights"  data-route data-page="insights">Insights</a>
      <a href="/resources" data-route data-page="resources">Resources</a>
      <a href="/contact"   data-route data-page="contact">Contact</a>
    </div>
    <div class="footer-col">
      <h5>Topics</h5>
      <a href="/resources/retirement" data-route>Retirement</a>
      <a href="/resources/investment" data-route>Investment</a>
      <a href="/resources/estate"     data-route>Estate</a>
      <a href="/resources/insurance"  data-route>Insurance</a>
      <a href="/resources/tax"        data-route>Tax</a>
      <a href="/resources/lifestyle"  data-route>Lifestyle</a>
    </div>
    <div class="footer-col">
      <h5>Legal</h5>
      <a href="https://brokercheck.finra.org/" target="_blank" rel="noopener">FINRA BrokerCheck</a>
      <a href="#">LPL Form CRS</a>
      <a href="#">Privacy Policy</a>
      <a href="#">Do Not Sell My Info</a>
    </div>
  </div>
  <div class="footer-bottom">
    <p>© <?php echo esc_html( date( 'Y' ) ); ?> Fortune Financial Planning &nbsp;·&nbsp; 1202 Laurel Oak Road, Suite 206, Voorhees, NJ 08043 &nbsp;·&nbsp; <a href="tel:8564545005">(856) 454-5005</a></p>
    <p>The content is developed from sources believed to be providing accurate information. Not intended as tax or legal advice. Consult legal or tax professionals for specific information regarding your individual situation. The LPL Financial representatives associated with this website may discuss and/or transact securities business only with residents of the following states: CT, DE, FL, GA, IL, MA, NJ, NC, &amp; PA.</p>
    <p>We take protecting your data and privacy very seriously. <a href="#">Do not sell my personal information.</a> Copyright <?php echo esc_html( date( 'Y' ) ); ?>.</p>
  </div>
</footer>
