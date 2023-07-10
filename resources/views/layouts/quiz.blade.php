<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests">
    <title>{{ $title }} | Quiz</title>
    <link rel="stylesheet" href="{{ asset('css/font.css') }}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
    <link rel="icon" href="{{ asset('img/logo/icon.png') }}">
    <link rel="stylesheet" href="{{ asset('css/draggable.css') }}">
</head>
<body>

    <nav class="navbar bg-light px-2">
        <div class="container-fluid">
          <div class="navbar-brand">
            <img src="{{ asset('img/logo/logo.png') }}" alt="Logo" width="120" height="40" class="d-inline-block align-text-top">
          </div>
          <h5 style="font-weight: bold">
            {{ $quiz->quiz_type }}
          </h5>
        </div>
    </nav>

    @yield('quiz-content')

    {{-- key answer by choices --}}
    <script>
        const inputTexts = document.querySelectorAll('.input-text');
        const optionsSelect = document.getElementById('options-select');
        let selectedOption = '';
    
        inputTexts.forEach((input) => {
            input.addEventListener('input', (event) => {
                const target = event.target;
                const optionId = target.dataset.option;
                const option = document.getElementById(optionId);
                option.textContent = target.value;
    
                // Jika opsi terpilih sebelumnya tetap ada, set kembali opsi terpilih
                if (selectedOption !== '') {
                    optionsSelect.value = selectedOption;
                }
            });
        });
    
        optionsSelect.addEventListener('change', (event) => {
            selectedOption = event.target.value;
        });
    </script>
    
    {{-- draggable --}}
    <script>
      const items = document.querySelectorAll('.drag-item');
      const nameInputs = document.querySelectorAll('.name-input');
      const cancelButton = document.querySelectorAll('.cancel-button');
      const enableButton = document.querySelectorAll('.enable-button');

      items.forEach(item => {
          item.addEventListener('dragstart', function (e) {
              e.dataTransfer.setData('text/plain', this.textContent);
          });
      });

      nameInputs.forEach((nameInput, index) => {
          nameInput.addEventListener('dragover', function (e) {
              e.preventDefault();
          });

          nameInput.addEventListener('drop', function (e) {
              e.preventDefault();
              const text = e.dataTransfer.getData('text/plain');
              this.value = text;
              this.classList.add('disabled'); // Menambahkan class 'disabled' pada input teks
              enableButton[index].style.display = 'inline'; // Menampilkan tombol "Enable"

              // Menonaktifkan item yang di-drop
              items.forEach(item => {
                  if (item.textContent === text) {
                      item.classList.add('disabled'); // Menambahkan class 'disabled' pada drag item
                  }
              });
          });

          // Menambahkan event listener untuk memeriksa jika input memiliki nilai
          nameInput.addEventListener('input', function() {
              if (this.value !== "") {
                  this.classList.remove('disabled'); // Menghapus class 'disabled' pada input teks
                  enableButton[index].style.display = 'none'; // Menyembunyikan tombol "Enable" jika input memiliki nilai

                  // Mengaktifkan item yang sesuai saat input diisi
                  items.forEach(item => {
                      if (item.textContent === this.value) {
                          item.classList.remove('disabled'); // Menghapus class 'disabled' pada drag item
                      }
                  });
              }
          });

          // Menambahkan event listener untuk tombol "Enable"
          enableButton[index].addEventListener('click', function() {
              const correspondingItemText = nameInputs[index].value;
              items.forEach(item => {
                  if (item.textContent === correspondingItemText) {
                      item.classList.remove('disabled'); // Menghapus class 'disabled' pada drag item
                  }
              });
              nameInput.value = "";
              nameInput.classList.remove('disabled');
              this.style.display = 'none';
          });
      });
    </script>



    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>