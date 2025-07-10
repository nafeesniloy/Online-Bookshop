<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8" />
<title>Select Payment Method</title>
<style>
  body {
    font-family: Arial, sans-serif;
    max-width: 450px;
    margin: 50px auto;
    background: #f7f7f7;
    padding: 20px;
    border-radius: 8px;
  }
  h2 {
    text-align: center;
    margin-bottom: 25px;
  }
  label {
    display: block;
    margin: 15px 0 5px;
    font-weight: bold;
  }
  input[type="radio"] {
    margin-right: 10px;
  }
  button {
    margin-top: 25px;
    padding: 12px;
    width: 100%;
    background-color: #007bff;
    border: none;
    color: white;
    font-size: 16px;
    border-radius: 6px;
    cursor: pointer;
  }
  button:hover {
    background-color: #0056b3;
  }
</style>
</head>
<body>
  <h2>Choose Payment Method</h2>
  <form action="pay_router.php" method="POST">
    <label><input type="radio" name="payment_method" value="card" required /> Visa / MasterCard</label>
    <label><input type="radio" name="payment_method" value="bkash" /> bKash</label>
    <label><input type="radio" name="payment_method" value="nagad" /> Nagad</label>

    <button type="submit">Buy Now</button>
  </form>
</body>
</html>
