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
                <input 
                    type="date" 
                    value="{{ \Carbon\Carbon::parse(str_replace('/', '-', $user->birth_date))->format('Y-m-d') }}" 
                    disabled>
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
          <div class="input-box">
            <span class="details">Svars (kg)</span>
            <input type="number" name="weight">
          </div>
          <div class="input-box">
            <span class="details">Bio</span>
            <input type="text" name="bio">
          </div>
          <div class="input-box">
            <span class="details">Novads</span>
            <select name="region_id" required>
                <option value="">Izvēlies novadu</option>
                @foreach($regions as $region)
                    <option value="{{ $region->id }}" {{ $user->region_id == $region->id ? 'selected' : '' }}>
                        {{ $region->name }}
                    </option>
                @endforeach
            </select>
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
