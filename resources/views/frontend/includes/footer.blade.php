<footer class="ftco-footer ftco-section">
    <div class="container">
        <div class="row">
            <div class="mouse">
                      <a href="#" class="mouse-icon">
                          <div class="mouse-wheel"><span class="ion-ios-arrow-up"></span></div>
                      </a>
                  </div>
        </div>
      <div class="row mb-4">
        <div class="col-md">
          <div class="ftco-footer-widget mb-4">
            <h2 class="ftco-heading-2">{{$setting->site_name}} on Social Media:</h2>
            {{-- <p>Far far away, behind the word mountains, far from the countries Vokalia and Consonantia.</p> --}}
            <ul class="ftco-footer-social list-unstyled float-md-left float-lft m3-5">
              <li class="ftco-animate"><a href="{{$setting->twitter}}" target="_blank"><span class="icon-twitter"></span></a></li>
              <li class="ftco-animate"><a href="{{$setting->facebook}}" target="_blank"><span class="icon-facebook"></span></a></li>
              <li class="ftco-animate"><a href="{{$setting->instagram}}" target="_blank"><span class="icon-instagram"></span></a></li>
              <li class="ftco-animate"><a href="{{$setting->linkedin}}" target="_blank"><span class="icon-linkedin"></span></a></li>
            </ul>
          </div>
        </div>
        <div class="col-md-4">
           <div class="ftco-footer-widget mb-4">
            <h2 class="ftco-heading-2">Help</h2>
            <div class="d-flex">
                <ul class="list-unstyled mr-l-5 pr-l-3 mr-4">
                    <li><a href="{{route('faq')}}" class="py-2 d-block">FAQs</a></li>
                    <li><a href="{{route('contact')}}" class="py-2 d-block">Contact</a></li>
                  <li><a href="{{route('termsandconditions')}}" class="py-2 d-block">Terms &amp; Conditions</a></li>
                  <li><a href="{{route('policy')}}" class="py-2 d-block">Privacy Policy</a></li>
                  <li><a href="{{route('about')}}" class="py-2 d-block">About Us</a></li>
                </ul>
              </div>
          </div>
        </div>
        <div class="col-md-4">
          <div class="ftco-footer-widget mb-4">
              <h2 class="ftco-heading-2">Have a Questions?</h2>
              <div class="block-23 mb-3">
                <ul>
                  <li><span class="icon icon-map-marker"></span><span class="text">{{$setting->address}}</span></li><br>
                  <li><a href="#"><span class="icon icon-phone"></span><span class="text">+977 01-{{$setting->phone}}</span></a></li>
                  <li><a href="#"><span class="icon icon-envelope"></span><span class="text">{{$setting->email}}</a></li>
                </ul>
              </div>
          </div>
        </div>
      </div>
      <div class="row">
        <div class="col-md-12 text-center">

        <p>
            Copyright &copy;<script>document.write(new Date().getFullYear());</script> All rights reserved | This site is for you made with <i class="icon-heart color-danger" aria-hidden="true"></i> by <a href="http://127.0.0.1:8000/" target="_blank">{{$setting->site_name}}</a>
        </p>
        </div>
      </div>
    </div>
  </footer>
