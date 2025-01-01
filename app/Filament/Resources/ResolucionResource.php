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
use App\Models\TipoDocumento;
use Carbon\Carbon;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Filters\Indicator;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\HtmlString;

class ResolucionResource extends Resource
{
    protected static ?string $model = Resolucion::class;

    protected static ?string $navigationLabel = 'Resoluciones';

    protected static ?string $navigationIcon = 'heroicon-o-folder-open';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                // Forms\Components\TextInput::make('n_resolucion')->label('N° Resolucion')->required(),
                Forms\Components\Section::make('')
                    ->schema([
                        Forms\Components\TextInput::make('n_resolucion')->label('N° Resolucion')->required(),
                        Forms\Components\TextInput::make('nro_acta')->label('N° Acta')->numeric()->required(),
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
                            ->label('Tipo Documento')
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
                        Forms\Components\Select::make('compania_id')
                            ->label('Compañias')
                            ->options(Compania::getSelectOptions())
                            ->multiple()
                            ->searchable()
                            ->preload(),
                        Forms\Components\Select::make('personal_id')
                            ->label('Personales')
                            ->multiple()
                            ->options(Personal::getSelectOptions())
                            ->searchable()
                            ->preload()
                    ])->columns(2)

            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('n_resolucion')->label('N° Resolución')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('nro_acta')->label('N° Acta')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('concepto')->label('Concepto')->limit(50),
                Tables\Columns\TextColumn::make('fecha')->label('Fecha')->date()->searchable()->sortable(),
                Tables\Columns\TextColumn::make('ano')->label('Año')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('usuario.name')->label('Agregado por')->searchable()->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('fuenteOrigen.origen')->label('Origen')->searchable()->sortable()->badge()->color('gray'),
                Tables\Columns\TextColumn::make('tipoDocumento.tipo')->label('Tipo')->searchable()->sortable()->badge(),

                Tables\Columns\TextColumn::make('getCompaniasNamesAttribute') // Usa el método que has definido
                    ->label('Compañías')
                    ->getStateUsing(fn($record) => $record->getCompaniasNamesAttribute())
                    ->toggleable(isToggledHiddenByDefault: true),

                Tables\Columns\TextColumn::make('getPersonalNamesAttribute') // Usa el método que has definido
                    ->label('Personal')
                    ->getStateUsing(fn($record) => $record->getPersonalNamesAttribute())
                    ->toggleable(isToggledHiddenByDefault: true),

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
                Tables\Filters\SelectFilter::make('ano')
                    ->label('Año')
                    ->options(function () {
                        // Asumiendo que tienes una columna 'ano' en tu tabla
                        return \App\Models\Resolucion::distinct()->pluck('ano', 'ano')->toArray();
                    })
                    ->multiple(),
            ])->filtersFormColumns(2)
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
            ->defaultPaginationPageOption(5);
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->select('id', 'n_resolucion', 'nro_acta', 'concepto', 'fecha', 'ano', 'usuario_id', 'compania_id', 'personal_id', 'tipo_documento_id', 'fuente_origen_id')
            ->with(['usuario:id,name', 'tipoDocumento:id,tipo', 'fuenteOrigen:id,origen'])
            ->orderBY('fecha', 'desc');
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
