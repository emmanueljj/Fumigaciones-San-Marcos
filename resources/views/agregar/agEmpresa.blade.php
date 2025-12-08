@extends('layouts.plantilla')

@section('tittle', 'Agregar empresa')

@section('titular')
    <x-navbar>
        Agregar empresa
    </x-navbar>
@endsection

@section('contenido')
    <div class="form-container p-4 bg-light rounded shadow-sm mx-auto formulario-content" style="max-width: 400px;">
        <form action="/addEmpresa" method="POST" enctype="multipart/form-data">
            @csrf

            <!-- Imagen de perfil con input -->
            <div class="inputImg mb-3 text-center position-relative">
                <img src="{{ url('imagenes/profile.jpg') }}" id="profileImg" class="perfilImg mb-2" alt="Foto de perfil">
                
                <input type="file" id="fotoEmpresa" accept="image/*" name="fotoEmpresa" class="d-none">
                
                <button type="button" id="btnEditFoto" class="btn btn-primary btn-sm editFoto rounded-circle p-1 position-absolute" style="height: 30px; right: 10px;" aria-label="Editar foto">
                    <i class="fa-solid fa-pen-to-square"></i>
                </button>
            </div>

            <!-- Campo: Nombre -->
            <div class="mb-3">
                <label for="nombre" class="form-label">Nombre</label>
                <input type="text" name="nombre" class="form-control" id="nombre">
            </div>

            <!-- Campo: Encargado -->
            <div class="mb-3">
                <label for="encargado" class="form-label">Encargado</label>
                <input type="text" name="encargado" class="form-control" id="encargado">
            </div>

            <!-- Botón de envío -->
            <div class="text-end">
                <button type="submit" class="btn btn-primary">
                    <i class="fa-solid fa-floppy-disk"></i>
                </button>
            </div>
        </form>
    </div>
@endsection

<script>
document.addEventListener('DOMContentLoaded', function () {
    // 1. Obtener las referencias a los elementos
    const btnEditFoto = document.getElementById('btnEditFoto');
    const fotoInput = document.getElementById('fotoEmpresa');
    const profileImage = document.getElementById('profileImg');

    // 2. Lógica para activar el input de archivo al hacer clic en el botón azul
    btnEditFoto.addEventListener('click', function() {
        // Simula un clic en el input de tipo 'file' oculto
        fotoInput.click();
    });

    // 3. Lógica para previsualizar la imagen cuando el usuario selecciona un archivo
    fotoInput.addEventListener('change', function(event) {
        // Asegúrate de que se seleccionó un archivo
        if (event.target.files && event.target.files[0]) {
            const reader = new FileReader();

            // Esto se ejecuta una vez que el archivo se ha cargado en la memoria
            reader.onload = function(e) {
                // Actualiza el atributo 'src' de la imagen con la URL del archivo local
                profileImage.src = e.target.result;
            }

            // Lee el archivo como una URL de datos (Data URL)
            reader.readAsDataURL(event.target.files[0]);
        }
    });
});
</script>