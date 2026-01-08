  <style>
    .footer-social {
    display: flex;
    gap: 12px;
    align-items: center;
    justify-content: center;
}

.footer-social .social-icon {
    width: 42px;
    height: 42px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #fff;
    font-size: 18px;
    transition: all 0.3s ease;
    box-shadow: 0 5px 15px rgba(0,0,0,0.15);
}

.footer-social .social-icon:hover {
    transform: translateY(-4px);
}

/* Platform Colors */
.footer-social .facebook { background: #1877F2; }
.footer-social .instagram { 
    background: radial-gradient(circle at 30% 30%, #fdf497, #fd5949, #d6249f, #285AEB);
}
.footer-social .whatsapp { background: #25D366; }

/* Mobile Responsive */
@media (max-width: 576px) {
    .footer-social {
        margin-top: 10px;
    }
}
</style>
  
  <footer class="footer-wrapper footer-default overflow-hidden">
      <div class="shape-mockup d-none d-xxl-block wow fadeinup" data-top="22%" data-left="0%">
          <img src="assets/img/footer/footer-left.png" alt="img" />
      </div>
      <div class="shape-mockup moving d-none d-lg-block" data-top="10%" data-right="4%">
          <img src="{{asset('assets/img/shape/footer-top.png')}}" alt="img" />
      </div>
      <div class="footer-top">
          <div class="container">
              <div class="row gy-40 align-items-center justify-content-center">
                  <div class="col-xl-12">
                      <div class="subscribe-box">
                          <h2 class="footer-top_title">Let’s Talk With Us</h2>
                      </div>
                  </div>
              </div>
          </div>
      </div>
      <div class="widget-area">
          <div class="container">
              <div class="row gy-4 justify-content-center">
                  <div class="col-md-12 col-lg-6 col-xl-4">
                      <div class="widget footer-widget">
                          <h3 class="widget_title">Contact Info</h3>
                          <div class="icon">
                              <img src="{{asset('assets/img/icon/f-title-icon2.png')}}" alt="icon" />
                          </div>
                          <div class="th-widget-contact">
                              <div class="info-box">
                                  <p class="info-box_text">
                                      <span>Phone:</span>
                                      <a href="tel:256369854789" class="info-box_link">+256 3698 54789</a>
                                  </p>
                              </div>
                              <div class="info-box">
                                  <p class="info-box_text">
                                      <span>Email:</span>
                                      <a href="mailto:info@barab.com" class="info-box_link">info@barab.com</a>
                                  </p>
                              </div>
                          </div>
                      </div>
                  </div>
                  <div class="col-md-12 col-lg-6 col-xl-4">
                      <div class="widget widget_nav_menu footer-widget">
                          <h3 class="widget_title">Quick Links</h3>
                          <div class="icon">
                              <img src="{{asset('assets/img/icon/f-title-icon3.png')}}" alt="icon" />
                          </div>
                          <div class="menu-all-pages-container">
                              <ul class="menu">
                                  <li><a href="{{url('/')}}">Home</a></li>
                                  <li><a href="#">About Us</a></li>
                                  <li><a href="#">Contact</a></li>
                              </ul>
                          </div>
                      </div>
                  </div>
                  <div class="col-md-12 col-lg-6 col-xl-4">
                      <div class="widget widget_nav_menu footer-widget">
                          <h3 class="widget_title">Quick Links</h3>
                          <div class="icon">
                              <img src="{{asset('assets/img/icon/f-title-icon3.png')}}" alt="icon" />
                          </div>
                          <div class="menu-all-pages-container">
                              <ul class="menu">
                                  <li><a href="{{url('/')}}">Home</a></li>
                                  <li><a href="#">About Us</a></li>
                                  <li><a href="#">Contact</a></li>
                              </ul>
                          </div>
                      </div>
                  </div>
              </div>
          </div>
      </div>
      <div class="copyright-wrap">
          <div class="container">
              <div class="copy-right-content">
                  <div class="copyright-text-wrap">
                      <p class="copyright-text">
                          <i class="fal fa-copyright"></i> Copyright 2025
                          <a href="{{url('/')}}">Scooble</a>. All Rights Reserved.
                      </p>
                  </div>
                  <div class="footer-bottom-logo">
                      <a href="{{url('/')}}"><img src="{{ asset('assets/img/logo.jpg') }}" alt="img" /></a>
                  </div>
                  <div class="footer-card">
                     <div class="footer-social">
    <a href="https://facebook.com" target="_blank" class="social-icon facebook">
        <i class="fab fa-facebook-f"></i>
    </a>
    <a href="https://instagram.com" target="_blank" class="social-icon instagram">
        <i class="fab fa-instagram"></i>
    </a>
    <a href="https://wa.me/919999999999" target="_blank" class="social-icon whatsapp">
        <i class="fab fa-whatsapp"></i>
    </a>
</div>

                  </div>
              </div>
          </div>    
      </div>
  </footer>

  