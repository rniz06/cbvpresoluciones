<div>
    <section class="mt-10">
        <div class="mx-auto max-w-screen-2xl px-4 lg:px-12">
            <!-- Start coding here -->
            <div class="flex justify-end mb-4">
                <a href="{{url('/')}}" class="text-black bg-white hover:bg-slate-100 focus:outline-none focus:ring-4 focus:ring-yellow-300 font-medium rounded-full text-sm px-5 py-2.5 text-center me-2 mb-2 dark:focus:ring-yellow-900"><i class="fas fa-reply-all"></i> Volver</a>
                <a href="{{route('descargar.resolucion', $resolucionView->id_resolucion)}}" class="text-black bg-white hover:bg-slate-100 focus:outline-none focus:ring-4 focus:ring-yellow-300 font-medium rounded-full text-sm px-5 py-2.5 text-center me-2 mb-2 dark:focus:ring-yellow-900"><i class="fas fa-file-pdf"></i> Descargar</a>
            </div>

            <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg p-4 mb-4">
                <!-- Título General -->
                <h2 class="text-lg font-semibold text-gray-900 text-center dark:text-gray-100 mb-2">
                    Detalles de la Resolución
                </h2>
                <!-- Sección de Información General -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div class="flex items-center">
                        <h5 class="text-sm font-medium text-gray-700 dark:text-gray-300 mr-2">N° Resolución:</h5>
                        <p class="text-gray-900 dark:text-gray-100">{{ $resolucionView->n_resolucion }}</p>
                    </div>
                    <div class="flex items-center">
                        <h5 class="text-sm font-medium text-gray-700 dark:text-gray-300 mr-2">N° Acta:</h5>
                        <p class="text-gray-900 dark:text-gray-100">{{ $resolucionView->nro_acta ?? 'N/A' }}</p>
                    </div>
                    <div class="flex items-center">
                        <h5 class="text-sm font-medium text-gray-700 dark:text-gray-300 mr-2">Fecha:</h5>
                        <p class="text-gray-900 dark:text-gray-100">{{ $resolucionView->fecha }}</p>
                    </div>
                    <div class="flex items-center">
                        <h5 class="text-sm font-medium text-gray-700 dark:text-gray-300 mr-2">Año:</h5>
                        <p class="text-gray-900 dark:text-gray-100">{{ $resolucionView->ano }}</p>
                    </div>
                    <div class="flex items-center">
                        <h5 class="text-sm font-medium text-gray-700 dark:text-gray-300 mr-2">Tipo Documento:</h5>
                        <p class="text-gray-900 dark:text-gray-100">{{ $resolucionView->tipo_documento }}</p>
                    </div>
                    <div class="flex items-center">
                        <h5 class="text-sm font-medium text-gray-700 dark:text-gray-300 mr-2">Origen:</h5>
                        <p class="text-gray-900 dark:text-gray-100">{{ $resolucionView->fuente_origen }}</p>
                    </div>
                    {{-- <div>
                        <h5 class="text-sm font-medium text-gray-700 dark:text-gray-300">Info 1:</h5>
                        <p class="text-gray-900 dark:text-gray-100">{{ $resolucionView->info1 }}</p>
                    </div> --}}
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 shadow-md rounded-lg p-4 mb-4">
                <!-- Título Parte Concepto -->
                <h2 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-2">
                    Concepto:
                </h2>
                <!-- Sección de Información Concepto -->
                <div class="">
                    <div class="flex items-center">
                        {{-- <h5 class="text-sm font-medium text-gray-700 dark:text-gray-300 mr-2">N° Resolución:</h5> --}}
                        <p class="text-gray-900 dark:text-gray-100">{{ $resolucionView->concepto }}</p>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 mb-4">
                <div class="bg-white rounded-lg p-4">
                    <h5 class="text-lg font-semibold mb-4">Compañías Afectadas</h5>
                    @if ($companias->isEmpty())
                        <p class="text-gray-500">No hay compañías afectadas...</p>
                    @else
                        <ul class="list-disc pl-5">
                            @foreach ($companias as $compania)
                                <li>{{ $compania->compania }} - {{ $compania->compania_departamento }} - {{ $compania->compania_ciudad}} </li>
                            @endforeach
                        </ul>
                        {{ $companias->appends(['personal_page' => request('personal_page')])->links() }}
                    @endif
                </div>
                <div class="bg-white rounded-lg p-4">
                    <h5 class="text-lg font-semibold mb-4">Personal Afectado</h5>
                        @if ($personales->isEmpty())
                            <p class="text-gray-500">No hay personal afectadas...</p>
                        @else
                            <ul class="list-disc pl-5">
                                @foreach ($personales as $personal)
                                    <li>{{ $personal->nombre_completo }} - {{ $personal->codigo }} - {{ $personal->categoria }}</li>
                                @endforeach
                            </ul>
                            {{ $personales->appends(['page' => request('page')])->links() }}
                        @endif
                </div>
            </div>
        </div>
    </section>

</div>
