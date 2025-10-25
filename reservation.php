<?php include __DIR__ . "/includes/header.php"; ?>
<?php
require_once __DIR__ . "/includes/config.php";

$ROOM_PRICES = ["King"=>200.0,"Queen"=>150.0,"Suite"=>300.0];
$TAX_RATE = 0.07;

function nights_between($in,$out){
  if(!$in || !$out) return 1;
  $d1=new DateTime($in); $d2=new DateTime($out);
  $days=$d1->diff($d2)->days; return max(1,$days);
}

$errors=[]; $payload=null;

if($_SERVER['REQUEST_METHOD']==='POST'){
  $payload = [
    "first" => trim($_POST['first']??''),
    "last"  => trim($_POST['last']??''),
    "addr"  => trim($_POST['addr']??''),
    "city"  => trim($_POST['city']??''),
    "state" => trim($_POST['state']??''),
    "zip"   => trim($_POST['zip']??''),
    "checkin"  => $_POST['checkin']??'',
    "checkout" => $_POST['checkout']??'',
    "room"  => $_POST['room']??'',
    "phone" => trim($_POST['phone']??''),
    "email" => trim($_POST['email']??''),
    "people"=> (int)($_POST['people']??1),
    "pay"   => $_POST['pay']??'',
    "card"  => $_POST['card']??'',
    "notes" => trim($_POST['notes']??'')
  ];

  foreach(["first","last","addr","city","state","zip","checkin","checkout","room","phone","email","people","pay","card"] as $k){
    if($payload[$k]==='' || $payload[$k]===null){ $errors[] = ucfirst($k) . " is required."; }
  }
  if($payload["phone"] && !preg_match('/^\(\d{3}\) \d{3}-\d{4}$/',$payload["phone"])) $errors[]="Phone must be in the format (123) 456-7890.";
  if($payload["email"] && !filter_var($payload["email"], FILTER_VALIDATE_EMAIL)) $errors[]="Email must be a valid address like name@example.com.";
  $digits = preg_replace('/\D/','', $payload["card"]);
  if(strlen($digits)!==16) $errors[]="Card number must contain exactly 16 digits.";
  if($payload["room"] && !isset($ROOM_PRICES[$payload["room"]])) $errors[]="Invalid room type.";

  if(!$errors){
    $payload["nights"]=nights_between($payload["checkin"],$payload["checkout"]);
    $payload["rate"]=$ROOM_PRICES[$payload["room"]];
    $payload["tax_rate"]=$TAX_RATE;
    $payload["total"]=$payload["rate"]*$payload["nights"]*(1+$TAX_RATE);
  }
}
?>
<section class="panel">
  <h2>Reservation at <?php echo htmlspecialchars($TEAM_NAME); ?></h2>

  <?php if($_SERVER['REQUEST_METHOD']!=='POST' || $errors): ?>
  <?php if($errors): ?>
    <div class="alert error">
      <strong>Please fix the following:</strong>
      <ul><?php foreach($errors as $e) echo "<li>".htmlspecialchars($e)."</li>"; ?></ul>
    </div>
  <?php endif; ?>

  <form method="post">
    <div class="form-row">
      <div><label>First name</label><input name="first" autofocus value="<?php echo htmlspecialchars($payload['first']??''); ?>" required></div>
      <div><label>Last name</label><input name="last" value="<?php echo htmlspecialchars($payload['last']??''); ?>" required></div>
      <div style="grid-column:1/-1;"><label>Address</label><input name="addr" value="<?php echo htmlspecialchars($payload['addr']??''); ?>" required></div>
      <div><label>City</label><input name="city" value="<?php echo htmlspecialchars($payload['city']??''); ?>" required></div>
      <div><label>State</label><input name="state" maxlength="2" placeholder="NJ" value="<?php echo htmlspecialchars($payload['state']??''); ?>" required></div>
      <div><label>Zip</label><input name="zip" placeholder="07043" value="<?php echo htmlspecialchars($payload['zip']??''); ?>" required></div>
      <div><label>Check-in</label><input type="date" name="checkin" value="<?php echo htmlspecialchars($payload['checkin']??''); ?>" required></div>
      <div><label>Check-out</label><input type="date" name="checkout" value="<?php echo htmlspecialchars($payload['checkout']??''); ?>" required></div>
      <div>
        <label>Room type</label>
        <select name="room" required>
          <option value="">Choose…</option>
          <?php foreach(array_keys($ROOM_PRICES) as $r): ?>
            <option value="<?php echo $r; ?>" <?php echo (($payload['room']??'')===$r)?'selected':''; ?>><?php echo $r; ?></option>
          <?php endforeach; ?>
        </select>
      </div>
      <div><label>Phone (US)</label><input name="phone" placeholder="(123) 456-7890" value="<?php echo htmlspecialchars($payload['phone']??''); ?>" required></div>
      <div><label>Email</label><input type="email" name="email" placeholder="you@example.com" value="<?php echo htmlspecialchars($payload['email']??''); ?>" required></div>
      <div><label>How many people</label><input type="number" name="people" min="1" value="<?php echo htmlspecialchars($payload['people']??'1'); ?>" required></div>
      <div>
        <label>Payment method</label>
        <select name="pay" required>
          <?php foreach(["MC","VISA","AMEX","Discover"] as $p): ?>
            <option value="<?php echo $p; ?>" <?php echo (($payload['pay']??'')===$p)?'selected':''; ?>><?php echo $p; ?></option>
          <?php endforeach; ?>
        </select>
      </div>
      <div style="grid-column:1/-1;"><label>Card number</label><input name="card" placeholder="1234 5678 9012 3456" value="<?php echo htmlspecialchars($payload['card']??''); ?>" required></div>
      <div style="grid-column:1/-1;"><label>Special requests (optional)</label><textarea name="notes" rows="3"><?php echo htmlspecialchars($payload['notes']??''); ?></textarea></div>
    </div>

    <div style="margin-top:12px;">
      <button class="btn">Submit Reservation</button>
      <a class="btn outline" href="reservation.php">Reset</a>
    </div>
  </form>

  <?php else: ?>
    <h3>Thank you <?php echo htmlspecialchars($payload['first'] . ' ' . $payload['last']); ?> for your reservation</h3>
    <p>The following are the information that you entered.</p>
    <table style="width:100%; border-collapse:collapse; font-size:15px;">
      <?php
        $rows = [
          "Number & Street" => $payload["addr"],
          "City" => $payload["city"],
          "State" => $payload["state"],
          "Zip Code" => $payload["zip"],
          "Check-In Date" => $payload["checkin"],
          "Check-Out Date" => $payload["checkout"],
          "Room Type" => $payload["room"],
          "Number of People" => $payload["people"],
          "Number of Days" => $payload["nights"],
          "Email" => $payload["email"],
          "Phone Number" => $payload["phone"],
          "Credit card" => $payload["pay"],
          "Card Number" => $payload["card"],
          "Special Request" => ($payload["notes"]===''?'N/A':$payload["notes"]),
        ];
        $i=0;
        foreach($rows as $k=>$v){
          $shade = ($i++ % 2)==0 ? "#f2f2f2" : "#ffffff";
          echo "<tr style='background:$shade'><th style=\"text-align:left;padding:8px;border:1px solid #ccc; width:28%;\">".htmlspecialchars($k)."</th><td style=\"padding:8px;border:1px solid #ccc;\">".htmlspecialchars((string)$v)."</td></tr>";
        }
      ?>
      <tr style="background:#f2f2f2;"><th style="text-align:left;padding:8px;border:1px solid #ccc;">Total Charge</th>
        <td style="padding:8px;border:1px solid #ccc;"><strong>$<?php echo number_format($payload["total"], 2, '.', ''); ?></strong></td></tr>
    </table>

    <p style="margin-top:10px;"><em>Total charge is (<?php echo (int)$payload['rate']; ?> * <?php echo (int)$payload['nights']; ?> * <?php echo number_format(1+$payload['tax_rate'], 2); ?>) = <?php echo number_format($payload['total'], 2, '.', ''); ?>.</em></p>
  <?php endif; ?>
</section>
<?php include __DIR__ . "/includes/footer.php"; ?>
