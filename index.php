<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>CAPTCHA Verification</title>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <style>
    :root {
      --primary: #4361ee;
      --primary-light: #4cc9f0;
      --primary-dark: #3f37c9;
      --success: #4ade80;
      --error: #f87171;
      --warning: #fbbf24;
      --light: #f8fafc;
      --dark: #1e293b;
      --gray: #64748b;
      --light-gray: #e2e8f0;
      --border-radius: 12px;
      --border-radius-sm: 8px;
      --box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
      --transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    }
    
    * {
      box-sizing: border-box;
      margin: 0;
      padding: 0;
    }
    
    body {
      font-family: 'Poppins', sans-serif;
      background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
      min-height: 100vh;
      display: flex;
      justify-content: center;
      align-items: center;
      padding: 20px;
      line-height: 1.5;
    }
    
    .captcha-container {
      background: white;
      border-radius: var(--border-radius);
      box-shadow: var(--box-shadow);
      padding: 2.5rem;
      width: 100%;
      max-width: 500px;
      text-align: center;
      transform: translateY(0);
      transition: var(--transition);
      border: 1px solid var(--light-gray);
    }
    
    .captcha-container:hover {
      transform: translateY(-5px);
      box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
    }
    
    h2 {
      color: var(--dark);
      margin-bottom: 1.5rem;
      font-weight: 600;
      font-size: 1.75rem;
    }
    
    .description {
      color: var(--gray);
      margin-bottom: 2rem;
      font-size: 0.95rem;
    }
    
    .captcha-display {
      background: linear-gradient(145deg, #f1f5f9, #ffffff);
      border-radius: var(--border-radius-sm);
      padding: 1.25rem;
      margin-bottom: 1.5rem;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 80px;
      border: 1px dashed var(--light-gray);
      position: relative;
      overflow: hidden;
    }
    
    .captcha-display::before {
      content: "";
      position: absolute;
      top: 0;
      left: 0;
      right: 0;
      bottom: 0;
      background: linear-gradient(135deg, rgba(67, 97, 238, 0.1) 0%, rgba(76, 201, 240, 0.1) 100%);
      opacity: 0;
      transition: var(--transition);
    }
    
    .captcha-display:hover::before {
      opacity: 1;
    }
    
    .captcha-image {
      filter: drop-shadow(0 2px 4px rgba(0, 0, 0, 0.1));
      transition: var(--transition);
    }
    
    .captcha-image:hover {
      transform: scale(1.02);
    }
    
    .captcha-controls {
      display: flex;
      justify-content: center;
      gap: 0.75rem;
      margin-bottom: 1.5rem;
    }
    
    .captcha-btn {
      background: var(--primary);
      color: white;
      border: none;
      border-radius: 50%;
      width: 44px;
      height: 44px;
      cursor: pointer;
      display: flex;
      justify-content: center;
      align-items: center;
      transition: var(--transition);
      box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
    }
    
    .captcha-btn:hover {
      background: var(--primary-dark);
      transform: translateY(-2px);
      box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
    }
    
    .captcha-btn:active {
      transform: translateY(0);
    }
    
    .captcha-btn i {
      font-size: 1.1rem;
    }
    
    .input-group {
      display: flex;
      margin-bottom: 1.5rem;
      border-radius: var(--border-radius-sm);
      overflow: hidden;
      box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1), 0 1px 2px 0 rgba(0, 0, 0, 0.06);
      transition: var(--transition);
    }
    
    .input-group:focus-within {
      box-shadow: 0 0 0 3px rgba(67, 97, 238, 0.3);
    }
    
    input[type="text"] {
      flex: 1;
      padding: 0.75rem 1rem;
      border: none;
      font-size: 1rem;
      background: var(--light);
      color: var(--dark);
      transition: var(--transition);
    }
    
    input[type="text"]:focus {
      outline: none;
      background: white;
    }
    
    input[type="text"]::placeholder {
      color: var(--gray);
      opacity: 0.6;
    }
    
    button[type="submit"] {
      background: var(--primary);
      color: white;
      border: none;
      padding: 0 1.5rem;
      font-size: 1rem;
      font-weight: 500;
      cursor: pointer;
      transition: var(--transition);
      display: flex;
      align-items: center;
      gap: 0.5rem;
    }
    
    button[type="submit"]:hover {
      background: var(--primary-dark);
    }
    
    button[type="submit"] i {
      font-size: 0.9rem;
    }
    
    .message {
      padding: 1rem;
      border-radius: var(--border-radius-sm);
      margin-bottom: 1.5rem;
      font-weight: 500;
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 0.75rem;
      animation: fadeIn 0.5s ease-out;
    }
    
    .success {
      background: rgba(74, 222, 128, 0.15);
      color: #166534;
      border-left: 4px solid var(--success);
    }
    
    .error {
      background: rgba(248, 113, 113, 0.15);
      color: #991b1b;
      border-left: 4px solid var(--error);
    }
    
    .hint {
      font-size: 0.85rem;
      color: var(--gray);
      margin-top: -1rem;
      margin-bottom: 1.5rem;
      text-align: left;
      opacity: 0.8;
    }
    
    .footer {
      margin-top: 1.5rem;
      font-size: 0.85rem;
      color: var(--gray);
    }
    
    .footer a {
      color: var(--primary);
      text-decoration: none;
      transition: var(--transition);
    }
    
    .footer a:hover {
      color: var(--primary-dark);
      text-decoration: underline;
    }
    
    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(-10px); }
      to { opacity: 1; transform: translateY(0); }
    }
    
    @keyframes shake {
      0%, 100% { transform: translateX(0); }
      20%, 60% { transform: translateX(-5px); }
      40%, 80% { transform: translateX(5px); }
    }
    
    .shake {
      animation: shake 0.4s ease-in-out;
    }
    
    /* Responsive adjustments */
    @media (max-width: 480px) {
      .captcha-container {
        padding: 1.5rem;
      }
      
      h2 {
        font-size: 1.5rem;
      }
      
      .input-group {
        flex-direction: column;
      }
      
      button[type="submit"] {
        padding: 0.75rem;
        justify-content: center;
      }
    }
  </style>
</head>
<body>
  <div class="captcha-container">
    <h2>Verify You're Human</h2>
    <p class="description">Complete the CAPTCHA to continue</p>

    <?php
    if (isset($_POST['submit'])) {
        $userInput = strtoupper(trim(str_replace(' ', '', $_POST['captcha_input'] ?? '')));
        $realCaptcha = $_SESSION['captcha'] ?? '';

        if ($userInput === $realCaptcha) {
            echo "<div class='message success'><i class='fas fa-check-circle'></i> Verification successful! You may proceed.</div>";
        } else {
            echo "<div class='message error'><i class='fas fa-exclamation-circle'></i> Verification failed. Please try again.</div>";
        }
    }
    ?>

    <form method="POST">
      <div class="captcha-display">
        <img src="generate.php?<?php echo time(); ?>" alt="CAPTCHA Image" id="captchaImage" class="captcha-image">
      </div>
      
      <div class="captcha-controls">
        <button type="button" class="captcha-btn" id="refreshCaptcha" title="Refresh CAPTCHA" aria-label="Refresh CAPTCHA">
          <i class="fas fa-sync-alt"></i>
        </button>
        <button type="button" class="captcha-btn" id="audioCaptcha" title="Play Audio CAPTCHA" aria-label="Play Audio CAPTCHA">
          <i class="fas fa-volume-up"></i>
        </button>
      </div>
      
      <p class="hint"><i class="fas fa-info-circle"></i> Type the characters you see or hear (case insensitive)</p>
      
      <div class="input-group">
        <input type="text" name="captcha_input" id="captchaInput" placeholder="Enter CAPTCHA code" onkeydown="blockSpaces(event)" required aria-required="true">
        <button type="submit" name="submit">
          <i class="fas fa-check"></i> Verify
        </button>
      </div>
    </form>
    
    <div class="footer">
      Having trouble? <a href="#" id="helpLink">Get help</a>
    </div>
  </div>

  <script>
    function blockSpaces(event) {
      if (event.key === ' ') {
        event.preventDefault();
      }
    }
    
    const captchaImage = document.getElementById('captchaImage');
    const captchaInput = document.getElementById('captchaInput');
    const refreshBtn = document.getElementById('refreshCaptcha');
    const audioBtn = document.getElementById('audioCaptcha');
    const helpLink = document.getElementById('helpLink');
    const form = document.querySelector('form');    
    refreshBtn.addEventListener('click', function() {
      captchaImage.src = 'generate.php?' + new Date().getTime();
      captchaInput.value = '';
      captchaInput.focus();      
      captchaImage.classList.add('shake');
      setTimeout(() => captchaImage.classList.remove('shake'), 500);
    });
    

    audioBtn.addEventListener('click', function() {
      const audio = new Audio('audio_captcha.php?' + new Date().getTime());
      audio.play().catch(e => console.log('Audio playback failed:', e));
      
      audioBtn.innerHTML = '<i class="fas fa-volume-up fa-spin"></i>';
      setTimeout(() => {
        audioBtn.innerHTML = '<i class="fas fa-volume-up"></i>';
      }, 1000);
    });
    
    helpLink.addEventListener('click', function(e) {
      e.preventDefault();
      alert("If you're having trouble with the CAPTCHA:\n\n1. Click the refresh button for a new image\n2. Click the speaker button for audio assistance\n3. Make sure you're entering all characters correctly");
    });
       
    form.addEventListener('submit', function(e) {
      if (!captchaInput.value.trim()) {
        e.preventDefault();
        captchaInput.focus();
        captchaInput.placeholder = "Please enter the CAPTCHA!";
        captchaInput.classList.add('shake');
        setTimeout(() => captchaInput.classList.remove('shake'), 500);
      }
    });
    
    window.addEventListener('load', function() {
      captchaInput.focus();
    });
  </script>
</body>
</html>