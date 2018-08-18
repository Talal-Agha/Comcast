<nav class="navbar navbar-inverse">
    <div class="container-fluid">
      <div class="navbar-header">
        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>                        
        </button>
        <a class="navbar-brand" href="/"><img src="https://easyzigbee.com/images/img/logo.png" class="logo" alt="xfinity"></a>
      </div>
      <div class="collapse navbar-collapse" id="myNavbar">

        <ul class="nav navbar-nav navbar-right">
        <li><a href="/products">Shop</a></li>
        <li><a href="/products">Products</a></li>
        <li class="hidden-sm hidden-xs"><a href="/cart">
            <?php
                        // count items in the cart
                        $cookie = isset($_COOKIE['comcast_cart_items_cookie']) ? $_COOKIE['comcast_cart_items_cookie'] : "";
                        $cookie = stripslashes($cookie);
                        $saved_cart_items = json_decode($cookie, true);
                        $cart_count=count($saved_cart_items);
                    ?>
            Cart &nbsp; <span class="badge" id="comparison-count"><?php echo $cart_count; ?></span>
        </a></li>
        </ul>
      </div>
      <div class="visible-sm visible-xs">
      <a href="/cart">
        <div class="shoppingbasket"> 
          <div class="top"></div>
          <div class="bottom"></div>
          <div class="left"></div>
          <div class="right"></div>
          <div class="basketitems"><?php echo $cart_count; ?></div>
        </div>
        </div>
        </a>

    </div>
  </nav>