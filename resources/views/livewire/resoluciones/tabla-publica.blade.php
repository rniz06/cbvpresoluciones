<div class="d-flex flex-column min-vh-100">
    {{-- HEADER --}}
    <header class="">
        <div class="px-3 py-2 text-bg-white border-bottom">
            <div class="container">
                <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start"> <a
                        href="/"
                        class="d-flex align-items-center my-2 my-lg-0 me-lg-auto text-secondary text-decoration-none">
                        <img src="{{ asset('img/cbvp-logo-png.webp') }}" alt="CBVP" width="40" height="32"
                            class="bi me-2"><span class="fs-5">Portal de Resoluciones</span>
                    </a>
                    <ul class="nav col-12 col-lg-auto my-2 justify-content-center my-md-0">
                        <li><a href="{{ route('index') }}" class="nav-link text-secondary"><i class="fas fa-home"></i>
                                Inicio</a></li>
                        <li><a href="https://sinabom.cbvp.org.py/login" class="nav-link text-secondary"><i
                                    class="fas fa-university"></i>
                                Sinabom</a></li>
                        <li><a href="{{ url('/app') }}" class="nav-link text-secondary"><i
                                    class="fas fa-sign-in-alt"></i>
                                Ingresar</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </header>

    {{-- CONTENIDO --}}
    <main class="bg-warning p-3">

        {{-- CONTENEDOR PRINCIPAL --}}
        <div class="container">

            {{-- ===================== --}}
            {{-- FILTROS --}}
            {{-- ===================== --}}
            <div class="card shadow-sm mb-3">
                <div class="card-header py-2">
                    <i class="fas fa-filter"></i> Filtros de búsqueda
                </div>

                <div class="card-body p-2">
                    <div class="row g-2">

                        {{-- N° Resolución --}}
                        <div class="col-md-3 col-sm-6">
                            <div class="input-group input-group-sm">
                                <span class="input-group-text">N° Resolución</span>
                                <input type="text" class="form-control" placeholder="Buscar..."
                                    wire:model="buscarNResolucion">
                            </div>
                        </div>

                        {{-- N° Acta --}}
                        <div class="col-md-3 col-sm-6">
                            <div class="input-group input-group-sm">
                                <span class="input-group-text">N° Acta</span>
                                <input type="text" class="form-control" placeholder="Buscar..."
                                    wire:model="buscarNActa">
                            </div>
                        </div>

                        {{-- Concepto --}}
                        <div class="col-md-3 col-sm-6">
                            <div class="input-group input-group-sm">
                                <span class="input-group-text">Concepto</span>
                                <input type="text" class="form-control" placeholder="Buscar..."
                                    wire:model="buscarConcepto">
                            </div>
                        </div>

                        {{-- Fecha --}}
                        <div class="col-md-3 col-sm-6">
                            <div class="input-group input-group-sm">
                                <span class="input-group-text">Fecha</span>
                                <input type="date" class="form-control" wire:model="buscarFecha">
                            </div>
                        </div>

                        {{-- Año --}}
                        <div class="col-md-3 col-sm-6">
                            <div class="input-group input-group-sm">
                                <span class="input-group-text">Año</span>
                                <select class="form-select" wire:model="buscarAnho">
                                    <option value="">Todos</option>
                                    @foreach ($anhos as $anho)
                                        <option value="{{ $anho }}">{{ $anho ?? 'S/D' }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        {{-- Origen --}}
                        <div class="col-md-3 col-sm-6">
                            <div class="input-group input-group-sm">
                                <span class="input-group-text">Origen</span>
                                <select class="form-select" wire:model="buscarOrigenId">
                                    <option value="">Todos</option>
                                    @foreach ($origenes as $origen)
                                        <option value="{{ $origen->id }}">{{ $origen->origen ?? 'S/D' }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        {{-- Tipo --}}
                        <div class="col-md-3 col-sm-6">
                            <div class="input-group input-group-sm">
                                <span class="input-group-text">Tipo</span>
                                <select class="form-select" wire:model="buscarTipoId">
                                    <option value="">Todos</option>
                                    @foreach ($tipos as $tipo)
                                        <option value="{{ $tipo->id }}">{{ $tipo->tipo ?? 'S/D' }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="col-md-3 col-sm-6">
                            <button type="button" class="btn btn-sm btn-outline-warning w-100" wire:click="$dispatch('filtrar')"><i
                                    class="fas fa-search"></i> Filtrar</button>
                        </div>

                    </div>
                </div>
            </div>


            {{-- ===================== --}}
            {{-- TABLA --}}
            {{-- ===================== --}}
            <div class="bg-white rounded shadow-sm p-2">

                <div class="table-responsive">
                    <table class="table table-sm table-hover align-middle mb-0">

                        <thead class="table-light">
                            <tr class="text-sm">
                                <th>N° Resolución</th>
                                <th>N° Acta</th>
                                <th>Concepto</th>
                                <th>Fecha</th>
                                <th>Año</th>
                                <th>Origen</th>
                                <th>Tipo</th>
                                <th class="text-center">Acciones</th>
                            </tr>
                        </thead>

                        <tbody class="table-group-divider">
                            @forelse ($resoluciones as $resolucion)
                                <tr>
                                    <th>{{ $resolucion->n_resolucion }}</th>
                                    <td>{{ $resolucion->nro_acta ?? 'NO' }}</td>
                                    <td class="text-truncate" style="max-width: 250px;">
                                        {{ $resolucion->concepto ?? 'SIN DATOS' }}
                                    </td>
                                    <td>{{ $resolucion->fecha ? date('d/m/Y', strtotime($resolucion->fecha)) : 'S/D' }}
                                    </td>
                                    <td>{{ $resolucion->ano ?? 'S/D' }}</td>
                                    <td>{{ $resolucion->fuenteOrigen->origen ?? 'S/D' }}</td>
                                    <td>{{ $resolucion->tipoDocumento->tipo ?? 'S/D' }}</td>
                                    <td class="text-center">
                                        <a href="{{ route('resolucion.detalle', $resolucion->id) }}" class="btn btn-sm btn-secondary">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('descargar.resolucion', $resolucion->id) }}" class="btn btn-sm btn-warning">
                                            <i class="fas fa-download"></i>
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center text-muted">
                                        Sin registros coincidentes
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- PAGINACIÓN --}}
                <div class="mt-3 d-flex justify-content-between align-items-center">
                    <div class="d-flex align-items-center gap-2">
                        <label class="mb-0 text-sm text-muted">Por página:</label>
                        <select class="form-select form-select-sm w-auto" wire:model.live="paginado">
                            <option value="5">5</option>
                            <option value="10">10</option>
                            <option value="15">15</option>
                            <option value="20">20</option>
                            <option value="25">25</option>
                        </select>
                    </div>

                    <div>
                        {{ $resoluciones->links() }}
                    </div>
                </div>

            </div>

        </div>
    </main>


    {{-- FOOTER --}}
    <footer class="container py-3">
        <ul class="nav justify-content-center border-bottom pb-3 mb-3">
            <li class="nav-item"><a href="{{ route('index') }}" class="nav-link px-2 text-secondary">Inicio</a></li>
            <li class="nav-item"><a href="http://www.bomberoscbvp.org.py/" class="nav-link px-2 text-secondary">Web
                    Institucional</a></li>
            <li class="nav-item"><a href="https://sinabom.cbvp.org.py/login"
                    class="nav-link px-2 text-secondary">Sinabom</a></li>
        </ul>
        <p class="text-center text-body-secondary mb-0">
            © {{ date('Y') }} Desarrollado por el Departamento de Tecnología e Innovación
        </p>
    </footer>
</div>
