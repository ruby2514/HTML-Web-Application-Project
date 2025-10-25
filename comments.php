<?php include __DIR__ . "/includes/header.php"; ?>
<?php
$name = trim($_POST["name"] ?? "");
$email = trim($_POST["email"] ?? "");
$phone = trim($_POST["phone"] ?? "");
$comment = trim($_POST["comment"] ?? "");
$submitted = ($_SERVER["REQUEST_METHOD"] === "POST");

function greeting_title($name, $email){
  if($name!=="") return $name;
  if($email!=="") return $email;
  return "Guest";
}

$response = null;
if($submitted){
  if($name==="" && $email==="" && $phone==="" && $comment===""){
    $response = ["Please enter something before submitting.","error"];
  } elseif($comment==="" && ($name!=="" || $email!=="" || $phone!=="")){
    $response = ["We received your contact details, but you didn't include a comment.","error"];
  } elseif($comment!=="" && $name==="" && $email===""){
    $response = ["Thanks for your comment! Next time, please include your name or email so we can greet you properly.","success"];
  } elseif($comment!==""){
    $title = greeting_title($name, $email);
    $response = ["Dear {$title}, thank you for your comment!","success"];
  }
}
?>
<section class="panel">
  <h2>Comments</h2>
  <form method="post">
    <div class="form-row">
      <div><label>Name</label><input name="name" value="<?php echo htmlspecialchars($name); ?>"></div>
      <div><label>Email</label><input type="email" name="email" value="<?php echo htmlspecialchars($email); ?>"></div>
      <div><label>Phone</label><input name="phone" placeholder="(123) 456-7890" value="<?php echo htmlspecialchars($phone); ?>"></div>
      <div style="grid-column:1/-1;">
        <label>Comment</label>
        <textarea name="comment" rows="3"><?php echo htmlspecialchars($comment); ?></textarea>
      </div>
    </div>
    <div style="margin-top:12px;">
      <button class="btn">Submit</button>
      <a class="btn outline" href="comments.php">Reset</a>
    </div>
  </form>

  <?php if($submitted): ?>
    <div class="alert <?php echo $response && $response[1]==='success' ? 'success' : 'error'; ?>" style="margin-top:14px;">
      <?php echo htmlspecialchars($response ? $response[0] : "No valid input detected."); ?>
    </div>
    <div class="small" style="margin-top:8px;color:#555;">
      Greeting logic: prefer <strong>Name</strong> → <strong>Email</strong> → <strong>Guest</strong>. Never greet by phone number.
    </div>
  <?php endif; ?>
</section>
<?php include __DIR__ . "/includes/footer.php"; ?>
