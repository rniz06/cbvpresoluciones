<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ConvenioResource\Pages;
use App\Filament\Resources\ConvenioResource\RelationManagers;
use App\Models\Convenio;
use App\Models\Convenio\Archivo;
use App\Models\Vistas\VtPersonal;
use App\Services\Convenio\ArchivoDirectorio;
use App\Services\Convenio\ObtenerAutoridad;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\Action;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;

use function Pest\Laravel\options;

class ConvenioResource extends Resource
{
    protected static ?string $model = Convenio::class;

    protected static ?string $navigationLabel = 'Convenios';

    protected static ?string $navigationGroup = 'Convenios';

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Section::make()->schema([
                    Forms\Components\TextInput::make('titulo')->label('Titulo:')->required()->columnSpan(3),
                    Forms\Components\Select::make('institucion_id')->label('Institución:')
                        ->relationship('institucion', 'nombre')
                        ->preload()
                        ->searchable()
                        ->optionsLimit(10)
                        ->required(),
                    Forms\Components\Select::make('estado_id')->label('Estado:')
                        ->relationship('estado', 'estado')
                        ->preload()
                        //->searchable()
                        ->optionsLimit(10)
                        ->required(),
                    Forms\Components\DatePicker::make('fecha_suscrito')->reactive()->required(),
                    Forms\Components\DatePicker::make('fecha_fin')->minDate(fn(Get $get) => $get('fecha_suscrito'))->required(),
                    Forms\Components\TextInput::make('presidente_id')->label('Presidente:')
                        ->default(ObtenerAutoridad::presidente())
                        ->readOnly()
                        ->required(),
                    Forms\Components\TextInput::make('secretario_id')->label('Secretario/a:')
                        ->default(ObtenerAutoridad::secretario())
                        ->readOnly()->required(),
                    Forms\Components\Select::make('personal_id')
                        ->label('Otro Representante:')
                        ->relationship(
                            name: 'otros',
                            modifyQueryUsing: fn(Builder $query) => $query->orderBy('nombrecompleto')->orderBy('codigo')->orderBy('categoria'),
                        )
                        ->getOptionLabelFromRecordUsing(fn(Model $record) => "{$record->nombrecompleto} - {$record->codigo} - {$record->categoria}")
                        ->searchable(['nombrecompleto', 'codigo', 'categoria'])
                        ->optionsLimit(10),
                    Forms\Components\FileUpload::make('archivo')->label('Archivo Digital')
                        ->disk('public')
                        ->directory(fn ($get) => 'convenios/' . ($get('fecha_suscrito') ? date('Y', strtotime($get('fecha_suscrito'))) : date('Y')))
                        //->directory(ArchivoDirectorio::archivodirectorio())
                        ->preserveFilenames()
                        ->storeFileNamesIn('archivo_nombre')
                        ->acceptedFileTypes(['application/pdf'])
                        ->maxSize(20480)
                        ->previewable()
                        ->columnSpan(3)
                ])->columns(3),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('titulo')->label('Titilo')->toggleable()->searchable()->sortable()->limit(100),
                Tables\Columns\TextColumn::make('institucion.nombre')->label('Institucion')->toggleable()->searchable()->sortable(),
                Tables\Columns\TextColumn::make('estado.estado')->label('Estado')->toggleable()->searchable()->sortable(),
                Tables\Columns\TextColumn::make('fecha_suscrito')->label('Fecha Suscrito')->toggleable()->searchable()->sortable()->date(),
                Tables\Columns\TextColumn::make('fecha_fin')->label('Fecha Fin')->toggleable()->searchable()->sortable()->date(),
            ])
            ->filters([
                Filter::make('titulo')
                    ->form([
                        Forms\Components\TextInput::make('titulo')->label('Titulo:'),
                    ])->query(function (Builder $query, array $data): Builder {
                        return $query->when(
                            $data['titulo'],
                            fn(Builder $query, $titulo): Builder => $query->where('titulo', 'like', '%' . $titulo . '%') // Se agrega la funcion like debido a que el campo es de tipo TEXT
                        );
                    }),
                SelectFilter::make('institucion_id')
                    ->label('Institucion:')
                    ->relationship('institucion', 'nombre')
                    ->optionsLimit(10)
                    ->searchable(),
                SelectFilter::make('estado_id')
                    ->label('Estado:')
                    ->relationship('estado', 'estado')
                    ->optionsLimit(10)
                    ->preload(),
                Filter::make('fecha_suscrito')
                    ->label('Fecha Suscrito:')
                    ->form([
                        DatePicker::make('fecha_suscrito'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['fecha_suscrito'],
                                fn(Builder $query, $date): Builder => $query->whereDate('fecha_suscrito', '>=', $date),
                            );
                    }),
                Filter::make('fecha_fin')
                    ->label('Fecha Fin:')
                    ->form([
                        DatePicker::make('fecha_fin'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['fecha_fin'],
                                fn(Builder $query, $date): Builder => $query->whereDate('fecha_fin', '>=', $date),
                            );
                    }),
                SelectFilter::make('anho_suscrito')
                    ->label('Año Suscrito:')
                    ->options(function () {
                        return \App\Models\Convenio::distinct()->orderBy('anho_suscrito', 'desc')->pluck('anho_suscrito', 'anho_suscrito')->toArray();
                    })
                    ->multiple()
                    ->preload(),
                SelectFilter::make('anho_fin')
                    ->label('Año Finalización:')
                    ->options(function () {
                        return \App\Models\Convenio::distinct()->orderBy('anho_fin', 'desc')->pluck('anho_fin', 'anho_fin')->toArray();
                    })
                    ->multiple()
                    ->preload(),
            ], layout: FiltersLayout::AboveContent)
            // ->filtersTriggerAction(
            //     fn(Action $action) => $action
            //         ->button()
            //         ->label('Filtros'),
            // )
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Action::make('descargar')
                    ->label('Descargar')
                    ->icon('heroicon-c-arrow-down-tray')
                    ->url(fn(Convenio $record): string => route('descargar.convenio', $record))
                    ->openUrlInNewTab(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])->paginated([5, 10, 15, 20, 25])
            ->defaultPaginationPageOption(5);
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
            'index' => Pages\ListConvenios::route('/'),
            'create' => Pages\CreateConvenio::route('/create'),
            'view' => Pages\ViewConvenio::route('/{record}'),
            'edit' => Pages\EditConvenio::route('/{record}/edit'),
        ];
    }
}
