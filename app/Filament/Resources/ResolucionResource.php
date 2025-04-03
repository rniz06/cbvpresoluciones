<?php

namespace App\Filament\Resources;

use Illuminate\Support\Str;
use Filament\Tables\Actions\Action;
use App\Filament\Resources\ResolucionResource\Pages;
use App\Filament\Resources\ResolucionResource\RelationManagers;
use App\Models\Compania;
use App\Models\FuenteOrigen;
use App\Models\Personal;
use App\Models\Resolucion;
use App\Models\Resolucion\Estado as ResolucionEstado;
use App\Models\TipoDocumento;
use Carbon\Carbon;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Filters\Indicator;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\HtmlString;

class ResolucionResource extends Resource
{
    protected static ?string $model = Resolucion::class;

    protected static ?string $navigationLabel = 'Resoluciones';

    protected static ?string $navigationGroup = 'Resoluciones';

    protected static ?string $navigationIcon = 'heroicon-o-folder-open';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                // Forms\Components\TextInput::make('n_resolucion')->label('N° Resolucion')->required(),
                Forms\Components\Section::make('')
                    ->schema([
                        Forms\Components\TextInput::make('n_resolucion')->label('N° Resolucion')->required(),
                        Forms\Components\TextInput::make('nro_acta')->label('N° Acta')->numeric(),
                        Forms\Components\DatePicker::make('fecha')->label('Fecha')->required()->format('Y-m-d'),
                        Forms\Components\Hidden::make('usuario_id')->default(Auth::id()),

                        Forms\Components\Select::make('fuente_origen_id')
                            ->label('Origen')
                            ->options(FuenteOrigen::all()->pluck('origen', 'id'))
                            ->preload()
                            ->required()
                            ->afterStateUpdated(function ($set, $state) {
                                $fuenteOrigen = FuenteOrigen::find($state);
                                if ($fuenteOrigen) {
                                    $origen = Str::lower($fuenteOrigen->origen);
                                    $set('upload_directory_origen', $origen);
                                }
                            }),

                        Forms\Components\Select::make('tipo_documento_id')
                            ->label('Tipo Documento:')
                            ->options(TipoDocumento::all()->pluck('tipo', 'id'))
                            ->preload()
                            ->required()
                            ->live()
                            ->afterStateUpdated(function ($set, $state) {
                                $tipoDocumento = TipoDocumento::find($state);
                                if ($tipoDocumento) {
                                    $directorio = Str::lower($tipoDocumento->tipo);
                                    $set('upload_directory_tipo', $directorio);
                                }
                            }),

                        Forms\Components\Select::make('estado_id')
                            ->label('Estado:')
                            ->options(ResolucionEstado::all()->pluck('estado', 'id_resolucion_estado'))
                            ->preload()
                            ->required(),

                        // Campos ocultos para almacenar las partes del directorio
                        Forms\Components\Hidden::make('upload_directory_tipo')
                            ->default('resoluciones'),
                        Forms\Components\Hidden::make('upload_directory_origen')
                            ->default('directorio'),
                    ])->columns(3),

                Forms\Components\Section::make('')
                    ->schema([
                        Forms\Components\Textarea::make('concepto')->label('Concepto')->required()->columnSpan(3),

                        Forms\Components\FileUpload::make('ruta_archivo')
                            ->label('Subir Resolución')
                            ->disk('public')
                            ->directory(function (callable $get) {
                                $tipo = $get('upload_directory_tipo');
                                $origen = $get('upload_directory_origen');
                                return $tipo . '/' . $origen . '/' . date('Y') . '/' . date('m') . '/' . date('d');
                            })
                            // ->directory('resoluciones/' . date('Y') . '/' . date('m') . '/' . date('d'))
                            ->preserveFilenames()
                            ->storeFileNamesIn('nombre_original')
                            ->maxSize(20480)
                            ->required(fn($context) => $context === 'create') // Solo requerido en la creación
                            ->hiddenOn('edit')
                            ->previewable(true)
                            ->uploadingMessage('Subiendo archivo adjunto...')
                            ->columnSpan(3),
                    ]),

                Forms\Components\Section::make()
                    ->schema([
                        // Forms\Components\Select::make('compania_id')
                        //     ->label('Compañias:')
                        //     ->options(Compania::getSelectOptions())
                        //     ->multiple()
                        //     ->searchable()
                        //     ->preload(),
                        Forms\Components\Select::make('compania_id')
                            ->label('Compañias:')
                            ->relationship(
                                name: 'companias',
                                modifyQueryUsing: fn(Builder $query) => $query->orderBy('orden'),
                            )
                            ->getOptionLabelFromRecordUsing(fn(Model $record) => "{$record->compania} - {$record->departamento} - {$record->ciudad}")
                            ->multiple()
                            ->searchable(['compania', 'departamento', 'ciudad'])
                            ->preload()
                            ->optionsLimit(10),
                        Forms\Components\Select::make('personal_id')
                            ->label('Personas:')
                            ->relationship(
                                name: 'personales',
                                modifyQueryUsing: fn(Builder $query) => $query->orderBy('nombrecompleto')->orderBy('codigo')->orderBy('categoria'),
                            )
                            ->getOptionLabelFromRecordUsing(fn(Model $record) => "{$record->nombrecompleto} - {$record->codigo} - {$record->categoria}")
                            ->multiple()
                            ->searchable(['nombrecompleto', 'codigo', 'categoria'])
                            ->optionsLimit(10)
                    ])->columns(2)

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('n_resolucion')->label('N° Resolución')->sortable(),
                Tables\Columns\TextColumn::make('nro_acta')->label('N° Acta')->sortable(),
                Tables\Columns\TextColumn::make('concepto')->label('Concepto')->limit(50),
                Tables\Columns\TextColumn::make('fecha')->label('Fecha')->date()->sortable(),
                Tables\Columns\TextColumn::make('ano')->label('Año')->sortable(),
                // Tables\Columns\TextColumn::make('usuario.name')->label('Agregado por')->searchable()->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('fuenteOrigen.origen')->label('Origen')->sortable()->badge()->color('gray'),
                Tables\Columns\TextColumn::make('tipoDocumento.tipo')->label('Tipo')->sortable()->badge(),
                Tables\Columns\TextColumn::make('estado.estado')->label('Estado')->sortable()->badge()
                    ->color(fn(string $state): string => match ($state) {
                        'Vigente' => 'success',
                        'Modificada' => 'gray',
                        'Derogada' => 'danger',
                        default => 'gray'
                    }),

                // Tables\Columns\TextColumn::make('getCompaniasNamesAttribute') // Usa el método que has definido
                //     ->label('Compañías')
                //     ->getStateUsing(fn($record) => $record->getCompaniasNamesAttribute())
                //     ->toggleable(isToggledHiddenByDefault: true),

                // Tables\Columns\TextColumn::make('getPersonalNamesAttribute') // Usa el método que has definido
                //     ->label('Personal')
                //     ->getStateUsing(fn($record) => $record->getPersonalNamesAttribute())
                //     ->toggleable(isToggledHiddenByDefault: true),

            ])
            ->filters([
                Tables\Filters\Filter::make('n_resolucion')
                    ->form([
                        Forms\Components\TextInput::make('n_resolucion')->label('N° Resolución'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query->when(
                            $data['n_resolucion'],
                            fn(Builder $query, $n_resolucion): Builder => $query->where('n_resolucion', 'like', "%{$n_resolucion}%")
                        );
                    }),
                Tables\Filters\Filter::make('nro_acta')
                    ->form([
                        Forms\Components\TextInput::make('nro_acta')->label('N° Acta:'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query->when(
                            $data['nro_acta'],
                            fn(Builder $query, $nro_acta): Builder => $query->where('nro_acta', 'like', "%{$nro_acta}%")
                        );
                    }),
                Tables\Filters\Filter::make('concepto')
                    ->form([
                        Forms\Components\TextInput::make('concepto')->label('Concepto:'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query->when(
                            $data['concepto'],
                            fn(Builder $query, $concepto): Builder => $query->where('concepto', 'like', "%{$concepto}%")
                        );
                    }),
                Tables\Filters\SelectFilter::make('ano')
                    ->label('Año')
                    ->options(function () {
                        return \App\Models\Resolucion::distinct()->orderBy('ano', 'desc')->pluck('ano', 'ano')->toArray();
                    })
                    ->multiple(),
                // FILTRAR POR CAMPO (RELACION) FUENTEORIGEN
                Tables\Filters\SelectFilter::make('fuente_origen_id')
                    ->label('Origen:')
                    ->relationship('fuenteOrigen', 'origen', fn(Builder $query) => $query->orderBy('origen', 'asc'))
                    ->preload()
                    ->multiple(),
                // FILTRAR POR CAMPO (RELACION) TIPODOCUMENTO
                Tables\Filters\SelectFilter::make('tipo_documento_id')
                    ->label('Tipo:')
                    ->relationship('tipoDocumento', 'tipo', fn(Builder $query) => $query->orderBy('tipo', 'asc'))
                    ->preload()
                    ->multiple(),
                // FILTRAR POR CAMPO (RELACION) ESTADO
                Tables\Filters\SelectFilter::make('estado_id')
                    ->label('Estado:')
                    ->relationship('estado', 'estado')
                    ->preload(),
                // FILTRAR POR CAMPO (RELACION) PERSONALES
                Tables\Filters\SelectFilter::make('personales')
                    ->label('Personas:')
                    ->multiple()
                    ->relationship('personales', 'nombrecompleto', fn(Builder $query) => $query->orderBy('nombrecompleto')->orderBy('codigo')->orderBy('categoria'))
                    ->getOptionLabelFromRecordUsing(fn(Model $record) => "{$record->nombrecompleto} - {$record->codigo} - {$record->categoria}")
                    ->searchable(['nombrecompleto', 'codigo', 'categoria'])
                    ->optionsLimit(10),
                // FILTRAR POR CAMPO (RELACION) COMPANIAS
                Tables\Filters\SelectFilter::make('companias')
                    ->label('Compañias:')
                    ->multiple()
                    ->relationship('companias', 'compania', fn(Builder $query) => $query->orderBy('orden'))
                    ->getOptionLabelFromRecordUsing(fn(Model $record) => "{$record->compania} - {$record->departamento} - {$record->ciudad}")
                    ->searchable(['compania', 'departamento', 'ciudad'])
                    ->preload()
                    ->optionsLimit(10),
                Tables\Filters\Filter::make('fecha')
                    ->form([
                        Forms\Components\DatePicker::make('fecha_desde')->label('Fecha desde'),
                        Forms\Components\DatePicker::make('fecha_hasta')->label('Fecha hasta'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['fecha_desde'],
                                fn(Builder $query, $date): Builder => $query->whereDate('fecha', '>=', $date)
                            )
                            ->when(
                                $data['fecha_hasta'],
                                fn(Builder $query, $date): Builder => $query->whereDate('fecha', '<=', $date)
                            );
                    }),
                // , layout: FiltersLayout::AboveContent
            ], layout: FiltersLayout::AboveContent)->filtersFormColumns(5)
            ->actions([
                Tables\Actions\EditAction::make()->label('Editar'),
                Tables\Actions\ViewAction::make()->label('Ver'),
                Action::make('descargar')
                    ->label('Descargar')
                    ->icon('heroicon-c-arrow-down-tray')
                    ->url(fn(Resolucion $record): string => route('descargar.resolucion', $record))
                    ->openUrlInNewTab(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    // Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->paginated([5, 10, 15, 20, 25])
            ->defaultPaginationPageOption(5)
            ->defaultSort('ano', 'desc');
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->select('id', 'n_resolucion', 'nro_acta', 'concepto', 'fecha', 'ano', 'usuario_id', 'compania_id', 'personal_id', 'tipo_documento_id', 'fuente_origen_id', 'estado_id')
            ->with(['usuario:id,name', 'tipoDocumento:id,tipo', 'fuenteOrigen:id,origen', 'estado', 'personales']);
        //->orderBY('ano', 'desc')->orderBy('n_resolucion', 'desc');
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListResolucions::route('/'),
            'create' => Pages\CreateResolucion::route('/create'),
            'view' => Pages\ViewResolucion::route('/{record}'),
            'edit' => Pages\EditResolucion::route('/{record}/edit'),
        ];
    }
}
