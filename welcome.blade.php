<!DOCTYPE html>
<html>
  <head>
    <title>Buy cool new product</title>
    <link rel="stylesheet" href="style.css">
    <script src="https://js.stripe.com/v3/"></script>
  </head>
  <body>
    <section>
      <div class="product">
        <div class="description">
          <h3>Payment Eaxample</h3>
          <h5>$20.00</h5>
        </div>
      </div>
      <form action="{{ url('pay') }}" method="GET">
        <button type="submit" id="checkout-button">Pay</button>
      </form>
    </section>
    <br/>
    <section>
      <div class="product">
        <div class="description">
          <h3>Vendor Account Connect</h3>
        </div>
      </div>
      <form action="{{ url('connect') }}" method="GET">
        <button type="submit" id="checkout-button">Connect</button>
      </form>
    </section>
  </body>
</html>