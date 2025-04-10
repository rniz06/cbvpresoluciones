<div>
    <section class="mt-10">
        <div class="mx-auto max-w-screen-2xl px-4 lg:px-12">
            <!-- Start coding here -->
            <div class="bg-white  relative shadow-md sm:rounded-lg overflow-hidden mb-4">
                <div class="flex items-center justify-between d p-4">
                    <div class="flex">
                        <div class="relative w-full">
                            <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                <svg aria-hidden="true" class="w-5 h-5 text-gray-500"
                                    fill="currentColor" viewbox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd"
                                        d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"
                                        clip-rule="evenodd" />
                                </svg>
                            </div>
                            <input type="text" wire:model.live.debounce.300ms="buscar"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full pl-10 p-2 "
                                placeholder="Buscar..." required="">
                        </div>
                    </div>
                    <div class="flex space-x-3">

                        <div class="flex space-x-3 items-center">
                            <label class="w-40 ml-4 text-sm font-medium text-gray-900">Origen :</label>
                            <select wire:model.live="origen"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-1 ">
                                <option value="">Seleccionar...</option>
                                @foreach ($origenes as $origen)
                                    <option value="{{ $origen->id }}">{{ $origen->origen }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="flex space-x-3 items-center">
                            <label class="w-40 text-sm font-medium text-gray-900">Fecha Desde :</label>
                            <input type="date" wire:model.live="fechaDesde"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-1">
                        </div>

                        <div class="flex space-x-3 items-center">
                            <label class="w-40 text-sm font-medium text-gray-900">Fecha Hasta :</label>
                            <input type="date" wire:model.live="fechaHasta"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-1">
                        </div>

                        <div class="flex space-x-3 items-center">
                            <label class="w-40 ml-4 text-sm font-medium text-gray-900">Años :</label>
                            <select wire:model.live="anosFilter"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-1 ">
                                <option value="">Seleccionar...</option>
                                @foreach ($anos as $ano)
                                    <option value="{{ $ano }}">{{ $ano }}</option>
                                @endforeach
                            </select>
                        </div>

                        {{-- <div class="flex space-x-3 items-center">
                            <label class="w-40 text-sm font-medium text-gray-900">User Type :</label>
                            <select
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 ">
                                <option value="">All</option>
                                <option value="0">User</option>
                                <option value="1">Admin</option>
                            </select>
                        </div> --}}
                    </div>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm text-left text-gray-500">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                            <tr>
                                <th scope="col" class="px-4 py-3">N° Resolución:</th>
                                <th scope="col" class="px-4 py-3">N° Acta:</th>
                                <th scope="col" class="px-4 py-3">Concepto:</th>
                                <th scope="col" class="px-4 py-3">Fecha:</th>
                                <th scope="col" class="px-4 py-3">Año:</th>
                                <th scope="col" class="px-4 py-3">Origen:</th>
                                <th scope="col" class="px-4 py-3">Tipo:</th>
                                {{-- <th scope="col" class="px-4 py-3">Last update</th> --}}
                                <th scope="col" class="px-4 py-3">
                                    <span class="sr-only">Acciones</span>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($resoluciones as $resolucion)
                                <tr class="border-b hover:bg-gray-100 cursor-pointer"
                                    onclick="window.location='{{ route('resolucion.detalle', $resolucion->id_resolucion) }}'">
                                    <th scope="row"
                                        class="px-4 py-3 font-medium text-gray-900 whitespace-nowrap">
                                        {{ $resolucion->n_resolucion }}
                                    </th>
                                    <td class="px-4 py-3">{{ $resolucion->nro_acta ?? 'N/A' }}</td>
                                    {{-- <td class="px-4 py-3">{{ $resolucion->concepto }}</td> --}}
                                    <td class="px-4 py-3 max-w-xs truncate overflow-hidden text-ellipsis whitespace-nowrap">
                                        {{ Str::of($resolucion->concepto)->limit(150) }}
                                    </td>
                                    <td class="px-4 py-3">
                                        {{ date('d/m/Y', strtotime($resolucion->fecha)) }}
                                    </td>
                                    <td class="px-4 py-3">{{ $resolucion->ano }}</td>
                                    <td class="px-4 py-3">{{ $resolucion->fuente_origen }}</td>
                                    <td class="px-4 py-3">{{ $resolucion->tipo_documento }}</td>
                                    <td class="px-4 py-3 flex items-center justify-end">
                                        <a href="{{ route('resolucion.detalle', $resolucion->id_resolucion) }}"
                                             class="px-3 py-1 text-white rounded mr-2 bg-slate-500">
                                            <i class="fas fa-eye"></i>
                                        </a>

                                        <a href="{{ route('descargar.resolucion', $resolucion->id_resolucion) }}"
                                            style="background-color: #FEDD00" class="px-3 py-1 text-white rounded">
                                            <i class="fas fa-download"></i>
                                        </a>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center py-3">
                                        <p class="text-gray-500 italic">Sin registros coincidentes...</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>

                    </table>
                </div>

                <div class="py-4 px-3">
                    <div class="flex ">
                        <div class="flex space-x-4 items-center mb-3">
                            <label class="w-32 text-sm font-medium text-gray-900">Mostrar</label>
                            <select wire:model.live="paginado"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 ">
                                <option value="5">5</option>
                                <option value="10">10</option>
                                <option value="15">15</option>
                                <option value="20">20</option>
                            </select>
                        </div>
                    </div>
                    {{ $resoluciones->links() }}
                </div>
            </div>
        </div>
    </section>

</div>
