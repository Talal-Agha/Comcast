@extends('layouts.app')

@section('content')
   <!-- DESKTOP JUMBOTRON -->
    <div id="homepage">  
   <div class="desktop jumbotron hidden-sm hidden-xs">
    <div class="container">
        <div class="row">
            <div class="col-md-8">
       <span class="header-p"> Turn your home into a fully automated</span>
      <h1>Smart Home</h1>
      <p>Control and schedule scenes within your home for different times of 
        the day or different events with the touch of your finger!</p>
        <a class="btn btn-default" href="https://xfinity.easyzigbee.com/products">Shop Now</span>	</a>
    </div>
    <div id="popup1" class="overlay">
            <div class="popup">
                <a class="close" href="#">&times;</a>
                <div class="content">
                        <iframe width="850" height="350" src="https://www.youtube.com/embed/QkBfV1GcFgg" frameborder="0" gesture="media" allow="encrypted-media" allowfullscreen></iframe>
                </div>
            </div>
        </div>
    <img src="{{ asset('images/img/ezzigbee-plug.png') }}" class="plug-media" alt="EZ Zigbee">
    <img src="{{ asset('images/img/hand.png') }}" class="hand-media" alt="Hand">
    <div class="col-md-4">


    </div>
    </div>     
    </div>
  </div>
<!-- END JUMBOTRON -->

<!-- MOBILE HEADER -->
<div id="mobile-header">
<div class="container-fluid no-padding visible-sm visible-xs">
    <div class="row">
        <div class="col-md-12">
           <a href="https://xfinity.easyzigbee.com/products"><img class="img-responsive" src="{{ asset('images/img/xfinity-header.jpg') }}"></a>
        </div>
    </div>
</div>
</div>

<!-- END MOBILE -->

  <!-- DESCRIPTION SECTION -->

  <div id="info-content"> 
  <div class="container text-center">    
    <div class="row">
      <div class="col-sm-3">
        <img src="{{ asset('images/img/world.png') }}" class="img-responsive main-icon" alt="Image"><br>
        <h3>Control and Schedule from Anywhere</h3>
        <p>Wireless control from smartphones, tablets, and PCs</p>
      </div>
      <div class="col-sm-3">
            <img src="{{ asset('images/img/custom.png') }}" class="img-responsive main-icon" alt="Image">
            <h3>Customize Scenes</h3>
            <p>Schedule lighting for different times of the day or different events</p>
          </div>
          <div class="col-sm-3">
                <img src="{{ asset('images/img/schedule.png') }}" class="img-responsive main-icon" alt="Image">
                <h3>Schedule Timed Events</h3>
                <p>Program your device to automatically turn on, off, or dim</p>
              </div>
              <div class="col-sm-3">
                    <img src="{{ asset('images/img/energy.png') }}" class="img-responsive main-icon" alt="Image">
                    <h3>Save Energy, Save Money</h3>
                    <p>This GE Smart Switch reports energy usage of connected devices providing the information and automation needed to reduce energy consumption and save money</p>
                  </div>
    </div>
    <br>
    <br>
    <div class="row">
    <div class="col-md-12 text-center">
            <a class="btn btn-default" style="border:show;border:#fff!important; border-width:2px;"href="#popup1">Learn More <span class="icon icon-play"></span>	</a>

    </div>
    </div>

    </div><br>
    </div> 

        <!-- END DESCRIPTION -->

        <div class="container visible-sm visible-xs">
            <div class="row">
                <div class="col-sm-12">
                    <img class="img-responsive" src="{{ asset('images/img/wireless-home.jpg') }}" alt="Wireless Home">
                </div>
            </div>
        </div>

        <!-- PRODUCT MAP -->
        <div id="prod-map" class="hidden-sm hidden-xs desktop">
        <div class="index-section-2">
                <div class="bg-attachment-1"></div>
                <div class="container callout-map">
                    <div class="locations-markers">
                        <div class="location-marker right" data-target="1" style="top: 100px; left: 450px;"></div>
                        <div class="location-marker right" data-target="2" style="top: 60px; left: 665px;"></div>
                        <div class="location-marker right" data-target="3" style="top: 260px; left: 525px;"></div>
                        <div class="location-marker right" data-target="4" style="top: 320px; left: 475px;"></div>
                        <div class="location-marker right" data-target="5" style="top: 310px; left: 370px;"></div>
                    </div>
                    <div class="callout-panel">
                        <div class="panel-inner">
                            <img src="about:blank" class="callout-product">
                            <div class="callout-title-block">
                                <h4 class="callout-title">Callout Title</h4>
                            </div>
                            <div class="callout-info-block">
                                <h4 class="callout-product-title">Product Title</h4>
                                <p class="callout-product-info">Product Info</p>
                            </div>
                        </div>
                    </div>
                    <div class="info-block">
                        <h2>Wirelessly control and schedule from anywhere!<br><br></h2>
                        <p><a class="btn btn-default" href="https://xfinity.easyzigbee.com/products">View Products</a></p>
                    </div>
                </div>
            </div>
        </div>
        <!-- END MAP -->     
        
        <!-- MOBILE PRODUCTS -->
        <div id="mobile-products" class="container visible-sm visible-xs">
            <div class="row">
                <div class="col-xs-4">
                    <img src="{{ asset('images/img/45856ge.png') }}" class="img-responsive prod" width="150px">
                </div>
                <div class="col-xs-8">
                    <span class="prod-title">In-Wall</span><br>
                    <h4>Smart Switch</h4>
                  <p>Control and schedue ceiling lights and fans, wall sconces, or porch lights from any indoor switch.</p><br>
                </div>
                <div class="row">
                    <div class="col-xs-12 text-center">
                  <img src="{{ asset('images/img/inwall-switch.png') }}" class="img-responsive center-block"><br>
                  <p><a class="btn btn-default" href="https://xfinity.easyzigbee.com/products">Shop Now</a></p>
                </div>
            </div>
            </div>

            <div class="row">
                    <div class="col-xs-4">
                        <img src="{{ asset('images/img/45857ge.png') }}" class="img-responsive prod" width="150px">
                    </div>
                    <div class="col-xs-8">
                        <span class="prod-title">In-Wall</span><br>
                        <h4>Smart Dimmer</h4>
                      <p>Control, schedule &amp; dim ceiling and wall light fixtures.</p><br>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 text-center">
                      <img src="{{ asset('images/img/inwall-dimmer.png') }}" width="250px" class="img-responsive center-block"><br>
                      <p><a class="btn btn-default" href="https://xfinity.easyzigbee.com/products">Shop Now</a></p>
                    </div>
                </div>
                </div>
                
                <div class="row">
                        <div class="col-xs-4">
                            <img src="{{ asset('images/img/45853.png') }}" class="img-responsive prod" width="150px">
                        </div>
                        <div class="col-xs-8">
                            <span class="prod-title">Plug-In</span><br>
                            <h4>Smart Switch</h4>
                          <p>Control &amp; schedule lamps and other devices.</p><br>
                        </div>
                        <div class="row">
                            <div class="col-xs-12 text-center">
                                    <img src="{{ asset('images/img/plugin-switch.png') }}" class="img-responsive center-block"><br>
                                    <p><a class="btn btn-default" href="https://xfinity.easyzigbee.com/products">Shop Now</a></p>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                            <div class="col-xs-4">
                                <img src="{{ asset('images/img/45852.png') }}" class="img-responsive prod" width="150px">
                            </div>
                            <div class="col-xs-8">
                                <span class="prod-title">Plug-In</span><br>
                                <h4>Smart Dimmer</h4>
                              <p>Control, schedule &amp; dim table and floor lamps.</p><br>
                            </div>
                            <div class="row">
                                <div class="col-xs-12 text-center">
                              <img src="{{ asset('images/img/plugin-dimmer.png') }}" class="img-responsive center-block"><br>
                              <p><a class="btn btn-default" href="https://xfinity.easyzigbee.com/products">Shop Now</a></p>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                                <div class="col-xs-4">
                                    <img src="{{ asset('images/img/45856ge.png') }}" class="img-responsive prod" width="150px">
                                </div>
                                <div class="col-xs-8">
                                    <span class="prod-title">In-Wall</span><br>
                                    <h4>Add-On Switch</h4>
                                  <p>Convert any GE Smart Control to a Multi-Location Switch. Control Lighting from up to five (5) different switches.</p><br>
                                </div>
                                <div class="row">
                                    <div class="col-xs-12 text-center">
                                  <img src="{{ asset('images/img/addon-switch.png') }}" class="img-responsive center-block"><br>
                                  <p><a class="btn btn-default" href="https://xfinity.easyzigbee.com/products">Shop Now</a></p>
                                </div>
                            </div>
                            </div>
        </div>


        <!-- END MOBILE -->
        

        <div id="switch-section" class="hidden-sm hidden-xs">
            <div class="container">
                <div class="row">
                    <div class="col-md-12 text-center">
                        <h2>Convert any GE Smart Control to a Multi-Location Switch</h2>
                        <p>Control lighting from up to (5) different switches.</p><br>
                        <img class="img-responsive center-block" src="{{ asset('images/img/switch-control.png') }}"><br><br>
                        <p><a class="btn btn-default" href="https://xfinity.easyzigbee.com/products">Shop Now</a></p>
                    </div>
                </div>
            </div>

        </div>

</div>
@endsection

@section('footer_js')
<script>
    $(document).ready(function() {
        $('.cms-slideshow-inner').cycle({
            width: '100%',
            height: 520,
            fx: 'fade',
            easing: 'easeOutCubic',
            timeout: 6000,
            speed: 1500,
            delay: 0,
            pause: false,
            fit: 1
        });
    });
</script>
@endsection
