<div class="row">

    <div class="col-md-6 mb-3">
        <label class="form-label">Nombre completo</label>

        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
            value="{{ old('name', $usuario->name ?? '') }}" required>

        @error('name')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-6 mb-3">
        <label class="form-label">Correo electrónico</label>

        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
            value="{{ old('email', $usuario->email ?? '') }}" required>

        @error('email')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-6 mb-3">
        <label class="form-label">Rol del usuario</label>

        <select name="rol" class="form-select @error('rol') is-invalid @enderror" required>

            <option value="">Seleccione un rol</option>

            @foreach(['Administrador', 'Tecnico'] as $rol)
                <option value="{{ $rol }}" @selected(old('rol', isset($usuario) ? $usuario->getRoleNames()->first() : '') === $rol)>
                    {{ $rol === 'Tecnico' ? 'Técnico' : $rol }}
                </option>
            @endforeach
        </select>

        @error('rol')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="col-md-6 mb-3">
        <label class="form-label">
            Contraseña
            @if(isset($usuario))
                <small class="text-muted">(opcional)</small>
            @endif
        </label>

        <input type="password" name="password" class="form-control @error('password') is-invalid @enderror"
            autocomplete="new-password" @if(!isset($usuario)) required @endif>

        @error('password')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror

        @if(isset($usuario))
            <small class="text-muted">
                Déjala en blanco para conservar la contraseña actual.
            </small>
        @endif
    </div>

    <div class="col-md-6 mb-3">
        <label class="form-label">Confirmar contraseña</label>

        <input type="password" name="password_confirmation" class="form-control" autocomplete="new-password"
            @if(!isset($usuario)) required @endif>
    </div>

</div>