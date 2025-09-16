<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Responsive Registration Form</title>
  @vite(['resources/css/register.css'])
</head>
<body>
  <div class="container">
    <!-- Title -->
    <div class="title">Reģistrēties</div>
    <div class="content">
      <!-- Registration form -->
      <form action="#">
        <div class="user-details">
          <!-- Vārds -->
          <div class="input-box">
            <span class="details">Vārds</span>
            <input type="text" placeholder="Ievadi vārdu" required>
          </div>
          <!-- Uzvārds -->
          <div class="input-box">
            <span class="details">Uzvārds</span>
            <input type="text" placeholder="Ievadi uzvārdu" required>
          </div>
          <!-- E-pasts -->
          <div class="input-box">
            <span class="details">E-pasts</span>
            <input type="text" placeholder="Ievadi e-pastu" required>
          </div>
          <!-- Dzimšanas datums -->
          <div class="input-box">
            <span class="details">Dzimšanas datums</span>
            <input type="date" id="birth_date" name="birth_date" required>
            <span id="birth_error" style="color: red;">Atceries! Tev jābūt vismaz 16 gadus vecam!</span>
          </div>

          <script>
            const birthInput = document.getElementById('birth_date');
            const birthError = document.getElementById('birth_error');

            const today = new Date();
            const yearMax = today.getFullYear() - 16;
            const month = (today.getMonth() + 1).toString().padStart(2, '0');
            const day = today.getDate().toString().padStart(2, '0');
            const maxDate = `${yearMax}-${month}-${day}`;
            const minYear = today.getFullYear() - 100;
            const minDate = `${minYear}-01-01`;

            birthInput.setAttribute('max', maxDate);
            birthInput.setAttribute('min', minDate);

            birthInput.addEventListener('change', function() {
                if (birthInput.value > maxDate) {
                    birthError.style.display = 'inline';
                    birthInput.setCustomValidity("Jums jābūt vismaz 16 gadus vecam!");
                } else {
                    birthError.style.display = 'none';
                    birthInput.setCustomValidity("");
                }
            });
          </script>

          <!-- Parole -->
          <div class="input-box">
            <span class="details">Parole</span>
            <input type="text" placeholder="Ievadi paroli" required>
          </div>
          <!-- Apstiprini paroli -->
          <div class="input-box">
            <span class="details">Apstiprini paroli</span>
            <input type="text" placeholder="Apstiprini paroli" required>
          </div>
        </div>

        <!-- Gender selection -->
        <div class="gender-details">
          <input type="radio" name="gender" id="dot-1">
          <input type="radio" name="gender" id="dot-2">
          <span class="gender-title">Dzimums</span>
          <div class="category">
            <label for="dot-1">
              <span class="dot one"></span>
              <span class="gender">Vīrietis</span>
            </label>
            <label for="dot-2">
              <span class="dot two"></span>
              <span class="gender">Sieviete</span>
            </label>
          </div>
        </div>

        <!-- Submit button -->
        <div class="button">
          <input type="submit" value="Reģistrēties">
        </div>
      </form>
    </div>
  </div>
</body>
</html>
