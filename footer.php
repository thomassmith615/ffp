<?php
/**
 * Site footer — brand, navigation, resource topic deep links, legal.
 */
?>
</main>

<footer>
  <div class="footer-main">
    <div class="footer-brand">
      <a class="nav-logo" href="<?php echo esc_url( home_url( '/' ) ); ?>">
        <?php $ffp_mark = ffp_image_url( 'logo-tree-toolbar' ); ?>
        <?php if ( $ffp_mark ) : ?>
          <img class="nav-logo-img" src="<?php echo esc_url( $ffp_mark ); ?>" alt="" width="42" height="42" />
        <?php else : ?>
          <div class="nav-logo-mark">F</div>
        <?php endif; ?>
        <div class="nav-logo-text">Fortune Financial<span>Planning</span></div>
      </a>
      <p>Helping individuals, families, and business owners in South Jersey pursue financial clarity, confidence, and a life lived with purpose.</p>
      <p class="footer-compliance">Securities and Advisory services offered through LPL Financial, a Registered Investment Advisor. Member FINRA &amp; SIPC.</p>
    </div>
    <div class="footer-col">
      <h5>Navigate</h5>
      <a href="<?php echo esc_url( home_url( '/' ) ); ?>">Home</a>
      <a href="<?php echo esc_url( ffp_url( 'about' ) ); ?>">About</a>
      <a href="<?php echo esc_url( ffp_url( 'solutions' ) ); ?>">Solutions</a>
      <a href="<?php echo esc_url( ffp_url( 'insights' ) ); ?>">Insights</a>
      <a href="<?php echo esc_url( ffp_url( 'resources' ) ); ?>">Resources</a>
      <a href="<?php echo esc_url( ffp_url( 'contact' ) ); ?>">Contact</a>
    </div>
    <div class="footer-col">
      <h5>Topics</h5>
      <?php foreach ( ffp_categories() as $slug => $cat ) : ?>
        <a href="<?php echo esc_url( ffp_category_url( $slug ) ); ?>"><?php echo esc_html( $cat['label'] ); ?></a>
      <?php endforeach; ?>
    </div>
    <div class="footer-col">
      <h5>Legal</h5>
      <a href="https://brokercheck.finra.org/" target="_blank" rel="noopener">FINRA BrokerCheck</a>
      <a href="#">LPL Form CRS</a>
      <a href="#">Privacy Policy</a>
      <a href="<?php echo esc_url( ffp_url( 'do-not-sell' ) ); ?>">Do Not Sell My Info</a>
    </div>
  </div>
  <div class="footer-bottom">
    <p>© <?php echo esc_html( date( 'Y' ) ); ?> Fortune Financial Planning &nbsp;·&nbsp; 1202 Laurel Oak Road, Suite 206, Voorhees, NJ 08043 &nbsp;·&nbsp; <a href="tel:8564545005">(856) 454-5005</a></p>
    <p>The content is developed from sources believed to be providing accurate information. Not intended as tax or legal advice. Consult legal or tax professionals for specific information regarding your individual situation. The LPL Financial representatives associated with this website may discuss and/or transact securities business only with residents of the following states: CT, DE, FL, GA, IL, MA, NJ, NC, &amp; PA.</p>
    <p>We take protecting your data and privacy very seriously. <a href="<?php echo esc_url( ffp_url( 'do-not-sell' ) ); ?>">Do not sell my personal information.</a> Copyright <?php echo esc_html( date( 'Y' ) ); ?>.</p>
  </div>
</footer>

<?php wp_footer(); ?>
</body>
</html>
