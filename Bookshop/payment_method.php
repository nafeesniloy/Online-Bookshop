<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1" />
<title>Select Payment Method</title>
<style>
  body {
    font-family: Arial, sans-serif;
    background: #f5f5f5;
    padding: 40px;
  }
  .payment-container {
    background: #fff;
    max-width: 400px;
    margin: 0 auto;
    padding: 30px;
    border-radius: 8px;
    box-shadow: 0 4px 8px rgba(0,0,0,0.1);
  }
  h2 {
    text-align: center;
    margin-bottom: 25px;
    color: #333;
  }
  label {
    display: block;
    background: #eee;
    padding: 15px 20px;
    border-radius: 6px;
    margin-bottom: 15px;
    cursor: pointer;
    border: 2px solid transparent;
    font-size: 18px;
    transition: border-color 0.3s ease;
  }
  input[type="radio"] {
    margin-right: 15px;
    vertical-align: middle;
  }
  label:hover {
    border-color: #007bff;
  }
  input[type="radio"]:checked + label {
    border-color: #007bff;
    background: #e6f0ff;
    font-weight: bold;
  }
  .submit-btn {
    width: 100%;
    padding: 15px;
    font-size: 18px;
    background-color: #007bff;
    border: none;
    border-radius: 6px;
    color: white;
    cursor: pointer;
    margin-top: 10px;
  }
  .submit-btn:hover {
    background-color: #0056b3;
  }
</style>
</head>
<body>

<div class="payment-container">
  <h2>Choose Payment Method</h2>
  <form action="pay_router.php" method="POST">
    <input type="radio" id="card" name="payment_method" value="card" required />
    <label for="card">Visa / MasterCard</label>

    <input type="radio" id="bkash" name="payment_method" value="bkash" />
    <label for="bkash">bKash</label>

    <input type="radio" id="nagad" name="payment_method" value="nagad" />
    <label for="nagad">Nagad</label>

    <button type="submit" class="submit-btn">Proceed to Pay</button>
  </form>
</div>

</body>
</html>
