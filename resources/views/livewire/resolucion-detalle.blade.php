<div>
    <section class="mt-10">
        <div class="mx-auto max-w-screen-2xl px-4 lg:px-12">
            <!-- Start coding here -->

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
                    <ul class="list-disc pl-5">
                        {{-- @if ($companiasAfectadas->isEmpty())
                            <p class="text-gray-500">No hay compañías afectadas.</p>
                        @else
                            <ul>
                                @foreach ($companiasAfectadas as $compania)
                                    <li>{{ $compania->compania }}</li>
                                @endforeach
                            </ul>
                        @endif --}}
                        <li>K-15</li>
                        <li>K-15</li>
                        <li>K-15</li>
                        <li>K-15</li>
                        <li>K-15</li>
                    </ul>
                </div>
                <div class="bg-white rounded-lg p-4">
                    <h5 class="text-lg font-semibold mb-4">Personal Afectado</h5>
                    <ul class="list-disc pl-5">
                        {{-- @if ($companiasAfectadas->isEmpty())
                            <p class="text-gray-500">No hay compañías afectadas.</p>
                        @else
                            <ul>
                                @foreach ($companiasAfectadas as $compania)
                                    <li>{{ $compania }}</li>
                                @endforeach
                            </ul>
                        @endif --}}
                        <li>Ronald Niz</li>
                        <li>Ronald Niz</li>
                        <li>Ronald Niz</li>
                        <li>Ronald Niz</li>
                        <li>Ronald Niz</li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

</div>
