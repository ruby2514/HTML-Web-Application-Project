</main>

  <footer>
    <div class="container">
      <div>Copyright &copy; <?php echo date('Y'); ?> <?php echo htmlspecialchars($TEAM_NAME); ?></div>
      <div><a href="mailto:<?php echo htmlspecialchars($CONTACT_EMAIL); ?>"><?php echo htmlspecialchars($CONTACT_EMAIL); ?></a></div>
    </div>
  </footer>

  <script>
    // Fullscreen overlay for Activities images
    document.addEventListener('click', function(e){
      const t = e.target;
      if(t.matches('.activity-img')){
        const src = t.getAttribute('src');
        const overlay = document.createElement('div');
        overlay.style.position='fixed';
        overlay.style.inset='0';
        overlay.style.background='rgba(0,0,0,.95)';
        overlay.style.display='flex';
        overlay.style.alignItems='center';
        overlay.style.justifyContent='center';
        overlay.style.zIndex='10000';
        overlay.innerHTML = '<img src="'+src+'" alt="" style="max-width:96vw; max-height:92vh; box-shadow:0 8px 30px rgba(0,0,0,.6);">';
        overlay.addEventListener('click', ()=>overlay.remove());
        document.addEventListener('keydown', function esc(ev){
          if(ev.key==='Escape'){ overlay.remove(); document.removeEventListener('keydown', esc); }
        });
        document.body.appendChild(overlay);
      }
    });
  </script>
</body>
</html>
