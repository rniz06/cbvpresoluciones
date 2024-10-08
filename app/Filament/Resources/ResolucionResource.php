<?php

namespace App\Filament\Resources;

use Filament\Tables\Actions\Action;
use App\Filament\Resources\ResolucionResource\Pages;
use App\Filament\Resources\ResolucionResource\RelationManagers;
use App\Models\Compania;
use App\Models\Personal;
use App\Models\Resolucion;
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
                        Forms\Components\DatePicker::make('fecha')->label('Fecha')->required()->format('Y-m-d'),
                        Forms\Components\TextInput::make('ano')->label('Año')->required()->numeric(),
                        Forms\Components\Hidden::make('usuario_id')->default(Auth::id()),

                        Forms\Components\Textarea::make('concepto')->label('Concepto')->required()->columnSpan(3),

                        Forms\Components\FileUpload::make('ruta_archivo')
                            ->label('Subir Resolución')
                            ->disk('public')
                            ->directory('resoluciones')
                            ->preserveFilenames()
                            ->storeFileNamesIn('nombre_original')
                            ->required()
                            ->columnSpan(3),
                    ])->columns(3),

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
                Tables\Columns\TextColumn::make('concepto')->label('Concepto')->limit(50),
                Tables\Columns\TextColumn::make('fecha')->label('Fecha')->date()->searchable()->sortable(),
                Tables\Columns\TextColumn::make('ano')->label('Año')->searchable()->sortable(),
                Tables\Columns\TextColumn::make('usuario.name')->label('Agregado por')->searchable()->toggleable(true),
                Tables\Columns\TextColumn::make('getCompaniasNamesAttribute') // Usa el método que has definido
                    ->label('Compañías')
                    ->getStateUsing(fn($record) => $record->getCompaniasNamesAttribute()),

                    Tables\Columns\TextColumn::make('getPersonalNamesAttribute') // Usa el método que has definido
                    ->label('Personal')
                    ->getStateUsing(fn($record) => $record->getPersonalNamesAttribute()),

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
            ])
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
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
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
