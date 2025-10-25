<?php require_once __DIR__ . "/config.php"; ?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title><?php echo htmlspecialchars($TEAM_NAME); ?></title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <style>
    :root{ --green:#1d7f37; --border:#cfcfcf; --footer:#e6e6e6; }
    *{ box-sizing:border-box }
    body{ margin:0; font:16px/1.45 system-ui,-apple-system,Segoe UI,Roboto,Arial,sans-serif; color:#000; background:#fff; }
    .container{ max-width:900px; margin:0 auto; padding:0 16px; }
    .page-title{ text-align:center; font-size:44px; margin:24px 0 12px; color:#444;
                 text-shadow:1px 1px 0 #bbb, 2px 2px 0 #999; font-weight:600; letter-spacing:.5px; }
    @media (max-width:520px){ .page-title{ font-size:34px } }

    /* Green bar with brand, burger, and links */
    .bar { background:var(--green); border:1px solid #0f5a23; border-left:0; border-right:0; position:relative; }
    .bar-inner { display:flex; align-items:center; gap:14px; padding:10px 0; }
    .brand { display:flex; align-items:center; gap:12px; }
    .brand img { width:40px; height:40px; background:#fff; padding:4px; border-radius:4px; border:1px solid #0f5a23; }
    .brand-name { color:#e8ffe8; font-weight:700; display:none; }

    .burger { margin-left:auto; display:none; background:transparent; border:1px solid rgba(255,255,255,.35);
              padding:8px 10px; border-radius:6px; cursor:pointer; }
    .burger svg { display:block; }
    .menu-links { display:flex; gap:16px; }
    .menu-links a{ padding:10px 14px; color:#e8ffe8; text-decoration:none; border-radius:3px; font-weight:600; display:inline-block; }
    .menu-links a:hover, .menu-links a.active{ background:rgba(255,255,255,.15); }

    /* Collapse and center overlay below sm (576px) */
    @media (max-width: 575.98px){
      .menu-links{ display:none; }
      .burger{ display:block; }
      .menu-links.show{
        display:flex;
        position:absolute;
        inset:0;
        min-height:200px;
        justify-content:center;
        align-items:center;
        flex-direction:column;
        gap:16px;
        background:var(--green);
      }
      .menu-links.show a{ opacity:.85; }
    }

    .panel{ background:#fff; border:1px solid var(--border); margin:18px auto; padding:18px 22px; }
    ul{ margin:8px 0 16px 22px; }
    address{ font-style:normal; white-space:pre-line; }
    footer{ margin:16px 0 32px; border:1px solid #bdbdbd; background:var(--footer); color:#222; font-size:14px; }
    footer .container{ padding:10px 14px; text-align:center; }
    footer a{ color:#004aad; text-decoration:none; } footer a:hover{ text-decoration:underline; }

    .grid{ display:grid; grid-template-columns: repeat(auto-fit, minmax(220px,1fr)); gap:14px; }
    .card{ border:1px solid var(--border); padding:10px; }
    .card h4{ margin:8px 0 6px; }
    .card img{ width:100%; height:160px; object-fit:cover; display:block; background:#eee; }
    .form-row{ display:grid; grid-template-columns:repeat(auto-fit,minmax(240px,1fr)); gap:12px; }
    .btn{ display:inline-block; padding:9px 14px; border:1px solid #1a73e8; color:#fff; background:#1a73e8; text-decoration:none; border-radius:4px; cursor:pointer; }
    .btn.outline{ background:#fff; color:#1a73e8; }
    .alert{ padding:10px 12px; border:1px solid #bbb; background:#f7f7f7; margin-top:14px; }
    .alert.success{ border-color:#2b7a2b; background:#eaf7ea; }
    .alert.error{ border-color:#a52828; background:#fdeaea; }
    label{ font-weight:600; display:block; margin-bottom:4px; }
    input, select, textarea{ width:100%; padding:9px 10px; border:1px solid #bbb; border-radius:4px; }
  </style>
</head>
<body>
  <div class="container">
    <h1 class="page-title"><?php echo htmlspecialchars($TEAM_NAME); ?></h1>
  </div>

  <div class="bar">
    <div class="container bar-inner">
      <div class="brand">
        <img src="assets/images/logo.svg" alt="Logo">
        <span class="brand-name"><?php echo htmlspecialchars($TEAM_NAME); ?></span>
      </div>

      <button class="burger" id="burger" aria-label="Toggle menu" aria-expanded="false" aria-controls="navlinks">
        <svg width="28" height="20" viewBox="0 0 24 16" fill="none" stroke="#e8ffe8" stroke-width="2">
          <line x1="1" y1="2" x2="23" y2="2"/>
          <line x1="1" y1="8" x2="23" y2="8"/>
          <line x1="1" y1="14" x2="23" y2="14"/>
        </svg>
      </button>

      <?php $current = basename($_SERVER['PHP_SELF']); ?>
      <nav class="menu-links" id="navlinks" role="navigation" aria-label="Main">
        <a class="<?php echo $current==='index.php'?'active':''; ?>" href="index.php">Home</a>
        <a class="<?php echo $current==='yurts.php'?'active':''; ?>" href="yurts.php">Yurts</a>
        <a class="<?php echo $current==='activities.php'?'active':''; ?>" href="activities.php">Activities</a>
        <a class="<?php echo $current==='reservation.php'?'active':''; ?>" href="reservation.php">Reservation</a>
        <a class="<?php echo $current==='comments.php'?'active':''; ?>" href="comments.php">Comments</a>
      </nav>
    </div>
  </div>

  <main class="container">
  <script>
    (function(){
      const btn = document.getElementById('burger');
      const links = document.getElementById('navlinks');
      if(btn && links){
        btn.addEventListener('click', function(){
          const open = links.classList.toggle('show');
          btn.setAttribute('aria-expanded', open ? 'true' : 'false');
        });
        links.addEventListener('click', function(e){
          if(e.target.tagName === 'A'){
            links.classList.remove('show');
            btn.setAttribute('aria-expanded', 'false');
          }
        });
      }
    })();
  </script>
