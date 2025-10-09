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

      <!-- Ziņa par veiksmīgu saglabāšanu -->
      @if(session('success'))
        <div style="background: #d4edda; color: #155724; padding: 10px; border-radius: 8px; margin-bottom: 15px;">
          {{ session('success') }}
        </div>
      @endif

      <!-- Profila atjaunošanas forma -->
      <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="user-details">

          <div class="input-box">
              <span class="details">Vārds</span>
              <input type="text" name="first_name" value="{{ $user->first_name }}" readonly>
          </div>

          <div class="input-box">
              <span class="details">Uzvārds</span>
              <input type="text" name="last_name" value="{{ $user->last_name }}" readonly>
          </div>

          <div class="input-box">
              <span class="details">E-pasts</span>
              <input type="email" value="{{ $user->email }}" disabled>
          </div>

          <div class="input-box">
              <span class="details">Dzimšanas datums</span>
              <input type="date" value="{{ \Carbon\Carbon::parse(str_replace('/', '-', $user->birth_date))->format('Y-m-d') }}" disabled>
          </div>

          <div class="input-box">
              <span class="details">Dzimums</span>
              <input type="text" value="{{ ucfirst($user->gender) }}" readonly>
          </div>

          <div class="input-box">
              <span class="details">Parole</span>
              <input type="password" value="********" readonly>
          </div>

          <div class="input-box">
              <span class="details">Profila bilde</span>
              @if($user->profile_photo)
                  <img src="{{ asset('storage/' . $user->profile_photo) }}" 
                       alt="Profila bilde" 
                       style="width: 100px; height: 100px; object-fit: cover; border-radius: 50%; margin-bottom: 10px;">
              @endif
              <input type="file" name="profile_photo" accept="image/*">
          </div>

          <div class="input-box">
              <span class="details">Svars (kg)</span>
              <input type="number" name="weight" value="{{ old('weight', $user->weight) }}">
          </div>

          <div class="input-box">
            <span class="details">Augums (cm)</span>
            <input type="number" name="augums" value="{{ $user->augums }}" placeholder="Ievadi savu augumu">
          </div>

          <div class="input-box">
              <span class="details">Bio</span>
              <input type="text" name="bio" value="{{ old('bio', $user->bio) }}">
          </div>

          <div class="input-box">
              <span class="details">Novads</span>
              <select name="region_id" required>
                  <option value="">Izvēlies novadu</option>
                  @foreach($regions as $region)
                      <option value="{{ $region->id }}" {{ old('region_id', $user->region_id) == $region->id ? 'selected' : '' }}>
                          {{ $region->name }}
                      </option>
                  @endforeach
              </select>
          </div>
        </div>
        <div class="input-box">
            <span class="details">Profila bildes</span>

            <!-- Esošās bildes ar dzēšanas pogu -->
            <div id="existingImages" style="display:flex; flex-wrap:wrap; gap:10px; margin-bottom:10px;">
                @php
                    $images = $user->images ? json_decode($user->images, true) : [];
                @endphp

                @foreach($images as $img)
                    <div style="position:relative; display:inline-block;">
                        <img src="{{ asset('storage/' . $img) }}" 
                            alt="Profila bilde" 
                            style="width:100px; height:100px; object-fit:cover; border-radius:8px;">
                        <button type="button" class="remove-image-btn"
                                onclick="removeExistingImage('{{ $img }}')"
                                style="position:absolute; top:2px; right:2px; background:red; color:white; border:none; border-radius:50%; width:22px; height:22px; cursor:pointer;">
                            ×
                        </button>
                    </div>
                @endforeach
            </div>

            <!-- Preview jaunajām bildēm -->
            <div id="imagePreview" style="display:flex; flex-wrap:wrap; gap:10px; margin-bottom:10px;"></div>

            <!-- File input -->
            <input type="file" name="images[]" accept="image/*" multiple onchange="previewImages(event)">

            <!-- Dzēsto bilžu saraksts -->
            <input type="hidden" name="remove_images" id="removeImagesInput">

        </div>

        <script>
        let removedImages = [];

        function previewImages(event) {
            const previewContainer = document.getElementById('imagePreview');
            previewContainer.innerHTML = ''; // Notīra veco preview

            const files = event.target.files;
            if (files) {
                Array.from(files).forEach(file => {
                    const reader = new FileReader();
                    reader.onload = e => {
                        const img = document.createElement('img');
                        img.src = e.target.result;
                        img.style.width = '100px';
                        img.style.height = '100px';
                        img.style.objectFit = 'cover';
                        img.style.borderRadius = '8px';
                        img.style.marginRight = '10px';
                        previewContainer.appendChild(img);
                    };
                    reader.readAsDataURL(file);
                });
            }
        }

        function removeExistingImage(path) {
            // Pievieno dzēšamo bildi sarakstam
            removedImages.push(path);
            document.getElementById('removeImagesInput').value = removedImages.join(',');

            // Paslēpj attiecīgo attēlu no UI
            const imgs = document.querySelectorAll(`#existingImages img[src$="${path}"]`);
            imgs.forEach(img => img.parentElement.remove());
        }
        </script>



        <div class="button">
          <input type="submit" value="Saglabāt izmaiņas">
        </div>
      </form>

      <!-- Profila dzēšanas forma -->

    </form>
    <div style="width: 100%; display: flex; justify-content: space-between; margin-top: 20px; align-items: center;">
      <a href="/users">
            <button type="submit" style="
                  background-color: #ad5ad6;
                  color: #fff;
                  padding: 10px 20px;
                  border: none;
                  border-radius: 8px;
                  cursor: pointer;
                  font-weight: bold;
              ">
                Atpakaļ
              </button>

          </a>
      <form action="{{ route('profile.destroy') }}" method="POST"
            onsubmit="return confirm('Vai tiešām vēlies dzēst savu profilu? Šī darbība ir neatgriezeniska!');"
            >
        @csrf
        @method('DELETE')
        <button type="submit" style=`
            background-color: #e53935;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-weight: bold;
        `>
          Dzēst profilu
        </button>
      </form>
      </div>
    </div>
  </div>
</body>
</html>
