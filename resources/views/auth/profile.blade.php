<!DOCTYPE html>
<html lang="lv" dir="ltr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Mans Profils</title>
  @vite(['resources/css/profile.css'])
</head>
<body>
  <div class="container">
    <div class="title">Mans Profils</div>
    <div class="content">
      <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="user-details">
          <!-- Vārds (nemaināms) -->
            <div class="input-box">
                <span class="details">Vārds</span>
                <input type="text" name="first_name" value="{{ $user->first_name }}" readonly>
            </div>
            <!-- Uzvārds (nemaināms) -->
            <div class="input-box">
                <span class="details">Uzvārds</span>
                <input type="text" name="last_name" value="{{ $user->last_name }}" readonly>
            </div>
            <!-- E-pasts (nemaināms) -->
            <div class="input-box">
                <span class="details">E-pasts</span>
                <input type="email" value="{{ $user->email }}" disabled>
            </div>
            <!-- Dzimšanas datums (nemaināms) -->
            <div class="input-box">
                <span class="details">Dzimšanas datums</span>
                <input type="date" value="{{ $user->birth_date }}" disabled>
            </div>
            <!-- Dzimums (var redzēt, bet nevar mainīt) -->
            <div class="input-box">
                <span class="details">Dzimums</span>
                <input type="text" value="{{ ucfirst($user->gender) }}" readonly>
            </div>
            <!-- Parole (nemaināma šeit) -->
            <div class="input-box">
                <span class="details">Parole</span>
                <input type="password" value="********" readonly>
            </div>
          <!-- Profila bilde -->
          <div class="input-box">
            <span class="details">Profila bilde</span>
            <input type="file" name="profile_photo" accept="image/*">
          </div>
        </div>

        <div class="button">
          <input type="submit" value="Saglabāt izmaiņas">
        </div>
      </form>
    </div>
  </div>
</body>
</html>
