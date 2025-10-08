<!DOCTYPE html>
<html lang="lv" dir="ltr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Pieteikties</title>
  @vite(['resources/css/login.css'])
</head>
<body>
  @if (session('success'))
    <div id="flash-success"
        style="
          position: fixed;
          top: 20px;
          right: 20px;
          background: linear-gradient(135deg, #4CAF50, #2e7d32);
          color: #fff;
          padding: 15px 20px;
          border-radius: 10px;
          box-shadow: 0 4px 12px rgba(0,0,0,0.2);
          font-weight: 500;
          z-index: 9999;
          opacity: 0;
          transform: translateY(-10px);
          transition: all 0.4s ease;
        ">
        <span style="margin-right: 10px;">✅</span> {{ session('success') }}
    </div>

    <script>
      const flash = document.getElementById('flash-success');
      // animēta parādīšanās
      setTimeout(() => {
          flash.style.opacity = '1';
          flash.style.transform = 'translateY(0)';
      }, 100);
      // pazūd pēc 4 sekundēm
      setTimeout(() => {
          flash.style.opacity = '0';
          flash.style.transform = 'translateY(-10px)';
          setTimeout(() => flash.remove(), 400);
      }, 4000);
    </script>
  @endif

  <div class="container">
    <!-- Title -->
    <div class="title">Pieteikties</div>
    <div class="content">
      
      <!-- Login form -->
      <form action="{{ route('login') }}" method="POST">
        @csrf

        <div class="user-details">
          <!-- E-pasts -->
          <div class="input-box">
            <span class="details">E-pasts</span>
            <input type="email" name="email" placeholder="Ievadi e-pastu" required>
          </div>

          <!-- Parole -->
          <div class="input-box">
            <span class="details">Parole</span>
            <input type="password" name="password" placeholder="Ievadi paroli" required>
          </div>
        </div>
        @if($errors->any())
          <div id="flash-error" style="background-color: #f44336; color:white; padding:10px; margin-bottom:10px; border-radius:5px;">
              <ul style="margin:0; padding-left:20px;">
                  @foreach($errors->all() as $error)
                      <li>{{ $error }}</li>
                  @endforeach
              </ul>
          </div>
          <script>
              setTimeout(() => {
                  document.getElementById('flash-error').style.display = 'none';
              }, 5000);
          </script>
        @endif

        <!-- Submit button -->
        <div class="button">
          <input type="submit" value="Pieteikties">
        </div>
      </form>

      <!-- Link uz reģistrāciju -->
      <div class="extra-link" style="margin-top:15px; text-align:center;">
        <span>Tev vēl nav konta? </span>
        <a href="{{ route('register.form') }}">Reģistrējies šeit</a>
      </div>

    </div>
  </div>
</body>
</html>
