const fileInput = document.getElementById('fotoEmpresa');
const editButton = document.querySelector('.editFoto');
const imgPreview = document.getElementById('profileImg');

editButton.addEventListener('click', () => {
  fileInput.click(); // Simula clic en el input file
});

fileInput.addEventListener('change', e => {
  const file = e.target.files[0];
  if (file) {
    const reader = new FileReader();
    reader.onload = function (e) {
      imgPreview.src = e.target.result;
    };
    reader.readAsDataURL(file);
  }
});
